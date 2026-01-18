@extends('template')

@section('title', 'Laporan Nilai Aset')

@section('content')

<div class="d-print-none">
    <div class="mb-4 p-3 text-white rounded shadow-sm d-flex justify-content-between align-items-center" style="background:#1F447A;">
        <h4 class="mb-0">
            <i class="bi bi-file-earmark-spreadsheet"></i> Laporan Nilai Inventori (Metode AVG)
        </h4>
        <div>
            <button onclick="window.print()" class="btn btn-light btn-sm">
                <i class="bi bi-printer"></i> Cetak Laporan
            </button>
        </div>
    </div>
</div>

<div class="d-none d-print-block text-center mb-4">
    <h4>LAPORAN STOK & NILAI ASET INVENTORI</h4>
    <p>Per Tanggal: {{ date('d F Y') }}</p>
    <hr>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="mb-1">Total Item Barang</p>
                        <h2 class="mb-0 fw-bold">150 <small style="font-size: 15px">Unit</small></h2>
                    </div>
                    <i class="bi bi-box-seam fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="mb-1">Total Nilai Investasi (Aset)</p>
                        <h2 class="mb-0 fw-bold">Rp 12.500.000</h2>
                    </div>
                    <i class="bi bi-currency-dollar fs-1 opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <span class="fw-bold"><i class="bi bi-table"></i> Rincian Nilai Barang</span>
            </div>
            <div class="col-md-4">
                <input type="text" id="cariBarang" class="form-control form-control-sm" placeholder="Cari barang...">
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped mb-0">
                <thead class="text-white" style="background:#1F447A;">
                    <tr class="text-center">
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga Beli (AVG)</th>
                        <th>Total Nilai Aset</th>
                    </tr>
                </thead>
                <tbody id="isiLaporan">
                    <tr>
                        <td class="text-center">1</td>
                        <td>Kaos Aulia Merah XL</td>
                        <td class="text-center">Fashion</td>
                        <td class="text-center fw-bold">20</td>
                        <td class="text-end">Rp 55.000</td>
                        <td class="text-end fw-bold">Rp 1.100.000</td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td>Sepatu Sport Putih</td>
                        <td class="text-center">Sepatu</td>
                        <td class="text-center fw-bold">10</td>
                        <td class="text-end">Rp 150.000</td>
                        <td class="text-end fw-bold">Rp 1.500.000</td>
                    </tr>
                </tbody>
                <tfoot class="table-dark">
                    <tr>
                        <td colspan="5" class="text-end fw-bold">TOTAL KESELURUHAN ASET :</td>
                        <td class="text-end fw-bold" style="background: #ffc107; color: black;">Rp 2.600.000</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="d-none d-print-block mt-5">
    <div class="row text-center">
        <div class="col-8"></div>
        <div class="col-4">
            <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
            <br><br><br>
            <p class="fw-bold">( ____________________ )</p>
            <p>Admin Gudang</p>
        </div>
    </div>
</div>

<script>
    // Fitur Search Sederhana
    document.getElementById('cariBarang').addEventListener('keyup', function() {
        let val = this.value.toLowerCase();
        let rows = document.querySelectorAll('#isiLaporan tr');
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(val) ? '' : 'none';
        });
    });
</script>

<style>
    @media print {
        body { background-color: white !important; }
        .card { border: none !important; box-shadow: none !important; }
        .table thead th { background-color: #1F447A !important; color: white !important; -webkit-print-color-adjust: exact; }
    }
</style>

@endsection