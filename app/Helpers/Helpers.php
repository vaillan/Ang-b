<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use App\Models\Localidad\Localidad;
use Illuminate\Http\Response;
class Helpers {

    public function getUserInfo($user) {
        if($user) {
            $image = $this->getImage($user->image);
            return response()->json([
                'id' => $user->id,
                'role' => $user->role,
                'nick' => $user->nick,
                'name' => $user->name,
                'last_name' => $user->last_name,
                'image' => $image,
                'email' => $user->email,
                'about_me' => $user->about_me,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ],200)->original;
            
        }
        return [];
    }

    public function getImage($filename) {
        $file = $filename ? Storage::disk('usersImg')->url($filename): null;
        return $file;
    }

    public function getLOcation($localidad_id) {
        $location = Localidad::with(['municipio' => function($query) {
            $query->with('estado');
        }])->find($localidad_id);
        return $location;
    }

    public function mapPostUsers($arrayPostUsers) {
        $new_array_posts_user = array();
        foreach($arrayPostUsers as $post_user) {
            $post = [
                'budget_maximum' => $post_user->budget_maximum,
                'budget_minimum' => $post_user->budget_minimum,
                'created_at' => $post_user->created_at,
                'description' => $post_user->description,
                'divisa_budget_maximum' => $post_user->divisa_budget_maximum,
                'divisa_budget_minimum' => $post_user->divisa_budget_minimum,
                'end_date' => $post_user->end_date,
                'id' => $post_user->id,
                'init_date' => $post_user->init_date,
                'updated_at' => $post_user->updated_at,
                'user' => $user = $this->getUserInfo($post_user->user),
                'user_id' => $post_user->user_id,
                'address' =>  $post_user->address,
            ];
            $new_array_posts_user[] = $post;
        }
        return $new_array_posts_user;
    }

}