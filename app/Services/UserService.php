<?php

namespace App\Services;

use App\Traits\LogsActivity;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserService
{
    use LogsActivity;

    public function __construct(
        protected UserRepositoryInterface $userRepository,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | GET DATA UNTUK INDEX
    |--------------------------------------------------------------------------
    */

    public function getIndexData(array $filters)
    {
        return $this->userRepository->getAllPaginated($filters);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(array $data): void
    {
        $user = $this->userRepository->create($data);

        $this->logActivity(
            'Tambah User',
            'Menambahkan user: ' . $user->name . ' (role: ' . $user->role . ')'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(int $id, array $data): void
    {
        $user = $this->userRepository->update($id, $data);

        $this->logActivity(
            'Edit User',
            'Mengedit user: ' . $user->name
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function delete(int $id): void
    {
        $user = $this->userRepository->findById($id);

        $this->logActivity(
            'Hapus User',
            'Menghapus user: ' . $user->name . ' (role: ' . $user->role . ')'
        );

        $this->userRepository->delete($id);
    }
}