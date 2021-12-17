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
    public function store(Request $request, $postUserEnterprise=null, $postUserPremium=null)
    {
        $query = \DB::transaction(function () use($request, $postUserEnterprise, $postUserPremium) {
            $exteriorServicesSelected = json_decode($request->exteriores);
            if(isset($exteriorServicesSelected)) {
                foreach ($exteriorServicesSelected as $service) {
                    ExteriorSelected::create([
                        'exterior_id' => $service->id,
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
            $exterios = ExteriorSelected::where('post_client_id', $post_client_id)
            ->orWhere('post_user_id', $post_user_id)
            ->get();
            foreach ($exterios as $exterior) {
                $exterior->delete();
            }
        });
        return $query;
    }

}
