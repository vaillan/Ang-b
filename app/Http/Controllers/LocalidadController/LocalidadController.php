<?php

namespace App\Http\Controllers\LocalidadController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Localidad\Localidad;
use Validator;

class LocalidadController extends Controller
{

    public function searchMexicoLocalidades(Request $request) {
        $validator = Validator::make($request->all(), [
            'search' => 'required|string',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $searching = $request->search;
        $mexico_localidades = Localidad::with(['municipio' => function($query) {
            $query->with('estado');
        }])->where('nombre','LIKE',"%{$searching}%")->get();
        $array = array();
        foreach ($mexico_localidades as $localidad) {
            $array[] = [
                'ID' => $localidad['id'],
                'estado' => $localidad['municipio']['estado']['nombre'],
                'clave' => $localidad['clave'],
                'localidad' => $localidad['nombre'],
                'municipio' => $localidad['municipio']['nombre'],
                'lat' => $localidad['lat'],
                'lng' => $localidad['lng'],
            ];
        }
        return response()->json(['valid' => true, 'mexico' => $mexico_localidades, 'data' => $array],200);
    }

}
