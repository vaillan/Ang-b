<?php

namespace App\Http\Controllers\ServiceSelectedController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceSelected\ServiceSelected;

class ServiceSelectedController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $postUserEnterprise=null, $postUserPremium=null)
    {
        $query = \DB::transaction(function () use($request, $postUserEnterprise, $postUserPremium) {
            $servicesSelected = json_decode($request->servicios);
            if(isset($servicesSelected)) {
                foreach ($servicesSelected as $service) {
                    ServiceSelected::create([
                        'service_id' => $service->id,
                        'post_client_id' => isset($postUserEnterprise) ? $postUserEnterprise->id : null,
                        'post_user_id' => isset($postUserPremium) ? $postUserPremium->id : null,
                    ]);
                }
            }
        });
        return $query;
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
            $services = ServiceSelected::where('post_client_id', $post_client_id)
            ->orWhere('post_user_id', $post_user_id)
            ->get();
            foreach ($services as $service) {
                $service->delete();
            }
        });
        return $query;
    }
}
