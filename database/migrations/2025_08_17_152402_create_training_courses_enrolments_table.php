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
        Schema::create('training_courses_enrolments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->references('id')->on('students')->cascadeOnDelete()->onUpdate('cascade');
            $table->foreignId('training_course_id')->references('id')->on('training_courses')->cascadeOnDelete()->onUpdate('cascade');
            $table->date('enrolment_date')->comment('تاريخ التسجيل بالدورة التدريبية');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_courses_enrolments');
    }
};
