<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pass = bcrypt('asdasd');

        User::insert([
            [
                'name' => 'admin',
                'email' => 'admin@admin.admin',
                'password' => $pass,
                'role_id' => 1
            ],
            [
                'name' => 'teacher',
                'email' => 'teacher@teacher.teacher',
                'password' => $pass,
                'role_id' => 2
            ]
        ]);
    }
}