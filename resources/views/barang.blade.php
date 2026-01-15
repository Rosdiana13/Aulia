@extends('template')

@section('title','Tambah Barang')

@section('content')

<!-- Header -->
<div class="mb-4 p-3 text-white rounded shadow-sm" style="background:#1F447A;">
    <h4 class="mb-0">
        <i class="bi bi-box"></i> Tambah Barang
    </h4>
</div>

<div class="row">

    <!-- Form Tambah Produk -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background:#1F447A;">
                Add Produk
            </div>

            <div class="card-body">
                <form>
                    <div class="mb-2">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama barang">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Harga Beli</label>
                        <input type="number" class="form-control" placeholder="Contoh: 50000">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Harga Jual</label>
                        <input type="number" class="form-control" placeholder="Contoh: 75000">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select">
                            <option>Pilih Kategori</option>
                            <option>Fashion</option>
                            <option>Sepatu</option>
                            <option>Topi</option>
                            <option>Aksesoris</option>
                        </select>
                    </div>

                    <button class="btn w-100 text-white" style="background:#1F447A;">
                        Simpan Produk
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel Produk -->
    <div class="col-md-8">
        <div class="card shadow-sm">

            <div class="card-header text-white d-flex justify-content-between align-items-center" style="background:#1F447A;">
                <span>Daftar Produk</span>
            </div>

            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Kategori</th>
                            <th width="130">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh data -->
                        <tr>
                            <td>Kaos Aulia</td>
                            <td>50.000</td>
                            <td>75.000</td>
                            <td>Fashion</td>
                            <td>
                                <button 
                                    class="btn btn-sm btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal"
                                    onclick="setEdit('Kaos Aulia','50000','75000','Fashion')">
                                    Edit
                                </button>
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </td>
                        </tr>

                        <tr>
                            <td>Topi Hitam</td>
                            <td>30.000</td>
                            <td>50.000</td>
                            <td>Aksesoris</td>
                            <td>
                                <button 
                                    class="btn btn-sm btn-warning"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal"
                                    onclick="setEdit('Topi Hitam','30000','50000','Aksesoris')">
                                    Edit
                                </button>
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<!-- Modal Edit Produk -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header text-white" style="background:#1F447A;">
        <h5 class="modal-title">Edit Produk</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form>
          <div class="mb-2">
            <label>Nama Barang</label>
            <input type="text" id="editNama" class="form-control">
          </div>

          <div class="mb-2">
            <label>Harga Beli</label>
            <input type="number" id="editBeli" class="form-control">
          </div>

          <div class="mb-2">
            <label>Harga Jual</label>
            <input type="number" id="editJual" class="form-control">
          </div>

          <div class="mb-3">
            <label>Kategori</label>
            <select id="editKategori" class="form-select">
              <option>Fashion</option>
              <option>Sepatu</option>
              <option>Topi</option>
              <option>Aksesoris</option>
            </select>
          </div>

          <button class="btn w-100 text-white" style="background:#1F447A;">
            Update Produk
          </button>
        </form>
      </div>

    </div>
  </div>
</div>

<!-- Script Edit -->
<script>
function setEdit(nama, beli, jual, kategori) {
    document.getElementById('editNama').value = nama;
    document.getElementById('editBeli').value = beli;
    document.getElementById('editJual').value = jual;
    document.getElementById('editKategori').value = kategori;
}
</script>

@endsection
