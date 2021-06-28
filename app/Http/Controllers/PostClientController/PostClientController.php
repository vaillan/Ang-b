<?php

namespace App\Http\Controllers\PostClientController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostClient\PostClient;
use App\Models\Address\Address;
use App\Models\Estado\Estado;
use App\Models\Municipio\Municipio;
use App\Models\Localidad\Localidad;
use App\Models\Images\Images;
use App\Helpers\Helpers;
use App\User;
use Validator;
use File;
use Storage;

class PostClientController extends Controller
{

    public function createPostClient(Request $request) {
        $localidad_id = $request->input('localidad_id');
        $user_id = $request->input('user_id');
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'description' => 'required',
            'services' => 'required',
            'type_post' => 'required',
            'post_client_status' => 'required',
            'price' => 'required',
            'divisa' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $createPostClient = $request->all();
        $createPostClient['post_client_status'] = $request->input('post_client_status') === true ? 1 : 0;
        $postClient = PostClient::create($createPostClient);
        $getLocation = new Helpers();
        $mexico = $getLocation->getLOcation($localidad_id);
        $query = Address::create([
            'user_id' => $user_id,
            'post_client_id' => $postClient->id,
            'clave' => $mexico['clave'],
            'estado' => $mexico['municipio']['estado']['nombre'],
            'localidad' => $mexico['nombre'],
            'municipio' => $mexico['municipio']['nombre'],
            'lat' => $mexico['lat'],
            'lng' => $mexico['lng'],
        ]);

        $files = $request->image;
        $count = 1;
        if($files) {
            foreach ($files as $image) {
                //asignarle un nombre unico
                $image_full = \time()+$count.'.'.$image->extension();
                //guardarla en la carpeta storage/app/public/usersClientImg
                Storage::disk('usersClientImg')->put($image_full, File::get($image));
                Images::create([
                    'post_client_id' => $postClient->id,
                    'image' => $image_full,
                ]);
                $count++;
            }
        }else {
            return response()->json(['failed' => true, 'message' => 'upload images failed'],422);
        }

        if($query) {
            return response()->json(['valid' => true, 'message' => 'post wass created successfully'],200);
        }
    }

}
