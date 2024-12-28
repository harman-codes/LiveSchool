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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('admissionno')->nullable();
            $table->string('name');
            $table->enum('gender',['m','f','o']);
            $table->date('dob');
            $table->string('mobile')->nullable();
            $table->string('email')->unique();
            $table->string('fathername')->nullable();
            $table->string('mothername')->nullable();
            $table->string('address')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('role')->default('parent');
            $table->string('selectedsessionyear')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
