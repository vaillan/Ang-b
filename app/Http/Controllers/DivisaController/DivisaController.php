<?php

namespace App\Http\Controllers\DivisaController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Divisa\Divisa;

class DivisaController extends Controller
{
    public function getDivisas(Request $request) {
        $divisas = Divisa::all();
        if($divisas) {
            return response()->json(['valid' => true, 'divisas' => $divisas],200);
        }else {
            return response()->json(['valid' => false, 'divisas' => []],200);
        }
    }
}
