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
use Illuminate\Support\Facades\Auth;

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

    public function getEnterprisePostsByUser(Request $request, $user_id, $type_post, $property_type_id=null, $post_id=null) {
        $query = \DB::transaction(function () use($request, $user_id, $property_type_id, $type_post, $post_id) {
            if(!$property_type_id) {
                $query =  $this->getTypePost($user_id, null, $type_post, $post_id);
                return response()->json(['valid'=> true, 'posts' => $query ]);
            }else {
                $query =  $this->getTypePost($user_id, $property_type_id, $type_post, $post_id);
                return response()->json(['valid'=> true, 'posts' => $query ]);
            }
        });
        return $query;
    }

    public function getTypePost($user_id, $property_type_id=null, $type_post=null, $post_id=null) {
        $posts = null;
        $property = $property_type_id ? PropertyType::with(['house', 'departament', 'office', 'ground'])->find($property_type_id) : null;
        if($property) {
            if(count($property->house) > 0) {
                $models_selected = ["user", "house"];
                $posts = $this->getPost($models_selected, $user_id, $type_post, $post_id);
                $houses = array_column($posts, $models_selected[1]);
                $houses_ids = array_column($houses, 'id');
                if(count($houses_ids) > 0) {
                    $models_selected[] = "divisa";
                    $models_selected[] = "rent";
                    $models_selected[] = "images";
                    if(!empty($post_id)) {
                        $models_selected[] = "services";
                        $models_selected[] = "generalCategories";
                        $models_selected[] = "conservationState";
                    }
                    $posts = PostClient::with($models_selected)->whereIn('house_id', $houses_ids)
                    ->when($post_id, function($query) use ($post_id) {
                        return $query->where('id', $post_id);
                    })->get();
                    return $posts;
                }else {
                    return [];
                }
            }else if (count($property->departament) > 0) {
                $models_selected = ["user", "departament"];
                $posts = $this->getPost($models_selected, $user_id, $type_post, $post_id);
                $departaments = array_column($posts, $models_selected[1]);
                $departaments_id = array_column($departaments, 'id');
                if(count($departaments_id) > 0) {
                    $models_selected[] = "divisa";
                    $models_selected[] = "rent";
                    $models_selected[] = "images";
                    if(!empty($post_id)) {
                        $models_selected[] = "services";
                        $models_selected[] = "generalCategories";
                        $models_selected[] = "conservationState";
                    }
                    $posts = PostClient::with($models_selected)->whereIn('departament_id', $departaments_id)
                    ->when($post_id, function($query) use ($post_id) {
                        return $query->where('id', $post_id);
                    })->get();
                    return $posts;
                }else {
                    return [];
                }
            }else if(count($property->office) > 0) {
                $models_selected = ["user", "office"];
                $posts = $this->getPost($models_selected, $user_id, $type_post, $post_id);
                $offices = array_column($posts, $models_selected[1]);
                $offices = array_column($offices, 'id');
                if(count($offices) > 0) {
                    $models_selected[] = "divisa";
                    $models_selected[] = "rent";
                    $models_selected[] = "images";
                    if(!empty($post_id)) {
                        $models_selected[] = "services";
                        $models_selected[] = "generalCategories";
                        $models_selected[] = "conservationState";
                    }
                    $posts = PostClient::with($models_selected)->whereIn('office_id', $offices)
                    ->when($post_id, function($query) use ($post_id) {
                        return $query->where('id', $post_id);
                    })->get();  
                    return $posts;
                }else {
                    return [];
                }
            }else if(count($property->ground) > 0) {
                $models_selected = ["user", "ground"];
                $posts = $this->getPost($models_selected, $user_id, $type_post, $post_id);
                $grounds = array_column($posts, $models_selected[1]);
                $grounds = array_column($grounds, 'id');
                if(count($grounds) > 0) {
                    $models_selected[] = "divisa";
                    $models_selected[] = "rent";
                    $models_selected[] = "images";
                    if(!empty($post_id)) {
                        $models_selected[] = "services";
                        $models_selected[] = "generalCategories";
                        $models_selected[] = "conservationState";
                    }
                    $posts = PostClient::with($models_selected)->whereIn('house_id', $grounds)
                    ->when($post_id, function($query) use ($post_id) {
                        return $query->where('id', $post_id);
                    })->get();  
                    return $posts;
                }else {
                    return [];
                }
            }
        }
        else {
            $models_selected = ["user", "images", "rent", "divisa"];
            $_posts = [];
            if(!empty($post_id)) {
                $models_selected[] = "services";
                $models_selected[] = "generalCategories";
                $models_selected[] = "conservationState";
            }
            $posts = $this->getPost($models_selected, $user_id, $type_post, $post_id);
            $otros = array_column($posts, 'otros');
            foreach ($otros as $key => $value) {
                if(!empty($value) && $value !== "null") {
                    $_posts[] = $posts[$key];
                }
            }
            return $_posts; 
        }
    }

    public function getPost($property, $user_id, $type_post=null, $post_id=null) {
        $posts = PostClient::with($property)
        ->where('type_post', $type_post)
        ->where('user_id', $user_id)
        ->when($post_id, function($query) use($post_id) {
            return $query->where('id', $post_id);
        })
        ->get();
        return $posts->toArray();
    }

    public function deletePostUserEnterprise(Request $request, $post_id, $type_post, $property_type_id=null) {
        $query = \DB::transaction(function () use($request, $post_id, $type_post, $property_type_id) {
            $user = Auth::user();
            $serviceSelected = new ServiceSelectedController();
            $exteriorSelected = new ExteriorSelectedController();
            $conservationStateSelected = new ConservationStateSelectedController();
            $generalCategorySelected = new GeneralCategorySelectedController();
            $postUserEnterprise = PostClient::find($post_id);
            $images = Images::where('post_client_id', $postUserEnterprise->id)->get();
            foreach ($images as $image) {
                $image->delete();
            }
            $serviceSelected->destroy($postUserEnterprise->id);
            $exteriorSelected->destroy($postUserEnterprise->id);
            $conservationStateSelected->destroy($postUserEnterprise->id);
            $generalCategorySelected->destroy($postUserEnterprise->id);
            $postUserEnterprise->delete();
            $getPosts = $this->getAllPostsEnterpriseByUser($request, $user->id, $type_post, $property_type_id);
            return $getPosts;
        });
        return $query;
    }
}
