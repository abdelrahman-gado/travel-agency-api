<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::create([
            "email" => env('ADMIN_EMAIL', 'admin@admin.com'),
            "password" => Hash::make(env('ADMIN_PASSWORD', 'admin'))
        ]);

        $user->roles()->attach(1);

        $user->save();
    }
}
