<?php

use Illuminate\Database\Migrations\Migration;

/*
|--------------------------------------------------------------------------
| Migration ini sudah tidak diperlukan karena timestamps sudah ada
| di create_users_table migration. Dibiarkan kosong agar tidak error
| saat migrate:fresh pada project yang sudah berjalan.
|--------------------------------------------------------------------------
*/

return new class extends Migration
{
    public function up(): void
    {
        // sudah di-handle di create_users_table
    }

    public function down(): void
    {
        //
    }
};