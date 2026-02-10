@extends('template')

@section('title', 'Manajemen Kategori')

@section('content')

<div class="mb-4 p-3 text-white rounded shadow-sm" style="background:#1F447A;">
    <h4 class="mb-0">
        <i class="bi bi-tags"></i> Manajemen Kategori Produk
    </h4>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="autoAlert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="autoAlert">
        {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


<div class="row">
    {{-- FORM TAMBAH --}}
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background:#1F447A;">
                Tambah Kategori
            </div>
            <div class="card-body">
                {{-- TAMBAHAN: FORM --}}
                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text"
                               name="Nama_Kategori"
                               class="form-control"
                               placeholder="Contoh: Elektronik, Fesyen"
                               required>
                    </div>

                    <button class="btn w-100 text-white" style="background:#1F447A;">
                        <i class="bi bi-plus-circle"></i> Simpan Kategori
                    </button>
                </form>

            </div>
        </div>
    </div>

    {{-- TABEL KATEGORI --}}
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
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    {{-- TAMBAHAN: LOOP DATA --}}
                    @foreach ($kategori as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->Nama_Kategori }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning text-white"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $item->id }}">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>

                                {{-- TAMBAHAN: HAPUS --}}
                                <form action="{{ route('kategori.destroy', $item->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin hapus kategori?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
@foreach ($kategori as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1">
    <div class="modal-dialog">
        {{-- TAMBAHAN: FORM UPDATE --}}
        <form action="{{ route('kategori.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header text-white" style="background:#1F447A;">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <button type="button" class="btn-close btn-close-white"
                            data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text"
                               name="Nama_Kategori"
                               class="form-control"
                               value="{{ $item->Nama_Kategori }}"
                               required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary"
                            data-bs-dismiss="modal">Batal</button>
                    <button class="btn text-white"
                            style="background:#1F447A;">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
    setTimeout(function () {
        const alert = document.getElementById('autoAlert');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
</script>


@endsection
