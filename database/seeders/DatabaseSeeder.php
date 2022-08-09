<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\AdresseSeeder;
use Database\Seeders\CategorieSeeder;
use Database\Seeders\RestaurantSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            UserSeeder::class,
            CategorieSeeder::class,
            AdresseSeeder::class,
            RestaurantSeeder::class,
            MenuSeeder::class,
            ProduitSedeer::class,
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
