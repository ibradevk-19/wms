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
        Schema::create('supply_invoices', function (Blueprint $table) {
                $table->id();
                $table->string('invoice_number')->unique(); // رقم الفاتورة
                $table->date('invoice_date');
                $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
                $table->foreignId('truck_id')->nullable()->constrained()->onDelete('set null');
                $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
                $table->text('notes')->nullable();
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supply_invoices');
    }
};
