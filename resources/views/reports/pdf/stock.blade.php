<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Barang</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }

        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #2563EB; padding-bottom: 12px; }
        .header h1 { font-size: 18px; margin: 0; color: #1e40af; }
        .header p  { margin: 4px 0 0; font-size: 11px; color: #666; }

        table { width: 100%; border-collapse: collapse; }
        thead tr { background: #1e40af; color: #fff; }
        th { padding: 8px 10px; text-align: left; font-size: 11px; }
        td { padding: 7px 10px; border-bottom: 1px solid #e5e7eb; }
        tr:nth-child(even) td { background: #f0f4ff; }

        .badge-low { background: #fee2e2; color: #dc2626; padding: 2px 8px; border-radius: 99px; font-size: 10px; }
        .footer { margin-top: 24px; text-align: right; font-size: 10px; color: #888; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Stok Barang — Stockify</h1>
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
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Supplier</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Tgl Input</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $i => $product)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>{{ $product->supplier->name  ?? '-' }}</td>
                    <td>
                        {{ $product->stock }}
                        @if($product->stock <= 5)
                            <span class="badge-low">Menipis</span>
                        @endif
                    </td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center; color:#999;">
                        Tidak ada data
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Total: {{ count($products) }} produk</div>

</body>
</html>