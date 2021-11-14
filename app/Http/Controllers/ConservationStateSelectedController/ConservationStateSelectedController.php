<?php

namespace App\Http\Controllers\ConservationStateSelectedController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConservationStateSelected\ConservationStateSelected;

class ConservationStateSelectedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function createConservationStateService($postClient, $conservationStateServicesSelected) {
        $query = \DB::transaction(function () use($postClient, $conservationStateServicesSelected) {
            foreach ($conservationStateServicesSelected as $service) {
                ConservationStateSelected::create([
                    'conservation_state_id' => $service->id,
                    'post_client_id' => $postClient->id,
                ]);
            }
        });
        return $query;
    }
}
