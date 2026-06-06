<?php

namespace App\Services;

use App\Traits\LogsActivity;
use App\Repositories\Interfaces\ProductAttributeRepositoryInterface;

class ProductAttributeService
{
    use LogsActivity;

    public function __construct(
        protected ProductAttributeRepositoryInterface $attributeRepository,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | GET DATA UNTUK INDEX
    |--------------------------------------------------------------------------
    */

    public function getIndexData(array $filters): array
    {
        $attributes = $this->attributeRepository->getAllPaginated($filters);

        return compact('attributes');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(array $data): void
    {
        // Jika tipe bukan 'select', hapus options agar tidak tersimpan noise
        if (($data['type'] ?? 'text') !== 'select') {
            $data['options'] = null;
        } else {
            // options dikirim sebagai string baris-per-baris, ubah ke array JSON
            $data['options'] = $this->parseOptions($data['options'] ?? '');
        }

        $attribute = $this->attributeRepository->create($data);

        $this->logActivity(
            'Tambah Atribut Produk',
            'Menambahkan atribut produk: ' . $attribute->name
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(int $id, array $data): void
    {
        if (($data['type'] ?? 'text') !== 'select') {
            $data['options'] = null;
        } else {
            $data['options'] = $this->parseOptions($data['options'] ?? '');
        }

        $attribute = $this->attributeRepository->update($id, $data);

        $this->logActivity(
            'Edit Atribut Produk',
            'Mengedit atribut produk: ' . $attribute->name
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete(int $id): void
    {
        $attribute = $this->attributeRepository->findById($id);

        $this->logActivity(
            'Hapus Atribut Produk',
            'Menghapus atribut produk: ' . $attribute->name
        );

        $this->attributeRepository->delete($id);
    }

    /*
    |--------------------------------------------------------------------------
    | GET ALL (untuk dropdown di form produk)
    |--------------------------------------------------------------------------
    */

    public function getAll()
    {
        return $this->attributeRepository->getAll();
    }

    /*
    |--------------------------------------------------------------------------
    | FIND BY ID (untuk form edit)
    |--------------------------------------------------------------------------
    */

    public function findById(int $id)
    {
        return $this->attributeRepository->findById($id);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER — ubah textarea (satu opsi per baris) ke array bersih
    |--------------------------------------------------------------------------
    */

    private function parseOptions(string $raw): array
    {
        return array_values(
            array_filter(
                array_map('trim', explode("\n", $raw))
            )
        );
    }
}