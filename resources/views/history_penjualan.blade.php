@extends('template')

@section('title','History Penjualan')

@section('content')

<div class="card shadow-sm border-0">

    <div class="card-header text-white d-flex justify-content-between align-items-center"
        style="background:#1F447A;">

        <h5 class="mb-0">
            <i class="bi bi-clock-history"></i>
            History Penjualan
        </h5>

        <small>
            Total Data:
            {{ $history_penjualan->total() }}
        </small>
    </div>

    <div class="card-body">

        <!-- FILTER -->
        <form method="GET"
                action="{{ route('penjualan.history') }}"
                class="row g-3 align-items-end mb-4">

                <div class="col-md-3">
                    <label class="form-label fw-bold">
                        Dari Tanggal
                    </label>

                    <input type="date"
                        name="tanggal_awal"
                        class="form-control"
                        value="{{ request('tanggal_awal') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">
                        Sampai Tanggal
                    </label>

                    <input type="date"
                        name="tanggal_akhir"
                        class="form-control"
                        value="{{ request('tanggal_akhir') }}">
                </div>

                <div class="col-md-2">
                    <button type="submit"
                        class="btn text-white w-100"
                        style="background:#1F447A;">

                        <i class="bi bi-funnel"></i>
                        Filter
                    </button>
                </div>

                <div class="col-md-4">

                    <label class="form-label fw-bold">
                        Cari Barang
                    </label>

                    <div class="d-flex gap-2">

                        <input type="text"
                           name="search"
                            id="searchInput"
                            class="form-control"
                            placeholder="Cari nama barang..."
                            value="{{ request('search') }}">

                        <a href="{{ route('penjualan.history') }}"
                            class="btn btn-secondary">

                            Reset
                        </a>

                    </div>

                </div>

            </form>

        <!-- TABEL -->
        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light text-center">

                    <tr>
                        <th width="5%">No</th>
                        <th class="text-start">Nama Barang</th>
                        <th>Tanggal Penjualan</th>
                        <th>Jumlah Terjual</th>
                        <th>Harga Jual</th>
                        <th>Subtotal</th>
                    </tr>

                </thead>

                <tbody class="text-center">

                    @forelse($history_penjualan as $item)

                    <tr>

                        <td>
                            {{ ($history_penjualan->currentPage() - 1) * $history_penjualan->perPage() + $loop->iteration }}
                        </td>

                        <td class="text-start fw-semibold">
                            {{ $item->nama_barang }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal_penjualan)->format('d-m-Y') }}
                        </td>

                        <td>
                            {{ number_format($item->jumlah) }}
                        </td>

                        <td>
                            Rp {{ number_format($item->harga_saat_ini,0,',','.') }}
                        </td>

                        <td class="fw-bold">
                            Rp {{ number_format($item->sub_total_penjualan,0,',','.') }}
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="6" class="text-muted py-4">
                            Data history penjualan belum tersedia
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- PAGINATION -->
        @if($history_penjualan->hasPages())
        <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top bg-light">

            <div class="text-muted small">
                Menampilkan
                {{ $history_penjualan->firstItem() }}
                -
                {{ $history_penjualan->lastItem() }}
                dari
                {{ $history_penjualan->total() }}
                data
            </div>

            <div>
                {{ $history_penjualan
                    ->fragment('history-penjualan')
                    ->links('pagination::bootstrap-4') }}
            </div>

        </div>
        @endif

    </div>

</div>

<script>

document.getElementById('searchInput')
    .addEventListener('input', function () {

        clearTimeout(window.delaySearch);

        window.delaySearch = setTimeout(() => {
            this.form.submit();
        }, 500);
    });
</script>

@endsection