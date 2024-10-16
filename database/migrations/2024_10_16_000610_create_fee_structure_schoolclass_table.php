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
        Schema::create('fee_structure_schoolclass', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_structure_id')->constrained('fee_structures')->cascadeOnDelete();
            $table->foreignId('schoolclass_id')->constrained('schoolclasses')->cascadeOnDelete();
            $table->string('sessionyear')->default(SessionYears::currentSessionYear());
//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_structure_schoolclass');
    }
};
