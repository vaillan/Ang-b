<?php

namespace App\Http\Controllers\ServiceController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service\Service;

class ServiceController extends Controller
{
    public function getServicesProperty(Request $request) {
        $propertyServices = Service::all();
        if($propertyServices) {
            return response()->json(['valid' => true, 'propertyServices' => $propertyServices],200);
        }else {
            return response()->json(['valid' => false, 'propertyServices' => []],200);
        }
    } 
}
