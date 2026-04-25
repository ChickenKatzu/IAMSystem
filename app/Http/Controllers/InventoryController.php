<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use Illuminate\Support\Facades\Log;
use App\Exports\InventoryExport;
use App\Exports\InventoryPDFExport;
use Maatwebsite\Excel\Facades\Excel;



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
            $query->where(function ($q) use ($search) {
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
        return view('inventory.create', [
            'title' => 'Tambah Item Inventory',
            'item' => null
        ]);
    }

    /**
     * Menampilkan form edit item modal di index (tanpa halaman terpisah)
     */
    public function edit($id, Inventory $inventory)
    {
        return view('inventory.create', [
            'title' => 'Edit Item Inventory',
            'item' => Inventory::findOrFail($id)
        ]);
        // $item = Inventory::findOrFail($id);
        // return view ('Inventory.create', compact('item'));
    }

    // update inventory modal di index (tanpa halaman terpisah)
    public function updateInventory(Request $request, $id)
    {
        $validasi = $request->validate([
            'nama_item' => 'required|min:3|max:255',
            'kategori' => 'required|in:Elektronik,Furniture,Stationery,Lainnya',
            'sku' => 'required|max:50|unique:inventories,sku,' . $id,
            'quantity' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'supplier' => 'nullable|max:255',
            'deskripsi' => 'nullable|max:1000'
        ]);

        $item = Inventory::findOrFail($id);

        // @dd([
        //     'request_data' => $request->all(),
        //     'item_sebelum_update' => $item->toArray(),
        //     'validated_data' => $validasi,
        //     'id' => $id
        // ]);

        $item->update([
            'name' => $request->nama_item,
            'category' => $request->kategori,
            'sku' => $request->sku,
            'quantity' => $request->quantity,
            'price' => $request->harga,
            'supplier' => $request->supplier,
            'description' => $request->deskripsi
        ]);


        return redirect()->route('inventory.index')
            ->with('success', 'Item Inventory berhasil diupdate!');
    }

    // menghapus item (konfirmasi)
    public function delete($id)
    {
        try {
            $item = Inventory::findOrFail($id);
            $item->delete();

            return redirect()->route('inventory.index')
                ->with('success', 'Item Inventory berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('inventory.index')
                ->with('error', 'Gagal menghapus item inventory!');
        }
        // return view('inventory.delete', compact('item'));
    }

    /**
     * Menyimpan data item baru ke database
     */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'name' => 'required|min:3|max:255',
            'category' => 'required|in:elektronik,furniture,stationery,lainnya',
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

    public function kurangistockModal(Request $request, $id)
    {
        $validasi = $request->validate([
            'quantity' => 'required|integer|min:1',
            'deskripsi' => 'nullable|max:255'
        ]);

        $item = Inventory::findOrFail($id);

        if ($item->quantity < $request->quantity) {
            return redirect()->route('inventory.index')
                ->with('error', 'Gagal mengurangi stok! Stok tidak mencukupi.');
        } else {
            $item->quantity -= $request->quantity;
            $item->save();

            // Simpan log pengurangan stok (opsional)
            // StockLog::create([
            //     'inventory_id' => $id,
            //     'change_type' => 'decrease',
            //     'quantity' => $request->quantity,
            //     'description' => $request->deskripsi
            // ]);

            return redirect()->route('inventory.index')
                ->with('success', 'Stok berhasil dikurangi!');
        }
    }

    public function tambahstockModal(Request $request, $id)
    {
        $validasi = $request->validate([
            'quantity' => 'required|integer|min:1',
            'deskripsi' => 'nullable|max:255'
        ]);

        $item = Inventory::findOrFail($id);
        $item->quantity += $request->quantity;
        $item->save();

        // Simpan log penambahan stok (opsional)
        // StockLog::create([
        //     'inventory_id' => $id,
        //     'change_type' => 'increase',
        //     'quantity' => $request->quantity,
        //     'description' => $request->deskripsi
        // ]);

        return redirect()->route('inventory.index')
            ->with('success', 'Stok berhasil ditambahkan!');
    }


    /**
     * Mengupdate data item
     */
    public function update(Request $request, $id)
    {
        $item = Inventory::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|min:3|max:255',
            'category' => 'required|in:elektronik,furniture,stationery,lainnya',
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

    /**
     * Export ke Excel
     */
    public function exportExcel(Request $request)
    {
        try {
            $filters = [
                'search' => $request->search,
                'category' => $request->category,
                'stock_status' => $request->stock_status,
            ];

            $export = new InventoryExport($filters);

            return Excel::download($export, 'inventory-' . date('Y-m-d-His') . '.xlsx');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal export Excel: ' . $e->getMessage());
        }
    }

    /**
     * Export ke PDF
     */
    public function exportPdf(Request $request)
    {
        try {
            $export = new InventoryPDFExport([
                'search' => $request->search,
                'category' => $request->category,
                'stock_status' => $request->stock_status,
            ]);

            $pdf = $export->generate();

            return $pdf->download('inventory-' . date('Y-m-d-His') . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal export PDF: ' . $e->getMessage());
        }
    }

    /**
     * Print view
     */
    public function printView(Request $request)
    {
        $query = Inventory::query();

        // Apply filters
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        $items = $query->get();
        $totalValue = $items->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        return view('exports.inventory-print', compact('items', 'totalValue'));
    }
}
