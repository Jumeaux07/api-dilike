<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
 /**
    * @OA\Info(
    *     version="1.0",
    *     title="Api Diliké"
    * )
    */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function slugRename($slug){
        $slug = str_replace(' ','-',$slug);
        return $slug;
    }
}
