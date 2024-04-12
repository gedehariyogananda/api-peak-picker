@extends('templates.master')
@section('title', 'Detail Data User')
@section('page-name', 'Detail Data User')
@push('styles')
<link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/scss/pages/simple-datatables.scss') }}">
@endpush
@section('content')

<section class="section">
    <div class="card">
        <div class="container ">
            <div class="card-header">
                {{-- <select class="form-select w-25" id="sortingSelect">
                    <option value="{{ route('rawatjalan.index') }}" {{ request()->is('rawat-jalan/detail-kunjungan')
                        ? 'selected disabled' : '' }}>Semua Data Kunjungan</option>
                    <option value="{{ route('rawatjalan.sudahPemeriksaan') }}" {{ request()->
                        is('rawat-jalan/detail-kunjungan/sudah-pemeriksaan') ? 'selected disabled' : '' }}>Sudah
                        Pemeriksaan</option>
                    <option value="{{ route('rawatjalan.belumPemeriksaan') }}" {{ request()->
                        is('rawat-jalan/detail-kunjungan/belum-pemeriksaan') ? 'selected disabled' : '' }}>Belum
                        Pemeriksaan</option>
                </select> --}}
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table1">
                <thead>
                    <tr>
                        <th>ID Req</th>
                        <th>Nama</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Judul Campain</th>
                        <th>Proposal</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>adawd</td>
                        <td>adada</td>
                        <td>awdawd</td>
                        <td>awdadawd</td>
                        <td>adwawdawda </td>
                        <td>dawdaw</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
</div>


{{-- <script>
    document.getElementById('sortingSelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var route = selectedOption.value;

        if (route) {
            window.location.href = route;
        }
    });
</script> --}}

<script src="{{ asset ('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
<script>
    let dataTable = new simpleDatatables.DataTable(
                    document.getElementById("table1")
                )               
</script>

<script src="assets/js/main.js"></script>

@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session()->has('success'))
<script>
    Swal.fire({
    icon: 'success',
    title: 'Success',
    text : "{{ session('success') }}",
    showConfirmButton: true,
    timer: 2000
    });
</script>
@endif
@endpush