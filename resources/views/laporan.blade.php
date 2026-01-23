@extends('template')

@section('title', 'Laporan Barang Mengendap')

@section('content')

<div class="d-print-none">
    <div class="mb-4 p-3 text-white rounded shadow-sm d-flex justify-content-between align-items-center" style="background:#1F447A;">
        <h4 class="mb-0">
            <i class="bi bi-clock-history"></i> Identifikasi Barang Mengendap (Aging Report)
        </h4>
        <div>
            <button onclick="exportToExcel('laporan-barang-mengendap')" class="btn btn-light btn-sm">
                <i class="bi bi-file-earmark-excel"></i> Excel
            </button>
        </div>
    </div>
</div>

<div class="d-none d-print-block text-center mb-4">
    <h4>LAPORAN IDENTIFIKASI BARANG MENGENDAP</h4>
    <p>Periode Filter Stok Masuk: <strong>{{ request('start_date') ?? '01/01/2026' }}</strong> s/d <strong>{{ request('end_date') ?? date('d/m/Y') }}</strong></p>
    <hr>
</div>

<div class="card shadow-sm mb-4 d-print-none border-0">
    <div class="card-body">
        <form action="{{ url()->current() }}" method="GET" class="row align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-bold">Dari Tanggal Beli:</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date', '2026-01-01') }}">
            </div>
            <div class="col-md-5">
                <label class="form-label fw-bold">Sampai Tanggal Beli:</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date', date('Y-m-d')) }}">
            </div>
            <div class="col-md-2">
                {{-- Tombol ini tetap sama, tidak diubah --}}
                <button type="submit" class="btn btn-primary w-100 shadow-sm" style="background:#1F447A; border:none;">
                    <i class="bi bi-filter"></i> Jalankan Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white pt-3 pb-3">
        <div class="row align-items-center">
            <div class="col-md-8">
                <span class="fw-bold text-secondary"><i class="bi bi-table"></i> Hasil Analisis Modal Macet</span>
            </div>
            {{-- Search bar tetap di atas tabel --}}
            <div class="col-md-4 d-print-none">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="cariBarang" class="form-control border-start-0 ps-0" placeholder="Cari nama barang di tabel ini...">
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            {{-- Tabel diberi ID agar bisa ditarik ke Excel --}}
            <table id="tableToExport" class="table table-bordered table-hover mb-0 align-middle">
                <thead class="text-white text-center" style="background:#1F447A;">
                    <tr>
                        <th width="50">No</th>
                        <th class="text-start">Nama Barang</th>
                        <th>Tgl Pembelian (Masuk)</th> <th>Tgl Penjualan Terakhir</th> <th>Umur (Masa Tunggu)</th> <th>Stok Sisa</th>
                        <th>Harga Beli</th>
                        <th>Total Modal Macet</th>
                    </tr>
                </thead>
                <tbody id="isiLaporan">
                    <tr>
                        <td class="text-center">1</td>
                        <td>Panci Set Jumbo Aulia</td>
                        <td class="text-center">20/10/2025</td>
                        <td class="text-center text-danger small"><em>Belum Pernah Laku</em></td>
                        <td class="text-center">95 Hari <br><small class="text-muted">(Sejak Beli)</small></td>
                        <td class="text-center">10</td>
                        <td class="text-end px-3">150.000</td>
                        <td class="text-end px-3 fw-bold">1.500.000</td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td>Sapu Ijuk Super</td>
                        <td class="text-center">05/12/2025</td>
                        <td class="text-center">02/01/2026</td>
                        <td class="text-center">28 Hari <br><small class="text-muted">(Beli s/d Jual)</small></td>
                        <td class="text-center">45</td>
                        <td class="text-end px-3">20.000</td>
                        <td class="text-end px-3 fw-bold">900.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk Export ke Excel tanpa mengubah tampilan filter
    function exportToExcel(filename = '') {
        let table = document.getElementById("tableToExport");
        let html = table.outerHTML;

        let url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
        let downloadLink = document.createElement("a");

        document.body.appendChild(downloadLink);
        downloadLink.href = url;
        downloadLink.download = filename + '.xls';
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }

    // Live Search
    document.getElementById('cariBarang').addEventListener('keyup', function() {
        let val = this.value.toLowerCase();
        let rows = document.querySelectorAll('#isiLaporan tr');
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(val) ? '' : 'none';
        });
    });
</script>

@endsection