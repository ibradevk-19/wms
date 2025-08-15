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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');                        // اسم المورد
            $table->string('identifier')->nullable();      // رقم الهوية أو السجل التجاري
            $table->string('phone')->nullable();           // رقم الجوال
            $table->string('email')->nullable();           // البريد الإلكتروني
            $table->text('address')->nullable();           // العنوان
            $table->string('city')->nullable();            // المدينة
            $table->string('country')->nullable();         // الدولة
            $table->string('payment_method')->nullable();  // طريقة الدفع
            $table->enum('status', ['active', 'inactive'])->default('active'); // الحالة
            $table->text('notes')->nullable();             // ملاحظات
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
