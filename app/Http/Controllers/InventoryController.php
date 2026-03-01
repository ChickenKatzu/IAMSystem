<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;

class InventoryController extends Controller
{
    /**
     * Menampilkan halaman daftar inventory
     */
    public function index(Request $request)
    {
        $query = Inventory::query();

        // Filter berdasarkan pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        // Filter berdasarkan status stok
        if ($request->has('stock_status') && !empty($request->stock_status)) {
            switch ($request->stock_status) {
                case 'in_stock':
                    $query->where('quantity', '>', 10);
                    break;
                case 'low_stock':
                    $query->whereBetween('quantity', [1, 10]);
                    break;
                case 'out_of_stock':
                    $query->where('quantity', '<=', 0);
                    break;
            }
        }

        // Urutkan berdasarkan terbaru
        $query->latest();

        // Ambil data dengan pagination
        $items = $query->paginate(10)->withQueryString();

        // Hitung summary
        $totalItems = Inventory::count();
        $totalValue = Inventory::sum(\DB::raw('quantity * price'));
        $lowStockCount = Inventory::whereBetween('quantity', [1, 10])->count();
        $outOfStockCount = Inventory::where('quantity', '<=', 0)->count();

        return view('inventory.index', compact(
            'items',
            'totalItems',
            'totalValue',
            'lowStockCount',
            'outOfStockCount'
        ));
    }

    /**
     * Menampilkan halaman form tambah item
     */
    public function create()
    {
        return view('inventory.create');
    }

    /**
     * Menyimpan data item baru ke database
     */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'name' => 'required|min:3|max:255',
            'category' => 'required|in:elektronik,furniture,stationery,others',
            'sku' => 'required|unique:inventories,sku|max:50',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'supplier' => 'nullable|max:255',
            'description' => 'nullable|max:1000'
        ]);

        // Simpan ke database
        Inventory::create($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('inventory.index')
            ->with('success', 'Item inventory berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail item
     */
    public function show($id)
    {
        $item = Inventory::findOrFail($id);
        return view('inventory.show', compact('item'));
    }

    /**
     * Menampilkan form edit item
     */
    public function edit($id)
    {
        $item = Inventory::findOrFail($id);
        return view('inventory.edit', compact('item'));
    }

    /**
     * Mengupdate data item
     */
    public function update(Request $request, $id)
    {
        $item = Inventory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|min:3|max:255',
            'category' => 'required|in:elektronik,furniture,stationery,others',
            'sku' => 'required|max:50|unique:inventories,sku,' . $id,
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'supplier' => 'nullable|max:255',
            'description' => 'nullable|max:1000'
        ]);

        $item->update($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Item inventory berhasil diupdate!');
    }

    /**
     * Menghapus item
     */
    public function destroy($id)
    {
        try {
            $item = Inventory::findOrFail($id);
            $item->delete();

            return redirect()->route('inventory.index')
                ->with('success', 'Item inventory berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('inventory.index')
                ->with('error', 'Gagal menghapus item!');
        }
    }
}
