<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('restaurants')->insert([
            'nom' => 'chez Flora',
            'adresse' => 'Abobo petit paris',
            'email' => 'chezflora@gmail.com',
            'phone' => '0102030405'
        ]);
    }
}
