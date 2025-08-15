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
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number')->unique();   // رقم اللوحة
            $table->string('driver_name');              // اسم السائق
            $table->string('driver_phone')->nullable(); // رقم هاتف السائق
            $table->boolean('is_active')->default(true); // حالة الشاحنة (نشطة/غير نشطة)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};
