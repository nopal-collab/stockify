<?php

namespace App\Services;

use App\Models\ProductAttributeValue;
use App\Traits\LogsActivity;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\SupplierRepositoryInterface;
use App\Repositories\Interfaces\ProductAttributeRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    use LogsActivity;

    public function __construct(
        protected ProductRepositoryInterface          $productRepository,
        protected CategoryRepositoryInterface         $categoryRepository,
        protected SupplierRepositoryInterface         $supplierRepository,
        protected ProductAttributeRepositoryInterface $attributeRepository,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | GET DATA UNTUK INDEX (produk + dropdown filter)
    |--------------------------------------------------------------------------
    */

    public function getIndexData(array $filters)
    {
        $products   = $this->productRepository->getAllPaginated($filters);
        $categories = $this->categoryRepository->getAll();
        $suppliers  = $this->supplierRepository->getAll();

        return compact('products', 'categories', 'suppliers');
    }

    /*
    |--------------------------------------------------------------------------
    | GET DATA UNTUK FORM CREATE / EDIT
    |--------------------------------------------------------------------------
    */

    public function getFormData()
    {
        return [
            'categories' => $this->categoryRepository->getAll(),
            'suppliers'  => $this->supplierRepository->getAll(),
            'attributes' => $this->attributeRepository->getAll(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | STORE PRODUCT BARU
    |--------------------------------------------------------------------------
    */

    public function store(array $data, $imageFile = null): void
    {
        $data['image'] = $this->uploadImage($imageFile);

        // Pisahkan data atribut sebelum disimpan ke tabel products
        $attributeValues = $data['attributes'] ?? [];
        unset($data['attributes']);

        $product = $this->productRepository->create($data);

        // Simpan nilai atribut produk
        $this->syncAttributeValues($product->id, $attributeValues);

        $this->logActivity(
            'Tambah Produk',
            'Menambahkan produk: ' . $product->name
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PRODUCT
    |--------------------------------------------------------------------------
    */

    public function update(int $id, array $data, $imageFile = null): void
    {
        $product = $this->productRepository->findById($id);

        if ($imageFile) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $this->uploadImage($imageFile);
        }

        // Pisahkan data atribut sebelum disimpan ke tabel products
        $attributeValues = $data['attributes'] ?? [];
        unset($data['attributes']);

        $this->productRepository->update($id, $data);

        // Update nilai atribut produk
        $this->syncAttributeValues($id, $attributeValues);

        $this->logActivity(
            'Edit Produk',
            'Mengedit produk: ' . $product->name
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE PRODUCT
    |--------------------------------------------------------------------------
    */

    public function delete(int $id): void
    {
        $product = $this->productRepository->findById($id);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $this->logActivity(
            'Hapus Produk',
            'Menghapus produk: ' . $product->name
        );

        $this->productRepository->delete($id);
    }

    /*
    |--------------------------------------------------------------------------
    | GET DATA UNTUK HALAMAN PENGATURAN STOK MINIMUM
    |--------------------------------------------------------------------------
    */

    public function getMinStockData(): array
    {
        $products = $this->productRepository->getAllWithMinStock();

        return compact('products');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE MIN STOCK — simpan semua perubahan min_stock sekaligus
    |--------------------------------------------------------------------------
    */

    public function updateMinStock(array $minStocks): void
    {
        foreach ($minStocks as $productId => $minStock) {
            $this->productRepository->updateMinStock(
                (int) $productId,
                (int) $minStock
            );
        }

        $this->logActivity(
            'Pengaturan Stok Minimum',
            'Memperbarui stok minimum untuk ' . count($minStocks) . ' produk'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SYNC NILAI ATRIBUT PRODUK
    | Upsert jika ada nilai, hapus jika dikosongkan.
    |--------------------------------------------------------------------------
    */

    private function syncAttributeValues(int $productId, array $attributes): void
    {
        foreach ($attributes as $attributeId => $value) {

            if ($value === null || $value === '') {
                // Kosongkan = hapus nilai atribut ini dari produk
                ProductAttributeValue::where('product_id', $productId)
                    ->where('product_attribute_id', $attributeId)
                    ->delete();
            } else {
                // Simpan atau perbarui nilai
                ProductAttributeValue::updateOrCreate(
                    [
                        'product_id'           => $productId,
                        'product_attribute_id' => (int) $attributeId,
                    ],
                    [
                        'value' => $value,
                    ]
                );
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | UPLOAD IMAGE HELPER
    |--------------------------------------------------------------------------
    */

    private function uploadImage(?\Illuminate\Http\UploadedFile $imageFile): ?string
    {
        if (!$imageFile) {
            return null;
        }

        return $imageFile->store('products', 'public');
    }
}