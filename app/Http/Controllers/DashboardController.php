<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalInventory' => 1250,
            'totalAssets' => 450,
            'lowStock' => 18,
            'maintenanceDue' => 7,
            'recentActivities' => [
                // Sample data
            ]
        ];

        return view('dashboard.index', $data);
    }
}
