<?php

namespace App\Exports;

use App\Models\Inventory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Concerns\FromCollection;


class InventoryPDFExport
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function generate()
    {
        $query = Inventory::query();

        // apply filters if there is
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere("sku", "like", "%{$search}%");
            });
        }
        if (!empty($this->filters['category'])) {
            $query->where('category', $this->filters['category']);
        }

        $items = $query->get();
        $totalValue = $items->sum(function($item) {
            return $item->quantity * $item->price;
        });

        $pdf = PDF::loadView('exports.inventory-pdf', compact('items', 'totalValue'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf;
    }
}