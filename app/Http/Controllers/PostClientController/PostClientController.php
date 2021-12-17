<?php

namespace App\Http\Controllers\PostClientController;

use App\Http\Controllers\ServiceSelectedController\ServiceSelectedController;
use App\Http\Controllers\ExteriorSelectedController\ExteriorSelectedController;
use App\Http\Controllers\ConservationStateSelectedController\ConservationStateSelectedController;
use App\Http\Controllers\GeneralCategorySelectedController\GeneralCategorySelectedController;
use App\Models\PropertyType\PropertyType;
use App\Http\Controllers\Controller;
use App\Models\PostClient\PostClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Images\Images;
use App\Helpers\Helpers;
use App\Models\User;
use Exception;
use Validator;
use File;

class PostClientController extends Controller
{

    
    public function createPostClient(Request $request) {
        $query = \DB::transaction(function () use($request) {
            $serviceSelected = new ServiceSelectedController();
            $exteriorSelected = new ExteriorSelectedController();
            $conservationStateSelected = new ConservationStateSelectedController();
            $generalCategorySelected = new GeneralCategorySelectedController();
            $count = 1;
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
                if($files) {
                    $postClient = $this->create($request);
                    if($postClient) {
                        $serviceSelected->store($request, $postClient);
                        $exteriorSelected->store($request, $postClient);
                        $conservationStateSelected->store($request, $postClient);
                        $generalCategorySelected->store($request, $postClient);
                    }
                    foreach ($files as $image) {
                        //asignarle un nombre unico
                        $image_full = \time()+$count.'.'.$image->extension();
                        //guardarla en la carpeta storage/app/public/usersClientImg
                        Storage::disk('usersClientImg')->put($image_full, File::get($image));
                        $i = Images::create([
                            'post_client_id' => $postClient->id,
                            'image' => $image_full,
                        ]);
                        $count = $count+1;
                        $img = Storage::disk('usersClientImg')->url($i->image);
                        $i->url = $img;
                        $i->save();
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
                'otros' => $request->otros,
            ]
        );
        return $postClient;
    }

    public function getAllPostsEnterpriseByUser(Request $request, $id, $type_post=null, $property_type_id=null) {
        $query = \DB::transaction(function () use($request, $id, $property_type_id, $type_post) {
            if(!$property_type_id) {
                $query =  $this->getTypePost($id, null, $type_post);
                return response()->json(['valid'=> true, 'posts' => $query ]);
            }else {
                switch ($property_type_id) {
                    case 1:
                        $query =  $this->getTypePost($id, $property_type_id, $type_post);
                        return response()->json(['valid'=> true, 'posts' => $query ]);
                    break;
                    
                    case 2:
                        $query =  $this->getTypePost($id, $property_type_id, $type_post);
                        return response()->json(['valid'=> true, 'posts' => $query ]);
                    break;
    
                    case 3:  
                        $query =  $this->getTypePost($id, $property_type_id, $type_post);
                        return response()->json(['valid'=> true, 'posts' => $query ]);
                    break;
    
                    case 4:
                        $query =  $this->getTypePost($id, $property_type_id, $type_post);
                        return response()->json(['valid'=> true, 'posts' => $query ]);
                    break;
                }
            }
        });
        return $query;
    }

    public function getTypePost($id, $property_type_id=null, $type_post=null) {
        $posts = null;
        $property = $property_type_id ? PropertyType::with(['house', 'departament', 'office', 'ground'])->find($property_type_id) : null;
        if($property) {
            if(count($property->house) > 0) {
                $property_type = ["user", "house"];
                $posts = $this->getPost($property_type, $id, $type_post);
                $houses = array_column($posts, $property_type[1]);
                $houses = array_column($houses, 'id');
                if(count($houses) > 0) {
                    $property_type[] = "divisa";
                    $property_type[] = "rent";
                    $property_type[] = "images";
                    $property_type[] = "services";
                    $property_type[] = "generalCategories";
                    $property_type[] = "conservationState";
                    $posts = PostClient::with($property_type)->whereIn('house_id', $houses)->get();
                    return $posts;
                }else {
                    return [];
                }
            }else if (count($property->departament) > 0) {
                $property_type = ["user", "departament"];
                $posts = $this->getPost($property_type, $id, $type_post);
                $departaments = array_column($posts, $property_type[1]);
                $departaments = array_column($departaments, 'id');
                if(count($departaments) > 0) {
                    $property_type[] = "divisa";
                    $property_type[] = "rent";
                    $property_type[] = "images";
                    $property_type[] = "services";
                    $property_type[] = "generalCategories";
                    $property_type[] = "conservationState";
                    $posts = PostClient::with($property_type)->whereIn('departament_id', $departaments)->get();
                    return $posts;
                }else {
                    return [];
                }
            }else if(count($property->office) > 0) {
                $property_type = ["user", "office"];
                $posts = $this->getPost($property_type, $id, $type_post);
                $offices = array_column($posts, $property_type[1]);
                $offices = array_column($offices, 'id');
                if(count($offices) > 0) {
                    $property_type[] = "divisa";
                    $property_type[] = "rent";
                    $property_type[] = "images";
                    $property_type[] = "services";
                    $property_type[] = "generalCategories";
                    $property_type[] = "conservationState";
                    $posts = PostClient::with($property_type)->whereIn('office_id', $offices)->get();  
                    return $posts;
                }else {
                    return [];
                }
            }else if(count($property->ground) > 0) {
                $property_type = ["user", "ground"];
                $posts = $this->getPost($property_type, $id, $type_post);
                $grounds = array_column($posts, $property_type[1]);
                $grounds = array_column($grounds, 'id');
                if(count($grounds) > 0) {
                    $property_type[] = "divisa";
                    $property_type[] = "rent";
                    $property_type[] = "images";
                    $property_type[] = "services";
                    $property_type[] = "generalCategories";
                    $property_type[] = "conservationState";
                    $posts = PostClient::with($property_type)->whereIn('house_id', $grounds)->get();  
                    return $posts;
                }else {
                    return [];
                }
            }
        }
        else {
            $property_type = ["user", "images", "services", "generalCategories", "conservationState", "rent", "divisa"];
            $_posts = [];
            $posts = $this->getPost($property_type, $id, $type_post);
            $otros = array_column($posts, 'otros');
            foreach ($otros as $key => $value) {
                if(!empty($value) && $value !== "null") {
                    $_posts[] = $posts[$key];
                }
            }
            return $_posts; 
        }
    }

    public function getPost($property, $id, $type_post=null) {
        $posts = PostClient::with($property)
        ->where('type_post', $type_post)
        ->where('user_id', $id)
        ->get();
        return $posts->toArray();
    }

    public function deletePostUserEnterprise(Request $request, $id) {
        $query = \DB::transaction(function () use($request, $id) {
            $postUserEnterprise = PostClient::find($id);
            $images = Images::where('post_client_id', $postUserEnterprise->id)->get();
            foreach ($images as $image) {
                $image->delete();
            }

        });
    }
}
