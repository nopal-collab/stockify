<?php

namespace App\Repositories\Interfaces;

interface StockOpnameRepositoryInterface
{
    public function getAllPaginated(array $filters, int $perPage = 10);

    public function findById(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);
}