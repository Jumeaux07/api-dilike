<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nom' => 'Zouzoua',
            'prenoms' => 'Essis Cedric',
            'phone' => '0103772742',
            'email' => 'zouzoua@gmail.com',
            'password' => Hash::make('12345678X'),
            'remember_token' => Str::random(10),
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'nom' => 'Amenzou',
            'prenoms' => 'Ange',
            'phone' => '0787572030',
            'email' => 'amenzou@gmail.com',
            'password' => Hash::make('12345678X'),
            'remember_token' => Str::random(10),
            'created_at' => now()
        ]);
    }
}
