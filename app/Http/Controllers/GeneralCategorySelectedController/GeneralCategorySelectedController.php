<?php

namespace App\Http\Controllers\GeneralCategorySelectedController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralCategorySelected\GeneralCategorySelected;
use Illuminate\Database\Eloquent\Collection;
class GeneralCategorySelectedController extends Controller
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
            $caracteristicasGenerales = json_decode($request->caracteristicasGenerales);
            if(isset($caracteristicasGenerales)) {
                foreach ($caracteristicasGenerales as $service) {
                    GeneralCategorySelected::updateOrCreate(
                        ['general_category_id' => $service->id, 'post_client_id' => $postUserEnterpriseId],
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
    public function update(Request $request, $post_client_id=null, $post_user_id=0)
    {
        $query = \DB::transaction(function() use($request, $post_user_id, $post_client_id){
            $caracteristicasGeneralesSelected = new Collection(json_decode($request->caracteristicasGenerales));
            $GeneralCategories = GeneralCategorySelected::where('post_client_id', $post_client_id)
            ->orWhere('post_user_id', $post_user_id)
            ->get();
            foreach ($GeneralCategories as $GeneralCategory) {
                if(!$caracteristicasGeneralesSelected->contains('id', $GeneralCategory->general_category_id)) {
                    $GeneralCategory->delete();
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
    public function destroy($post_client_id=null, $post_user_id=0)
    {
        $query = \DB::transaction(function () use ($post_client_id, $post_user_id) {
            $GeneralCategories = GeneralCategorySelected::where('post_client_id', $post_client_id)
            ->orWhere('post_user_id', $post_user_id)
            ->get();
            foreach ($GeneralCategories as $GeneralCategory) {
                $GeneralCategory->delete();
            }
        });
        return $query;
    }

}
