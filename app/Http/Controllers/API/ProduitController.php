<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\produit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produits = Produit::all();
        return response()->json([
            'produits' => $produits,
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
     *      path="/api/produits",
     *      operationId="produits",
     *      tags={"produits"},
     *      summary="Créer un produit",
     *      description="Création d'un produit",
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
     *                     property="reference",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="prix",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="nombre_de_produit",
     *                     type="integer"
     *                 ),
     *                 example={"nom": "MenuSuper", "heureDebut":08, "heureFin":15, "permanant":"non"}
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
                'nom',
                'slug',
                'reference',
                'prix',
                'nombre_de_produit',
                'disponibilite',
                'restaurant_id',
                'menu_id',
            ]);
            $produit = Produit::create([
                'nom' => $request->nom,
                'slug' => $this->slugRename($request->nom),
                'reference' => $request->reference,
                'prix' => $request->prix,
                'nombre_de_produit' => $request->nombre_de_produit,
                'disponibilite' => true,
                'description' => $request->description,
                'specification' => $request->specification,
                'restaurant_id' => $request->restaurant_id,
                'menu_id' => $request->menu_id,
            ]);

            if ($produit) {
                Log::info("Création d'un avec succès : $request->nom -- $request->slug -- $request->reference -- $request->prix -- $request->nombre_de_produit -- $request->disponibilite -- $request->description -- $request->specification -- $request->restaurant_id -- $request->menu_id ".now());
                return response()->json([
                    'message' => 'Produit créé avec succès',
                    'produit' => $produit,
                    'status' => 201
                ], 200);
            }else{
                Log::warning("Crétion d'un produit est impossible: $request->nom -- $request->slug -- $request->reference -- $request->prix -- $request->nombre_de_produit -- $request->disponibilite -- $request->description -- $request->specification -- $request->restaurant_id -- $request->menu_id ".now());
                return response()->json([
                    'message' => 'La création d\'un produit a échoué',
                    'status' => 403
                ], 403);
            }
        } catch (Exception $exception) {
            Log::critical("Création d'un produit est impossible, Exception: $exception ".now());
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
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
