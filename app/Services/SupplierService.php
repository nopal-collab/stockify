<?php

namespace App\Services;

use App\Traits\LogsActivity;
use App\Repositories\Interfaces\SupplierRepositoryInterface;

class SupplierService
{
    use LogsActivity;

    public function __construct(
        protected SupplierRepositoryInterface $supplierRepository,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | GET DATA UNTUK INDEX
    |--------------------------------------------------------------------------
    */

    public function getIndexData()
    {
        return $this->supplierRepository->getAllPaginated();
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(array $data): void
    {
        $supplier = $this->supplierRepository->create($data);

        $this->logActivity(
            'Tambah Supplier',
            'Menambahkan supplier: ' . $supplier->name
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(int $id, array $data): void
    {
        $supplier = $this->supplierRepository->update($id, $data);

        $this->logActivity(
            'Edit Supplier',
            'Mengedit supplier: ' . $supplier->name
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete(int $id): void
    {
        $supplier = $this->supplierRepository->findById($id);

        $this->logActivity(
            'Hapus Supplier',
            'Menghapus supplier: ' . $supplier->name
        );

        $this->supplierRepository->delete($id);
    }
}