<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/api/categories",
     *      operationId="categories_list",
     *      tags={"categories"},
     *      summary="liste des categories",
     *      description="liste de de toutes les categories",
     *     @OA\Response(response="200", description="Afficher la liste de de toutes les categories")
     * )
     */
    public function index()
    {
        $categories = Categorie::all();
        return response()->json([
            'categories' => $categories,
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
     *      path="/api/categories",
     *      operationId="categories",
     *      tags={"categories"},
     *      summary="Créer une categorie",
     *      description="Inscription d'une categorie",
     *      @OA\RequestBody(
     *          required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="nom",
     *                     type="string"
     *                 ),
     *                 example={"nom": "Plat Attié"}
     *             )
     *         )
     *
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation"
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
            $this->validate($request, [
                'nom' => 'required'
            ]);
            $categorie = Categorie::create([
                'nom' => $request->nom,
                'slug' => $this->slugRename($request->nom),
            ]);
            if ($categorie) {
                Log::info("Création d'une categorie réussie: $request->nom -- $request->slug ".now());
                return response()->json([
                    'message' => 'Catégorie bien créée',
                    'categorie' => $categorie,
                    'status' => 201
                ], 201);
            }else{
                Log::warning(" La Création d'une categorie est impossible: $request->nom -- $request->slug ".now());
                return response()->json([
                    'message' => 'La création d\'une catégorie a échoué',
                    'status' => 403
                ], 403);
            }
        } catch (Exception $exception) {
            Log::critical("La création d'une catégorie est impossible Exception, $exception ".now());
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
     *      path="/api/categories/{id}",
     *      operationId="one_categorie",
     *      tags={"categories"},
     *      summary="Obtenir une seul categories",
     *      description="Obtenir une seul categories",
     *     @OA\Response(response="200", description="Obtenir une seul categories")
     * )
     */
    public function show($id)
    {
        $categorie = Categorie::find($id);
        if (!$categorie) {
            return response()->json([
                'message' => 'Categorie introuvable ou inexistante',
                'status' => 404
            ], 404);
        }
        return response()->json([
            'categorie' => $categorie,
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
     *      path="/api/categories/{id}",
     *      operationId="categories_update",
     *      tags={"categories"},
     *      summary="Mise à jour d'une categorie",
     *      description="Mise à jour d'une categorie",
     *      @OA\RequestBody(
     *          required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="nom",
     *                     type="string"
     *                 ),
     *                 example={"nom": "Plat Attié"}
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
                'nom' => 'required'
            ]);
            $categorie = Categorie::find($id);
            if(!$categorie){
                return response()->json([
                    'message' => 'Categorie introuvable ou inexistante',
                    'status' => 404
                ], 404);
            }
            $result = $categorie->update([
                'nom' => $request->nom,
                'slug' => $this->slugRename($request->nom)
            ]);
            if($result){
                Log::info("Mise à jour d'une categorie réussie : $categorie->nom -- $categorie->slug".now());
                return response()->json([
                    'message' => 'Mise à jour de la catégorie réussie',
                    'categorie' => $categorie,
                    'status' => 200
                ], 200);
            }else{
                Log::warning("Mise à jour d'une catégorie est impossible: $categorie->nom -- $categorie->slug".now());
                return response()->json([
                    'message' => 'Mise à jour de la catégorie a éechoué',
                    'status' => 403
                ], 403);
            }
        } catch (Exception $exception) {
            Log::critical("Mise à jour d'une catégorie est impossible, Exception : $exception".now());
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
     *      path="/api/categories/{id}",
     *      operationId="delete_categories",
     *      tags={"categories"},
     *      summary="Supprimer une categorie",
     *      description="Suprrime une categorie",
     *     @OA\Response(response="200", description="Supprime une categorie")
     * )
     */
    public function destroy($id)
    {
        $categorie = Categorie::find($id);
        if(!$categorie){
            return response()->json([
                'message' => 'Catégorie introuvable ou inexistante',
                'status' => 404
            ], 404);
        }
        if($categorie->delete()){
            return response()->json([
                'message' => 'Catégorie supprimé avec succès',
                'status' => 200
            ], 200);
        }
    }
}
