<?php

namespace App\Http\Controllers\GroundController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grouund\Ground;
class GroundController extends Controller
{
    public function getGroundType() {
        $ground = Ground::all();
        return $ground;
    }
}
