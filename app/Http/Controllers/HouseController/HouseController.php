<?php

namespace App\Http\Controllers\HouseController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\House\House;

class HouseController extends Controller
{
    public function getHouseType() {
        $house =  House::all();
        if($house) {
            return response()->json(['valid' => true, 'house_type' => $house],200);
        }else {
            return response()->json(['valid' => false, 'house_type' => []],200);
        }
    }
}
