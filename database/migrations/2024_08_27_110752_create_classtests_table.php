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
        Schema::create('classtests', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('sessionyear');
//            $table->foreignId('schoolclass_id')->constrained('schoolclasses')->nullOnDelete();
            $table->string('classname');
            $table->string('subject');
            $table->string('testname');
            $table->integer('maxmarks');
            $table->json('marksobtained')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classtests');
    }
};
