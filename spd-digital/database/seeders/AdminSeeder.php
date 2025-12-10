<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@spd.local'],
            [
                'name'     => 'admin',
                'role'     => 'admin',
                'email'    => 'admin@spd.local',
                'password' => Hash::make('123456'),
            ]
        );

        
        User::updateOrCreate(
            ['email' => 'user@spd.local'],
            [
                'name'     => 'User Biasa',
                'role'     => 'user',
                'email'    => 'user@spd.local',
                'password' => Hash::make('123456'),
            ]
        );
    }
}
