<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header text-white" style="background:#1F447A;">
                    <h5 class="mb-0">Tambah Pengguna Baru (Toko Aulia)</h5>
                </div>
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
                            <select name="jabatan" class="form-control" required>
                                <option value="Pemilik">Pemilik</option>
                                <option value="Pekerja">Pekerja</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn text-white" style="background:#1F447A;">Simpan Pengguna</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>