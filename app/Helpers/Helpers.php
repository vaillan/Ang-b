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

}