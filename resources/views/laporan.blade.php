@extends('template')

@section('title','Laporan Penjualan')

@section('content')

<!-- Header -->
<div class="mb-4 p-3 text-white rounded shadow-sm d-flex justify-content-between align-items-center" style="background:#1F447A;">
    <h4 class="mb-0">
        <i class="bi bi-bar-chart-line"></i> Laporan Penjualan
    </h4>

    <div>
        <button class="btn btn-light btn-sm me-2">
            <i class="bi bi-file-earmark-excel"></i> Excel
        </button>
    </div>
</div>

<!-- Filter -->
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-3">
                <label>Tanggal Mulai</label>
                <input type="date" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Tanggal Akhir</label>
                <input type="date" class="form-control">
            </div>
            <div class="col-md-3">
                <label>Kasir</label>
                <select class="form-select">
                    <option>Semua Kasir</option>
                    <option>Admin</option>
                    <option>Kasir 1</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn text-white w-100" style="background:#1F447A;">
                    Tampilkan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Ringkasan -->
<div class="row mb-3">
    <div class="col-md-4">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6>Total Transaksi</h6>
                <h3>25</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6>Total Barang Terjual</h6>
                <h3>134</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm text-center">
            <div class="card-body">
                <h6>Total Pendapatan</h6>
                <h3>Rp 12.450.000</h3>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Laporan -->
<div class="card shadow-sm">
    <div class="card-header text-white" style="background:#1F447A;">
        Detail Transaksi
    </div>

    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>No Transaksi</th>
                    <th>Kasir</th>
                    <th>Total Barang</th>
                    <th>Total Bayar</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contoh data -->
                <tr>
                    <td>1</td>
                    <td>15-01-2026</td>
                    <td>TRX001</td>
                    <td>Admin</td>
                    <td>5</td>
                    <td>Rp 350.000</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>15-01-2026</td>
                    <td>TRX002</td>
                    <td>Kasir 1</td>
                    <td>8</td>
                    <td>Rp 780.000</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
