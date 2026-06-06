<?php

namespace App\Services;

use App\Models\Setting;
use App\Traits\LogsActivity;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SettingService
{
    use LogsActivity;

    /*
    |--------------------------------------------------------------------------
    | GET DATA UNTUK FORM
    |--------------------------------------------------------------------------
    */

    public function getFormData(): array
    {
        return Setting::allAsArray();
    }

    /*
    |--------------------------------------------------------------------------
    | SAVE — simpan nama aplikasi dan logo
    |--------------------------------------------------------------------------
    */

    public function save(array $data, ?UploadedFile $logoFile): void
    {
        // Simpan nama aplikasi
        if (isset($data['app_name'])) {
            Setting::set('app_name', trim($data['app_name']));
        }

        // Simpan logo jika ada file baru
        if ($logoFile) {
            // Hapus logo lama dari storage
            $oldLogo = Setting::get('logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $logoFile->store('logos', 'public');
            Setting::set('logo', $path);
        }

        $this->logActivity(
            'Pengaturan Aplikasi',
            'Memperbarui pengaturan nama dan logo aplikasi'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS LOGO
    |--------------------------------------------------------------------------
    */

    public function deleteLogo(): void
    {
        $logo = Setting::get('logo');

        if ($logo) {
            Storage::disk('public')->delete($logo);
            Setting::set('logo', null);
        }

        $this->logActivity(
            'Hapus Logo',
            'Menghapus logo aplikasi'
        );
    }
}