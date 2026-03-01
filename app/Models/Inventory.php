<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'sku',
        'quantity',
        'price',
        'supplier',
        'description'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2'
    ];

    // Accessor untuk format harga
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Accessor untuk status stok
    public function getStockStatusAttribute()
    {
        if ($this->quantity <= 0) {
            return ['label' => 'Out of Stock', 'class' => 'danger'];
        } elseif ($this->quantity <= 10) {
            return ['label' => 'Low Stock', 'class' => 'warning'];
        } else {
            return ['label' => 'In Stock', 'class' => 'success'];
        }
    }
}
