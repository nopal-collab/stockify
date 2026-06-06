<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService,
    ) {}

    public function index(Request $request)
    {
        $role = Auth::user()->role;

        return match ($role) {

            'admin' => view(
                'dashboard.admin',
                $this->dashboardService->getAdminData(
                    $request->get('period', 'monthly')
                )
            ),

            'manajer_gudang' => view(
                'dashboard.manajer',
                $this->dashboardService->getManajerData()
            ),

            'staff_gudang' => view(
                'dashboard.staff',
                $this->dashboardService->getStaffData()
            ),

            default => abort(403, 'Role tidak dikenali'),

        };
    }
}