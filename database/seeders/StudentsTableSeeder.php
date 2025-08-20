<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')->insert([
        [
            'name' => 'أحمد',
            'phone' => '01012345678',
            'address' => 'القاهرة - مدينة نصر',
            'email' => 'ahmed@example.com',
            'notes' => 'عميل منتظم',
            'national_id' => '12345678901234',
            'gender' => 'ذكر',
            'image' => 'image1.jpg',
            'country_id' => 1,
            'active' => 1,
        ],
        [
            'name' => 'فاطمة',
            'phone' => '01198765432',
            'address' => 'الجيزة - الهرم',
            'email' => 'fatima@example.com',
            'notes' => 'عميلة جديدة',
            'national_id' => '23456789012345',
            'gender' => 'أنثى',
            'image' => 'image2.jpg',
            'country_id' => 2,
            'active' => 1,
        ],
        [
            'name' => 'محمد',
            'phone' => '01511223344',
            'address' => 'الإسكندرية - سيدي جابر',
            'email' => 'mohamed@example.com',
            'notes' => 'طلب عرض أسعار',
            'national_id' => '34567890123456',
            'gender' => 'ذكر',
            'image' => 'image3.jpg',
            'country_id' => 3,
            'active' => 0,
        ],
        [
            'name' => 'سارة',
            'phone' => '01233445566',
            'address' => 'دمياط - رأس البر',
            'email' => 'sara@example.com',
            'notes' => 'تحتاج متابعة',
            'national_id' => '45678901234567',
            'gender' => 'أنثى',
            'image' => 'image4.jpg',
            'country_id' => 4,
            'active' => 1,
        ],
        [
            'name' => 'خالد',
            'phone' => '01099887766',
            'address' => 'أسوان - كورنيش النيل',
            'email' => 'khaled@example.com',
            'notes' => 'عميل VIP',
            'national_id' => '56789012345678',
            'gender' => 'ذكر',
            'image' => 'image5.jpg',
            'country_id' => 5,
            'active' => 1,
        ],
        [
            'name' => 'ليلى',
            'phone' => '01166554433',
            'address' => 'المنصورة - حي الجامعة',
            'email' => 'layla@example.com',
            'notes' => 'تواصلت معنا عبر البريد',
            'national_id' => '67890123456789',
            'gender' => 'أنثى',
            'image' => 'image6.jpg',
            'country_id' => 6,
            'active' => 0,
        ],
    ]);
    }
}
