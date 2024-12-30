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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bookcategory_id')->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('publisher')->nullable();
            $table->string('bookno')->nullable();
            $table->string('isbn')->nullable();
            $table->integer('year')->nullable();
            $table->integer('total')->nullable();
            $table->integer('issued')->nullable();
            $table->integer('instock')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('sort')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
