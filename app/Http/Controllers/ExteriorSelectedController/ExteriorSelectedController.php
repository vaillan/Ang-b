<?php

namespace App\Http\Controllers\ExteriorSelectedController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExteriorSelected\ExteriorSelected;

class ExteriorSelectedController extends Controller
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

    public function createExteriorService($postClient, $exteriorServicesSelected) {
        $query = \DB::transaction(function () use($postClient, $exteriorServicesSelected) {
            foreach ($exteriorServicesSelected as $service) {
                ExteriorSelected::create([
                    'exterior_id' => $service->id,
                    'post_client_id' => $postClient->id,
                ]);
            }
        });
        return $query;
    }
}
