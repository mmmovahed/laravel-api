<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class courseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'name' => 'مبانی برنامه‌نویسی با پایتون',
                'category_id' => 1,
                'college_id' => 1,
                'description' => 'آشنایی با اصول اولیه برنامه‌نویسی با زبان پایتون.',
                'teacher' => 'دکتر رضایی',
                'status' => 'active',
            ],
            [
                'name' => 'پایگاه داده پیشرفته',
                'category_id' => 3,
                'college_id' => 2,
                'description' => 'مباحث طراحی پایگاه داده و کوئری‌نویسی پیشرفته.',
                'teacher' => 'مهندس احمدی',
                'status' => 'active',
            ],
            [
                'name' => 'مبانی امنیت شبکه',
                'category_id' => 4,
                'college_id' => 4,
                'description' => 'آشنایی با تهدیدات امنیتی و راهکارهای مقابله.',
                'teacher' => 'مهندس محمدی',
                'status' => 'inactive',
            ],
        ];

        foreach ($courses as $data) {
            Course::create($data);
        }
    }
}
