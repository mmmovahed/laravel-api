<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'برنامه‌نویسی', 'status' => 'active'],
            ['name' => 'شبکه', 'status' => 'active'],
            ['name' => 'پایگاه داده', 'status' => 'active'],
            ['name' => 'امنیت اطلاعات', 'status' => 'active'],
            ['name' => 'هوش مصنوعی', 'status' => 'active'],
            ['name' => 'مهندسی نرم‌افزار', 'status' => 'active'],
        ];

        foreach ($categories as $data) {
            Category::create($data);
        }
    }
}
