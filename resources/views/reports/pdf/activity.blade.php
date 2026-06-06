<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Aktivitas</title>
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

        .footer { margin-top: 24px; text-align: right; font-size: 10px; color: #888; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Aktivitas Pengguna — Stockify</h1>
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
                <th>User</th>
                <th>Role</th>
                <th>Aktivitas</th>
                <th>Deskripsi</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $i => $log)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $log->user->name ?? '-' }}</td>
                    <td>{{ str_replace('_', ' ', $log->user->role ?? '-') }}</td>
                    <td>{{ $log->activity }}</td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:#999;">
                        Tidak ada data
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Total: {{ count($logs) }} log</div>

</body>
</html>