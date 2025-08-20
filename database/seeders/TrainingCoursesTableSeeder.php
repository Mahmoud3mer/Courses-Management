<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainingCoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('training_courses')->insert([
            [
                'course_id' => 55,
                'start_date' => '2025-09-01',
                'end_date' => '2025-09-30',
                'price' => 1500.00,
                'note' => 'دورة تدريبية في تطوير الويب',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 56,
                'start_date' => '2025-10-01',
                'end_date' => '2025-10-31',
                'price' => 2000.00,
                'note' => 'دورة تدريبية في تحليل البيانات',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 57,
                'start_date' => '2025-11-01',
                'end_date' => '2025-11-30',
                'price' => 1800.00,
                'note' => 'دورة تدريبية في الذكاء الاصطناعي',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 58,
                'start_date' => '2025-12-01',
                'end_date' => '2025-12-31',
                'price' => 2200.00,
                'note' => 'دورة تدريبية في تطوير التطبيقات',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 62,
                'start_date' => '2026-01-01',
                'end_date' => '2026-01-31',
                'price' => 2500.00,
                'note' => 'دورة تدريبية في التسويق الرقمي',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'course_id' => 64,
                'start_date' => '2026-02-01',
                'end_date' => '2026-02-28',
                'price' => 2700.00,
                'note' => 'دورة تدريبية في تطوير الألعاب',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
