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
        Schema::create('supply_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supply_invoice_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('unit_id')->constrained()->onDelete('cascade'); // وحدة قياس (مشطاح / كرتون)
            $table->unsignedInteger('pallets_count'); // عدد المشاطيح
            $table->unsignedInteger('quantity_per_pallet'); // الكمية في كل مشطاح
            $table->decimal('total_weight', 10, 2); // الوزن الكلي بالجرام
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supply_invoice_items');
    }
};
