<?php

namespace App\Exports;

use App\Services\ReportService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionReportExport implements FromCollection, WithHeadings, WithStyles
{
    public function __construct(protected array $filters = []) {}

    public function collection()
    {
        $service      = app(ReportService::class);
        $transactions = $service->getTransactionForExport($this->filters);

        return $transactions->map(fn($t, $i) => [
            'No'       => $i + 1,
            'Produk'   => $t->product->name ?? '-',
            'Kategori' => $t->product->category->name ?? '-',
            'User'     => $t->user->name ?? '-',
            'Tipe'     => $t->type === 'in' ? 'Masuk' : 'Keluar',
            'Qty'      => $t->qty,
            'Catatan'  => $t->note ?? '-',
            'Tanggal'  => $t->created_at->format('d/m/Y H:i'),
        ]);
    }

    public function headings(): array
    {
        return ['No', 'Produk', 'Kategori', 'User', 'Tipe', 'Qty', 'Catatan', 'Tanggal'];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}