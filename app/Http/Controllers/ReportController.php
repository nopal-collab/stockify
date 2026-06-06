<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StockReportExport;
use App\Exports\TransactionReportExport;
use App\Exports\ActivityReportExport;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | INDEX — halaman utama laporan (tab-based)
    | Satu method ini handle 3 tab sekaligus,
    | tergantung ?tab=stock / transactions / activity di URL
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $role      = Auth::user()->role;
        $activeTab = $request->get('tab', 'stock'); // default tab: stok
        $filters   = $request->only(['category_id', 'date_from', 'date_to', 'type', 'search']);

        $data = ['activeTab' => $activeTab, 'filters' => $filters];

        if ($activeTab === 'stock') {
            $data += $this->reportService->getStockReport($filters);
        }

        if ($activeTab === 'transactions') {
            $data += $this->reportService->getTransactionReport($filters);
        }

        // Tab aktivitas hanya diproses kalau rolenya admin
        if ($activeTab === 'activity' && $role === 'admin') {
            $data += $this->reportService->getActivityReport($filters);
        }

        return view('reports.index', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF — STOK
    |--------------------------------------------------------------------------
    */

    public function stockPdf(Request $request)
    {
        $filters  = $request->only(['category_id', 'date_from', 'date_to']);
        $products = $this->reportService->getStockForExport($filters);

        $pdf = Pdf::loadView('reports.pdf.stock', compact('products', 'filters'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-stok-' . now()->format('Ymd') . '.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL — STOK
    |--------------------------------------------------------------------------
    */

    public function stockExcel(Request $request)
    {
        $filters = $request->only(['category_id', 'date_from', 'date_to']);

        return Excel::download(
            new StockReportExport($filters),
            'laporan-stok-' . now()->format('Ymd') . '.xlsx'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF — TRANSAKSI
    |--------------------------------------------------------------------------
    */

    public function transactionPdf(Request $request)
    {
        $filters      = $request->only(['type', 'category_id', 'date_from', 'date_to']);
        $transactions = $this->reportService->getTransactionForExport($filters);

        $pdf = Pdf::loadView('reports.pdf.transactions', compact('transactions', 'filters'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-transaksi-' . now()->format('Ymd') . '.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL — TRANSAKSI
    |--------------------------------------------------------------------------
    */

    public function transactionExcel(Request $request)
    {
        $filters = $request->only(['type', 'category_id', 'date_from', 'date_to']);

        return Excel::download(
            new TransactionReportExport($filters),
            'laporan-transaksi-' . now()->format('Ymd') . '.xlsx'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF — AKTIVITAS (admin only)
    |--------------------------------------------------------------------------
    */

    public function activityPdf(Request $request)
    {
        $filters = $request->only(['search', 'date_from', 'date_to']);
        $logs    = $this->reportService->getActivityForExport($filters);

        $pdf = Pdf::loadView('reports.pdf.activity', compact('logs', 'filters'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-aktivitas-' . now()->format('Ymd') . '.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL — AKTIVITAS (admin only)
    |--------------------------------------------------------------------------
    */

    public function activityExcel(Request $request)
    {
        $filters = $request->only(['search', 'date_from', 'date_to']);

        return Excel::download(
            new ActivityReportExport($filters),
            'laporan-aktivitas-' . now()->format('Ymd') . '.xlsx'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LEGACY — products PDF
    | Tetap dipertahankan karena masih dipanggil dari route 'products.report'
    | yang ada di tombol Export PDF halaman products/index.blade.php
    |--------------------------------------------------------------------------
    */

    public function productsPdf()
    {
        $filters  = [];
        $products = $this->reportService->getStockForExport($filters);

        $pdf = Pdf::loadView('reports.pdf.stock', compact('products', 'filters'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('products-report.pdf');
    }
}