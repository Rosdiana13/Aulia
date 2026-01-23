@extends('template')

@section('title', 'Manajemen Barang')

@section('content')

<div class="mb-4 p-3 text-white rounded shadow-sm" style="background:#1F447A;">
    <h4 class="mb-0">
        <i class="bi bi-box"></i> Manajemen Data Barang (Demo Mode)
    </h4>
</div>

<div class="row">
    {{-- FORM TAMBAH --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header text-white" style="background:#1F447A;">
                Tambah Produk Baru
            </div>
            <div class="card-body">
                <form id="formTambah">
                    <div class="mb-2">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" placeholder="Contoh Baju Kaos Merah All size">
                    </div>
                    {{-- INPUT KATEGORI BARU --}}
                    <div class="mb-2">
                        <label class="form-label">Kategori</label>
                        <select class="form-select">
                            <option value="">Pilih Kategori</option>
                            <option value="Alat Dapur">Alat Dapur</option>
                            <option value="Kebersihan">Kebersihan</option>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Harga Beli (Modal)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control input-rupiah" placeholder="0">
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Harga Jual</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" class="form-control input-rupiah" placeholder="0">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label class="form-label">Stok</label>
                            <input type="number" class="form-control" placeholder="0">
                        </div>
                        <div class="col">
                            <label class="form-label text-danger">Min. Stok</label>
                            <input type="number" class="form-control border-danger" placeholder="0">
                        </div>
                    </div>
                    <button type="button" class="btn w-100 text-white shadow-sm" style="background:#1F447A;" onclick="alert('Simulasi: Data berhasil disimpan!')">
                        <i class="bi bi-save"></i> Simpan Produk
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- TABEL DATA --}}
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header text-white d-flex justify-content-between align-items-center" style="background:#1F447A;">
                <span>Daftar Produk</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 text-center">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Baris Dummy 1 --}}
                            <tr>
                                <td>1</td>
                                <td class="text-start"><strong>Kaos Merah all Size</strong></td>
                                <td><span>Fashion</span></td>
                                <td>15</td>
                                <td>150.000</td>
                                <td>185.000</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="setEdit('1', 'Panci Set Jumbo Aulia', '150000', '185000', 'Alat Dapur', '15', '5')" data-bs-toggle="modal" data-bs-target="#editModal">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus barang?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            {{-- Baris Dummy 2 --}}
                            <tr>
                                <td>2</td>
                                <td class="text-start"><strong>Kaos Merah size L</strong></td>
                                <td><span>Fashion</span></td>
                                <td><span>2</span></td>
                                <td>20.000</td>
                                <td>35.000</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" onclick="setEdit('2', 'Sapu Ijuk Super', '20000', '35000', 'Kebersihan', '2', '10')" data-bs-toggle="modal" data-bs-target="#editModal">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus barang?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header text-white" style="background:#1F447A;">
                <h5 class="modal-title">Edit Produk (Demo)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editId">
                <div class="mb-2">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" id="editNama" class="form-control">
                </div>
                {{-- EDIT KATEGORI --}}
                <div class="mb-2">
                    <label class="form-label">Kategori</label>
                    <select id="editKategori" class="form-select">
                        <option value="Alat Dapur">Alat Dapur</option>
                        <option value="Kebersihan">Kebersihan</option>
                        <option value="Elektronik">Elektronik</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label class="form-label">Harga Beli (Modal) <small class="text-muted">(Read-only)</small></label>
                    <div class="input-group">
                        <span class="input-group-text bg-light">Rp</span>
                        <input type="text" id="editBeli" class="form-control bg-light" readonly>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label">Harga Jual</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="text" id="editJual" class="form-control input-rupiah">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <label class="form-label">Stok</label>
                        <input type="number" id="editStok" class="form-control bg-light" readonly>
                    </div>
                    <div class="col">
                        <label class="form-label">Min. Stok</label>
                        <input type="number" id="editMinStok" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn text-white" style="background:#1F447A;" onclick="alert('Simulasi: Perubahan berhasil disimpan!')" data-bs-dismiss="modal">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<script>
    function formatNumber(n) {
        if (!n) return "";
        let val = n.toString().replace(/\D/g, "");
        return val.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Update parameter untuk menerima kategori
    function setEdit(id, nama, beli, jual, kategori, stok, min) {
        document.getElementById('editId').value = id;
        document.getElementById('editNama').value = nama;
        document.getElementById('editBeli').value = formatNumber(beli);
        document.getElementById('editJual').value = formatNumber(jual);
        document.getElementById('editKategori').value = kategori; // Set kategori di modal
        document.getElementById('editStok').value = stok;
        document.getElementById('editMinStok').value = min;
    }

    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('input-rupiah')) {
            e.target.value = formatNumber(e.target.value);
        }
    });
</script>

@endsection