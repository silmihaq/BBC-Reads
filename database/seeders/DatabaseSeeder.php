<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat Akun Admin Default untuk Login
        User::updateOrCreate(
            ['email' => 'admin@bbc-reads.com'],
            [
                'name'     => 'Administrator BBC',
                'password' => bcrypt('BBC3Admin'),
            ]
        );
    }
}