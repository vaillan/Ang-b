<?php

namespace App\Http\Controllers\PostClientController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostClient\PostClient;
use App\Models\Images\Images;
use App\Helpers\Helpers;
use App\Models\User;
use Validator;
use File;
use Storage;

class PostClientController extends Controller
{

    public function createPostClient(Request $request) {

        $query = \DB::transaction(function () use($request) {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'moneda_id' => 'required',
                'renta_opcion_id' => 'required',
                'pais' => 'required',
                'estado' => 'required',
                'ciudadMunicipio' => 'required',
                'calle' => 'required',
                'colonia' => 'required',
                'tipoInmueble' => 'required',
                'type_post' => 'required',
                'precio' => 'required',
                'descripcion' => 'required',
                'titulo' => 'required',
            ]);

            if($validator->fails()) {
                return [$validator->errors()];
            }else {
                $createPostClient = $request->all();
                $files = $request->images;
                $count = 0;
                if($files) {
                    $count = 1;
                    $postClient = PostClient::create($createPostClient);
                    foreach ($files as $image) {
                        //asignarle un nombre unico
                        $image_full = \time()+$count.'.'.$image->extension();
                        //guardarla en la carpeta storage/app/public/usersClientImg
                        Storage::disk('usersClientImg')->put($image_full, File::get($image));
                        Images::create([
                            'post_client_id' => $postClient->id,
                            'image' => $image_full,
                        ]);
                        $count = $count + 1;;
                    }
                }else {
                    return ['valid' => false, 'message' => 'Fallo al cargar imagenes'];
                }
                return ['valid' => true, 'message' => 'La publiación se ha creado correctamente'];
            }
        });

        return response()->json($query);
    }

}
