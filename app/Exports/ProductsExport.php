<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    /**
     * Data yang diekspor — kolom heading harus cocok dengan
     * kolom yang diharapkan ProductsImport agar file hasil
     * export bisa langsung dipakai sebagai template import.
     */
    public function collection()
    {
        return Product::with(['category', 'supplier'])
            ->get()
            ->map(fn (Product $p) => [
                'name'        => $p->name,
                'category'    => $p->category?->name,
                'supplier'    => $p->supplier?->name,
                'stock'       => $p->stock,
                'min_stock'   => $p->min_stock,
                'harga_beli'  => $p->harga_beli,
                'harga_jual'  => $p->harga_jual,
                'description' => $p->description,
            ]);
    }

    /**
     * Heading Excel — urutan harus sama dengan map() di atas.
     */
    public function headings(): array
    {
        return [
            'name',
            'category',
            'supplier',
            'stock',
            'min_stock',
            'harga_beli',
            'harga_jual',
            'description',
        ];
    }
}