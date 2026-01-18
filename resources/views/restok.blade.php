@extends('template')

@section('title','Restok Barang')

@section('content')

<div class="mb-4 p-3 text-white rounded shadow-sm d-flex justify-content-between align-items-center" style="background:#1F447A;">
    <h4 class="mb-0">
        <i class="bi bi-arrow-repeat"></i> Barang Perlu Restok
    </h4>

    <a href="#" class="btn btn-light btn-sm">
        <i class="bi bi-file-earmark-pdf"></i> Download PDF
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header text-white d-flex justify-content-between align-items-center" style="background:#1F447A;">
        <span>Daftar Barang dengan Stok Menipis</span>
        
        <div class="col-md-4">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light"><i class="bi bi-search"></i></span>
                <input type="text" id="searchInput" class="form-control" placeholder="Cari nama barang atau kategori...">
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped mb-0 align-middle" id="restokTable">
            <thead class="table-light text-center">
                <tr>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok Tersisa</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <tr>
                    <td>Kaos Aulia</td>
                    <td>Fashion</td>
                    <td class="text-center">2</td>
                    <td class="text-center"><span class="badge bg-danger">Perlu Restok</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#restokModal" onclick="setRestok('1', 'Kaos Aulia', 2)">
                            Restok
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>Sepatu Sport</td>
                    <td>Sepatu</td>
                    <td class="text-center">3</td>
                    <td class="text-center"><span class="badge bg-warning">Menipis</span></td>
                    <td class="text-center">
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#restokModal" onclick="setRestok('2', 'Sepatu Sport', 3)">
                            Restok
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="restokModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:#1F447A;">
                <h5 class="modal-title">Form Restok (Metode AVG)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/restok/update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_barang" id="restokId">
                    <div class="mb-2">
                        <label>Nama Barang</label>
                        <input type="text" id="restokNama" class="form-control" readonly>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label>Stok Saat Ini</label>
                            <input type="number" id="restokStok" class="form-control" readonly>
                        </div>
                        <div class="col-6">
                            <label>Jumlah Masuk</label>
                            <input type="number" name="qty_masuk" class="form-control" placeholder="Contoh: 10" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Harga Beli Baru (Satuan)</label>
                        <input type="number" name="harga_beli_baru" class="form-control" placeholder="Input harga beli terbaru..." required>
                    </div>
                    <button type="submit" class="btn w-100 text-white" style="background:#1F447A;">Simpan Restok</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Fitur Search Otomatis (Live Search)
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableBody tr');

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    function setRestok(id, nama, stok) {
        document.getElementById('restokId').value = id;
        document.getElementById('restokNama').value = nama;
        document.getElementById('restokStok').value = stok;
    }
</script>

@endsection