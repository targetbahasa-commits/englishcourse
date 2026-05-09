<?php

namespace App\Http\Controllers;

use App\Application\Admin\GetAdminDashboardSummary;

class AdminDashboardController extends Controller
{
    public function __construct(
        private readonly GetAdminDashboardSummary $getAdminDashboardSummary,
    ) {
    }

    public function index()
    {
        $data = $this->getAdminDashboardSummary->execute();

        return view('admin.dashboard', $data);
    }
}
