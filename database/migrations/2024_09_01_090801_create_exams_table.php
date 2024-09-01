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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('sessionyear');
            $table->foreignId('schoolclass_id')->constrained('schoolclasses')->nullOnDelete();
            $table->date('fromdate');
            $table->date('todate');
            $table->string('examname');
            $table->integer('totalmarks')->nullable();
            $table->json('maxmarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
