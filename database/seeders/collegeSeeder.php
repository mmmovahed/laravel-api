<?php

namespace Database\Seeders;

use App\Models\College;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class collegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colleges = [
            ['name' =>'دانشکده فنی و حرفه‌ای شهید شمسی‌پور تهران', 'rank' => 2 , 'city' => 'تهران'],
            ['name' =>'دانشکده فنی و حرفه‌ای دکتر شریعتی تهران', 'rank' => 1 , 'city' => 'تهران'],
            ['name' =>'دانشکده فنی و حرفه‌ای دختران تبریز', 'rank' => 3 , 'city' => 'تبریز'],
            ['name' =>'دانشکده فنی و حرفه‌ای پسران مشهد', 'rank' => 4 , 'city' => 'مشهد'],
            ['name' =>'دانشکده فنی و حرفه‌ای کرمان', 'rank' => 5 , 'city' => 'کرمان'],
            ['name' =>'دانشکده فنی و حرفه‌ای همدان', 'rank' => 6 , 'city' => 'همدان'],
        ];

        foreach ($colleges as $data) {
            College::create($data);
        }
    }
}
