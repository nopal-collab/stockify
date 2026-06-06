<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ActivityLogRepositoryInterface;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function __construct(
        protected ActivityLogRepositoryInterface $activityLogRepository,
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'user_id', 'date_from', 'date_to']);

        $logs = $this->activityLogRepository->getPaginated($filters, perPage: 15);

        $logs->appends($request->all());

        return view('activity-logs.index', compact('logs', 'filters'));
    }
}