<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            ['name' => 'كورس تصميم وتطوير المواقع [PHP, Laravel, MySQL]', 'active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'كورس تطوير تطبيقات الويب باستخدام Laravel [PHP, Laravel, MySQL]', 'active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'كورس JavaScript لتطوير واجهات المستخدم [JavaScript, DOM, ES6]', 'active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'كورس Python لتطوير التطبيقات وتحليل البيانات [Python, Django, Pandas]', 'active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'كورس Ruby لتطوير تطبيقات الويب [Ruby, Rails, SQLite]', 'active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'كورس تصميم صفحات الويب باستخدام HTML [HTML5, SEO, Forms]', 'active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'كورس تنسيق وتصميم واجهات الويب باستخدام CSS [CSS3, Flexbox, Grid]', 'active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'كورس تطوير واجهات المستخدم باستخدام React.js [React.js, JSX, Hooks]', 'active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'كورس تطوير تطبيقات الويب باستخدام Next.js [Next.js, React.js, SSR]', 'active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'كورس Java لتطوير تطبيقات سطح المكتب والويب [Java, Spring Boot, MySQL]', 'active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
