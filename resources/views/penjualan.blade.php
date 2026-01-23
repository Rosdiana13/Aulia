@extends('template')

@section('title','Barang Keluar')

@section('content')

<form action="#" method="POST">
@csrf

<!-- HEADER -->
<div class="mb-4 p-3 text-white rounded shadow-sm" style="background:#1F447A;">
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="mb-0">
            <i class="bi bi-box-arrow-right"></i> Transaksi Barang Keluar
        </h4>
        <span class="badge bg-light text-dark">{{ date('d M Y') }}</span>
    </div>
</div>

<div class="row">
    <!-- INPUT -->
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-header text-white" style="background:#1F447A;">
                Input Data Barang
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Pilih Produk</label>
                    <select id="pilih-barang" class="form-select">
                        <option value="">-- Pilih Barang --</option>
                        <option value="BRG001" data-nama="Kaos Aulia" data-harga="50000">Kaos Aulia</option>
                        <option value="BRG002" data-nama="Jilbab Syari" data-harga="75000">Jilbab Syari</option>
                        <option value="BRG003" data-nama="Gamis Katun" data-harga="120000">Gamis Katun</option>
                        <option value="BRG004" data-nama="Sepatu Sneakers" data-harga="275000">Sepatu Sneakers</option>
                        <option value="BRG005" data-nama="Tas Selempang" data-harga="185000">Tas Selempang</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Keluar</label>
                    <input type="number" id="input-qty" class="form-control" value="1" min="1">
                </div>

                <button type="button" onclick="tambahKeKeranjang()" class="btn w-100 text-white" style="background:#1F447A;">
                    <i class="bi bi-plus-lg"></i> Tambahkan
                </button>
            </div>
        </div>
    </div>

    <!-- KERANJANG -->
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header text-white" style="background:#1F447A;">
                Daftar Barang Keluar
            </div>

            <div class="card-body p-0">
                <table class="table table-hover mb-0 text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start ps-3">Nama Barang</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th class="text-end pe-3">Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="isi-keranjang"></tbody>
                </table>

                <div id="pesan-kosong" class="p-5 text-center text-muted">
                    Belum ada barang dalam daftar
                </div>
            </div>
        </div>

        <!-- TOTAL -->
        <div class="card shadow-sm border-0 mt-3">
            <div class="card-body d-flex justify-content-between align-items-center bg-light">
                <div>
                    <span class="text-muted fw-bold">TOTAL:</span>
                    <h3 class="mb-0 fw-bold text-primary">
                        Rp <span id="label-total">0</span>
                    </h3>
                </div>

                <button type="button" class="btn btn-success btn-lg px-5" disabled>
                    <i class="bi bi-check-circle"></i> Simpan (Dummy)
                </button>
            </div>
        </div>
    </div>
</div>
</form>

<script>
let keranjang = [];

function tambahKeKeranjang() {
    const select = document.getElementById('pilih-barang');
    const opt = select.options[select.selectedIndex];
    const qty = parseInt(document.getElementById('input-qty').value);

    if (!opt.value) {
        alert('Pilih barang terlebih dahulu!');
        return;
    }

    const id = opt.value;
    const nama = opt.dataset.nama;
    const harga = parseInt(opt.dataset.harga);

    const index = keranjang.findIndex(item => item.id === id);
    if (index > -1) {
        keranjang[index].qty += qty;
    } else {
        keranjang.push({ id, nama, harga, qty });
    }

    renderTabel();
}

function renderTabel() {
    const tbody = document.getElementById('isi-keranjang');
    const kosong = document.getElementById('pesan-kosong');

    tbody.innerHTML = '';
    let total = 0;

    if (keranjang.length === 0) {
        kosong.classList.remove('d-none');
        document.getElementById('label-total').innerText = 0;
        return;
    }

    kosong.classList.add('d-none');

    keranjang.forEach((item, index) => {
        const subtotal = item.qty * item.harga;
        total += subtotal;

        tbody.innerHTML += `
        <tr>
            <td class="text-start ps-3">${item.nama}</td>
            <td>
                <input type="number" min="1" value="${item.qty}"
                    class="form-control form-control-sm text-center"
                    onchange="ubahQty(${index}, this.value)">
            </td>
            <td>${item.harga.toLocaleString('id-ID')}</td>
            <td class="text-end pe-3 fw-bold">${subtotal.toLocaleString('id-ID')}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm"
                    onclick="hapusItem(${index})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>`;
    });

    document.getElementById('label-total').innerText = total.toLocaleString('id-ID');
}

function ubahQty(index, qty) {
    qty = parseInt(qty);
    if (qty < 1) return;
    keranjang[index].qty = qty;
    renderTabel();
}

function hapusItem(index) {
    keranjang.splice(index, 1);
    renderTabel();
}
</script>

@endsection
