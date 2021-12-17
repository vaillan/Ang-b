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
    public function store(Request $request, $postUserEnterprise=null, $postUserPremium=null)
    {
        $query = \DB::transaction(function () use($request, $postUserEnterprise, $postUserPremium) {
            $conservationStateServicesSelected = json_decode($request->estado_conservacion);
            if(isset($conservationStateServicesSelected)) {
                foreach ($conservationStateServicesSelected as $service) {
                    ConservationStateSelected::create([
                        'conservation_state_id' => $service->id,
                        'post_client_id' => isset($postUserEnterprise) ? $postUserEnterprise->id : null,
                        'post_user_id' => isset($postUserPremium) ? $postUserPremium->id : null,
                    ]);
                }
            }
        });
        return $query;
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
    public function destroy($post_client_id=null, $post_user_id=null)
    {
        $query = \DB::transaction(function () use ($post_client_id, $post_user_id) {
            $conservationState = ConservationStateSelected::where('post_client_id', $post_client_id)
            ->orWhere('post_user_id', $post_user_id)
            ->get();
            foreach ($conservationState as $conservation) {
                $conservation->delete();
            }
        });
        return $query;
    }
}
