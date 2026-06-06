<?php

namespace App\Services;

use App\Repositories\Interfaces\ActivityLogRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;

class ReportService
{
    public function __construct(
        protected ActivityLogRepositoryInterface $activityLogRepository,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | LAPORAN STOK BARANG
    | Filter: category_id, date_from, date_to
    |--------------------------------------------------------------------------
    */

    public function getStockReport(array $filters): array
    {
        $query = Product::with(['category', 'supplier']);

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        $products   = $query->latest()->paginate(10)->appends($filters);
        $categories = Category::all();
        $totalStockIn = Product::when(
                !empty($filters['category_id']),
                fn($q) => $q->where('category_id', $filters['category_id'])
            )->sum('stock');

        return compact('products', 'categories', 'totalStockIn');
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN TRANSAKSI BARANG MASUK & KELUAR
    | Filter: type (in/out), date_from, date_to, category_id
    |--------------------------------------------------------------------------
    */

    public function getTransactionReport(array $filters): array
    {
        $query = StockTransaction::with(['product.category', 'user'])
            ->where('status', 'confirmed');

        if (!empty($filters['type']) && in_array($filters['type'], ['in', 'out'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        if (!empty($filters['category_id'])) {
            $query->whereHas('product', fn($q) => $q->where('category_id', $filters['category_id']));
        }

        $transactions = $query->latest()->paginate(10)->appends($filters);
        $categories   = Category::all();

        // Query terpisah untuk summary (tidak terpengaruh paginate)
        $summaryQuery = StockTransaction::where('status', 'confirmed');

        if (!empty($filters['date_from'])) {
            $summaryQuery->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $summaryQuery->whereDate('created_at', '<=', $filters['date_to']);
        }
        if (!empty($filters['category_id'])) {
            $summaryQuery->whereHas('product', fn($q) => $q->where('category_id', $filters['category_id']));
        }

        $totalIn  = (clone $summaryQuery)->where('type', 'in')->sum('qty');
        $totalOut = (clone $summaryQuery)->where('type', 'out')->sum('qty');

        return compact('transactions', 'categories', 'totalIn', 'totalOut');
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN AKTIVITAS PENGGUNA (admin only)
    | Filter: search (nama user / aktivitas), date_from, date_to
    |--------------------------------------------------------------------------
    */

    public function getActivityReport(array $filters): array
    {
        $logs      = $this->activityLogRepository->getPaginated($filters, perPage: 10);
        $logs->appends($filters);
        $totalLogs = $this->activityLogRepository->getPaginated([], perPage: 1)->total();

        return compact('logs', 'totalLogs');
    }

    /*
    |--------------------------------------------------------------------------
    | GET ALL FOR EXPORT — tanpa paginate, dipakai saat export PDF/Excel
    |--------------------------------------------------------------------------
    */

    public function getStockForExport(array $filters)
    {
        $query = Product::with(['category', 'supplier']);

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query->latest()->get();
    }

    public function getTransactionForExport(array $filters)
    {
        $query = StockTransaction::with(['product.category', 'user'])
            ->where('status', 'confirmed');

        if (!empty($filters['type']) && in_array($filters['type'], ['in', 'out'])) {
            $query->where('type', $filters['type']);
        }
        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }
        if (!empty($filters['category_id'])) {
            $query->whereHas('product', fn($q) => $q->where('category_id', $filters['category_id']));
        }

        return $query->latest()->get();
    }

    public function getActivityForExport(array $filters)
    {
        return $this->activityLogRepository->getAllForExport($filters);
    }
}