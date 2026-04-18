@extends('template')

@section('title','Dashboard')

@section('content')

@if(session('login_success'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <strong>Berhasil!</strong> {{ session('login_success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="mb-4">
    <h4 class="fw-bold text-dark">Ringkasan Inventori</h4>
    <hr>
</div>

<div class="row mb-4">
    <!-- TOTAL BARANG -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm text-white" style="background: #1F447A;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="font-size: 0.8rem; opacity: 0.8;">
                            Total Barang (Jenis)
                        </h6>
                        <h2 class="mb-0 fw-bold">{{ $total_barang }}</h2>
                    </div>
                    <i class="bi bi-box-seam" style="font-size: 2.5rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- TOTAL STOK -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm text-white" style="background: #1F447A;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1" style="font-size: 0.8rem; opacity: 0.8;">
                            Total Stok (Unit)
                        </h6>
                        <h2 class="mb-0 fw-bold">{{ $total_stok }}</h2>
                    </div>
                    <i class="bi bi-stack" style="font-size: 2.5rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PENJUALAN HARI INI -->
<div class="card border-0 shadow-sm mt-4">

    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
    
        <!-- KIRI -->
        <h5 class="mb-0 fw-bold text-dark">
            <i class="bi bi-cart-check text-success me-2"></i>
            Penjualan Hari Ini
        </h5>

        <!-- KANAN -->
        <div class="d-flex align-items-center gap-2">
            
            <!-- Tombol -->
            <button onclick="exportToExcel()" class="btn btn-success btn-sm">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </button>

            <!-- Tanggal -->
            <small class="text-muted">
                {{ now()->format('d F Y') }}
            </small>

        </div>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table id="tableToExport" class="table table-hover mb-0 align-middle">

                <thead class="table-light text-secondary text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th class="text-start">Nama Barang</th>
                        <th width="15%">Tanggal</th>
                        <th width="10%">Jumlah</th>
                        <th width="15%">Harga Jual</th>
                        <th width="15%">Subtotal</th>
                    </tr>
                </thead>

                <tbody class="text-center">
                    @forelse($penjualan_hari_ini as $p)
                    <tr>
                        <td>
                            {{ ($penjualan_hari_ini->currentPage() - 1) * $penjualan_hari_ini->perPage() + $loop->iteration }}
                        </td>
                        <td class="text-start fw-semibold">
                            {{ $p->nama_barang }}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}
                        </td>
                        <td>{{ number_format($p->jumlah) }}</td>
                        <td>Rp {{ number_format($p->harga_jual, 0, ',', '.') }}</td>
                        <td class="fw-bold">
                            Rp {{ number_format($p->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-muted py-4">
                            Belum ada transaksi hari ini
                        </td>
                    </tr>
                    @endforelse
                </tbody>

                <tfoot class="table-light">
                    <tr>
                        <th colspan="5" class="text-end">
                            Total Pendapatan Hari Ini:
                        </th>
                        <th class="text-primary fs-5">
                            Rp {{ number_format($total_pendapatan_hari_ini, 0, ',', '.') }}
                        </th>
                    </tr>
                </tfoot>

            </table>
        </div>

        {{-- Pagination --}}
        @if($penjualan_hari_ini->hasPages())
        <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top bg-light">
            <div class="text-muted small">
                Menampilkan {{ $penjualan_hari_ini->firstItem() }} -
                {{ $penjualan_hari_ini->lastItem() }}
                dari {{ $penjualan_hari_ini->total() }} data
            </div>

            <div>
                {{ $penjualan_hari_ini->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @endif

    </div>
</div>

<!-- BARANG PERLU RESTOK -->
<div class="card border-0 shadow-sm mt-4">

    <div class="card-header py-3" style="background: #1F447A;">
        <h5 class="mb-0 fw-bold text-danger">
            <i class="bi bi-exclamation-triangle me-2"></i>
            Barang Perlu Restok
        </h5>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">

                <thead class="table-light text-center">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Min Stok</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody class="text-center">
                    @forelse($barang_restok as $b)
                    <tr>
                        <td class="text-start fw-semibold">
                            {{ $b->nama_barang }}
                        </td>
                        <td>{{ $b->kategori->Nama_Kategori }}</td>
                        <td class="text-danger fw-bold">
                            {{ $b->jumlah }}
                        </td>
                        <td>{{ $b->min_stok }}</td>
                        <td>
                            <span class="badge bg-danger">
                                Perlu Restok
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-muted py-4">
                            Semua stok aman 
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

<!-- GRAFIK -->
<div class="card shadow-sm mt-4">

    <div class="card-header d-flex justify-content-between align-items-center text-white" style="background: #1F447A;">

        <h5 class="fw-bold mb-0" >
            @if(request('filter','harian')=='harian')
                Grafik Penjualan Harian
            @else
                Grafik Penjualan Bulanan
            @endif
        </h5>

        <form method="GET" class="d-flex gap-2">

            <select name="filter" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="harian" {{ request('filter','harian')=='harian'?'selected':'' }}>Harian</option>
                <option value="bulanan" {{ request('filter')=='bulanan'?'selected':'' }}>Bulanan</option>
            </select>

            @if(request('filter','harian')=='harian')
            <select name="range" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="7" {{ request('range')=='7'?'selected':'' }}>7 Hari</option>
                <option value="30" {{ request('range',30)=='30'?'selected':'' }}>30 Hari</option>
                <option value="90" {{ request('range')=='90'?'selected':'' }}>90 Hari</option>
            </select>
            @endif

        </form>
    </div>

    <div class="card-body">
        <canvas id="grafikPenjualan" height="100"></canvas>

        <small class="text-muted">
            @if(request('filter','harian')=='harian')
                Menampilkan {{ request('range',30) }} hari terakhir
            @else
                Menampilkan 12 bulan terakhir
            @endif
        </small>
    </div>

</div>


@push('scripts')

<script>
window.onload = function() {
    const alert = document.getElementById('success-alert');
    if (alert) {
        setTimeout(function() {
            alert.classList.add('fade');
            setTimeout(() => alert.remove(), 500);
        }, 3000);
    }
};

function exportToExcel() {
    let table = document.getElementById("tableToExport");

    if (!table) {
        alert("Tabel tidak ditemukan!");
        return;
    }

    let wb = XLSX.utils.book_new();
    let ws = XLSX.utils.table_to_sheet(table);

    XLSX.utils.book_append_sheet(wb, ws, "Penjualan Harian");

    let today = new Date();
    let tanggal = today.getFullYear() + '-' +
                  String(today.getMonth()+1).padStart(2, '0') + '-' +
                  String(today.getDate()).padStart(2, '0');

    XLSX.writeFile(wb, "penjualan-harian-" + tanggal + ".xlsx");
}

document.addEventListener("DOMContentLoaded", function () {

    const labels = @json($tanggal ?? []);
    const dataPenjualan = @json($total_penjualan ?? []);

    if (!labels.length) {
        console.warn("Data grafik kosong");
        return;
    }

    const canvas = document.getElementById('grafikPenjualan');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Penjualan (Rp)',
                data: dataPenjualan,
                borderColor: '#1F447A',
                backgroundColor: 'rgba(31, 68, 122, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

});
</script>
@endpush

@endsection
