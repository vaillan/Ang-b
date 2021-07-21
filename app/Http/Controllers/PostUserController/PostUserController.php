<?php

namespace App\Http\Controllers\PostUserController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\PostUser\PostUser;
use App\Models\Address\Address;
use App\Models\Estado\Estado;
use App\Models\Municipio\Municipio;
use App\Models\Localidad\Localidad;
use App\Helpers\Helpers;
use App\Models\User;
use Validator;

class PostUserController extends Controller
{

    public function createPostUser(Request $request) {  //Crea post usuario tipo [user]

        $query = \DB::transaction(function () use($request) {
            $carbon = new \Carbon\Carbon();
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'description' => 'required|string',
                'budget_minimum' => 'required',
                'budget_maximum' => 'required',
                'init_date' => 'required',
                'end_date' => 'required',
                'divisa_budget_minimum' => 'required',
                'divisa_budget_maximum' => 'required',
                'localidad_id' => 'required',
                'address' => 'required',
            ]);
            if($validator->fails()) {
                return [$validator->errors()];
            }
            $dt1 = $carbon->parse($request->input('init_date'))->locale('English');
            $dt2 = $carbon->parse($request->input('end_date'))->locale('English');
            $createPostUser = $request->all();
            $createPostUser['init_date'] = $dt1;
            $createPostUser['end_date'] = $dt2;
            $post_user = PostUser::create($createPostUser);
            $getLocation = new Helpers();
            $mexico = $getLocation->getLOcation($request->input('localidad_id'));
            $address = Address::create([
                'user_id' => $request->user_id,
                'post_user_id' => $post_user->id,
                'clave' => $mexico['clave'],
                'estado' => $mexico['municipio']['estado']['nombre'],
                'localidad' => $mexico['nombre'],
                'municipio' => $mexico['municipio']['nombre'],
                'lat' => $mexico['lat'],
                'lng' => $mexico['lng'],
                'address' => $request->input('address'),
            ]);
            if($address) {
                $posts = $this->getPostUser($request->user_id)->original;
                return ['valid' => true, 'message' => 'post wass created successfully', 'posts_user' => $posts];
            }
        });
        return response()->json($query);
    }

    public function getPostUser($id) {
        $array_posts_user = PostUser::with('user', 'address')->where('user_id',$id)->orderBy('id', 'desc')->get();
        $helperService = new Helpers();
        $new_array_posts_user = $helperService->mapPostUsers($array_posts_user);
        if(count($new_array_posts_user) > 0) {
            return response()->json(['valid' => true,'posts_user' => $new_array_posts_user],200);
        }else {
            return response()->json(['valid' => false, 'posts_user' => []],200);
        }
    }

    public function deletePostUser($id) {
        $user = auth()->user();
        $postUser = PostUser::find($id);
        $addressPostUser = Address::where('post_user_id', $postUser->id)->where('user_id',$postUser->user_id)->first();
        $postUser->delete();
        $addressPostUser->delete();
        $posts = $this->getPostUser($user->id)->original;
        return  $posts;
    }

    public function getAllPostUsers() {
        $post_users = PostUser::with('user', 'address')->get();
        $helperService = new Helpers();
        $new_array_posts_user = $helperService->mapPostUsers($post_users);
        if(count($new_array_posts_user) > 0) {
            return response()->json(['valid' => true, 'post_users' => $new_array_posts_user],200);
        }else {
            return response()->json(['valid' => false, 'post_users' => []], 200);
        }
    }
}
