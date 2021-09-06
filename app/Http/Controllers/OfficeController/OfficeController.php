<?php

namespace App\Http\Controllers\OfficeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Office\Office;
class OfficeController extends Controller
{
    public function getOfficeType() {
        $office = Office::all();
        if($office) {
            return response()->json(['valid' => true, 'office_type' => $office],200);
        }else {
            return response()->json(['valid' => false, 'office_type' => []],200);
        }
    }
}
