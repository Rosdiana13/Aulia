@extends('template')

@section('title','Manajemen Barang')

@section('content')

<div class="mb-4 p-3 text-white rounded shadow-sm" style="background:#1F447A;">
    <h4 class="mb-0">
        <i class="bi bi-box"></i> Manajemen Data Barang
    </h4>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <strong>Gagal!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
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
                        <label class="form-label">Harga Beli (Modal)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" name="harga_beli" class="form-control input-rupiah" placeholder="0" required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Harga Jual</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" name="harga_jual" class="form-control input-rupiah" placeholder="0" required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Stok Awal</label>
                        <input type="number" name="stok" class="form-control" placeholder="0" min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->Nama_Kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn w-100 text-white shadow-sm" style="background:#1F447A;">
                        <i class="bi bi-save"></i> Simpan Produk
                    </button>
                </form>
            </div>
        </div>
    </div>

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
                                <th>Stok</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($barang as $b)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start">
                                    <strong>{{ $b->nama_barang }}</strong> <br>
                                    <small class="badge text-dark">{{ $b->kategori->Nama_Kategori ?? 'Tanpa Kategori' }}</small>
                                </td>
                                <td>
                                    <span class="{{ $b->jumlah > 5 }} text-dark">
                                        {{ $b->jumlah }}
                                    </span>
                                </td>
                                <td>{{ number_format($b->harga_beli, 0, ',', '.') }}</td>
                                <td>{{ number_format($b->harga_jual, 0, ',', '.') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning shadow-sm" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editModal"
                                        onclick="setEdit('{{ $b->id }}','{{ $b->nama_barang }}','{{ $b->harga_beli }}','{{ $b->harga_jual }}','{{ $b->id_kategori }}','{{ $b->jumlah }}')">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    
                                    <a href="{{ route('barang.delete', $b->id) }}" class="btn btn-sm btn-danger shadow-sm" onclick="return confirm('Hapus barang ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header text-white" style="background:#1F447A;">
                <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Produk</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('/barang/update') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id_barang" id="editId">

                    <div class="mb-2">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" id="editNama" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Harga Beli</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" name="harga_beli" id="editBeli" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Harga Jual</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp </span>
                            <input type="text" name="harga_jual" id="editJual" class="form-control input-rupiah" required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Stok Barang</label>
                        <input type="number" name="stok" id="editStok" class="form-control" required>
                    </div>

                    <div class="mb-0">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" id="editKategori" class="form-select" required>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->Nama_Kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white" style="background:#1F447A;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    // Fungsi untuk Mengisi Data ke Modal Edit
    function setEdit(id, nama, beli, jual, kategori, stok) {
        document.getElementById('editId').value = id;
        document.getElementById('editNama').value = nama;
        document.getElementById('editBeli').value = beli; 
        document.getElementById('editJual').value = jual; 
        document.getElementById('editKategori').value = kategori;
        document.getElementById('editStok').value = stok;
    }
</script>

@endsection