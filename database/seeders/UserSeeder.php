<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user')->insert([
            [
                'name' => 'Admin',
                'middle_name' => 'admin',
                'last_name' => 'ihm',
                'phone' => '0000000000',
                'email' => 'admin@ihm.com',
                'password' => Hash::make('prueba'),
            ],
        ]);
    }
}
