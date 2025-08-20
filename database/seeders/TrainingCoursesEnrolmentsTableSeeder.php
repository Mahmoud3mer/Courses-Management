<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainingCoursesEnrolmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('training_courses_enrolments')->insert([
            ['training_course_id' => 25, 'student_id' => 1, 'enrolment_date' => now()],
            ['training_course_id' => 30, 'student_id' => 2, 'enrolment_date' => now()],
            ['training_course_id' => 26, 'student_id' => 12, 'enrolment_date' => now()],
            ['training_course_id' => 28, 'student_id' => 3, 'enrolment_date' => now()],
            ['training_course_id' => 26, 'student_id' => 20, 'enrolment_date' => now()],
            ['training_course_id' => 27, 'student_id' => 15, 'enrolment_date' => now()],
        ]);
    }
}
