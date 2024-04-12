<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;

class ProductController extends Controller
{                       
    public function getAllProduct()
    {
        $dataset = Product::all();
        return response()->json([
            'success' => true,
            'message' => '(SUCCESS) get all data product',
            'data' => $dataset,
        ], 200);
    }

    public function getProductById($id)
    {
        try {
            $dataset = Product::find($id);

            if ($dataset) {
                return response()->json([
                    'success' => true,
                    'message' => '(SUCCESS) get data product by id',
                    'data' => $dataset,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '(FAILED) product not found',
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

    public function getProductCategoryTenda()
    {
        $dataset = Product::where('category_product', 'Tenda')->get();

        try {
            if ($dataset) {
                return response()->json([
                    'success' => true,
                    'message' => '(SUCCESS) get data product by category TENDA',
                    'data' => $dataset,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '(FAILED) product not found',
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

    public function getProductCategoryAlatCamping()
    {
        $dataset = Product::where('category_product', 'Alat camping')->get();

        try {
            if ($dataset) {
                return response()->json([
                    'success' => true,
                    'message' => '(SUCCESS) get data product by _product ALAT CAMPING',
                    'data' => $dataset,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '(FAILED) product not found',
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

    public function getProductCategoryLainnya()
    {
        $dataset = Product::where('category_product', 'Lainnya')->get();

        try {
            if ($dataset) {
                return response()->json([
                    'success' => true,
                    'message' => '(SUCCESS) get data product by category LAINNYA',
                    'data' => $dataset,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '(FAILED) product not found',
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
