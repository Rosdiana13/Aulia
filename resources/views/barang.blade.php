@extends('template')

@section('title','Manajemen Barang')

@section('content')

<div class="mb-4 p-3 text-white rounded shadow-sm" style="background:#1F447A;">
    <h4 class="mb-0">
        <i class="bi bi-box"></i> Manajemen Data Barang
    </h4>
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

                    <button type="submit" class="btn w-100 text-white shadow-sm" style="background:#1F447A;" onclick="return confirm('Apakah Anda yakin ingin simpan data ini?')">
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
                <form action="{{ url()->current() }}" method="GET" class="d-flex" style="width: 250px;">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="Cari barang..." value="{{ request('search') }}">
                        <button class="btn btn-light" type="submit">
                            <i class="bi bi-search text-dark"></i>
                        </button>
                        @if(request('search'))
                            <a href="{{ url()->current() }}" class="btn btn-danger">
                                <i class="bi bi-x-circle"></i>
                            </a>
                        @endif
                    </div>
                </form>
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
                                <th>Harga satuan</th>
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
                                <td>
                                    {{ number_format($b->harga_satuan, 0, ',', '.') }}
                                </td>
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
                        <label class="form-label">Harga Beli (Average)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="text" name="harga_beli" id="editBeli" class="form-control bg-light" readonly required>
                        </div>
                        <small class="text-muted">Harga ini dihitung otomatis berdasarkan rata-rata stok.</small>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Harga Satuan (HPP Rata-rata)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="text" id="editSatuan" class="form-control bg-light" readonly>
                        </div>
                        <small class="text-muted">Hasil bagi Harga Beli / Stok.</small>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Stok Barang</label>
                        <input type="number" name="stok" id="editStok" class="form-control bg-light" readonly required>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Harga Jual</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp </span>
                            <input type="text" name="harga_jual" id="editJual" class="form-control input-rupiah" required>
                        </div>
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
                    <button type="submit" class="btn text-white" onclick="return confirm('Hapus barang ini?')" style="background:#1F447A;">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    // 1. Fungsi Format: Membersihkan segalanya kecuali angka, lalu beri titik
    function formatNumber(n) {
        if (!n || n == 0) return "";
        
        // Hapus semua karakter yang bukan angka (termasuk titik desimal dari DB atau titik ribuan)
        // Ini memastikan input 1.000.000 tidak terpotong saat diketik
        let val = n.toString().replace(/\D/g, "");
        
        // Tambahkan titik setiap 3 digit
        return val.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // 2. Fungsi Khusus Database: Memastikan angka .00 tidak jadi nol tambahan
    function bersihkanDataDB(n) {
        if (!n) return "0";
        // Hanya untuk data awal dari DB: ambil angka sebelum titik desimal
        return n.toString().split('.')[0];
    }

    // 3. Event Listener: Menangani ketikan manual user agar tidak macet/salah
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('input-rupiah')) {
            let cursorPosition = e.target.selectionStart;
            let oldLength = e.target.value.length;

            // Langsung format angka murni
            e.target.value = formatNumber(e.target.value);

            let newLength = e.target.value.length;
            cursorPosition = cursorPosition + (newLength - oldLength);
            e.target.setSelectionRange(cursorPosition, cursorPosition);
        }
    });

    // 4. Fungsi setEdit: Menampilkan data ke modal dengan benar
    function setEdit(id, nama, beli, jual, kategori, stok) {
        document.getElementById('editId').value = id;
        document.getElementById('editNama').value = nama;
        document.getElementById('editKategori').value = kategori;
        document.getElementById('editStok').value = stok;

        // Ambil bagian depan angka saja (buang .00)
        let beliBersih = bersihkanDataDB(beli);
        let jualBersih = bersihkanDataDB(jual);
        let jumlahStok = parseFloat(stok) || 0;
        
        // Hitung Satuan
        let hargaSatuan = jumlahStok > 0 ? Math.round(parseInt(beliBersih) / jumlahStok) : 0;

        // Tampilkan di modal
        document.getElementById('editBeli').value = formatNumber(beliBersih);
        document.getElementById('editJual').value = formatNumber(jualBersih);
        document.getElementById('editSatuan').value = formatNumber(hargaSatuan);
    }

    // 5. Sebelum simpan: Buang semua titik agar database tidak error
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            this.querySelectorAll('.input-rupiah').forEach(input => {
                input.value = input.value.replace(/\./g, '');
            });
        });
    });

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