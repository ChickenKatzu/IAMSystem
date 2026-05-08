<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Exports\AssetExport;
use App\Exports\AssetPDFExport;
use Maatwebsite\Excel\Facades\Excel;

class AssetController extends Controller
{
    /**
     * Display a listing of assets.
     */
    public function index(Request $request)
    {
        $query = Asset::query();

        // Filter berdasarkan pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('asset_code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan kategori
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        // Filter berdasarkan status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan lokasi
        if ($request->has('location') && !empty($request->location)) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        // Urutkan berdasarkan terbaru
        $query->latest();

        // Ambil data dengan pagination
        $assets = $query->paginate(10)->withQueryString();

        // Hitung summary
        $totalAssets = Asset::count();
        $totalValue = Asset::sum('current_value');
        $maintenanceCount = Asset::where('status', 'maintenance')->count();
        $disposedCount = Asset::where('status', 'disposed')->count();

        return view('assets.index', compact(
            'assets',
            'totalAssets',
            'totalValue',
            'maintenanceCount',
            'disposedCount'
        ));
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
                'status' => $request->status,
                'location' => $request->location,
            ];

            $export = new AssetExport($filters);

            return Excel::download($export, 'assets-' . date('Y-m-d-His') . '.xlsx');
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
            $export = new AssetPDFExport([
                'search' => $request->search,
                'category' => $request->category,
                'status' => $request->status,
                'location' => $request->location,
            ]);

            $pdf = $export->generate();

            return $pdf->download('assets-' . date('Y-m-d-His') . '.pdf');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal export PDF: ' . $e->getMessage());
        }
    }

    /**
     * Print view
     */
    public function print(Request $request)
    {
        $query = Asset::query();

        // Apply filters
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('asset_code', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $assets = $query->get();
        $totalValue = $assets->sum('current_value');

        return view('exports.assets-print', compact('assets', 'totalValue'));
    }

    /**
     * Show the form for creating a new asset.
     */
    public function create()
    {
        return view('assets.create');
    }

    /**
     * Store a newly created asset.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'asset_code' => 'required|unique:assets,asset_code',
            'category' => 'required|string|in:elektronik,furniture,kendaraan,mesin,it,others',
            'sub_category' => 'nullable|string|max:100',
            'purchase_date' => 'required|date',
            'purchase_price' => 'required|numeric|min:0',
            'current_value' => 'required|numeric|min:0',
            'depreciation_rate' => 'nullable|numeric|min:0|max:100',
            'location' => 'required|string|max:255',
            'assigned_to' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'status' => 'required|in:active,maintenance,disposed,sold',
            'condition' => 'required|in:excellent,good,fair,poor,damaged',
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'serial_number' => 'nullable|unique:assets,serial_number',
            'warranty_months' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Hitung warranty end date jika ada
        if (isset($validated['warranty_months']) && $validated['warranty_months'] > 0) {
            $validated['warranty_end_date'] = now()->addMonths($validated['warranty_months']);
        }

        // Set created_by
        $validated['created_by'] = auth()->id();

        Asset::create($validated);

        return redirect()->route('assets.index')
            ->with('success', 'Asset berhasil ditambahkan!');
    }
    /**
     * Display a listing of the assets.
     */
    // public function index()
    // {
    //     return view('assets.index');
    // }

    // /**
    //  * Show the form for creating a new asset.
    //  */
    // public function create()
    // {
    //     return view('assets.create');
    // }

    // /**
    //  * Store a newly created asset in storage.
    //  */
    // public function store(Request $request)
    // {
    //     // Implement store logic here
    //     return redirect()->route('assets.index')->with('success', 'Asset berhasil ditambahkan');
    // }

    /**
     * Display the specified asset.
     */
    public function show($id)
    {
        return view('assets.show');
    }

    /**
     * Show the form for editing the specified asset.
     */
    public function edit($id)
    {
        return view('assets.edit');
    }

    /**
     * Update the specified asset in storage.
     */
    public function update(Request $request, $id)
    {
        // Implement update logic here
        return redirect()->route('assets.index')->with('success', 'Asset berhasil diupdate');
    }

    /**
     * Remove the specified asset from storage.
     */
    public function destroy($id)
    {
        // Implement delete logic here
        return redirect()->route('assets.index')->with('success', 'Asset berhasil dihapus');
    }

    /**
     * Store maintenance record
     */
    public function storeMaintenance(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        $validated = $request->validate([
            'maintenance_date' => 'required|date',
            'maintenance_type' => 'required|in:routine,corrective,preventive,emergency',
            'cost' => 'nullable|numeric|min:0',
            'description' => 'required|string'
        ]);

        // Update status menjadi maintenance jika diperlukan
        if ($request->has('change_status') && $request->change_status == 'yes') {
            $asset->update(['status' => 'maintenance']);
        }

        // Simpan record maintenance (jika ada table maintenance)
        // AssetMaintenance::create([
        //     'asset_id' => $asset->id,
        //     ...$validated
        // ]);

        return redirect()->route('assets.show', $asset->id)
            ->with('success', 'Maintenance berhasil dicatat!');
    }

    /**
     * Store transfer record
     */
    public function storeTransfer(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        $validated = $request->validate([
            'new_location' => 'required|string',
            'assigned_to' => 'nullable|string',
            'transfer_date' => 'required|date',
            'reason' => 'required|string'
        ]);

        // Update lokasi asset
        $asset->update([
            'location' => $validated['new_location'],
            'assigned_to' => $validated['assigned_to'] ?? $asset->assigned_to
        ]);

        // Simpan record transfer (jika ada table transfers)
        // AssetTransfer::create([
        //     'asset_id' => $asset->id,
        //     ...$validated
        // ]);

        return redirect()->route('assets.show', $asset->id)
            ->with('success', 'Asset berhasil ditransfer!');
    }

    /**
     * Dispose asset
     */
    public function disposal(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        $request->validate([
            'disposal_reason' => 'required|string'
        ]);

        $asset->update([
            'status' => 'disposed',
            'notes' => ($asset->notes ? $asset->notes . "\n" : '') .
                '[DISPOSAL] ' . $request->disposal_reason . ' pada ' . date('Y-m-d H:i:s')
        ]);

        return redirect()->route('assets.index')
            ->with('success', 'Asset berhasil didisposal!');
    }

    /**
     * Transfer form
     */
    public function transfer($id)
    {
        $asset = Asset::findOrFail($id);
        return view('assets.transfer', compact('asset'));
    }

    /**
     * Maintenance form
     */
    public function maintenance($id)
    {
        $asset = Asset::findOrFail($id);
        return view('assets.maintenance', compact('asset'));
    }
}
