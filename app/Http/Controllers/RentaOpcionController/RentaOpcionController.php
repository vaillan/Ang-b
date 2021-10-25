<?php

namespace App\Http\Controllers\RentaOpcionController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RentaOpcion\RentaOpcion;
class RentaOpcionController extends Controller
{
    public function getRentaOpciones(Request $request) {
        $rentaOpciones = RentaOpcion::all();
        if($rentaOpciones) {
            return response()->json(['valid' => true, 'renta_opciones' => $rentaOpciones],200);
        }else {
            return response()->json(['valid' => false, 'renta_opciones' => []],200);
        }
    }
}
