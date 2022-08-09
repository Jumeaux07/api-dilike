<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdresseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('adresses')->insert([
            'entreprise' => 'ELTIC',
            'position' => 'postion géographique',
            'ville' => 'Abidjan',
            'quartier' => 'Yopougon-Toitrouge',
            'repere' => 'devant l\'imeuble',
        ]);
    }
}
