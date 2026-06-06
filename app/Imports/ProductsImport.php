<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToCollection, WithHeadingRow
{
    /*
    |--------------------------------------------------------------------------
    | Kolom yang dibaca dari Excel (header baris 1, data mulai baris 2):
    |   name | category | supplier | stock | min_stock | harga_beli | harga_jual | description
    |
    | Kolom wajib   : name, category, stock, min_stock, harga_beli, harga_jual
    | Kolom opsional: supplier, description
    |--------------------------------------------------------------------------
    */

    /** Daftar string yang menandakan baris adalah baris keterangan, bukan data. */
    private array $skipKeywords = [
        'nama produk',
        'kategori',
        'supplier',
        'opsional',
        'dibuat otomatis',
        'angka bulat',
        'angka tanpa',
        'deskripsi',
    ];

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {

            $name = trim((string) ($row['name'] ?? ''));

            /*
            |--------------------------------------------------------------
            | SKIP: baris kosong atau baris keterangan dari template
            |--------------------------------------------------------------
            */

            if (empty($name)) {
                continue;
            }

            // Skip jika nama mengandung keyword baris keterangan
            $nameLower = mb_strtolower($name);
            foreach ($this->skipKeywords as $keyword) {
                if (str_contains($nameLower, $keyword)) {
                    continue 2;
                }
            }

            // Skip jika nama terlalu panjang (kemungkinan baris keterangan)
            if (mb_strlen($name) > 191) {
                continue;
            }

            /*
            |--------------------------------------------------------------
            | CATEGORY — wajib, buat jika belum ada
            |--------------------------------------------------------------
            */

            $categoryName = trim((string) ($row['category'] ?? ''));

            if (empty($categoryName)) {
                continue;
            }

            // Skip jika category mengandung keyword keterangan
            $catLower = mb_strtolower($categoryName);
            foreach ($this->skipKeywords as $keyword) {
                if (str_contains($catLower, $keyword)) {
                    continue 2;
                }
            }

            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['description' => null]
            );

            /*
            |--------------------------------------------------------------
            | SUPPLIER — opsional, buat jika diisi
            |--------------------------------------------------------------
            */

            $supplier     = null;
            $supplierName = trim((string) ($row['supplier'] ?? ''));

            if (!empty($supplierName)) {
                $supLower = mb_strtolower($supplierName);
                $isKeyword = false;
                foreach ($this->skipKeywords as $keyword) {
                    if (str_contains($supLower, $keyword)) {
                        $isKeyword = true;
                        break;
                    }
                }

                if (!$isKeyword) {
                    $supplier = Supplier::firstOrCreate(
                        ['name' => $supplierName],
                        [
                            'phone'   => null,
                            'address' => null,
                        ]
                    );
                }
            }

            /*
            |--------------------------------------------------------------
            | CREATE PRODUCT
            |--------------------------------------------------------------
            */

            Product::firstOrCreate(
                ['name' => $name],
                [
                    'category_id' => $category->id,
                    'supplier_id' => $supplier?->id,
                    'stock'       => (int)   ($row['stock']       ?? 0),
                    'min_stock'   => (int)   ($row['min_stock']   ?? 0),
                    'harga_beli'  => (float) ($row['harga_beli']  ?? 0),
                    'harga_jual'  => (float) ($row['harga_jual']  ?? 0),
                    'description' => trim((string) ($row['description'] ?? '')),
                ]
            );
        }
    }
}