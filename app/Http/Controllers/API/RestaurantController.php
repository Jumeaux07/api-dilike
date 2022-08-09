<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/api/restaurants",
     *      operationId="restaurants_list",
     *      tags={"restaurants"},
     *      summary="liste des restaurants",
     *      description="liste de de tous les restaurants",
     *     @OA\Response(response="200", description="Afficher la liste de de tous les restaurants")
     * )
     */
    public function index()
    {
        $restaurants = Restaurant::all();
        return response()->json([
            'restaurants' => $restaurants,
            'status' => 200
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Post(
     *      path="/api/restaurants",
     *      operationId="restaurants",
     *      tags={"restaurants"},
     *      summary="Créer un restaurant",
     *      description="Inscription d'un restaurant",
     *      @OA\RequestBody(
     *          required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="nom",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="adresse",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string"
     *                 ),
     *                 example={"nom": "Les Delices","adresse":"Yopougon-Maroc","email":"delice@gmail.com","phone":"0102030405"}
     *             )
     *         )
     *
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request,[
                'nom' => 'required',
                'adresse' => 'required',
                'phone' => 'required',
                'email' => 'email|unique:restaurants'
            ]);
            $restaurant = Restaurant::create([
                'nom' => $request->nom,
                'adresse' => $request->adresse,
                'email' => $request->email,
                'phone' => $request->phone
            ]);
            if($restaurant){
                Log::info("Création d'un restaurant réussi: $request->nom -- $request->adresse -- $request->email -- $request->phone ".now());
                return response()->json([
                    'message' => 'Restaurant créé avec succès',
                    'restaurant' => $restaurant,
                    'status' => 201
                ], 201);
            }else{
                Log::warning("Création d'un restaurant est impossible: $request->nom -- $request->adresse -- $request->email -- $request->phone ".now());
                return response()->json([
                    'message' => 'La création d\'un restaurant a échoué',
                    'status' => 403
                ], 403);
            }
        } catch (Exception $exception) {
            Log::critical("Création d'un restaurant d'un restaurant est impossible, Exception $exception ".now());
            return response()->json([
                'Exception' => $exception,
                'status' => 405
            ], 405);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/api/restaurants/{id}",
     *      operationId="one_restaurant",
     *      tags={"restaurants"},
     *      summary="Obtenir un seul restaurant",
     *      description="Obetenir un seul restaurant",
     *     @OA\Response(response="200", description="Afficher les information d'un seul restaurant")
     * )
     */
    public function show($id)
    {
        $restaurant = Restaurant::find($id);
        if(!$restaurant){
            return response()->json([
                'message' => 'Restaurant introuvable ou inexistant',
                'status' => 404
            ], 404);
        }
        return response()->json([
            'restaurant' => $restaurant,
            'status' => 200
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *      path="/api/restaurants/{id}",
     *      operationId="_update_restaurants",
     *      tags={"restaurants"},
     *      summary="Mettre à jour un restaurant",
     *      description="Mise à jour d'un restaurant",
     *      @OA\RequestBody(
     *          required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="nom",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="adresse",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string"
     *                 ),
     *                 example={"nom": "Les Delices","adresse":"Yopougon-Maroc","email":"delice@gmail.com","phone":"0102030405"}
     *             )
     *         )
     *
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validate($request,[
                'nom' => 'required',
                'adresse' => 'required',
                'phone' => 'required',
                'email' => 'email'
            ]);
            $restaurant = Restaurant::find($id);
            if(!$restaurant){
                return response()->json([
                    'message' => 'Restaurant introuvable ou inexistant',
                    'status' => 404
                ], 404);
            }
            $result = $restaurant->update([
                'nom' => $request->nom,
                'adresse' => $request->adresse,
                'email' => $request->email,
                'phone' => $request->phone
            ]);
            if($result){
                Log::info("Mise à jour d'un restaurant réussie: $restaurant->nom -- $restaurant->adresse -- $restaurant->email -- $restaurant->phone ".now());
                return response()->json([
                    'message' => 'Restaurant mise à jour avec succès',
                    'restaurant' => $restaurant,
                    'status' => 200
                ], 200);
            }else{
                Log::warning("Mise à jour d'un restaurant est impossible: $request->nom -- $request->adresse -- $request->email -- $request->phone ".now());
                response()->json([
                    'message' => 'La mise à jour d\'un restaurant a échoué',
                    'status' => 403
                ], 403);
            }
        } catch (Exception $exception) {
            Log::critical("Mise à jour d'un restaurant impossible, Exception $exception".now());
            return response()->json([
                'Exception' => $exception,
                'status' => 405
            ], 405);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *      path="/api/restaurants/{id}",
     *      operationId="delete_restaurants",
     *      tags={"restaurants"},
     *      summary="Supprimer un restaurant",
     *      description="Suprrime un restaurant",
     *     @OA\Response(response="200", description="Supprime une restaurant")
     * )
     */
    public function destroy($id)
    {
        $restaurant = Restaurant::find($id);
        if(!$restaurant){
            return response()->json([
                'message' => 'Restaurant introuvable ou inexistant',
                'status' => 404
            ], 404);
        }
        if($restaurant->delete()){
            return response()->json([
                'message' => 'Restaurant supprimé avec succès',
                'status' => 200
            ], 200);
        }
    }
}
