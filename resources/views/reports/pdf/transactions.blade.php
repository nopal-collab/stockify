<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }

        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #2563EB; padding-bottom: 12px; }
        .header h1 { font-size: 18px; margin: 0; color: #1e40af; }
        .header p  { margin: 4px 0 0; font-size: 11px; color: #666; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead tr { background: #1e40af; color: #fff; }
        th { padding: 8px 10px; text-align: left; font-size: 11px; }
        td { padding: 7px 10px; border-bottom: 1px solid #e5e7eb; }
        tr:nth-child(even) td { background: #f0f4ff; }

        .badge-in  { background: #dcfce7; color: #16a34a; padding: 2px 8px; border-radius: 99px; font-size: 10px; font-weight: bold; }
        .badge-out { background: #fee2e2; color: #dc2626; padding: 2px 8px; border-radius: 99px; font-size: 10px; font-weight: bold; }
        .footer { margin-top: 24px; text-align: right; font-size: 10px; color: #888; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Transaksi Barang — Stockify</h1>
        <p>
            Dicetak: {{ now()->format('d M Y, H:i') }}
            @if(!empty($filters['date_from']) || !empty($filters['date_to']))
                &nbsp;|&nbsp; Periode: {{ $filters['date_from'] ?? '—' }} s/d {{ $filters['date_to'] ?? '—' }}
            @endif
        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Kategori</th>
                <th>User</th>
                <th>Tipe</th>
                <th>Qty</th>
                <th>Catatan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $i => $t)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $t->product->name          ?? '-' }}</td>
                    <td>{{ $t->product->category->name ?? '-' }}</td>
                    <td>{{ $t->user->name              ?? '-' }}</td>
                    <td>
                        @if($t->type === 'in')
                            <span class="badge-in">Masuk</span>
                        @else
                            <span class="badge-out">Keluar</span>
                        @endif
                    </td>
                    <td>{{ $t->qty }}</td>
                    <td>{{ $t->note ?? '-' }}</td>
                    <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; color:#999;">
                        Tidak ada data
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Total: {{ count($transactions) }} transaksi</div>

</body>
</html>