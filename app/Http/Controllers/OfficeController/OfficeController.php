<?php

namespace App\Http\Controllers\OfficeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Office\Office;
class OfficeController extends Controller
{
    public function getOfficeType() {
        $office = Office::all();
        return $office;
    }
}
