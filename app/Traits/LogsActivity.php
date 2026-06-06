<?php

namespace App\Traits;

use App\Repositories\Interfaces\ActivityLogRepositoryInterface;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Catat aktivitas pengguna via ActivityLogRepository.
     *
     * @param string $activity    Judul singkat aksi, contoh: "Tambah Produk"
     * @param string $description Keterangan detail, contoh: "Menambahkan produk: Laptop Asus"
     */
    protected function logActivity(string $activity, string $description): void
    {
        app(ActivityLogRepositoryInterface::class)->create([
            'user_id'     => Auth::id(),
            'activity'    => $activity,
            'description' => $description,
        ]);
    }
}