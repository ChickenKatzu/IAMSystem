<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AssetExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $filters;
    
    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }
    
    public function collection()
    {
        $query = Asset::query();
        
        // Apply filters
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('asset_code', 'like', "%{$search}%");
            });
        }
        
        if (!empty($this->filters['category'])) {
            $query->where('category', $this->filters['category']);
        }
        
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        
        return $query->get();
    }
    
    public function headings(): array
    {
        return [
            'No',
            'Kode Asset',
            'Nama Asset',
            'Kategori',
            'Lokasi',
            'Ditugaskan Kepada',
            'Status',
            'Tanggal Pembelian',
            'Harga Pembelian',
            'Nilai Saat Ini',
            'Penyusutan',
            'Deskripsi'
        ];
    }
    
    public function map($asset): array
    {
        static $rowNumber = 0;
        $rowNumber++;
        
        $categoryLabels = [
            'elektronik' => 'Elektronik',
            'furniture' => 'Furniture',
            'kendaraan' => 'Kendaraan',
            'mesin' => 'Mesin & Peralatan',
            'it' => 'IT & Hardware',
            'others' => 'Lainnya',
        ];
        
        return [
            $rowNumber,
            $asset->asset_code,
            $asset->name,
            $categoryLabels[$asset->category] ?? $asset->category,
            $asset->location,
            $asset->assigned_to ?? '-',
            ucfirst($asset->status),
            $asset->purchase_date->format('d/m/Y'),
            number_format($asset->purchase_price, 0, ',', '.'),
            number_format($asset->current_value, 0, ',', '.'),
            number_format($asset->depreciation, 0, ',', '.'),
            $asset->description ?? '-',
        ];
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 11]],
            'A1:L1' => [
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4']
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF']]
            ],
        ];
    }
}