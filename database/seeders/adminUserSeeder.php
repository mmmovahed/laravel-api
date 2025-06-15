<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class adminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'ادمین',
            'email' => 'admin@example.com',
            'password' => bcrypt('123456789'),
            'phone' => '09120000000',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'مدرس نمونه',
            'email' => 'teacher@example.com',
            'password' => bcrypt('123456789'),
            'phone' => '09130000000',
            'role' => 'teacher',
        ]);
    }
}
