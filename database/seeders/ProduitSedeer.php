<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProduitSedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('produits')->insert([
            'nom' => 'Coca-cola',
            'slug' => 'Coca-cola',
            'reference' => 'CO458',
            'prix' => 1000,
            'nombre_de_produit' => 89,
            'disponibilite' => true,
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi accusantium, natus architecto odit, rerum hic fugit nisi laborum ex, facilis magni eveniet tenetur quibusdam enim in dolores! Officiis, exercitationem atque!',
            'specification' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi accusantium, natus architecto odit, rerum hic fugit nisi laborum ex, facilis magni eveniet tenetur quibusdam enim in dolores! Officiis, exercitationem atque!',
            'restaurant_id' => 1,
            'menu_id' => 1,
        ]);
        DB::table('produits')->insert([
            'nom' => 'Fanta',
            'slug' => 'Fanta',
            'reference' => 'CO458',
            'prix' => 1000,
            'nombre_de_produit' => 0,
            'disponibilite' => false,
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi accusantium, natus architecto odit, rerum hic fugit nisi laborum ex, facilis magni eveniet tenetur quibusdam enim in dolores! Officiis, exercitationem atque!',
            'specification' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi accusantium, natus architecto odit, rerum hic fugit nisi laborum ex, facilis magni eveniet tenetur quibusdam enim in dolores! Officiis, exercitationem atque!',
            'restaurant_id' => 1,
            'menu_id' => 1,
        ]);
    }
}
