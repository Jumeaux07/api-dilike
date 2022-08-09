<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            'nom' => 'Menus1',
            'heureDebut' => 8,
            'heureFin' => 12,
            'permanant' => false,
        ]);
        DB::table('menus')->insert([
            'nom' => 'Menus1',
            'permanant' => 1,
        ]);
    }
}
