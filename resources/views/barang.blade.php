@extends('template')

@section('title', 'Manajemen Barang')

@section('content')

<div class="mb-4 p-3 text-white rounded shadow-sm" style="background:#1F447A;">
    <h4 class="mb-0">
        <i class="bi bi-box"></i> Manajemen Data Barang
    </h4>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="autoAlert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="autoAlert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="autoAlert">
        {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif


<div class="row">
    {{-- FORM TAMBAH --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header text-white" style="background:#1F447A;">
                Tambah Produk Baru
            </div>
            <div class="card-body">
                <form id="formTambah"
                      action="{{ route('barang.store') }}"
                      method="POST">
                    @csrf

                    <div class="mb-2">
                        <label class="form-label">Nama Barang</label>
                        <input type="text"
                               name="nama_barang"
                               class="form-control"
                               placeholder="Contoh Baju Kaos Merah All size">
                    </div>

                    {{-- INPUT KATEGORI --}}
                    <div class="mb-2">
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-select">
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->Nama_Kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Harga Beli (Modal)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text"
                                   name="harga_beli"
                                   class="form-control input-rupiah"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Harga Jual</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text"
                                   name="harga_jual"
                                   class="form-control input-rupiah"
                                   placeholder="0">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col">
                            <label class="form-label">Stok</label>
                            <input type="number"
                                   name="jumlah"
                                   class="form-control"
                                   placeholder="0">
                        </div>
                        <div class="col">
                            <label class="form-label text-danger">Min. Stok</label>
                            <input type="number"
                                   name="min_stok"
                                   class="form-control border-danger"
                                   placeholder="0">
                        </div>
                    </div>

                    <button type="submit"
                            class="btn w-100 text-white shadow-sm"
                            style="background:#1F447A;">
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

                            @forelse ($barang as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start"><strong>{{ $item->nama_barang }}</strong></td>
                                <td><span>{{ $item->kategori->Nama_Kategori }}</span></td>
                                <td>{{ $item->jumlah }}</td>
                                <td>{{ number_format($item->harga_beli,0,',','.') }}</td>
                                <td>{{ number_format($item->harga_jual,0,',','.') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning"
                                        onclick="setEdit(
                                            '{{ $item->id }}',
                                            '{{ $item->nama_barang }}',
                                            '{{ $item->harga_beli }}',
                                            '{{ $item->harga_jual }}',
                                            '{{ $item->id_kategori }}',
                                            '{{ $item->jumlah }}',
                                            '{{ $item->min_stok }}'
                                        )"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <form action="{{ route('barang.destroy', $item->id) }}"
                                        method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Hapus barang?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="7">
                                    <div class="p-5 text-center text-muted">
                                        Belum ada barang dalam daftar
                                    </div>
                                </td>
                            </tr>
                            @endforelse

                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDIT (STOK + Rp TETAP ADA) --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-content border-0">
                <div class="modal-header text-white" style="background:#1F447A;">
                    <h5 class="modal-title">Edit Produk (Demo)</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editId">

                    <div class="mb-2">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" id="editNama" class="form-control">
                    </div>

                    {{-- EDIT KATEGORI --}}
                    <div class="mb-2">
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" id="editKategori" class="form-select">
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->Nama_Kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- HARGA BELI (READONLY, Rp ADA) --}}
                    <div class="mb-2">
                        <label class="form-label">Harga Beli (Modal)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="text" id="editBeli" class="form-control bg-light" readonly>
                        </div>
                    </div>

                    {{-- HARGA JUAL (Rp ADA) --}}
                    <div class="mb-2">
                        <label class="form-label">Harga Jual</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" name="harga_jual" id="editJual" class="form-control input-rupiah">
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col">
                            <label class="form-label">Stok</label>
                            <input type="number" id="editStok" class="form-control bg-light" readonly>
                        </div>
                        <div class="col">
                            <label class="form-label">Min. Stok</label>
                            <input type="number" name="min_stok" id="editMinStok" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn text-white" style="background:#1F447A;">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
/* ===============================
   HELPER RUPIAH
================================ */

/* Rp 150.000 → 150000 */
function rupiahToNumber(value) {
    if (!value) return 0;
    return parseInt(value.toString().replace(/\D/g, ''), 10);
}

/* 150000 → 150.000 */
function numberToRupiah(number) {
    if (!number) return "";
    // 🔥 PENTING: paksa ke integer → .00 hilang
    number = parseInt(number, 10);
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

/* ===============================
   SET DATA KE MODAL EDIT
================================ */
function setEdit(id, nama, beli, jual, kategori, stok, min) {
    document.getElementById('editNama').value = nama;

    // harga dari DB (ANGKA), diformat SEKALI
    document.getElementById('editBeli').value = numberToRupiah(beli);
    document.getElementById('editJual').value = numberToRupiah(jual);

    document.getElementById('editKategori').value = kategori;
    document.getElementById('editStok').value = stok; // stok = jumlah
    document.getElementById('editMinStok').value = min;

    document.getElementById('formEdit').action = '/barang/' + id;
}

/* ===============================
   FORMAT SAAT USER MENGETIK
================================ */
document.addEventListener('input', function (e) {
    if (e.target.classList.contains('input-rupiah')) {
        e.target.value = numberToRupiah(
            rupiahToNumber(e.target.value)
        );
    }
});

/* ===============================
   SEBELUM SUBMIT (WAJIB)
================================ */
document.getElementById('formTambah').addEventListener('submit', function () {
    this.harga_beli.value = rupiahToNumber(this.harga_beli.value);
    this.harga_jual.value = rupiahToNumber(this.harga_jual.value);
});

document.getElementById('formEdit').addEventListener('submit', function () {
    this.harga_jual.value = rupiahToNumber(this.harga_jual.value);
});

 setTimeout(function () {
        const alert = document.getElementById('autoAlert');
        if (alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000);
</script>


@endsection
