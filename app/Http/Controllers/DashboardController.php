<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // data inventory status by category
        $inventoryByCategory = Inventory::select(
            'category',
            DB::raw('COUNT(*) as total_items'),
            DB::raw('SUM(quantity) as in_stock'),
            DB::raw('SUM(CASE WHEN quantity = 0 THEN 1 ELSE 0 END) as out_of_stock'),
            DB::raw('SUM(CASE WHEN quantity < 10 AND quantity > 0 THEN 1 ELSE 0 END) as low_stock')
        )
            ->groupBy('category')
            ->get();

        // hitung status setiap kategori
        foreach ($inventoryByCategory as $category){
            $totalItemsInCategory = $category->total_items;
            $lowStockItems = $category->low_stock ?? 0;
            $outOfStockItems = $category->out_of_stock ?? 0;
            
            $problemItems = $lowStockItems + $outOfStockItems;
            $problemPercentage = ($problemItems / $totalItemsInCategory) * 100;

            if ($problemPercentage <= 10){
                $category->status = 'Good';
                $category->status_class = 'success';
                $category->status_icon = 'bi-check-circle';
            }elseif ($problemPercentage <= 30) {
                $category->status = 'Warning';
                $category->status_class = 'warning';
                $category->status_icon = 'bi-exclamation-triangle';
            }else{
                $category->status = 'Critical';
                $category->status_class = 'danger';
                $category->status_icon = 'bi-x-octagon';
            }
        }

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

            // data table
            'inventoryByCategory' => $inventoryByCategory,

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
