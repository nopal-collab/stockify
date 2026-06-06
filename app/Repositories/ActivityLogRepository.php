<?php

namespace App\Repositories;

use App\Models\ActivityLog;
use App\Repositories\Interfaces\ActivityLogRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ActivityLogRepository implements ActivityLogRepositoryInterface
{
    public function __construct(
        protected ActivityLog $model,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | GET PAGINATED — dengan filter search & user_id
    |--------------------------------------------------------------------------
    */

    public function getPaginated(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->with('user')->latest();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('activity',    'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query->paginate($perPage);
    }

    /*
    |--------------------------------------------------------------------------
    | GET LATEST — untuk widget dashboard admin
    |--------------------------------------------------------------------------
    */

    public function getLatest(int $limit = 8): Collection
    {
        return $this->model->with('user')->latest()->take($limit)->get();
    }

    /*
    |--------------------------------------------------------------------------
    | GET ALL FOR EXPORT — tanpa paginate, untuk PDF / Excel
    |--------------------------------------------------------------------------
    */

    public function getAllForExport(array $filters = []): Collection
    {
        $query = $this->model->with('user')->latest();

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        return $query->get();
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE — simpan log baru
    |--------------------------------------------------------------------------
    */

    public function create(array $data): void
    {
        $this->model->create($data);
    }
}