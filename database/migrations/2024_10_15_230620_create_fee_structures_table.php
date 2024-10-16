<?php

use App\Helpers\SessionYears;
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
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->id();
//            $table->foreignId('schoolclass_id')->constrained('schoolclasses')->nullOnDelete();
            $table->string('sessionyear')->default(SessionYears::currentSessionYear());
            $table->string('title');
            $table->date('from');
            $table->date('to');
            $table->date('lastdate');
            $table->integer('amount');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_structures');
    }
};
