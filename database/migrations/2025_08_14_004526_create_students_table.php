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
            $table->string('name', 225);
            $table->string('phone', 20);
            $table->string('address', 255);
            $table->string('email', 255)->unique();
            $table->string('notes', 255);
            $table->string('national_id', 50)->unique();
            $table->string('gender', 10);
            $table->string('image')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->foreignId('country_id')->references('id')->on('countries')->onDelete('cascade')->onUpdate('cascade');
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
