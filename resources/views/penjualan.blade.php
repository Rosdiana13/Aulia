@extends('template')

@section('title','Barang Keluar')

@section('content')

<form action="{{ url('/penjualan/store') }}" method="POST">
    @csrf 
    <div class="mb-4 p-3 text-white rounded shadow-sm" style="background:#1F447A;">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-box-arrow-right"></i> Transaksi Barang Keluar
            </h4>
            <span class="badge bg-light text-dark">{{ date('d M Y') }}</span>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header text-white" style="background:#1F447A;">
                    Input Data Barang
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Produk</label>
                        <select id="pilih-barang" class="form-select">
                            <option value="">-- Cari Nama Barang --</option>
                            <option value="1" data-nama="Kaos Aulia" data-harga="50000">Kaos Aulia</option>
                            <option value="2" data-nama="Jilbab Syari" data-harga="75000">Jilbab Syari</option>
                            <option value="3" data-nama="Gamis Katun" data-harga="120000">Gamis Katun</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Jumlah Keluar</label>
                        <input type="number" id="input-qty" class="form-control" value="1" min="1">
                    </div>

                    <button type="button" class="btn w-100 text-white shadow-sm" style="background:#1F447A;" onclick="tambahKeKeranjang()">
                        <i class="bi bi-plus-lg"></i> Tambahkan
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white" style="background:#1F447A;">
                    Daftar Barang Keluar
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0 text-center align-middle" id="tabel-keranjang">
                        <thead class="table-light">
                            <tr>
                                <th class="text-start ps-3">Nama Barang</th>
                                <th>Qty</th>
                                <th>Harga Jual (Rp)</th> 
                                <th class="text-end pe-3">Subtotal</th>
                                {{-- Kolom Aksi Dihapus --}}
                            </tr>
                        </thead>
                        <tbody id="isi-keranjang">
                            {{-- Baris akan muncul di sini --}}
                        </tbody>
                    </table>

                    <div id="pesan-kosong" class="p-5 text-center text-muted">
                        Belum ada barang dalam daftar
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mt-3">
                <div class="card-body d-flex justify-content-between align-items-center bg-light rounded">
                    <div>
                        <span class="text-muted small fw-bold">TOTAL HARGA:</span>
                        <h3 class="mb-0 fw-bold text-primary">Rp <span id="label-total">0</span></h3>
                        <input type="hidden" name="total_transaksi" id="input-total" value="0">
                    </div>
                    
                    <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm" id="btn-simpan" disabled>
                        <i class="bi bi-cloud-arrow-up"></i> Simpan Data
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
        const selectedOption = select.options[select.selectedIndex];
        const qtyInput = document.getElementById('input-qty');

        if (!selectedOption.value) {
            alert("Silakan pilih barang dulu!");
            return;
        }

        const id = selectedOption.value;
        const nama = selectedOption.getAttribute('data-nama');
        const harga = parseInt(selectedOption.getAttribute('data-harga'));
        const qty = parseInt(qtyInput.value);

        const indexExist = keranjang.findIndex(item => item.id === id);
        if (indexExist > -1) {
            keranjang[indexExist].qty += qty;
        } else {
            keranjang.push({ id, nama, harga, qty });
        }

        renderTabel();
        qtyInput.value = 1;
    }

    function renderTabel() {
        const tbody = document.getElementById('isi-keranjang');
        const pesanKosong = document.getElementById('pesan-kosong');
        const btnSimpan = document.getElementById('btn-simpan');
        let html = '';
        let total = 0;

        if (keranjang.length > 0) {
            pesanKosong.classList.add('d-none');
            btnSimpan.disabled = false;
        }

        keranjang.forEach((item, index) => {
            const subtotal = item.harga * item.qty;
            total += subtotal;
            html += `
                <tr>
                    <td class="text-start ps-3">
                        <strong>${item.nama}</strong>
                        <input type="hidden" name="items[${index}][id_barang]" value="${item.id}">
                        <input type="hidden" name="items[${index}][harga_jual]" value="${item.harga}">
                        <input type="hidden" name="items[${index}][qty]" value="${item.qty}">
                    </td>
                    <td>${item.qty}</td>
                    <td>${item.harga.toLocaleString('id-ID')}</td>
                    <td class="text-end pe-3 fw-bold">${subtotal.toLocaleString('id-ID')}</td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
        document.getElementById('label-total').innerText = total.toLocaleString('id-ID');
        document.getElementById('input-total').value = total;
    }
</script>

@endsection