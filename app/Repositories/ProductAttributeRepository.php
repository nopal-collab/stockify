<?php

namespace App\Repositories;

use App\Models\ProductAttribute;
use App\Repositories\Interfaces\ProductAttributeRepositoryInterface;

class ProductAttributeRepository implements ProductAttributeRepositoryInterface
{
    /*
    |--------------------------------------------------------------------------
    | GET ALL PAGINATED (dengan filter search)
    |--------------------------------------------------------------------------
    */

    public function getAllPaginated(array $filters, int $perPage = 10)
    {
        return ProductAttribute::when($filters['search'] ?? null, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($filters['type'] ?? null, function ($query, $type) {
                $query->where('type', $type);
            })
            ->latest()
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | GET ALL (untuk dropdown / pilihan di form produk)
    |--------------------------------------------------------------------------
    */

    public function getAll()
    {
        return ProductAttribute::orderBy('name')->get();
    }

    /*
    |--------------------------------------------------------------------------
    | FIND BY ID
    |--------------------------------------------------------------------------
    */

    public function findById(int $id)
    {
        return ProductAttribute::findOrFail($id);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create(array $data)
    {
        return ProductAttribute::create($data);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(int $id, array $data)
    {
        $attribute = ProductAttribute::findOrFail($id);
        $attribute->update($data);
        return $attribute;
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete(int $id)
    {
        $attribute = ProductAttribute::findOrFail($id);
        $attribute->delete();
        return $attribute;
    }
}