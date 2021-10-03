<?php

namespace App\Http\Controllers\GeneralCategoryController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralCategory\GeneralCategory;
class GeneralCategoryController extends Controller
{
    public function getGeneralCategories(Request $request) {
        $categories = GeneralCategory::all();
        if($categories) {
            return response()->json(['valid' => true, 'generalCategories' => $categories],200);
        }else {
            return response()->json(['valid' => false, 'generalCategories' => []],200);
        }
    }
}
