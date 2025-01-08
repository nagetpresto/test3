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
        Schema::create('Master_Users', function (Blueprint $table) {
            $table->id();  // automatically creates an auto-incrementing primary key
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('password');
            $table->string('ktp')->nullable()->unique();
            $table->datetime('dob')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->boolean('is_admin')->default(false); 
            $table->boolean('is_sales')->default(false); 
            $table->boolean('is_verified')->default(false); 
            $table->datetime('verified_date')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Master_Users');
    }
};
