<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            
            // Informasi Dasar Asset
            $table->string('name');
            $table->string('asset_code')->unique();
            $table->string('category');
            $table->string('sub_category')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            
            // Informasi Pembelian
            $table->date('purchase_date');
            $table->decimal('purchase_price', 15, 2)->default(0);
            $table->decimal('current_value', 15, 2)->default(0);
            $table->decimal('depreciation_rate', 5, 2)->default(0);
            
            // Informasi Lokasi & Penanggung Jawab
            $table->string('location');
            $table->string('assigned_to')->nullable();
            $table->string('department')->nullable();
            
            // Informasi Status (tanpa index terpisah)
            $table->enum('status', ['active', 'maintenance', 'disposed', 'sold'])->default('active');
            $table->enum('condition', ['excellent', 'good', 'fair', 'poor', 'damaged'])->default('good');
            
            // Informasi Teknis
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable()->unique();
            $table->integer('warranty_months')->default(0);
            $table->date('warranty_end_date')->nullable();
            
            // Audit Trail
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->date('last_maintenance_date')->nullable();
            $table->date('next_maintenance_date')->nullable();
            $table->date('disposal_date')->nullable();
            $table->text('disposal_reason')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};