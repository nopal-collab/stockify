<?php

namespace App\Exports;

use App\Services\ReportService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ActivityReportExport implements FromCollection, WithHeadings, WithStyles
{
    public function __construct(protected array $filters = []) {}

    public function collection()
    {
        $service = app(ReportService::class);
        $logs    = $service->getActivityForExport($this->filters);

        return $logs->map(fn($l, $i) => [
            'No'        => $i + 1,
            'User'      => $l->user->name ?? '-',
            'Role'      => str_replace('_', ' ', $l->user->role ?? '-'),
            'Aktivitas' => $l->activity,
            'Deskripsi' => $l->description,
            'Tanggal'   => $l->created_at->format('d/m/Y H:i'),
        ]);
    }

    public function headings(): array
    {
        return ['No', 'User', 'Role', 'Aktivitas', 'Deskripsi', 'Tanggal'];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}