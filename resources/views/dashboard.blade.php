@extends('template')

@section('title','Dashboard')

@section('content')

{{-- DATA DUMMY SIMULASI --}}
@php
    // Simulasi data ringkasan
    $total_stok = 150; 
    $total_barang = 45;

    // Simulasi data penjualan khusus hari ini
    $penjualan_hari_ini = [
        (object)[
            'nama_barang' => 'Baju Kaos Merah All Size',
            'tanggal' => date('d-m-Y'),
            'jumlah' => 2,
            'harga_jual' => 3500,
            'subtotal' => 7000
        ],
        (object)[
            'nama_barang' => 'Baju Kaos Merah Ukuran L',
            'tanggal' => date('d-m-Y'),
            'jumlah' => 1,
            'harga_jual' => 5000,
            'subtotal' => 5000
        ],
        (object)[
            'nama_barang' => 'Baju Kaos Merah Ukuran M',
            'tanggal' => date('d-m-Y'),
            'jumlah' => 5,
            'harga_jual' => 4000,
            'subtotal' => 20000
        ],
    ];

    $total_pendapatan_hari_ini = 32000;
@endphp

@if(session('login_success'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <strong>Berhasil!</strong> {{ session('login_success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="mb-4">
    <h4 class="fw-bold text-dark">Ringkasan Inventori</h4>
    <hr>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm text-white" style="background: #1F447A;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="font-size: 0.8rem; opacity: 0.8;">Total Barang (Jenis)</h6>
                        <h2 class="mb-0 fw-bold">{{ $total_barang }}</h2>
                    </div>
                    <i class="bi bi-box-seam" style="font-size: 2.5rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm text-white" style="background: #28a745;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="font-size: 0.8rem; opacity: 0.8;">Total Stok (Unit)</h6>
                        <h2 class="mb-0 fw-bold">{{ $total_stok }}</h2>
                    </div>
                    <i class="bi bi-stack" style="font-size: 2.5rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-cart-check text-success me-2"></i>Penjualan Hari Ini</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center align-middle">
                <thead class="table-light text-secondary">
                    <tr>
                        <th>No</th>
                        <th class="text-start">Nama Barang</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Harga Jual</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penjualan_hari_ini as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-start fw-bold">{{ $p->nama_barang }}</td>
                        <td>{{ $p->tanggal }}</td>
                        <td>{{ $p->jumlah }}</td>
                        <td>Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</td>
                        <td class="fw-bold">Rp {{ number_format($p->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="5" class="text-end">Total Pendapatan Hari Ini:</th>
                        <th class="text-primary fs-5">Rp {{ number_format($total_pendapatan_hari_ini, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    window.onload = function() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(function() {
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 500);
            }, 3000);
        }
    };
</script>

@endsection