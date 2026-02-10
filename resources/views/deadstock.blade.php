@extends('template')

@section('title', 'Notifikasi Dead Stock')

@section('content')

<div class="d-print-none">
    <div class="mb-4 p-3 text-white rounded shadow-sm d-flex justify-content-between align-items-center"
         style="background:#1F447A;">
        <h4 class="mb-0">
            <i class="bi bi-exclamation-octagon-fill"></i>
            Notifikasi Dead Stock (Stok Mati)
        </h4>
        <button onclick="exportToExcel('laporan-dead-stock')" class="btn btn-success btn-sm">
            <i class="bi bi-file-earmark-excel"></i> Excel
        </button>
    </div>
</div>

{{-- Header khusus cetak --}}
<div class="d-none d-print-block text-center mb-4">
    <h4>LAPORAN IDENTIFIKASI STOK MATI (DEAD STOCK)</h4>
    <p>Parameter Batas: Tidak Terjual Selama
        <strong>{{ request('days', 30) }} Hari</strong> atau Lebih
    </p>
    <hr>
</div>

{{-- Filter --}}
<div class="card shadow-sm mb-4 d-print-none border-0">
    <div class="card-body">
        <form method="GET" class="row align-items-end">
            <div class="col-md-6">
                <label class="form-label fw-bold text-danger">
                    Batas Lama Mengendap (Hari)
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-danger text-white">
                        <i class="bi bi-alarm"></i>
                    </span>
                    <input type="number" name="days"
                           class="form-control border-danger"
                           value="{{ request('days', 30) }}"
                           min="1">
                    <span class="input-group-text">Hari</span>
                    <button class="btn btn-danger">
                        <i class="bi bi-funnel"></i> Tampilkan
                    </button>
                </div>
                <div class="form-text">
                    Sistem menampilkan barang dengan lama mengendap ≥ {{ request('days', 30) }} hari.
                </div>
            </div>

            <div class="col-md-6 text-end">
                <div class="p-2 bg-light rounded border border-danger">
                    <small class="text-muted d-block">Kriteria Tampilan</small>
                    <span class="badge bg-danger">
                        Dead Stock ≥ {{ request('days', 30) }} Hari
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Dead Stock --}}
<div class="card shadow-sm border-0">
    <div class="card-header bg-white pt-3 pb-3">
        <div class="row align-items-center">
            <div class="col-md-8">
                <span class="fw-bold text-secondary">
                    <i class="bi bi-table"></i>
                    Daftar Barang Dead Stock
                </span>
            </div>
            <div class="col-md-4 d-print-none">
                <div class="input-group">
                    <span class="input-group-text bg-light">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="cariBarang"
                           class="form-control"
                           placeholder="Cari barang...">
                </div>
            </div>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="tableToExport"
                   class="table table-bordered table-hover mb-0 align-middle">
                <thead class="text-center text-white"
                       style="background:#1F447A;">
                    <tr>
                        <th width="50">No</th>
                        <th class="text-start">Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok Awal</th>
                        <th>Tanggal Masuk / Pembelian</th>
                        <th>Lama Mengendap (Hari)</th>
                    </tr>
                </thead>
                <tbody id="isiLaporan">
                    <tr>
                        <td class="text-center">1</td>
                        <td class="fw-bold">Kaos Polos Cotton Combed</td>
                        <td class="text-center">Fesyen</td>
                        <td class="text-center">50</td>
                        <td class="text-center">05/09/2025</td>
                        <td class="text-center text-danger fw-bold">120</td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td class="fw-bold">Kemeja Lengan Panjang Pria</td>
                        <td class="text-center">Fesyen</td>
                        <td class="text-center">30</td>
                        <td class="text-center">20/09/2025</td>
                        <td class="text-center text-danger fw-bold">105</td>
                    </tr>
                    <tr>
                        <td class="text-center">3</td>
                        <td class="fw-bold">Jaket Hoodie Wanita</td>
                        <td class="text-center">Fesyen</td>
                        <td class="text-center">25</td>
                        <td class="text-center">01/10/2025</td>
                        <td class="text-center text-danger fw-bold">95</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Script --}}
<script>
    // Live Search
    document.getElementById('cariBarang').addEventListener('keyup', function () {
        let value = this.value.toLowerCase();
        document.querySelectorAll('#isiLaporan tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value)
                ? ''
                : 'none';
        });
    });

    // Export Excel
    function exportToExcel(filename = '') {
        let table = document.getElementById("tableToExport");
        let html = table.outerHTML;
        let url = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
        let link = document.createElement("a");
        link.href = url;
        link.download = filename + '.xls';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>

@endsection
