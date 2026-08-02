<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use RuntimeException;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $name = env('INITIAL_ADMIN_NAME');
        $email = env('INITIAL_ADMIN_EMAIL');
        $password = env('INITIAL_ADMIN_PASSWORD');

        if (empty($name) || empty($email) || empty($password)) {
            throw new RuntimeException(
                'Isi INITIAL_ADMIN_NAME, INITIAL_ADMIN_EMAIL, dan INITIAL_ADMIN_PASSWORD di file .env.'
            );
        }

        Admin::firstOrCreate(
            [
                'email' => strtolower(trim($email)),
            ],
            [
                'name' => trim($name),
                'password' => $password,
                'role' => 'superadmin',
                'is_active' => true,
            ]
        );
    }
}