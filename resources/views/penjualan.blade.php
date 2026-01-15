@extends('template')

@section('title','Penjualan')

@section('content')

<div class="mb-4 p-3 text-white rounded shadow-sm" style="background:#1F447A;">
    <h4 class="mb-0">
        <i class="bi bi-cash-stack"></i> Transaksi Penjualan
    </h4>
</div>

<div class="row">

    <!-- Input Scan / Cari Barang -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background:#1F447A;">
                Scan / Cari Barang
            </div>
            <div class="card-body">

                <label class="form-label">Barcode / Nama Barang</label>
                <input type="text" class="form-control mb-2" placeholder="Scan barcode atau ketik nama...">

                <button class="btn w-100 text-white" style="background:#1F447A;">
                    Tambah
                </button>

                <div class="alert alert-danger mt-3 d-none">
                    Barang tidak ditemukan
                </div>

            </div>
        </div>
    </div>

    <!-- Tabel Keranjang -->
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background:#1F447A;">
                Daftar Barang
            </div>
            <div class="card-body p-0">

                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Barcode</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh item -->
                        <tr>
                            <td>899123</td>
                            <td>Kaos Aulia</td>
                            <td>50.000</td>
                            <td>1</td>
                            <td>50.000</td>
                            <td>
                                <button class="btn btn-sm btn-danger">X</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <!-- Total & Bayar -->
        <div class="card shadow-sm mt-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h4>Total: Rp 50.000</h4>
                <button class="btn btn-success btn-lg">
                    <i class="bi bi-cash"></i> Bayar
                </button>
            </div>
        </div>

    </div>

</div>

@endsection
