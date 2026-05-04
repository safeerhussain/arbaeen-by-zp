<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(SettingsSeeder::class);

        // Default admin user — change password before going live
        User::firstOrCreate(
            ['email' => 'admin@arbaeen.local'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin2026'),
            ]
        );
    }
}
