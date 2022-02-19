<?php

namespace App\Http\Controllers\ExteriorSelectedController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExteriorSelected\ExteriorSelected;
use Illuminate\Database\Eloquent\Collection;
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
    public function store(Request $request, $postUserEnterpriseId=null, $postUserPremiumId=null)
    {
        $query = \DB::transaction(function () use($request, $postUserEnterpriseId, $postUserPremiumId) {
            $exteriorServicesSelected = json_decode($request->exteriores);
            if(isset($exteriorServicesSelected)) {
                foreach ($exteriorServicesSelected as $service) {
                    ExteriorSelected::updateOrCreate(
                        ['exterior_id' => $service->id],
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
            $exteriorServicesSelected = new Collection(json_decode($request->exteriores));
            $exterios = ExteriorSelected::where('post_client_id', $post_client_id)
            ->orWhere('post_user_id', $post_user_id)
            ->get();
            foreach ($exterios as $exterior) {
                if(!$exteriorServicesSelected->contains('id', $exterior->exterior_id)) {
                    $exterior->delete();
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
