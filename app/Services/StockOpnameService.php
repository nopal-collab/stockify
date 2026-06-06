<?php

namespace App\Services;

use App\Traits\LogsActivity;
use App\Models\Product;
use App\Models\StockOpnameItem;
use App\Repositories\Interfaces\StockOpnameRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockOpnameService
{
    use LogsActivity;

    public function __construct(
        protected StockOpnameRepositoryInterface $opnameRepository,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | GET DATA UNTUK INDEX
    |--------------------------------------------------------------------------
    */

    public function getIndexData(array $filters): array
    {
        $opnames = $this->opnameRepository->getAllPaginated($filters);

        return compact('opnames', 'filters');
    }

    /*
    |--------------------------------------------------------------------------
    | GET DATA UNTUK CREATE FORM
    |--------------------------------------------------------------------------
    */

    public function getCreateData(): array
    {
        $products = Product::with('category')->orderBy('name')->get();

        return compact('products');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE — Buat sesi opname baru + items
    |--------------------------------------------------------------------------
    */

    public function store(array $data): void
    {
        DB::transaction(function () use ($data) {

            $opname = $this->opnameRepository->create([
                'title'      => $data['title'],
                'notes'      => $data['notes'] ?? null,
                'status'     => 'in_progress',
                'created_by' => Auth::id(),
            ]);

            $productIds = $data['product_ids'] ?? [];
            $products   = Product::whereIn('id', $productIds)->get();

            foreach ($products as $product) {
                StockOpnameItem::create([
                    'stock_opname_id' => $opname->id,
                    'product_id'      => $product->id,
                    'system_stock'    => $product->stock,
                    'physical_stock'  => null,
                    'difference'      => null,
                ]);
            }

            $this->logActivity(
                'Stock Opname Dibuat',
                'Sesi stock opname "' . $opname->title . '" dibuat dengan ' . count($productIds) . ' produk.'
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | GET DATA UNTUK HALAMAN DETAIL
    |--------------------------------------------------------------------------
    */

    public function getShowData(int $id): array
    {
        $opname = $this->opnameRepository->findById($id);

        return compact('opname');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PHYSICAL STOCK
    |--------------------------------------------------------------------------
    */

    public function updateItems(int $opnameId, array $items): void
    {
        $opname = $this->opnameRepository->findById($opnameId);

        if ($opname->status !== 'in_progress') {
            throw ValidationException::withMessages([
                'status' => 'Opname ini sudah selesai dan tidak bisa diubah.',
            ]);
        }

        DB::transaction(function () use ($opname, $items) {

            foreach ($items as $itemId => $data) {

                $item = StockOpnameItem::where('stock_opname_id', $opname->id)
                                       ->findOrFail($itemId);

                $physical   = (int) $data['physical_stock'];
                $difference = $physical - $item->system_stock;

                $item->update([
                    'physical_stock' => $physical,
                    'difference'     => $difference,
                    'notes'          => $data['notes'] ?? null,
                ]);
            }

            $this->logActivity(
                'Stock Opname Diperbarui',
                'Data fisik stok pada opname "' . $opname->title . '" telah diperbarui.'
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | COMPLETE — Selesaikan opname & sesuaikan stok produk
    |--------------------------------------------------------------------------
    */

    public function complete(int $opnameId): void
    {
        $opname = $this->opnameRepository->findById($opnameId);

        if ($opname->status !== 'in_progress') {
            throw ValidationException::withMessages([
                'status' => 'Opname tidak dalam status in_progress.',
            ]);
        }

        $unfilled = $opname->items->whereNull('physical_stock')->count();

        if ($unfilled > 0) {
            throw ValidationException::withMessages([
                'items' => 'Masih ada ' . $unfilled . ' produk yang belum diisi stok fisiknya.',
            ]);
        }

        DB::transaction(function () use ($opname) {

            foreach ($opname->items as $item) {
                $item->product->update(['stock' => $item->physical_stock]);
            }

            $opname->update([
                'status'       => 'completed',
                'completed_by' => Auth::id(),
                'completed_at' => now(),
            ]);

            $this->logActivity(
                'Stock Opname Diselesaikan',
                'Sesi opname "' . $opname->title . '" diselesaikan. Stok ' . $opname->items->count() . ' produk telah disesuaikan.'
            );
        });
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete(int $id): void
    {
        $opname = $this->opnameRepository->findById($id);

        if ($opname->status === 'completed') {
            throw ValidationException::withMessages([
                'status' => 'Opname yang sudah selesai tidak bisa dihapus.',
            ]);
        }

        $this->logActivity(
            'Stock Opname Dihapus',
            'Sesi opname "' . $opname->title . '" telah dihapus.'
        );

        $this->opnameRepository->delete($id);
    }
}