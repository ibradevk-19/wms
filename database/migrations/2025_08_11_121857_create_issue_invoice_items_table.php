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
        Schema::create('issue_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issue_invoice_id')->constrained('issue_invoices')->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('restrict');
            $table->foreignId('unit_id')->constrained()->onDelete('restrict');

            $table->decimal('quantity', 12, 3); // الكمية المصروفة
            $table->decimal('stock_unit_quantity', 12, 3); // الكمية المكافئة بوحدة التخزين

            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issue_invoice_items');
    }
};
