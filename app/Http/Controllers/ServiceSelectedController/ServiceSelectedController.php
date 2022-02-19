<?php

namespace App\Http\Controllers\ServiceSelectedController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceSelected\ServiceSelected;
use Illuminate\Database\Eloquent\Collection;

class ServiceSelectedController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $post_client_id=null, $post_user_id=null)
    {
        $query = \DB::transaction(function () use($request, $post_client_id, $post_user_id) {
            $servicesSelected = json_decode($request->servicios);
            if(isset($servicesSelected)) {
                foreach ($servicesSelected as $service) {
                    ServiceSelected::updateOrCreate(
                        ['service_id' => $service->id],
                        [
                            'post_client_id' => isset($post_client_id) ? $post_client_id : null,
                            'post_user_id' => isset($post_user_id) ? $post_user_id : null
                        ]
                    );
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


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $post_client_id
     * @param int $post_user_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $post_client_id=null, $post_user_id=null)
    {
        $query = \DB::transaction(function() use($request, $post_user_id, $post_client_id){
            $servicesSelected = new Collection(json_decode($request->servicios));
            $services = ServiceSelected::where('post_client_id', $post_client_id)
            ->orWhere('post_user_id', $post_user_id)
            ->get();
            foreach ($services as $service) {
                if(!$servicesSelected->contains('id', $service->service_id)) {
                    $service->delete();
                }
            }
            $this->store($request, $post_client_id);
        });
        return $query;
    }

}
