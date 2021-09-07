<?php

namespace App\Http\Controllers\DepartamentController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Departament\Departament;
class DepartamentController extends Controller
{
    public function getDepartamentType() {
        $departament = Departament::all();
        if($departament) {
            return \response()->json(['valid' => true, 'departament_type' => $departament],200);
        }else {
            return \response()->json(['valid' => false, 'departament_type' => []],200);
        }
    }
}
