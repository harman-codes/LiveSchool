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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('sessionyear');
            $table->string('year');
            $table->string('classname');
            $table->json('january')->nullable();
            $table->json('february')->nullable();
            $table->json('march')->nullable();
            $table->json('april')->nullable();
            $table->json('may')->nullable();
            $table->json('june')->nullable();
            $table->json('july')->nullable();
            $table->json('august')->nullable();
            $table->json('september')->nullable();
            $table->json('october')->nullable();
            $table->json('november')->nullable();
            $table->json('december')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
