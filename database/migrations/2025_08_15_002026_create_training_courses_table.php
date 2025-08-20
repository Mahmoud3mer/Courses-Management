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
        Schema::create('training_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
            $table->date('start_date')->comment('تاريخ بدء الدورة');
            $table->date('end_date')->comment('تاريخ انتهاء الدورة');
            $table->decimal('price', 10, 2)->comment('سعر الدورة');
            $table->string('note', 255)->nullable()->comment('ملاحظات الدورة');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_courses');
    }
};
