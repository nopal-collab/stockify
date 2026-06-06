<?php

namespace App\Http\Controllers;

use App\Services\SettingService;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(
        protected SettingService $settingService,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | INDEX — halaman pengaturan
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $settings = $this->settingService->getFormData();

        return view('settings.index', compact('settings'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE — simpan perubahan
    |--------------------------------------------------------------------------
    */

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:100',
            'logo'     => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        $this->settingService->save(
            $request->only('app_name'),
            $request->file('logo')
        );

        return redirect()
            ->route('settings.index')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE LOGO
    |--------------------------------------------------------------------------
    */

    public function deleteLogo()
    {
        $this->settingService->deleteLogo();

        return redirect()
            ->route('settings.index')
            ->with('success', 'Logo berhasil dihapus.');
    }
}