<?php

namespace App\Services;

use App\Traits\LogsActivity;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryService
{
    use LogsActivity;

    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | GET DATA UNTUK INDEX
    |--------------------------------------------------------------------------
    */

    public function getIndexData(array $filters)
    {
        return $this->categoryRepository->getAllPaginated($filters);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(array $data): void
    {
        $category = $this->categoryRepository->create($data);

        $this->logActivity(
            'Tambah Kategori',
            'Menambahkan kategori: ' . $category->name
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(int $id, array $data): void
    {
        $category = $this->categoryRepository->update($id, $data);

        $this->logActivity(
            'Edit Kategori',
            'Mengedit kategori: ' . $category->name
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete(int $id): void
    {
        $category = $this->categoryRepository->findById($id);

        $this->logActivity(
            'Hapus Kategori',
            'Menghapus kategori: ' . $category->name
        );

        $this->categoryRepository->delete($id);
    }
}