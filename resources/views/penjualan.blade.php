@extends('template')

@section('title','Barang Keluar')

@section('content')

@if(session('login_success'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <strong>Berhasil!</strong> {{ session('login_success') }}
        <button type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<form action="{{ url('/penjualan/store') }}" method="POST">
    @csrf <div class="mb-4 p-3 text-white rounded shadow-sm" style="background:#1F447A;">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-box-arrow-right"></i> Transaksi Barang Keluar
            </h4>
            <span class="badge bg-light text-dark">{{ date('d M Y') }}</span>
        </div>
    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="card shadow-sm mb-3">
                <div class="card-header text-white" style="background:#1F447A;">
                    Info Transaksi
                </div>
                <div class="card-body">
                    <label class="form-label">Scan Barcode / Cari Barang</label>
                    <div class="input-group">
                        <input type="text" id="input-barcode" class="form-control" placeholder="Scan atau ketik...">
                        <button type="button" class="btn text-white" style="background:#1F447A;" onclick="tambahBarang()">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    <small class="text-muted">Tekan enter untuk tambah otomatis</small>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header text-white" style="background:#1F447A;">
                    Daftar Barang Keluar
                </div>
                <div class="card-body p-0">

                    <table class="table table-striped mb-0" id="tabel-keranjang">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Barang</th>
                                <th width="15%">Qty</th>
                                <th>Nilai Aset (Rp)</th> 
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    Kaos Aulia
                                    <input type="hidden" name="items[0][id_barang]" value="uuid-barang-1">
                                    <input type="hidden" name="items[0][harga_saat_ini]" value="50000">
                                </td>
                                <td>
                                    <input type="number" name="items[0][qty]" value="1" class="form-control form-control-sm" min="1">
                                </td>
                                <td>50.000</td>
                                <td>50.000</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <div id="pesan-kosong" class="p-4 text-center text-muted">
                        Belum ada barang yang dipilih
                    </div>

                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">Total Aset Keluar:</span>
                        <h4 class="mb-0 fw-bold">Rp <span id="label-total">50.000</span></h4>
                        <input type="hidden" name="total_transaksi" id="input-total" value="50000">
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-save"></i> Simpan Data
                    </button>
                </div>
            </div>

        </div>

    </div>
</form>
@endsection

<script>
    // Tunggu sampai halaman selesai dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            // Set waktu tunggu 3000ms (3 detik) sebelum hilang
            setTimeout(function() {
                // Gunakan class Bootstrap untuk efek fade out
                alert.classList.remove('show');
                alert.classList.add('fade');
                
                // Hapus elemen dari layar setelah transisi selesai
                setTimeout(function() {
                    alert.remove();
                }, 500); 
            }, 3000); 
        }
    });
</script>
