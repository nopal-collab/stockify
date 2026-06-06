<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ActivityLogRepositoryInterface
{
    /**
     * Ambil semua log dengan filter opsional, paginated.
     */
    public function getPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    /**
     * Ambil log terbaru sejumlah $limit (untuk dashboard).
     */
    public function getLatest(int $limit = 8): \Illuminate\Database\Eloquent\Collection;

    /**
     * Ambil semua log untuk export (tanpa paginate).
     */
    public function getAllForExport(array $filters = []): \Illuminate\Database\Eloquent\Collection;

    /**
     * Simpan satu record log baru.
     */
    public function create(array $data): void;
}