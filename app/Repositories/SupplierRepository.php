<?php

namespace App\Repositories;

use App\Models\Supplier;
use App\Repositories\Interfaces\SupplierRepositoryInterface;

class SupplierRepository implements SupplierRepositoryInterface
{
    /*
    |--------------------------------------------------------------------------
    | GET ALL PAGINATED
    |--------------------------------------------------------------------------
    */

    public function getAllPaginated(int $perPage = 5)
    {
        return Supplier::latest()->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | GET ALL (untuk dropdown)
    |--------------------------------------------------------------------------
    */

    public function getAll()
    {
        return Supplier::all();
    }

    /*
    |--------------------------------------------------------------------------
    | FIND BY ID
    |--------------------------------------------------------------------------
    */

    public function findById(int $id)
    {
        return Supplier::findOrFail($id);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create(array $data)
    {
        return Supplier::create($data);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(int $id, array $data)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->update($data);
        return $supplier;
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete(int $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();
        return $supplier;
    }
}