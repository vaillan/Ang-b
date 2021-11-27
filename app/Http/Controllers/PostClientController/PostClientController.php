<?php

namespace App\Http\Controllers\PostClientController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostClient\PostClient;
use App\Models\Images\Images;
use App\Helpers\Helpers;
use App\Http\Controllers\ServiceSelectedController\ServiceSelectedController;
use App\Http\Controllers\ExteriorSelectedController\ExteriorSelectedController;
use App\Http\Controllers\ConservationStateSelectedController\ConservationStateSelectedController;
use App\Http\Controllers\GeneralCategorySelectedController\GeneralCategorySelectedController;
use App\Models\User;
use Validator;
use File;
use Storage;

class PostClientController extends Controller
{

    public function createPostClient(Request $request) {
        $query = \DB::transaction(function () use($request) {
            $serviceSelected = new ServiceSelectedController();
            $exteriorSelected = new ExteriorSelectedController();
            $conservationStateSelected = new ConservationStateSelectedController();
            $generalCategorySelected = new GeneralCategorySelectedController();

            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'moneda_id' => 'required',
                'pais' => 'required',
                'estado' => 'required',
                'ciudadMunicipio' => 'required',
                'calle' => 'required',
                'colonia' => 'required',
                'type_post' => 'required',
                'precio' => 'required',
                'descripcion' => 'required',
                'titulo' => 'required',
            ]);

            if($validator->fails()) {
                return $validator->errors();
            }else {
                $files = $request->images;
                $count = 0;
                if($files) {
                    $count = 1;
                    $postClient = $this->create($request);
                    if($postClient) {
                        $servicios = json_decode($request->servicios);
                        $exteriores = json_decode($request->exteriores);
                        $estadoConservacion = json_decode($request->estado_conservacion);
                        $caracteristicasGenerales = json_decode($request->caracteristicasGenerales);
                        isset($servicios) ? $serviceSelected->createService($postClient, $servicios) : null;
                        isset($exteriores) ? $exteriorSelected->createExteriorService($postClient, $exteriores) : null;
                        isset($estadoConservacion) ? $conservationStateSelected->createConservationStateService($postClient, $estadoConservacion) : null;
                        isset($caracteristicasGenerales) ? $generalCategorySelected->createGeneralCategoryService($postClient, $caracteristicasGenerales) : null;
                    }
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

    public function create(Request $request) {
        $postClient = PostClient::create(
            [
                'user_id' => $request->user_id,
                'moneda_id' => $request->moneda_id,
                'renta_opcion_id' => $request->renta_opcion_id,
                'ground_id' => isset($request->ground_id) && is_numeric($request->ground_id) ? $request->ground_id : null,
                'office_id' => isset($request->office_id) && is_numeric($request->office_id) ? $request->office_id : null,
                'departament_id' => isset($request->departament_id) && is_numeric($request->departament_id) ? $request->departament_id : null,
                'house_id' => isset($request->house_id) && is_numeric($request->house_id) ? $request->house_id : null,
                'pais' => $request->pais,
                'estado' => $request->estado,
                'ciudadMunicipio' => $request->ciudadMunicipio,
                'calle' => $request->calle,
                'colonia' => $request->colonia,
                'titulo' => $request->titulo,
                'descripcion' => $request->descripcion,
                'status' => isset($request->status) ? $request->status : 0,
                'precio' => $request->precio,
                'type_post' => $request->type_post,
                'numExt' => $request->numExt,
                'numInt' => $request->numInt,
                'youtubeId' => $request->youtubeId,
                'leflet_map' => $request->leflet_map,
                'num_recamaras' => $request->num_recamaras,
                'num_bathroom' => $request->num_bathroom,
                'num_estacionamiento' => $request->num_estacionamiento,
                'superficie_construida' => $request->superficie_construida,
                'superficie_terreno' => $request->superficie_terreno,
            ]
        );
        return $postClient;
    }

}
