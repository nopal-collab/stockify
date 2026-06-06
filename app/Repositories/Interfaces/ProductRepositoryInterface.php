<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function getAllPaginated(array $filters, int $perPage = 5);

    public function findById(int $id);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function getLowStock();

    public function getAllForChart();

    public function getAll();

    public function getAllWithMinStock();

    public function updateMinStock(int $id, int $minStock): void;
}