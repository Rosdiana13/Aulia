<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow-sm">

                <div class="text-center p-3">
                    <img src="{{ asset('storage/images/Logo_Aulia.png') }}"
                        class="img-fluid"
                        style="max-height:120px;">
                </div>

                <div class="card-header text-white text-center" style="background:#1F447A;">
                    <h5 class="mb-0">Login Pengguna</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        <!--1. KEAMANAN FORM -->
                        <!-- @csrf: 'Kunci Pengaman' agar form tidak bisa disalahgunakan oleh pihak luar/hacker.-->
                        @csrf

                        <!--2. NOTIFIKASI ERROR (TAMPILAN MERAH) 
                        Muncul jika ada yang salah, contoh: Username tidak terdaftar atau Password keliru. -->
                        @if($errors->any())
                            <div class="alert alert-danger py-2">
                                <small>{{ $errors->first() }}</small>
                            </div>
                        @endif

                        <!--3. NOTIFIKASI BERHASIL (TAMPILAN HIJAU)
                        Muncul jika sebuah aksi sukses, contoh: Setelah selesai daftar akun baru. -->
                        @if(session('success'))
                            <div class="alert alert-success py-2">
                                <small>{{ session('success') }}</small>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="nama_pengguna" class="form-control" placeholder="Masukkan username" required value="{{ old('nama_pengguna') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn text-white" style="background:#1F447A;">
                                Login
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>