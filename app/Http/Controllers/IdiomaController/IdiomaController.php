<?php

namespace App\Http\Controllers\IdiomaController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Idioma\Idioma;

class IdiomaController extends Controller
{
    public function getIdiomas(Request $request) {
        $idiomas = Idioma::all();
        if($idiomas) {
            return response()->json(['valid' => true, 'idiomas' => $idiomas], 200);
        }else {
            return response()->json(['valid' => false, 'idiomas' => []], 400);
        }
    }
}
