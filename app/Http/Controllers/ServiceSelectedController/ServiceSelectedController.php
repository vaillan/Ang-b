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
}
