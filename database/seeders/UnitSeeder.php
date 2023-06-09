<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('unit')->insert([
            [
                'title' => 'Unidad 1',
            ],
            [
                'title' => 'Unidad 2',
            ],
            [
                'title' => 'Unidad 3',
            ],
        ]);
    }
}
