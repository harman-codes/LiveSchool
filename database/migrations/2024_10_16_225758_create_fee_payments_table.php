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
        Schema::create('fee_payments', function (Blueprint $table) {
            $table->id();
            $table->string('sessionyear');
            $table->integer('amount_paid');
            $table->integer('amount_due');
            $table->string('payment_mode');
            $table->date('payment_date');
            $table->foreignId('student_id')->constrained('students')->nullOnDelete();
            $table->foreignId('fee_structure_id')->constrained('fee_structures')->nullOnDelete();
//            $table->foreignId('class_id')->constrained('classes')->nullOnDelete();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_payments');
    }
};
