<?php

namespace App\Http\Controllers\ExteriorController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exterior\Exterior;
class ExteriorController extends Controller
{
    public function getExteriors(Request $request) {
        $exteriors = Exterior::all();
        if($exteriors) {
            return response()->json(['valid' => true, 'exteriors' => $exteriors],200);
        }else {
            return response()->json(['valid' => false, 'exteriors' => []],200);
        }
    }
}
