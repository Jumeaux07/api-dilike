<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AdresseController;
use App\Http\Controllers\API\CategorieController;
use App\Http\Controllers\API\ProduitController;
use App\Http\Controllers\API\RestaurantController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// CRUD USERS
Route::resource('users',UserController::class);
Route::post('login_user',[UserController::class,'login_user']);
//CRUD CATEGORIE
Route::resource('categories', CategorieController::class);
//CRUD ADRESSE
Route::resource('adresses', AdresseController::class);
//CRUD RESTAURANT
Route::resource('restaurants', RestaurantController::class);
//CRUD MENU
Route::resource('menus', MenuController::class);
//CRUD PRODUITS
Route::resource('produits', ProduitController::class);

