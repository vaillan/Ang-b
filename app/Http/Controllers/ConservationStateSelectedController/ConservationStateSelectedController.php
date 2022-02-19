<?php

namespace App\Http\Controllers\ConservationStateSelectedController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConservationStateSelected\ConservationStateSelected;
use Illuminate\Database\Eloquent\Collection;
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
    public function store(Request $request, $postUserEnterpriseId=null, $postUserPremiumId=null)
    {
        $query = \DB::transaction(function () use($request, $postUserEnterpriseId, $postUserPremiumId) {
            $conservationStateServicesSelected = json_decode($request->estado_conservacion);
            if(isset($conservationStateServicesSelected)) {
                foreach ($conservationStateServicesSelected as $service) {
                    ConservationStateSelected::updateOrCreate(
                        ['conservation_state_id' => $service->id],
                        [
                            'post_client_id' => isset($postUserEnterpriseId) ? $postUserEnterpriseId : null,
                            'post_user_id' => isset($postUserPremiumId) ? $postUserPremiumId : null
                        ]
                    );
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
     * @param  int $post_client_id
     * @param int $post_user_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $post_client_id=null, $post_user_id=null)
    {
        $query = \DB::transaction(function() use($request, $post_user_id, $post_client_id){
            $conservationStateServicesSelected = new Collection(json_decode($request->estado_conservacion));
            $conservationState = ConservationStateSelected::where('post_client_id', $post_client_id)
            ->orWhere('post_user_id', $post_user_id)
            ->get();
            foreach ($conservationState as $conservation) {
                if(!$conservationStateServicesSelected->contains('id', $conservation->conservation_state_id)) {
                    $conservation->delete();
                }
            }
            $this->store($request, $post_client_id);
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
