<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class InventoryExport implements FromCollection
{
    protected $category;
    protected $search;

    public function __construct($category = null, $search = null)
    {
        $this->category = $category;
        $this->search = $search;
    }

    public function collection()
    {
        $query = Inventory::query();
        if ($this=>$category && $this->category != 'all'){
            $query->where('category', $this->category);
        }
        if ($this->search){
            $query->where(function ($q){
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('sku', 'like', '%' . $this->search . '%');
            });
        }
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'SKU',
            'Category',
            'Quantity',
            'Price',
            'Total Value',
            'Created At',
        ];
    }

    public function map($inventory): array
    {
        return [
            $inventory->id,
            $inventory->name,
            $inventory->sku,
            $inventory->category,
            $inventory->quantity,
            'Rp' . number_format($inventory->price, 0, ',', '.'),
            'Rp' . number_format($inventory->price * $inventory->quantity, 0, ',', '.'),
        ];
    }   
}
