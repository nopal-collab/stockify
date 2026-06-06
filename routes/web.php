<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| WELCOME PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| SEMUA ROUTE DI BAWAH INI BUTUH LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD — semua role bisa akses
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('verified')
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        // Kategori
        Route::resource('categories', CategoryController::class);

        // Produk — admin bisa create/edit/delete + import
        // (index & show ada di grup admin+manajer di bawah)
        Route::resource('products', ProductController::class)
            ->except(['index', 'show']);

        // Import Excel produk — admin only
        Route::post('/products-import', [ProductController::class, 'importExcel'])
            ->name('products.import');

        // Atribut Produk
        Route::resource('product-attributes', ProductAttributeController::class);

        // Supplier — CRUD penuh admin, index ada di grup admin+manajer
        Route::resource('suppliers', SupplierController::class)
            ->except(['index']);

        // User management
        Route::resource('users', UserController::class);

        // Activity Log
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])
            ->name('activity-logs.index');

        // Laporan aktivitas
        Route::get('/reports/activity/pdf',   [ReportController::class, 'activityPdf'])
            ->name('reports.activity.pdf');

        Route::get('/reports/activity/excel', [ReportController::class, 'activityExcel'])
            ->name('reports.activity.excel');

        // Stock Opname — create, store, destroy, complete: admin saja
        Route::resource('stock-opnames', StockOpnameController::class)
            ->only(['create', 'store', 'destroy']);

        Route::patch(
            '/stock-opnames/{id}/complete',
            [StockOpnameController::class, 'complete']
        )->name('stock-opnames.complete');

        // Pengaturan Stok Minimum
        Route::get('/stock/min-stock',   [ProductController::class, 'minStock'])
            ->name('stock.min-stock');

        Route::patch('/stock/min-stock', [ProductController::class, 'updateMinStock'])
            ->name('stock.min-stock.update');

        // Pengaturan Aplikasi
        Route::get('/settings',         [SettingController::class, 'index'])     ->name('settings.index');
        Route::patch('/settings',       [SettingController::class, 'update'])    ->name('settings.update');
        Route::delete('/settings/logo', [SettingController::class, 'deleteLogo'])->name('settings.logo.delete');

    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN & MANAJER GUDANG
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin,manajer_gudang')->group(function () {

        // Produk — index & show untuk manajer
        Route::get('/products',           [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

        // Produk — manajer boleh tambah & edit produk baru, tapi TIDAK bisa hapus
        // (sesuai spesifikasi: "Manajer Gudang dapat menambahkan produk baru ke dalam sistem")
        Route::get('/products/create',          [ProductController::class, 'create'])->name('products.create');
        Route::post('/products',                [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit',  [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}',       [ProductController::class, 'update'])->name('products.update');
        Route::patch('/products/{product}',     [ProductController::class, 'update']);

        // Supplier — daftar saja
        Route::get('/suppliers', [SupplierController::class, 'index'])
            ->name('suppliers.index');

        // Laporan — halaman utama + export stok & transaksi
        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/reports/stock/pdf',         [ReportController::class, 'stockPdf'])
            ->name('reports.stock.pdf');

        Route::get('/reports/stock/excel',       [ReportController::class, 'stockExcel'])
            ->name('reports.stock.excel');

        Route::get('/reports/transaction/pdf',   [ReportController::class, 'transactionPdf'])
            ->name('reports.transaction.pdf');

        Route::get('/reports/transaction/excel', [ReportController::class, 'transactionExcel'])
            ->name('reports.transaction.excel');

        // Legacy export
        Route::get('/products-report',          [ReportController::class, 'productsPdf'])
            ->name('products.report');

        Route::get('/products-export',          [ExportController::class, 'exportProducts'])
            ->name('products.export');

        Route::get('/stock-transactions-pdf',   [StockTransactionController::class, 'exportPdf'])
            ->name('stock-transactions.pdf');

        Route::get('/stock-transactions-excel', [StockTransactionController::class, 'exportExcel'])
            ->name('stock-transactions.excel');

    });

    /*
    |--------------------------------------------------------------------------
    | STOCK OPNAME — Admin, Manajer Gudang, Staff Gudang
    | index & show    : semua role
    | updateItems     : semua role (input stok fisik)
    | create/store/destroy/complete : admin saja (di atas)
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin,manajer_gudang,staff_gudang')->group(function () {

        Route::get('/stock-opnames', [StockOpnameController::class, 'index'])
            ->name('stock-opnames.index');

        Route::get('/stock-opnames/{id}', [StockOpnameController::class, 'show'])
            ->name('stock-opnames.show');

        Route::patch(
            '/stock-opnames/{id}/update-items',
            [StockOpnameController::class, 'updateItems']
        )->name('stock-opnames.update-items');

    });

    /*
    |--------------------------------------------------------------------------
    | TRANSAKSI STOK
    |
    | Admin & Manajer  : bisa create (buat transaksi baru) + confirm
    | Staff Gudang     : hanya bisa confirm (sesuai spesifikasi:
    |                    "Konfirmasi penerimaan & pengeluaran barang")
    |--------------------------------------------------------------------------
    */

    // Index & show transaksi — semua role bisa lihat
    Route::middleware('role:admin,manajer_gudang,staff_gudang')->group(function () {

        Route::get('/stock-transactions',                  [StockTransactionController::class, 'index'])
            ->name('stock-transactions.index');

        // Confirm — semua role (inti tugas staff)
        Route::patch(
            '/stock-transactions/{stockTransaction}/confirm',
            [StockTransactionController::class, 'confirm']
        )->name('stock-transactions.confirm');

    });

    // Create & store transaksi — admin & manajer saja
    Route::middleware('role:admin,manajer_gudang')->group(function () {

        // PENTING: route statis (/create) harus SEBELUM route dinamis (/{id})
        Route::get('/stock-transactions/create',      [StockTransactionController::class, 'create'])
            ->name('stock-transactions.create');

        Route::post('/stock-transactions',            [StockTransactionController::class, 'store'])
            ->name('stock-transactions.store');

        Route::get('/stock-transactions/{stockTransaction}/edit', [StockTransactionController::class, 'edit'])
            ->name('stock-transactions.edit');

        Route::put('/stock-transactions/{stockTransaction}',   [StockTransactionController::class, 'update'])
            ->name('stock-transactions.update');

        Route::patch('/stock-transactions/{stockTransaction}', [StockTransactionController::class, 'update']);

        Route::delete('/stock-transactions/{stockTransaction}', [StockTransactionController::class, 'destroy'])
            ->name('stock-transactions.destroy');

    });

    // Show — semua role bisa lihat detail (setelah /create agar tidak bentrok)
    Route::middleware('role:admin,manajer_gudang,staff_gudang')->group(function () {

        Route::get('/stock-transactions/{stockTransaction}', [StockTransactionController::class, 'show'])
            ->name('stock-transactions.show');

    });

    /*
    |--------------------------------------------------------------------------
    | PROFILE — semua role bisa akses
    |--------------------------------------------------------------------------
    */

    Route::get('/profile',    [ProfileController::class, 'edit'])   ->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update']) ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (login, register, dll — generate otomatis oleh Laravel)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';