<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{    /**
    * @OA\Post(
    *      path="/api/login_user",
    *      operationId="login_user",
    *      tags={"users"},
    *      summary="Connexion",
    *      description="Connexion et retour des données de l'utilisateur",
    *      @OA\RequestBody(
    *          required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="email",
    *                     type="string"
    *                 ),
    *                 @OA\Property(
    *                     property="password",
    *                     type="string"
    *                 ),
    *                 example={"email": "zouzoua@gmail.com", "password": "12345678X",}
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
    public function login_user(Request $request){
        try {
            $this->validate($request,[
                'email' => 'required',
                'password' => 'required'
            ]);
            $user = User::where('email',$request->email)->first();
            if(!$user){
                return response()->json([
                    'message' => "Cette adresse email ['email' => $request->email] n'appartien à aucun compte ",
                    'status' => 404
                ], 404);
            }
            if(Hash::check($request->password, $user->password)==true){
                Log::info("Un utilisateur s'est connecté : $user->nom -- $user->prenoms".now());
                return response()->json([
                    'message' => 'Connexion réussie',
                    'user' => $user,
                    'token' => $user->createToken($user->nom.''.$user->created_at)->plainTextToken,
                    'status' => 200
                ], 200);
            }else{
                Log::warning("Connexion d'un utilisateur est impossible : ['email' => $request->email] ".now());
                return response()->json([
                    'message' => 'Mot de passe incorrecte',
                    'status' => 403
                ], 403);
            }
        } catch (Exception $exception) {
            Log::critical("La connexion d'un utilisateur est impossible, Exception : $exception".now());
            return response()->json([
                'Exception' => $exception,
                'sataus' =>  405
            ], 405);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/api/users",
     *      operationId="users_list",
     *      tags={"users"},
     *      summary="liste des utilisateurs",
     *      description="liste de de tous les utilisateurs",
     *     @OA\Response(response="200", description="Afficher la liste de de tous les utilisateurs")
     * )
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            'users' => $users,
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
     *      path="/api/users",
     *      operationId="users",
     *      tags={"users"},
     *      summary="Inscription",
     *      description="Inscription d'un utilisateur",
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
     *                     property="prenoms",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     type="string"
     *                 ),
     *                 example={"nom": "XXXXX","prenoms": "XXXXX","phone": "xxxx", "email": "XXXXX@gmail.com", "password": "12345678X", "password_confirmation":"12345678X"}
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
                'prenoms' => 'required',
                'phone' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required|confirmed'
            ]);
            $user = User::create([
                'nom' => $request->nom,
                'prenoms' => $request->prenoms,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(10)
            ]);
            if($user){
                Log::info("Un utilisateur s'est inscrit :$request->nom--$request->prenoms--$request->phone,--$request->email ".now());
                return response()->json([
                    'message' => 'Inscription réussie',
                    'user' => $user,
                    'status' => 201
                ], 201);
            }else {
                Log::warning("Inscription d'un utilisateur est impossible :$request->nom--$request->prenoms--$request->phone,--$request->email ".now());
                return response()->json([
                    'message' => 'Inscription réussie',
                    'status' => 403
                ], 403);
            }
        } catch (Exception $exception) {
            Log::critical("Inscription d'un utilisateur est impossible, Exception: $exception".now());
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
     *      path="/api/users/{id}",
     *      operationId="on_user",
     *      tags={"users"},
     *      summary="Obtenir un utilisateur",
     *      description="Information sur un utilisateur",
     *     @OA\Response(response="200", description="Information sur un utilisateur")
     * )
     */
    public function show($id)
    {
        $user = User::find($id);
        if($user){
            return response()->json([
                'user' => $user,
                'status' => 200
            ], 200);
        }else{
            return response()->json([
                'message' => 'Utilisateur introuvable ou innexistant',
                'staus' => 404
            ], 404);
        }
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
     *      path="/api/users/{id}",
     *      operationId="users_update",
     *      tags={"users"},
     *      summary="Mise à jour d'un utilisateur",
     *      description="Mise à jour d'un utilisateur",
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
     *                     property="prenoms",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"nom": "Kouadio","prenoms": "Essis","phone": "56854215", "password": "12345678X"}
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
            $this->validate($request, [
                'nom' => 'required',
                'prenoms' => 'required',
                'phone' => 'required',
                'password' => 'required'
            ]);
            $user = User::find($id);
            if(!$user){
                return response()->json([
                    'message' => 'Utilisateur introuvable ou inexistant',
                    'status' => 404
                ], 404);
            }
            if (Hash::check($request->password, $user->password) == false) {
                return response()->json([
                    'message' => 'Mot de passe incorrecte',
                    'status' => 403,
                ], 403);
            }
            $result = $user->update([
                'nom' => $request->nom,
                'prenoms' => $request->prenoms,
                'phone' => $request->phone,
            ]);
            if ($result) {
                Log::info("Utilisateur bien mis à jour : $user->nom--$user->prenoms--$user->phone--$user->email ".now());
                return response()->json([
                    'message' => 'Mise à jour des données réussi',
                    'user' => $user,
                    'status' => 200
                ]);
            }else{
                Log::warning("Mise à jour d'un utilisateur est impossible : $user->nom--$user->prenoms--$user->phone--$user->email ".now());
                return response()->json([
                    'message' => 'Mise à jour des donné a échoué',
                    'status' => 403
                ], 403);
            }

        } catch (Exception $exception) {
            Log::critical("Mise à jour d'un utilisateur impossible Exception: $exception".now());
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
     *      path="/api/users/{id}",
     *      operationId="user_delete",
     *      tags={"users"},
     *      summary="Suprimer un utilisateur",
     *      description="Suprimer un utilisateur",
     *     @OA\Response(response="200", description="Suprimer un utilisateur")
     * )
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'message' => 'Utilisateur introuvable ou inesxistant',
                'status' => 404
            ], 404);
        }
        if($user->delete()){
            return response()->json([
                'message' => 'Utilisateur supprimé avec succès',
                'status' => 200
            ], 200);
        }
    }
}
