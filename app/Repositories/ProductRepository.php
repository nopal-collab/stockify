<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    /*
    |--------------------------------------------------------------------------
    | GET ALL PAGINATED (dengan filter search, supplier, category)
    |--------------------------------------------------------------------------
    */

    public function getAllPaginated(array $filters, int $perPage = 10)
    {
        return Product::with(['category', 'supplier'])
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($filters['supplier_id'] ?? null, function ($query, $supplierId) {
                $query->where('supplier_id', $supplierId);
            })
            ->when($filters['category_id'] ?? null, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->latest()
            ->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | FIND BY ID
    |--------------------------------------------------------------------------
    */

    public function findById(int $id)
    {
        return Product::with(['category', 'supplier'])->findOrFail($id);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create(array $data)
    {
        return Product::create($data);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(int $id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete(int $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return $product;
    }

    /*
    |--------------------------------------------------------------------------
    | LOW STOCK — pakai kolom min_stock per-produk, bukan angka hardcode
    |--------------------------------------------------------------------------
    */

    public function getLowStock()
    {
        return Product::with(['category', 'supplier'])
            ->whereColumn('stock', '<=', 'min_stock')
            ->orderBy('stock')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | GET ALL FOR CHART (urut stok tertinggi)
    |--------------------------------------------------------------------------
    */

    public function getAllForChart()
    {
        return Product::orderBy('stock', 'desc')->get();
    }

    /*
    |--------------------------------------------------------------------------
    | GET ALL (untuk export, laporan, dll.)
    |--------------------------------------------------------------------------
    */

    public function getAll()
    {
        return Product::with(['category', 'supplier'])->get();
    }

    /*
    |--------------------------------------------------------------------------
    | GET ALL WITH MIN STOCK — untuk halaman pengaturan stok minimum
    |--------------------------------------------------------------------------
    */

    public function getAllWithMinStock()
    {
        return Product::with(['category'])
            ->orderBy('name')
            ->get(['id', 'name', 'stock', 'min_stock', 'category_id']);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE MIN STOCK — update min_stock satu produk
    |--------------------------------------------------------------------------
    */

    public function updateMinStock(int $id, int $minStock): void
    {
        Product::where('id', $id)->update(['min_stock' => $minStock]);
    }
}