@extends('template')

@section('title','Restok Barang')

@section('content')

<!-- Header -->
<div class="mb-4 p-3 text-white rounded shadow-sm d-flex justify-content-between align-items-center" style="background:#1F447A;">
    <h4 class="mb-0">
        <i class="bi bi-arrow-repeat"></i> Barang Perlu Restok
    </h4>

    <a href="#" class="btn btn-light btn-sm">
        <i class="bi bi-file-earmark-pdf"></i> Download PDF
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-header text-white" style="background:#1F447A;">
        Daftar Barang dengan Stok Menipis
    </div>

    <div class="card-body p-0">
        <table class="table table-striped mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Stok Tersisa</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

                <!-- Contoh data -->
                <tr>
                    <td>Kaos Aulia</td>
                    <td>Fashion</td>
                    <td>2</td>
                    <td><span class="badge bg-danger">Perlu Restok</span></td>
                    <td>
                        <button class="btn btn-sm btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#restokModal"
                            onclick="setRestok('Kaos Aulia',2)">
                            Restok
                        </button>
                    </td>
                </tr>

                <tr>
                    <td>Sepatu Sport</td>
                    <td>Sepatu</td>
                    <td>3</td>
                    <td><span class="badge bg-warning">Menipis</span></td>
                    <td>
                        <button class="btn btn-sm btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#restokModal"
                            onclick="setRestok('Sepatu Sport',3)">
                            Restok
                        </button>
                    </td>
                </tr>

                <tr>
                    <td>Topi Premium</td>
                    <td>Aksesoris</td>
                    <td>1</td>
                    <td><span class="badge bg-danger">Perlu Restok</span></td>
                    <td>
                        <button class="btn btn-sm btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#restokModal"
                            onclick="setRestok('Topi Premium',1)">
                            Restok
                        </button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>

<!-- Modal Restok -->
<div class="modal fade" id="restokModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header text-white" style="background:#1F447A;">
        <h5 class="modal-title">Restok Barang</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form>
          <div class="mb-2">
            <label>Nama Barang</label>
            <input type="text" id="restokNama" class="form-control" readonly>
          </div>

          <div class="mb-2">
            <label>Stok Sekarang</label>
            <input type="number" id="restokStok" class="form-control" readonly>
          </div>

          <div class="mb-3">
            <label>Jumlah Barang Masuk</label>
            <input type="number" class="form-control" placeholder="Masukkan jumlah">
          </div>

          <button class="btn w-100 text-white" style="background:#1F447A;">
            Simpan Restok
          </button>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
function setRestok(nama, stok){
    document.getElementById('restokNama').value = nama;
    document.getElementById('restokStok').value = stok;
}
</script>

@endsection
