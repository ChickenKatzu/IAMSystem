<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class InventoryExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    // /**
    // * @return \Illuminate\Support\Collection
    // */
    // public function collection()
    // {
    //     return Inventory::all();
    // }

    protected $filters;
    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Inventory::query();

        // apply filters if there's
        if(!empty($this->filters['search'])){
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search){
                $q->where('name', 'like', "%{$search}%")
                    ->orwhere('sku', 'like', "%{$search}%");
                });
        }

        if (!empty($this->filters['category'])) {
            $query->where('category', $this->filters['category']);
        }
        
        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'SKU',
            'Nama Item',
            'Kategori',
            'Quantity',
            'Harga',
            'Total Nilai',
            'Supplier',
            'Deskripsi',
            'Status Stok',
            'Tanggal Dibuat',
            'Terakhir Update'
        ];
    }

    public function map($inventory): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        $categoryLabels = [
            'elektronik' => 'Elektronik',
            'furniture' => 'Furniture',
            'stationary' => 'Stationary',
            'lainnya' => 'Lainnya',
        ];

        $statusLabels = [
            'in_stock' => 'In Stock (>10)',
            'low_stock' => 'Low Stock (1-10)',
            'out_of_stock' => 'Out of Stock (0)',
        ];

        $status = $inventory->quantity > 10 ? 'in_stock' : ($inventory->quantity > 0 ? 'low_stock' : 'out_of_stock');

        return [
            $rowNumber,
            $inventory->sku,
            $inventory->name,
            $categoryLabels[$inventory->category] ?? $inventory->category,
            $inventory->quantity,
            'Rp ' . number_format($inventory->price, 0, ',', '.'),
            'Rp ' . number_format($inventory->quantity * $inventory->price, 0, ',', '.'),
            $inventory->supplier ?? '-',
            $inventory->description ?? '-',
            $statusLabels[$status],
            $inventory->created_at->format('d/m/Y H:i'),
            $inventory->updated_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
            'A1:L1' => ['fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E2E8F0']]],
        ];
    }
}
