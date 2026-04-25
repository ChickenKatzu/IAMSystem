<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Hitung total item inventory
        $totalItems = Inventory::count();
        
        // Hitung total nilai inventory (price * quantity)
        $totalValue = Inventory::selectRaw('SUM(price * quantity) as total')
            ->first()
            ->total ?? 0;
        
        // Hitung item dengan stok rendah (kurang dari: < 10)
        $lowStockCount = Inventory::where('quantity', '<', 10)
            ->where('quantity', '>', 0)
            ->count();
        
        // Hitung item yang habis stok (quantity = 0)
        $outOfStockCount = Inventory::where('quantity', '<=', 0)
            ->count();

        // Data untuk chart atau keperluan lain
        $recentActivities = Inventory::latest()
            ->take(5)
            ->get();

        $data = [
            // Data untuk cards
            'totalItems' => $totalItems,
            'totalValue' => $totalValue,
            'lowStockCount' => $lowStockCount,
            'outOfStockCount' => $outOfStockCount,
            
            // Data tambahan (jika diperlukan)
            'totalInventory' => 1250, // Bisa dihapus jika tidak digunakan
            'totalAssets' => 450,      // Bisa dihapus jika tidak digunakan
            'lowStock' => 18,           // Bisa dihapus jika tidak digunakan
            'maintenanceDue' => 7,      // Bisa dihapus jika tidak digunakan
            'recentActivities' => $recentActivities
        ];

        return view('dashboard.index', $data);
    }
}