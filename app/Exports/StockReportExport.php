<?php

namespace App\Exports;

use App\Services\ReportService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockReportExport implements FromCollection, WithHeadings, WithStyles
{
    public function __construct(protected array $filters = []) {}

    public function collection()
    {
        $service  = app(ReportService::class);
        $products = $service->getStockForExport($this->filters);

        return $products->map(fn($p, $i) => [
            'No'        => $i + 1,
            'Nama'      => $p->name,
            'Kategori'  => $p->category->name ?? '-',
            'Supplier'  => $p->supplier->name ?? '-',
            'Stok'      => $p->stock,
            'Harga'     => 'Rp ' . number_format($p->price, 0, ',', '.'),
            'Tgl Input' => $p->created_at->format('d/m/Y'),
        ]);
    }

    public function headings(): array
    {
        return ['No', 'Nama Produk', 'Kategori', 'Supplier', 'Stok', 'Harga', 'Tanggal Input'];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}