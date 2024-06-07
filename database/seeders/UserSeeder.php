<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // pengurus
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345'),
            'level' => '0',
            'noHP' => '0812345'
        ]);

        Project::create([
            'client' => 'satu',
            'project' => 'satu',
            'schedule' => 'satu',
            'dueDate' => '2024/05/01',
            'status' => '1'
        ]);
        Project::create([
            'client' => 'dua',
            'project' => 'dua',
            'schedule' => 'dua',
            'dueDate' => '2024/06/01',
        ]);
    }
}
