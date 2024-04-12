<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use App\Models\Product;
use App\Models\UserPurchased;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserPurchasedController extends Controller
{
    private $initUser;

    public function __construct()
    {
        $this->initUser = auth()->user()->id;
    }

    private static function formatPrice($price)
    {
        return 'Rp ' . number_format($price, 0, ',', '.');
    }

    public function insertKeranjang(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'start_borrow_purchased' => 'required|date_format:Y-m-d',
            'end_borrow_purchased' => 'required|date_format:Y-m-d',
        ]);

        try {
            if ($validate->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validate->errors(),
                ], 400);
            }

            // init product price/day
            $initProduct = Product::find($request->product_id);
            $priceProductDayInit = $initProduct->priceday_product;

            // selisih day peminjamanm 
            $startBorrowInit = DateTime::createFromFormat('Y-m-d', $request->start_borrow_purchased);
            $endBorrowInit = DateTime::createFromFormat('Y-m-d', $request->end_borrow_purchased);
            $interval = $startBorrowInit->diff($endBorrowInit);
            $resultDdayBorrows = $interval->days;

            // result harga sesuai interfal
            $resultPrice = $priceProductDayInit * $resultDdayBorrows;

            $dataPurchased = UserPurchased::create([
                'user_id' => $this->initUser,
                'product_id' => $request->product_id,
                'start_borrow_purchased' => $request->start_borrow_purchased,
                'end_borrow_purchased' => $request->end_borrow_purchased,
                'result_price_purchased' => self::formatPrice($resultPrice),
            ]);

            if ($dataPurchased) {
                return response()->json([
                    'success' => true,
                    'message' => '(SUCCESS) Berhasil menambahkan product ke keranjang',
                    'data' => $dataPurchased,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '(FAILED) Gagal menambahkan product ke keranjang',
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getKeranjang()
    {
        $dataset = UserPurchased::where('user_id', $this->initUser)
            ->where('status_purchased', 'belum_submit')->get();

        $mappedData = collect([]);

        foreach ($dataset as $item) {
            $orderanSama = false;

            foreach ($mappedData as $existingOrder) {
                if ($existingOrder['product_id'] == $item->product_id && $existingOrder['start_borrow_purchased'] == $item->start_borrow_purchased && $existingOrder['end_borrow_purchased'] == $item->end_borrow_purchased) {
                    $orderanSama = true;
                    break;
                }
            }

            if (!$orderanSama) {
                $totalBarangBeli = UserPurchased::where('user_id', $this->initUser)
                    ->where('product_id', $item->product_id)
                    ->where('start_borrow_purchased', $item->start_borrow_purchased)
                    ->where('end_borrow_purchased', $item->end_borrow_purchased)
                    ->count();

                $mappedData->push([
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'start_borrow_purchased' => $item->start_borrow_purchased,
                    'end_borrow_purchased' => $item->end_borrow_purchased,
                    'result_price_purchased' => $item->result_price_purchased,
                    'status_purchased' => $item->status_purchased,
                    'attemp_purchased' => $item->attemp_purchased,
                    'Total barang beli' => $totalBarangBeli,
                ]);
            }
        }

        try {
            if ($dataset->count() > 0) {
                return response()->json([
                    'success' => true,
                    'message' => '(SUCCESS) get all data keranjang',
                    'data' => $mappedData,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '(FAILED) tidak ada data keranjang',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '(ERROR) internal server',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function tambahSatuBarang($id)
    {
        try {
            $keranjang = UserPurchased::where('id', $id)->first();

            $dataTambahBarang = [
                'user_id' => $keranjang->user_id,
                'product_id' => $keranjang->product_id,
                'start_borrow_purchased' => $keranjang->start_borrow_purchased,
                'end_borrow_purchased' => $keranjang->end_borrow_purchased,
                'result_price_purchased' => $keranjang->result_price_purchased,
                'status_purchased' => $keranjang->status_purchased,
                'attemp_purchased' => $keranjang->attemp_purchased,
            ];

            $dataTambahBarang = UserPurchased::create($dataTambahBarang);

            if ($dataTambahBarang) {
                return response()->json([
                    'success' => true,
                    'message' => '(SUCCESS) Berhasil menambahkan barang',
                    'data' => $dataTambahBarang,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '(FAILED) Gagal menambahkan barang',
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '(ERROR) internal server',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function hapusSatuBarang($id)
    {
        try {
            $keranjang = UserPurchased::where('id', $id)->first();

            $deleteData = $keranjang->delete();

            if ($deleteData) {
                return response()->json([
                    'success' => true,
                    'message' => '(SUCCESS) Berhasil menghapus barang',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '(FAILED) Gagal menghapus barang',
                ], 500);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '(ERROR) internal server',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function checkoutKeranjang()
    {
        $keranjang = UserPurchased::where('user_id', $this->initUser)
            ->where('status_purchased', 'belum_submit')->get();

        $totalPrice = 0;

        foreach ($keranjang as $item) {
            $totalPrice += str_replace(['Rp ', '.'], '', $item->result_price_purchased);
        }

        // update status semuanya menjadi sudah_submit 
        UserPurchased::where('user_id', $this->initUser)
            ->where('status_purchased', 'belum_submit')
            ->update(['status_purchased' => 'sudah_submit']);

        // lalu insert di table checkout status nya
        $dataCheckoutResult = Checkout::create([
            'user_id' => $this->initUser,
            'result_checkout' => self::formatPrice($totalPrice),
            'date_checkout' => now(),
        ]);

        try {
            if ($dataCheckoutResult) {
                return response()->json([
                    'success' => true,
                    'message' => '(SUCCESS) berhasil checkout product',
                    'data' => $dataCheckoutResult,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '(FAILED) keranjang kosong',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '(ERROR) internal server',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getRiwayatPembelian()
    {
        $initUser = auth()->user()->id;

        $dataset = UserPurchased::where('user_id', $initUser)->where('status_purchased', 'sudah_submit')->get();

        $mappedData = $dataset->map(function ($items) {
            return [
                'id' => $items->id,
                'product_id' => $items->product_id,
                'start_borrow_purchased' => $items->start_borrow_purchased,
                'end_borrow_purchased' => $items->end_borrow_purchased,
                'result_price_purchased' => $items->result_price_purchased,
                'status_purchased' => $items->status_purchased,
                'attemp_purchased' => $items->attemp_purchased,
            ];
        });
        try {
            if ($dataset) {
                return response()->json([
                    'success' => true,
                    'message' => '(SUCCESS) get all data riwayat pembelian',
                    'data' => $mappedData,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '(FAILED) tidak ada data riwayat pembelian',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '(ERROR) internal server',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
