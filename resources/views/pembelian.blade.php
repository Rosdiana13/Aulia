@extends('template')

@section('title','Pembelian')

@section('content')

<div class="mb-4 p-3 text-white rounded shadow-sm d-flex justify-content-between align-items-center" style="background:#1F447A;">
    <h4 class="mb-0">
        <i class="bi bi-arrow-repeat"></i> Pembelian Barang dan Restock
    </h4>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="autoAlert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="autoAlert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="autoAlert">
        {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-header text-white d-flex justify-content-between align-items-center" style="background:#1F447A;">
        <span>Daftar Barang Perlu Restok</span>
        
        <div class="col-md-4">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" id="searchInput" class="form-control" placeholder="Cari nama barang...">
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th class="text-start ps-3">Nama Barang</th>
                        <th>Kategori</th>
                        <th>Batas Min</th>
                        <th>Stok Tersisa</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>

                <tbody id="tableBody">
                    @forelse($barang_restok as $item)
                    <tr>
                        <td class="text-start ps-3">
                            <strong>{{ $item->nama_barang }}</strong>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $item->kategori->Nama_Kategori ?? '-' }}
                            </small>
                        </td>
                        <td>{{ $item->min_stok }}</td>
                        <td class="fw-bold text-danger">
                            {{ $item->jumlah }}
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#restokModal"
                                onclick="setRestok(
                                    '{{ $item->id }}',
                                    '{{ $item->nama_barang }}',
                                    '{{ $item->jumlah }}',
                                    '{{ $item->min_stok }}',
                                    '{{ $item->harga_beli }}'
                                )">
                                Restok
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-4 text-muted">
                            Semua stok dalam kondisi aman
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

{{-- MODAL RESTOK --}}
<div class="modal fade" id="restokModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header text-white" style="background:#1F447A;">
                <h5 class="modal-title">Form Restok Barang</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('pembelian.restok') }}" method="POST" id="formRestok">
                @csrf

                <div class="modal-body text-start">

                    <input type="hidden" name="id_barang" id="restokId">

                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" id="restokNama" class="form-control bg-light" readonly>
                    </div>

                    <div class="row mb-3 text-center">
                        <div class="col-6">
                            <label class="form-label">Stok Sekarang</label>
                            <input type="number" id="restokStok" class="form-control bg-light text-center" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Batas Min</label>
                            <input type="number" id="restokBatas" class="form-control bg-light text-center" readonly>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="form-label">Harga Beli Saat ini</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="restokHargaLama"
                                   class="form-control bg-light text-start"
                                   readonly>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah Stok Masuk</label>
                        <input type="number" name="qty_masuk" class="form-control" required min="1">
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold">Harga Beli Baru (Satuan)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text"
                                   name="harga_beli_baru"
                                   class="form-control input-rupiah"
                                   required>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white" style="background:#1F447A;">
                        Simpan Restok
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>

document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#tableBody tr');
    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});

function setRestok(id, nama, stok, batas, harga_lama) {
    document.getElementById('restokId').value = id;
    document.getElementById('restokNama').value = nama;
    document.getElementById('restokStok').value = stok;
    document.getElementById('restokBatas').value = batas;
    document.getElementById('restokHargaLama').value =
        numberToRupiah(harga_lama);
}

function rupiahToNumber(value) {
    if (!value) return 0;
    return parseInt(value.replace(/\D/g, ''), 10);
}

function numberToRupiah(number) {
    if (!number) return "";
    number = parseInt(number, 10);
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

document.addEventListener('input', function(e) {
    if (e.target.classList.contains('input-rupiah')) {
        e.target.value = numberToRupiah(
            rupiahToNumber(e.target.value)
        );
    }
});

document.getElementById('formRestok').addEventListener('submit', function() {
    let input = this.querySelector('input[name="harga_beli_baru"]');
    input.value = rupiahToNumber(input.value);
});

setTimeout(function () {
        const alert = document.getElementById('autoAlert');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);

</script>

@endsection
