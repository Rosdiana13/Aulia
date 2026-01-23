@extends('template')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="mb-4 p-3 text-white rounded shadow-sm" style="background:#1F447A;">
    <h4 class="mb-0"><i class="bi bi-people"></i> Manajemen Pengguna</h4>
</div>


@if(session('success'))
    <div id="auto-alert" class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div id="auto-alert" class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <strong>Gagal!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header text-white" style="background:#1F447A;">Tambah Pengguna</div>
            <div class="card-body">
                <form method="POST" action="{{ url('/register') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="nama_pengguna" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <select name="jabatan" class="form-select" required>
                            <option value="Pemilik">Pemilik</option>
                            <option value="Pekerja">Pekerja</option>
                        </select>
                    </div>
                    <button type="submit" class="btn text-white w-100" style="background:#1F447A;">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header text-white fw-bold" style="background:#1F447A;">
                <i class="bi bi-list-ul"></i> Daftar Pengguna Sistem
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th>Username</th>
                                <th>Jabatan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($semua_pengguna as $key => $u)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td><strong>{{ $u->nama_pengguna }}</strong></td>
                                    <td>
                                        <span class="badge {{ $u->jabatan == 'Pemilik' ? 'bg-primary' : 'bg-info text-dark' }}">
                                            {{ $u->jabatan }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ url('/pengguna/delete/'.$u->id) }}" 
                                        class="btn btn-sm btn-danger" 
                                        onclick="return confirm('Apakah Anda yakin ingin menonaktifkan akun {{ $u->nama_pengguna }}? Karyawan ini tidak akan bisa login, namun data transaksinya tetap tersimpan di sistem.')">
                                            <i class="bi bi bi-trash"></i> Hapus
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

<script>
    window.onload = function() {
        const alert = document.getElementById('auto-alert');
        if (alert) {
            setTimeout(function() {
                // Tambahkan class 'fade' dari Bootstrap untuk animasi halus
                alert.classList.add('fade');
                // Tunggu 500ms (durasi animasi fade) baru hapus dari layar
                setTimeout(() => alert.remove(), 500);
            }, 2000); // Tampil selama 3 detik
        }
    };
</script>
@endsection