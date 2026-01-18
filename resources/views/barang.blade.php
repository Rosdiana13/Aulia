@extends('template')

@section('title','Manajemen Barang')

@section('content')

<div class="mb-4 p-3 text-white rounded shadow-sm" style="background:#1F447A;">
    <h4 class="mb-0">
        <i class="bi bi-box"></i> Manajemen Data Barang
    </h4>
</div>

<div class="row">

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background:#1F447A;">
                Tambah Produk Baru
            </div>

            <div class="card-body">
                <form action="{{ url('/barang/store') }}" method="POST">
                    @csrf 
                    <div class="mb-2">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" placeholder="Masukkan nama barang" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Harga Beli (Modal Awal)</label>
                        <input type="number" name="harga_beli" class="form-control" placeholder="Contoh: 50000" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Harga Jual</label>
                        <input type="number" name="harga_jual" class="form-control" placeholder="Contoh: 75000" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Stok Awal</label>
                        <input type="number" name="stok" class="form-control" value="0" min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Fashion">Fashion</option>
                            <option value="Sepatu">Sepatu</option>
                            <option value="Topi">Topi</option>
                            <option value="Aksesoris">Aksesoris</option>
                        </select>
                    </div>

                    <button type="submit" class="btn w-100 text-white" style="background:#1F447A;">
                        <i class="bi bi-save"></i> Simpan Produk
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header text-white d-flex justify-content-between align-items-center" style="background:#1F447A;">
                <span>Daftar Produk</span>
            </div>

            <div class="card-body p-0">
                <table class="table table-striped mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Harga Beli (AVG)</th>
                            <th>Harga Jual</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td class="text-start">Kaos Aulia</td>
                            <td><span class="badge bg-info text-dark">25</span></td>
                            <td>50.000</td>
                            <td>75.000</td>
                            <td>
                                <button 
                                    class="btn btn-sm btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal"
                                    onclick="setEdit('1','Kaos Aulia','50000','75000','Fashion')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-white" style="background:#1F447A;">
        <h5 class="modal-title">Edit Produk</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form action="{{ url('/barang/update') }}" method="POST">
          @csrf
          <input type="hidden" name="id_barang" id="editId">

          <div class="mb-2">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" id="editNama" class="form-control" required>
          </div>

          <div class="mb-2">
            <label>Harga Beli</label>
            <input type="number" name="harga_beli" id="editBeli" class="form-control" required>
          </div>

          <div class="mb-2">
            <label>Harga Jual</label>
            <input type="number" name="harga_jual" id="editJual" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" id="editKategori" class="form-select">
              <option value="Fashion">Fashion</option>
              <option value="Sepatu">Sepatu</option>
              <option value="Topi">Topi</option>
              <option value="Aksesoris">Aksesoris</option>
            </select>
          </div>

          <button type="submit" class="btn w-100 text-white" style="background:#1F447A;">
            Update Produk
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function setEdit(id, nama, beli, jual, kategori) {
    document.getElementById('editId').value = id; // Memasukkan ID ke input hidden
    document.getElementById('editNama').value = nama;
    document.getElementById('editBeli').value = beli;
    document.getElementById('editJual').value = jual;
    document.getElementById('editKategori').value = kategori;
}
</script>

@endsection