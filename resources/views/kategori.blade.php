@extends('template')

@section('title', 'Manajemen Kategori')

@section('content')

<div class="mb-4 p-3 text-white rounded shadow-sm" style="background:#1F447A;">
    <h4 class="mb-0">
        <i class="bi bi-tags"></i> Manajemen Kategori Produk
    </h4>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background:#1F447A;">
                Tambah Kategori
            </div>
            <div class="card-body">
                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" name="Nama_Kategori" class="form-control" placeholder="Contoh: Elektronik, Pakaian" required>
                    </div>
                    <button type="submit" class="btn w-100 text-white" style="background:#1F447A;">
                        <i class="bi bi-plus-circle"></i> Simpan Kategori
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background:#1F447A;">
                Daftar Kategori
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Kategori</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategori as $kat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kat->Nama_Kategori }}</td>
                            <td>
                                <form action="{{ route('kategori.destroy', $kat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini? Barang dengan kategori ini mungkin akan bermasalah.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-muted p-3">Belum ada kategori.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection