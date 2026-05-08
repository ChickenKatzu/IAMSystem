<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets';

    protected $fillable = [
        'name',
        'asset_code',
        'category',
        'sub_category',
        'purchase_date',
        'purchase_price',
        'current_value',
        'depreciation_rate',
        'location',
        'assigned_to',
        'department',
        'status',
        'condition',
        'brand',
        'model',
        'serial_number',
        'warranty_months',
        'warranty_end_date',
        'description',
        'notes',
        'created_by',
        'updated_by',
        'last_maintenance_date',
        'next_maintenance_date',
        'disposal_date',
        'disposal_reason'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_end_date' => 'date',
        'last_maintenance_date' => 'date',
        'next_maintenance_date' => 'date',
        'disposal_date' => 'date',
        'purchase_price' => 'decimal:2',
        'current_value' => 'decimal:2',
        'depreciation_rate' => 'decimal:2'
    ];

    // Accessors
    public function getFormattedPurchasePriceAttribute()
    {
        return 'Rp ' . number_format($this->purchase_price, 0, ',', '.');
    }

    public function getFormattedCurrentValueAttribute()
    {
        return 'Rp ' . number_format($this->current_value, 0, ',', '.');
    }

    public function getDepreciationAmountAttribute()
    {
        return $this->purchase_price - $this->current_value;
    }

    public function getFormattedDepreciationAmountAttribute()
    {
        return 'Rp ' . number_format($this->depreciation_amount, 0, ',', '.');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => ['label' => 'Active', 'class' => 'success'],
            'maintenance' => ['label' => 'Maintenance', 'class' => 'warning'],
            'disposed' => ['label' => 'Disposed', 'class' => 'danger'],
            'sold' => ['label' => 'Sold', 'class' => 'secondary'],
        ];

        return $badges[$this->status] ?? ['label' => ucfirst($this->status), 'class' => 'secondary'];
    }

    public function getConditionBadgeAttribute()
    {
        $badges = [
            'excellent' => ['label' => 'Excellent', 'class' => 'success'],
            'good' => ['label' => 'Good', 'class' => 'primary'],
            'fair' => ['label' => 'Fair', 'class' => 'warning'],
            'poor' => ['label' => 'Poor', 'class' => 'danger'],
            'damaged' => ['label' => 'Damaged', 'class' => 'dark'],
        ];

        return $badges[$this->condition] ?? ['label' => ucfirst($this->condition), 'class' => 'secondary'];
    }

    public function getCategoryLabelAttribute()
    {
        $categories = [
            'elektronik' => 'Elektronik',
            'furniture' => 'Furniture',
            'kendaraan' => 'Kendaraan',
            'mesin' => 'Mesin & Peralatan',
            'it' => 'IT & Hardware',
            'others' => 'Lainnya',
        ];

        return $categories[$this->category] ?? ucfirst($this->category);
    }

    public function getWarrantyStatusAttribute()
    {
        if (!$this->warranty_end_date) {
            return ['label' => 'No Warranty', 'class' => 'secondary'];
        }

        $today = Carbon::today();
        $warrantyEnd = Carbon::parse($this->warranty_end_date);

        if ($today->gt($warrantyEnd)) {
            return ['label' => 'Expired', 'class' => 'danger'];
        }

        $daysLeft = $today->diffInDays($warrantyEnd);

        if ($daysLeft <= 30) {
            return ['label' => "Expiring Soon ({$daysLeft} days)", 'class' => 'warning'];
        }

        return ['label' => "Active ({$daysLeft} days left)", 'class' => 'success'];
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByLocation($query, $location)
    {
        return $query->where('location', 'like', "%{$location}%");
    }

    public function scopeNeedMaintenance($query)
    {
        return $query->whereNotNull('next_maintenance_date')
            ->where('next_maintenance_date', '<=', Carbon::now()->addDays(30));
    }
}
