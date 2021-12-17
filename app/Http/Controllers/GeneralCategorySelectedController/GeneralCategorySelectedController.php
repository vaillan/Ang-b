<?php

namespace App\Http\Controllers\GeneralCategorySelectedController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralCategorySelected\GeneralCategorySelected;

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
    public function store(Request $request, $postUserEnterprise=null, $postUserPremium=null)
    {
        $query = \DB::transaction(function () use($request, $postUserEnterprise, $postUserPremium) {
            $caracteristicasGenerales = json_decode($request->caracteristicasGenerales);
            if(isset($caracteristicasGenerales)) {
                foreach ($caracteristicasGenerales as $service) {
                    GeneralCategorySelected::create([
                        'general_category_id' => $service->id,
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
