<?php

namespace App\Repositories;

use App\Models\StockTransaction;
use App\Repositories\Interfaces\StockTransactionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class StockTransactionRepository implements StockTransactionRepositoryInterface
{
    /*
    |--------------------------------------------------------------------------
    | GET ALL PAGINATED (semua type — masih dipakai export dll)
    |--------------------------------------------------------------------------
    */

    public function getAllPaginated(int $perPage = 10)
    {
        return StockTransaction::with(['product', 'user'])
            ->latest()
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | GET PAGINATED BY TYPE — 'in' atau 'out'
    |--------------------------------------------------------------------------
    */

    public function getPaginatedByType(string $type, int $perPage = 10)
    {
        return StockTransaction::with(['product', 'user'])
            ->where('type', $type)
            ->latest()
            ->paginate($perPage, ['*'], $type === 'in' ? 'page_in' : 'page_out');
    }

    /*
    |--------------------------------------------------------------------------
    | FIND BY ID
    |--------------------------------------------------------------------------
    */

    public function findById(int $id)
    {
        return StockTransaction::with(['product', 'user'])->findOrFail($id);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create(array $data)
    {
        return StockTransaction::create($data);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS
    |--------------------------------------------------------------------------
    */

    public function updateStatus(int $id, string $status)
    {
        $transaction = StockTransaction::findOrFail($id);
        $transaction->status = $status;
        $transaction->save();
        return $transaction;
    }

    /*
    |--------------------------------------------------------------------------
    | GET ALL FOR EXPORT (PDF / Excel)
    |--------------------------------------------------------------------------
    */

    public function getAllForExport()
    {
        return StockTransaction::with(['product', 'user'])->latest()->get();
    }

    /*
    |--------------------------------------------------------------------------
    | GET CHART DATA (per bulan, total in & out)
    |--------------------------------------------------------------------------
    */

    public function getChartData()
    {
        return StockTransaction::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw("SUM(CASE WHEN type = 'in' THEN qty ELSE 0 END) as total_in"),
                DB::raw("SUM(CASE WHEN type = 'out' THEN qty ELSE 0 END) as total_out")
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }
}