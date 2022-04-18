<?php

namespace App\Http\Controllers\UserTypeController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\usersType\UserType;
class UserTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $usersType = UserType::all();
      if(count($usersType) > 0) {
        return response()->json(['usersType' => $usersType],200);
      }else {
        return response()->json(['usersType' => [], 'message' => "No se encontraron daos"],404);
      }
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
      $usersType = UserType::find($id);
      if($usersType) {
        return response()->json(['usersType' => [$usersType]],200);
      }else {
        return response()->json(['usersType' => [], 'message' => "No se encontraron daos"],404);
      }
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
}
