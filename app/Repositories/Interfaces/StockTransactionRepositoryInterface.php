<?php

namespace App\Repositories\Interfaces;

interface StockTransactionRepositoryInterface
{
    public function getAllPaginated(int $perPage = 10);

    public function getPaginatedByType(string $type, int $perPage = 10);

    public function findById(int $id);

    public function create(array $data);

    public function updateStatus(int $id, string $status);

    public function getAllForExport();

    public function getChartData();
}