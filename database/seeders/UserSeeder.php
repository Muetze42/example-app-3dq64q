<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@example.app'],
            [
                'name'              => 'Administrator',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $user->assignRole('admin');
    }
}
