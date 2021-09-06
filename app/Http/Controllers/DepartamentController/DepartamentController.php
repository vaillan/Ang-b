<?php

namespace App\Http\Controllers\DepartamentController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Departament\Departament;
class DepartamentController extends Controller
{
    public function getGroundType() {
        $departament = Departament::all();
        return $departament;
    }
}
