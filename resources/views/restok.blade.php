@extends('template')

@section('title','Restok Barang')

@section('content')

<div class="mb-4 p-3 text-white rounded shadow-sm d-flex justify-content-between align-items-center" style="background:#1F447A;">
    <h4 class="mb-0">
        <i class="bi bi-arrow-repeat"></i> Barang Perlu Restok
    </h4>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header text-white d-flex justify-content-between align-items-center" style="background:#1F447A;">
        <span>Daftar Barang</span>
        
        <div class="col-md-4">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                <input type="text" id="searchInput" class="form-control" placeholder="Cari nama barang...">
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle text-center" id="restokTable">
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
                    {{-- Simulasi Data 1 --}}
                    <tr>
                        <td class="text-start ps-3"><strong>Kaos Aulia</strong></td>
                        <td><small class="text-muted">Fashion</small></td>
                        <td>10</td>
                        <td>2</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#restokModal" onclick="setRestok('1', 'Kaos Aulia', 2, 10)">
                                Restok
                            </button>
                        </td>
                    </tr>

                    {{-- Simulasi Data 2 --}}
                    <tr>
                        <td class="text-start ps-3"><strong>Sepatu Sport</strong></td>
                        <td><small class="text-muted">Sepatu</small></td>
                        <td>5</td>
                        <td>5</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#restokModal" onclick="setRestok('2', 'Sepatu Sport', 5, 5)">
                                Restok
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal Restok --}}
<div class="modal fade" id="restokModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header text-white" style="background:#1F447A;">
                <h5 class="modal-title">Form Restok Barang</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/restok/update') }}" method="POST">
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

                    <hr>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah Stok Masuk</label>
                        <input type="number" name="qty_masuk" class="form-control" placeholder="0" required min="1">
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold">Harga Beli Baru (Satuan)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="harga_beli_baru" class="form-control" placeholder="0" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white" style="background:#1F447A;">Simpan Restok</button>
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

    function setRestok(id, nama, stok, batas) {
        document.getElementById('restokId').value = id;
        document.getElementById('restokNama').value = nama;
        document.getElementById('restokStok').value = stok;
        document.getElementById('restokBatas').value = batas;
    }
</script>

@endsection