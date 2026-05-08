<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Asset;
use Carbon\Carbon;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = [
            [
                'name' => 'Laptop Dell XPS 13',
                'asset_code' => 'IT-LAP-001',
                'category' => 'it',
                'sub_category' => 'Laptop',
                'purchase_date' => '2024-01-15',
                'purchase_price' => 18500000,
                'current_value' => 16500000,
                'depreciation_rate' => 20,
                'location' => 'Gedung A Lt. 3 Ruang IT',
                'assigned_to' => 'Budi Santoso',
                'department' => 'IT Department',
                'status' => 'active',
                'condition' => 'excellent',
                'brand' => 'Dell',
                'model' => 'XPS 13 9320',
                'serial_number' => 'DL-XPS13-001',
                'warranty_months' => 12,
                'warranty_end_date' => '2025-01-15',
                'description' => 'Laptop Dell XPS 13 dengan prosesor Intel Core i7, RAM 16GB, SSD 512GB',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'AC Split 2 PK',
                'asset_code' => 'FAC-AC-001',
                'category' => 'elektronik',
                'sub_category' => 'AC',
                'purchase_date' => '2023-06-10',
                'purchase_price' => 5500000,
                'current_value' => 4200000,
                'depreciation_rate' => 15,
                'location' => 'Gedung B Lt. 2 Ruang Meeting',
                'assigned_to' => 'Facility Team',
                'department' => 'Facility Management',
                'status' => 'active',
                'condition' => 'good',
                'brand' => 'Daikin',
                'model' => 'STK-2PK',
                'serial_number' => 'DK-AC-001',
                'warranty_months' => 24,
                'warranty_end_date' => '2025-06-10',
                'description' => 'AC Split 2 PK untuk ruangan meeting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Meja Kerja Eksekutif',
                'asset_code' => 'FUR-MEJ-001',
                'category' => 'furniture',
                'sub_category' => 'Meja',
                'purchase_date' => '2023-12-20',
                'purchase_price' => 3250000,
                'current_value' => 3000000,
                'depreciation_rate' => 10,
                'location' => 'Gedung A Lt. 2 Ruang Direktur',
                'assigned_to' => 'Direktur Utama',
                'department' => 'Executive Office',
                'status' => 'active',
                'condition' => 'excellent',
                'brand' => 'Informa',
                'model' => 'Executive Series',
                'serial_number' => 'INF-MEJ-001',
                'warranty_months' => 12,
                'warranty_end_date' => '2024-12-20',
                'description' => 'Meja kerja eksekutif dengan material kayu jati',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Printer HP LaserJet',
                'asset_code' => 'IT-PRN-002',
                'category' => 'it',
                'sub_category' => 'Printer',
                'purchase_date' => '2023-08-05',
                'purchase_price' => 4250000,
                'current_value' => 2500000,
                'depreciation_rate' => 25,
                'location' => 'Gedung A Lt. 3 Ruang Admin',
                'assigned_to' => 'Staff Administrasi',
                'department' => 'Administrasi',
                'status' => 'maintenance',
                'condition' => 'fair',
                'brand' => 'HP',
                'model' => 'LaserJet M227fdw',
                'serial_number' => 'HP-LJ-002',
                'warranty_months' => 12,
                'warranty_end_date' => '2024-08-05',
                'description' => 'Printer multifungsi untuk kebutuhan administrasi',
                'last_maintenance_date' => '2024-03-15',
                'next_maintenance_date' => '2024-06-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Toyota Avanza (Operasional)',
                'asset_code' => 'VHC-CAR-001',
                'category' => 'kendaraan',
                'sub_category' => 'Mobil Operasional',
                'purchase_date' => '2022-01-20',
                'purchase_price' => 235000000,
                'current_value' => 180000000,
                'depreciation_rate' => 15,
                'location' => 'Parkir Gedung A',
                'assigned_to' => 'Driver Operasional',
                'department' => 'General Affair',
                'status' => 'active',
                'condition' => 'good',
                'brand' => 'Toyota',
                'model' => 'Avanza 1.5 G',
                'serial_number' => 'B-1234-ABC',
                'warranty_months' => 36,
                'warranty_end_date' => '2025-01-20',
                'description' => 'Mobil operasional untuk keperluan kantor',
                'last_maintenance_date' => '2024-03-10',
                'next_maintenance_date' => '2024-06-10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($assets as $asset) {
            Asset::create($asset);
        }
    }
}