<?php

namespace App\Services;

use App\Repositories\Interfaces\ActivityLogRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\Supplier;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\StockTransactionRepositoryInterface;

class DashboardService
{
    public function __construct(
        protected ProductRepositoryInterface          $productRepository,
        protected StockTransactionRepositoryInterface $transactionRepository,
        protected ActivityLogRepositoryInterface      $activityLogRepository,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    public function getAdminData(string $period = 'monthly'): array
    {
        $totalProducts   = Product::count();
        $totalCategories = Category::count();
        $totalSuppliers  = Supplier::count();

        $query = StockTransaction::query();

        $query = match ($period) {
            'daily'   => $query->whereDate('created_at', today()),
            'weekly'  => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
            'monthly' => $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
            'yearly'  => $query->whereYear('created_at', now()->year),
            default   => $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year),
        };

        $totalIn  = (clone $query)->where('type', 'in')->where('status', 'confirmed')->count();
        $totalOut = (clone $query)->where('type', 'out')->where('status', 'confirmed')->count();

        $recentActivities = $this->activityLogRepository->getLatest(8);

        $stockProducts = $this->productRepository->getAllForChart();
        $productNames  = $stockProducts->pluck('name')->toArray();
        $productStocks = $stockProducts->pluck('stock')->toArray();

        [$chartMonths, $chartIn, $chartOut] = $this->buildChartData();

        // Jumlah produk dengan stok menipis (untuk badge di admin)
        $lowStockCount = Product::whereColumn('stock', '<=', 'min_stock')->count();

        return compact(
            'totalProducts', 'totalCategories', 'totalSuppliers',
            'totalIn', 'totalOut', 'period',
            'recentActivities',
            'productNames', 'productStocks',
            'chartMonths', 'chartIn', 'chartOut',
            'lowStockCount',
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MANAJER GUDANG
    | getLowStock() sekarang pakai min_stock per-produk (tidak hardcode 5)
    |--------------------------------------------------------------------------
    */

    public function getManajerData(): array
    {
        // Ambil produk yang stoknya ≤ min_stock masing-masing
        $lowStocks = $this->productRepository->getLowStock();

        $todayIn = StockTransaction::with(['product', 'user'])
            ->where('type', 'in')
            ->whereDate('created_at', today())
            ->latest()->get();

        $todayOut = StockTransaction::with(['product', 'user'])
            ->where('type', 'out')
            ->whereDate('created_at', today())
            ->latest()->get();

        $pendingTransactions = StockTransaction::with(['product', 'user'])
            ->where('status', 'pending')
            ->latest()->get();

        return compact('lowStocks', 'todayIn', 'todayOut', 'pendingTransactions');
    }

    /*
    |--------------------------------------------------------------------------
    | STAFF GUDANG
    |--------------------------------------------------------------------------
    */

    public function getStaffData(): array
    {
        $incomingToCheck = StockTransaction::with(['product'])
            ->where('type', 'in')
            ->where('status', 'pending')
            ->latest()->get();

        $outgoingToPrepare = StockTransaction::with(['product'])
            ->where('type', 'out')
            ->where('status', 'pending')
            ->latest()->get();

        // Transaksi yang sudah dikonfirmasi staff hari ini (dari activity log)
        $myTodayActivities = $this->activityLogRepository->getPaginated([
            'user_id'   => auth()->id(),
            'date_from' => today()->toDateString(),
            'date_to'   => today()->toDateString(),
        ], perPage: 999)->items();

        // Jumlah konfirmasi hari ini
        $todayConfirmedCount = collect($myTodayActivities)
            ->where('activity', 'Konfirmasi Transaksi')
            ->count();

        return compact('incomingToCheck', 'outgoingToPrepare', 'myTodayActivities', 'todayConfirmedCount');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER — chart transaksi per bulan
    |--------------------------------------------------------------------------
    */

    private function buildChartData(): array
    {
        $raw      = $this->transactionRepository->getChartData();
        $months   = [];
        $totalIn  = [];
        $totalOut = [];

        foreach ($raw as $item) {
            $months[]   = date('M', mktime(0, 0, 0, $item->month, 1));
            $totalIn[]  = $item->total_in;
            $totalOut[] = $item->total_out;
        }

        return [$months, $totalIn, $totalOut];
    }
}