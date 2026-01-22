@extends('template')

@section('title', 'Laporan Barang Mengendap')

@section('content')

<div class="d-print-none">
    <div class="mb-4 p-3 text-white rounded shadow-sm d-flex justify-content-between align-items-center" style="background:#1F447A;">
        <h4 class="mb-0">
            <i class="bi bi-clock-history"></i> Identifikasi Barang Mengendap (Aging Report)
        </h4>
        <div>
            <button onclick="window.print()" class="btn btn-light btn-sm">
                <i class="bi bi-file-earmark-excel"></i> Excel
            </button>
        </div>
    </div>
</div>

<div class="d-none d-print-block text-center mb-4">
    <h4>LAPORAN IDENTIFIKASI BARANG MENGENDAP</h4>
    <p>Periode: <strong>{{ request('start_date') ?? '01/01/2026' }}</strong> s/d <strong>{{ request('end_date') ?? date('d/m/Y') }}</strong></p>
    <hr>
</div>

<div class="card shadow-sm mb-4 d-print-none border-0">
    <div class="card-body">
        <form action="{{ url()->current() }}" method="GET" class="row align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold">Tanggal Mulai:</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date', '2026-01-01') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Tanggal Selesai:</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date', date('Y-m-d')) }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100 shadow-sm">
                    <i class="bi bi-filter"></i> Jalankan Filter Aging
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white">
        <div class="row align-items-center">
            <div class="col">
                <span class="fw-bold"><i class="bi bi-table"></i> Hasil Analisis Stok Macet</span>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0 align-middle">
                <thead class="text-white text-center" style="background:#1F447A;">
                    <tr>
                        <th width="50">No</th>
                        <th class="text-start">Nama Barang</th>
                        <th>Terakhir Laku</th>
                        <th>Umur Mengendap</th>
                        <th>Stok</th>
                        <th>Harga Beli (Satuan)</th>
                        <th>Modal Tertanam</th>
                    </tr>
                </thead>
                <tbody id="isiLaporan">
                    {{-- Simulasi Data --}}
                    <tr>
                        <td class="text-center">1</td>
                        <td>Panci Set Jumbo Aulia</td>
                        <td class="text-center text-muted">Belum Pernah Laku</td>
                        <td class="text-center text-dark">92 Hari</td>
                        <td class="text-center">10</td>
                        <td class="text-end px-3">Rp 150.000</td>
                        <td class="text-end px-3 fw-bold">Rp 1.500.000</td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td>Sapu Ijuk Super</td>
                        <td class="text-center text-dark">05/12/2025</td>
                        <td class="text-center text-dark">48 Hari</td>
                        <td class="text-center">45</td>
                        <td class="text-end px-3">Rp 20.000</td>
                        <td class="text-end px-3 fw-bold">Rp 900.000</td>
                    </tr>
                    <tr>
                        <td class="text-center">3</td>
                        <td>Ember Plastik Hitam</td>
                        <td class="text-center text-dark">22/12/2025</td>
                        <td class="text-center text-dark">31 Hari</td>
                        <td class="text-center">15</td>
                        <td class="text-end px-3">Rp 20.000</td>
                        <td class="text-end px-3 fw-bold">Rp 300.000</td>
                    </tr>
                </tbody>
                <tfoot class="bg-light fw-bold">
                    <tr>
                        <td colspan="6" class="text-end px-3">Total Modal Tertanam (Macet):</td>
                        <td class="text-end px-3 fs-5">Rp 2.700.000</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="d-none d-print-block mt-5">
    <div class="row text-center">
        <div class="col-8"></div>
        <div class="col-4 border-top">
            <p class="mt-2">Pemilik Toko Aulia</p>
            <br><br><br>
            <p class="fw-bold">{{ Auth::user()->nama_pengguna ?? 'Admin Toko' }}</p>
        </div>
    </div>
</div>

<script>
    // Live Search Sederhana
    document.getElementById('cariBarang').addEventListener('keyup', function() {
        let val = this.value.toLowerCase();
        let rows = document.querySelectorAll('#isiLaporan tr');
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(val) ? '' : 'none';
        });
    });
</script>

@endsection