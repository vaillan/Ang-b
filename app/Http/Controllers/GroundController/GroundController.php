<?php

namespace App\Http\Controllers\GroundController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grouund\Ground;
class GroundController extends Controller
{
    public function getGroundType() {
        $ground = Ground::all();
        if($ground) {
            return response()->json(['valid' => true, 'ground_type' => $ground],200);
        }else {
            return response()->json(['valid' => false, 'ground_type' => []],200);
        }
    }
}
