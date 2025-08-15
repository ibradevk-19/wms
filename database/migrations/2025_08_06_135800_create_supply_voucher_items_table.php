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
        Schema::create('supply_voucher_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supply_voucher_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable();
            $table->integer('pallets')->default(1); // عدد المشاطيح
            $table->integer('qty_per_pallet')->default(1); // الكمية في المشطاح
            $table->integer('total_qty')->default(0); // سيتم حسابه = pallets × qty_per_pallet
            $table->integer('weight_gram')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supply_voucher_items');
    }
};
