<?php

namespace App\Repositories;

use App\Models\StockOpname;
use App\Repositories\Interfaces\StockOpnameRepositoryInterface;

class StockOpnameRepository implements StockOpnameRepositoryInterface
{
    /*
    |--------------------------------------------------------------------------
    | GET ALL PAGINATED (dengan filter search & status)
    |--------------------------------------------------------------------------
    */

    public function getAllPaginated(array $filters, int $perPage = 10)
    {
        return StockOpname::with(['creator', 'completer'])
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->when($filters['status'] ?? null, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | FIND BY ID (eager load items + produk)
    |--------------------------------------------------------------------------
    */

    public function findById(int $id)
    {
        return StockOpname::with([
            'items.product.category',
            'creator',
            'completer',
        ])->findOrFail($id);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create(array $data)
    {
        return StockOpname::create($data);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(int $id, array $data)
    {
        $opname = StockOpname::findOrFail($id);
        $opname->update($data);
        return $opname;
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete(int $id)
    {
        $opname = StockOpname::findOrFail($id);
        $opname->delete();
        return $opname;
    }
}