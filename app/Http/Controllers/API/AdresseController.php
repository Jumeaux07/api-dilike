<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Adresse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdresseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/api/adresses",
     *      operationId="adresses_list",
     *      tags={"adresses"},
     *      summary="liste des adresses",
     *      description="liste de de toutes les adresses",
     *     @OA\Response(response="200", description="Afficher la liste de de toutes les adresses")
     * )
     */
    public function index()
    {
        $adresses = Adresse::all();
        return response()->json([
            'adresses' => $adresses,
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
     *      path="/api/adresses",
     *      operationId="adresses",
     *      tags={"adresses"},
     *      summary="Créer une adresse",
     *      description="Créer d'une adresse",
     *      @OA\RequestBody(
     *          required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="entreprise",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="position",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="ville",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="quartier",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="rue",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="repere",
     *                     type="string"
     *                 ),
     *                 example={"entreprise": "ISTM", "position":"position 45 p4","ville":"Abidjan","quartier":"Yopougon-Koweit","repere":"Devant la pharmacie"}
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
                'position' => 'required',
                'ville' => 'required',
                'quartier' => 'required',
                'repere' => 'required'
            ]);
            $adresse = Adresse::create([
                'position' => $request->position,
                'ville' => $request->ville,
                'quartier' => $request->quartier,
                'repere' => $request->repere,
                'entreprise' => $request->entreprise,
            ]);
            if($adresse){
                Log::info("Création d'une adresse réussie : $request->position -- $request->ville -- $request->quartier -- $request->repere --  $request->entreprise ".now());
                return response()->json([
                    'message' => 'Création d\'une adresse réussi',
                    'adresse' => $adresse,
                    'status' => 200
                ]);
            }else{
                Log::warning("La création d'une adresse est impossible: $request->position -- $request->ville -- $request->quartier -- $request->repere --  $request->entreprise ".now());
                return response()->json([
                    'message' => 'Création d\'une adresse a échoué',
                    'status' => 403
                ], 403);
            }
        } catch (Exception $exception) {
            Log::critical("La création d'une adresse est impossible, Exception $exception".now());
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
     *      path="/api/adresses/{id}",
     *      operationId="one_adresse",
     *      tags={"adresses"},
     *      summary="Obtenir une seul adresse",
     *      description="Obtenir une seul adresse",
     *     @OA\Response(response="200", description="Obtenir une seul adresse")
     * )
     */
    public function show($id)
    {
        $adresse = Adresse::find($id);
        if(!$adresse){
            return response()->json([
                'message' => 'Adresse introuvable ou inexistante',
                'status' => 404
            ], 404);
        }
        return response()->json([
            'adresse' => $adresse,
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
     *      path="/api/adresses/{id}",
     *      operationId="adresses_update",
     *      tags={"adresses"},
     *      summary="Mettre à jour une adresse",
     *      description="Mise à jour d'une adresse",
     *      @OA\RequestBody(
     *          required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="entreprise",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="position",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="ville",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="quartier",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="repere",
     *                     type="string"
     *                 ),
     *                 example={"entreprise": "ISTM", "position":"position 45 p4","ville":"Abidjan","quartier":"Yopougon-Koweit","repere":"Devant la pharmacie"}
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
                'position' => 'required',
                'ville' => 'required',
                'quartier' => 'required',
                'repere' => 'required'
            ]);
            $adresse = Adresse::find($id);
            if(!$adresse){
                return response()->json([
                    'message' => 'Adresse introuvable ou inexistante',
                    'status' => 404
                ], 404);
            }
            if ($request->entreprise == null) {
                    $result = $adresse->update([
                    'position' => $request->position,
                    'ville' => $request->ville,
                    'quartier' => $request->quartier,
                    'repere' => $request->repere,
                ]);
            }else{
                $result = $adresse->update([
                    'position' => $request->position,
                    'ville' => $request->ville,
                    'quartier' => $request->quartier,
                    'repere' => $request->repere,
                    'entreprise' => $request->entreprise,
                ]);
            }
            if($result){
                Log::info("Mise à jour d'une adresse réussie :  $request->position -- $request->ville -- $request->quartier -- $request->repere --  $request->entreprise ".now());
                return response()->json([
                    'message' => 'Mise à jour de l\'adresse réussie',
                    'adresse' => $adresse,
                    'status' => 200
                ], 200);
            }else{
                Log::warning("Mise à jour d'une adresse impossie:  $request->position -- $request->ville -- $request->quartier -- $request->repere --  $request->entreprise ".now());
                return response()->json([
                    'message' => 'Mise à jour de l\'adresse impossible',
                    'status' => 403
                ], 403);
            }
        } catch (Exception $exception) {
           Log::critical("Mise à jour d'une adresse impossible, Exception: $exception".now());
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
     *      path="/api/adresses/{id}",
     *      operationId="delete_adresses",
     *      tags={"adresses"},
     *      summary="Supprimer une adresse",
     *      description="Supprimer une adress",
     *     @OA\Response(response="200", description="Supprimer une adresse")
     * )
     */
    public function destroy($id)
    {
        $adresse = Adresse::find($id);
        if (!$adresse) {
            return response()->json([
                'message' => 'Adresse introuvable ou inexistante',
                'status' => 404
            ], 404);
        }
        if($adresse->delete()){
            return response()->json([
                'message' => 'Adresse supprimé avec succès',
                'status' => 200
            ], 200);
        }
    }
}
