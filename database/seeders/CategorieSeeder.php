<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'nom' => 'Africain',
            'slug' => 'Categorie-Africain',
            'created_at' => now()
        ]);
        DB::table('categories')->insert([
            'nom' => 'Libanais',
            'slug' => 'Categorie-Libanais',
            'created_at' => now()
        ]);
        DB::table('categories')->insert([
            'nom' => 'Italien',
            'slug' => 'Categorie-Italien',
            'created_at' => now()
        ]);
    }
}
