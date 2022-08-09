<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'slug',
        'reference',
        'prix',
        'nombre_de_produit',
        'disponibilite',
        'description',
        'specification',
        'restaurant_id',
        'menu_id',
    ];
}
