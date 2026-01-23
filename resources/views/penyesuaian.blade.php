@extends('template')

@section('title', 'Penyesuaian Stok - Toko Aulia')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Penyesuaian agar Select2 cocok dengan Bootstrap 5 */
    .select2-container .select2-selection--single {
        height: 38px !important;
        border: 1px solid #dee2e6 !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }
</style>

<div class="mb-4 p-3 text-white rounded shadow-sm d-flex justify-content-between align-items-center" style="background:#1F447A;">
    <h4 class="mb-0">
        <i class="bi bi-shield-check"></i> Form Koreksi Stok Fisik
    </h4>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header text-white fw-bold" style="background:#1F447A;">Detail Penyesuaian</div>
            <div class="card-body">
                <form id="formPenyesuaian">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih & Cari Barang</label>
                        <select class="form-select select-cari" id="id_data_barang" name="id_data_barang">
                            <option value="">-- Ketik Nama Barang --</option>
                            <option value="ID-B001" data-nama="Jilbab Syari" data-stok="25">Jilbab Syari (Stok: 25)</option>
                            <option value="ID-B002" data-nama="Gamis Katun" data-stok="10">Gamis Katun (Stok: 10)</option>
                            <option value="ID-B003" data-nama="Mukena Dewasa" data-stok="15">Mukena Dewasa (Stok: 15)</option>
                            <option value="ID-B004" data-nama="Sajadah Travel" data-stok="40">Sajadah Travel (Stok: 40)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Alasan</label>
                        <select id="alasan_enum" name="alasan_enum" class="form-select">
                            <option value="Keluar">Keluar</option>
                            <option value="Masuk">Masuk</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jumlah Unit (jumlah)</label>
                        <input type="number" id="jumlah" name="jumlah" class="form-control" placeholder="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Keterangan Detail (alasan_text)</label>
                        <textarea id="alasan_text" name="alasan_text" class="form-control" rows="3" placeholder="Contoh: Sobek pada bagian jahitan..."></textarea>
                    </div>

                    <button type="button" class="btn w-100 text-white shadow-sm fw-bold" style="background:#1F447A;" onclick="simpanKoreksi()">
                        <i class="bi bi-save"></i> Simpan Penyesuaian
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold text-primary">
                <i class="bi bi-clock-history"></i> Catatan Aktivitas Penyesuaian Stok
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th class="text-start ps-3">Tanggal</th>
                                <th class="text-start">Nama Barang</th>
                                <th>Stok Sblmnya</th>
                                <th>Alasan</th>
                                <th>Jumlah</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-log">
                            {{-- DATA DUMMY DENGAN BADGE NETRAL (SECONDARY) --}}
                            <tr>
                                <td class="text-start ps-3"><small class="text-muted">23/01/2026 08:30</small></td>
                                <td class="text-start"><strong>Jilbab Syari</strong></td>
                                <td><span class="text-muted">26</span></td>
                                <td><span class="badge bg-secondary">Keluar</span></td>
                                <td class="fw-bold">1</td>
                                <td class="text-start small text-secondary">Kain sobek di gudang</td>
                            </tr>
                            <tr>
                                <td class="text-start ps-3"><small class="text-muted">22/01/2026 14:15</small></td>
                                <td class="text-start"><strong>Sajadah Travel</strong></td>
                                <td><span class="text-muted">42</span></td>
                                <td><span class="badge bg-secondary">Keluar</span></td>
                                <td class="fw-bold">2</td>
                                <td class="text-start small text-secondary">Barang hilang saat opname</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select-cari').select2({
            placeholder: "-- Ketik Nama Barang --",
            allowClear: true,
            width: '100%'
        });
    });

    function simpanKoreksi() {
        const select = document.getElementById('id_data_barang');
        const opt = select.options[select.selectedIndex];
        
        const nama = opt.getAttribute('data-nama');
        const stok = opt.getAttribute('data-stok');
        const tipe = document.getElementById('alasan_enum').value;
        const qty = document.getElementById('jumlah').value;
        const ket = document.getElementById('alasan_text').value;

        const sekarang = new Date();
        const tglString = sekarang.toLocaleDateString('id-ID') + ' ' + sekarang.toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'});

        if (!nama || !qty || !ket) {
            alert("Harap lengkapi semua data!");
            return;
        }

        if (confirm(`Simpan penyesuaian stok untuk ${nama}?`)) {
            const tbody = document.getElementById('tabel-log');
            
            // Badge diset ke bg-secondary (abu-abu gelap) untuk semua kondisi
            const badge = 'bg-secondary';
            
            const row = `
                <tr>
                    <td class="text-start ps-3"><small class="text-muted">${tglString}</small></td>
                    <td class="text-start"><strong>${nama}</strong></td>
                    <td><span class="text-muted">${stok}</span></td>
                    <td><span class="badge ${badge}">${tipe}</span></td>
                    <td class="fw-bold">${qty}</td>
                    <td class="text-start small text-secondary">${ket}</td>
                </tr>
            `;
            tbody.insertAdjacentHTML('afterbegin', row);

            document.getElementById('formPenyesuaian').reset();
            $('.select-cari').val(null).trigger('change'); 
            
            alert("Data berhasil dicatat dan form dibersihkan.");
        }
    }
</script>

@endsection