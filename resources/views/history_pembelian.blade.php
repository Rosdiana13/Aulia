

<table class="table table-bordered table-sm" id="tableHistory">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jumlah</th>
            <th>Sisa Stok</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>
    </thead>

    <tbody>
        @forelse($data as $d)
        <tr>
            <td>
                {{ $d->tanggal_beli ? \Carbon\Carbon::parse($d->tanggal_beli)->format('d-m-Y') : '-' }}
            </td>
            <td>{{ $d->jumlah }}</td>
             <td>{{ $d->sisa_stok }}</td>
            <td>Rp {{ number_format($d->harga) }}</td>
            <td>Rp {{ number_format($d->subtotal) }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">Tidak ada riwayat</td>
        </tr>
        @endforelse
    </tbody>
</table>



