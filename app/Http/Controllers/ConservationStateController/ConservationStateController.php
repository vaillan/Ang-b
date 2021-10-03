<?php

namespace App\Http\Controllers\ConservationStateController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConservationState\ConservationState;
class ConservationStateController extends Controller
{
    public function getConservationState(Request $request) {
        $conservationState = ConservationState::all();
        if($conservationState) {
            return response()->json(['valid' => true, 'conservationState' => $conservationState], 200);
        }else {
            return response()->json(['valid' => false, 'conservationState' => []], 200);
        }
    }
}
