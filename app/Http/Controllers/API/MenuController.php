<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/api/menus",
     *      operationId="menus_list",
     *      tags={"menus"},
     *      summary="liste des menus",
     *      description="liste de de tous les menus",
     *     @OA\Response(response="200", description="Afficher la liste de de tous les menus")
     * )
     */
    public function index()
    {
        $menus = Menu::all();
        return response()->json([
            'menus' => $menus,
            'status' => 200,
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
     *      path="/api/menus",
     *      operationId="menus",
     *      tags={"menus"},
     *      summary="Créer un menu",
     *      description="Création d'un menu",
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
     *                     property="heureDebut",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="heureFin",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="permanant",
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
                'nom' => 'required',
                'permanant' => 'required'
            ]);
            if($request->permanant ==  'true'){
                $menu = Menu::create([
                    'nom' => $request->nom,
                    'permanant' => 1,
                ]);
            }else{
                $this->validate($request,[
                    'heureDebut' => 'required',
                    'heureFin' => 'required'
                ]);
                $menu = Menu::create([
                    'nom' => $request->nom,
                    'heureDebut' => $request->heureDebut,
                    'heureFin' => $request->heureFin,
                    'permanant' => 0,
                ]);
            }
            if($menu){
                Log::info("Création d'un menu avec succès : $request->nom, $request->heureDebut, $request->heureFin, $request->permanant ".now());
                return response()->json([
                    'message' => 'Menu créé avec succès',
                    'menu' => $menu,
                    'status' => 201
                ], 201);
            }else{
                Log::warning("Création d'un menu impossible : $request->nom, $request->heureDebut, $request->heureFin, $request->permanant ".now());
                return response()->json([
                    'message' => 'Création d\'un menu a échoué',
                    'status' => 403
                ], 403);
            }
        } catch (Exception $exception) {
            Log::critical("La crétion d'un menu est impossible Exception : $exception ".now());
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
     *      path="/api/menus/1",
     *      operationId="one_menu",
     *      tags={"menus"},
     *      summary="liste des menus",
     *      description="liste de de tous les menus",
     *     @OA\Response(response="200", description="Afficher la liste de de tous les menus")
     * )
     */
    public function show($id)
    {
        $menu = Menu::find($id);
        if(!$menu){
            return response()->json([
                'message' => 'Menu introuvable ou inexistant',
                'status' => 404,
            ], 404);
        }
        return response()->json([
            'menu' => $menu,
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
     *      path="/api/menus/1",
     *      operationId="menu_client",
     *      tags={"clients"},
     *      summary="Mise à jour d'un client",
     *      description="Mise à jour d'un client",
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
                    'nom' => 'required',
                    'permanant' => 'required'
                ]);
                $menu = Menu::find($id);
                if (!$menu) {
                    return response()->json([
                        'message' => 'Menu introuvable ou inexistant',
                        'status' => 404
                    ], 404);
                }
                if($request->permanant ==  'true'){
                    $result = $menu->update([
                        'nom' => $request->nom,
                        'heureDebut' => null,
                        'heureFin' => null,
                        'permanant' => 1,
                    ]);
                }else{
                    $this->validate($request,[
                        'heureDebut' => 'required',
                        'heureFin' => 'required'
                    ]);
                    $result = $menu->update([
                        'nom' => $request->nom,
                        'heureDebut' => $request->heureDebut,
                        'heureFin' => $request->heureFin,
                        'permanant' => 0,
                    ]);
                }
                if($menu){
                    Log::info("Mise à jour d'un menu avec succès : $menu->nom, $menu->heureDebut, $menu->heureFin, $menu->permanant ".now());
                    return response()->json([
                        'message' => 'Mise à jour du menu avec succès',
                        'menu' => $menu,
                        'status' => 200
                    ], 200);
                }else{
                    Log::warning("Mise à jour d'un menu impossible : $request->nom, $request->heureDebut, $request->heureFin, $request->permanant ".now());
                    return response()->json([
                        'message' => 'Mise à jour d\'un menu a échoué',
                        'status' => 403
                    ], 403);
                }
            }catch(Exception $exception) {
                Log::critical("Mise à jour d'un menu est impossible Exception : $exception ".now());
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
    public function destroy($id)
    {
        $menu = Menu::find($id);
        if(!$menu){
            return response()->json([
                'message' => 'Menu introuvable ou inexistant',
                'status' => 404
            ], 404);
        }
        if($menu->delete()){
            return response()->json([
                'message' => 'Menu supprimé avec succès',
                'status' => 200
            ], 200);
        }
    }
}
