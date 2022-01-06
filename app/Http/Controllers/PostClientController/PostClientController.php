<?php

namespace App\Http\Controllers\PostClientController;

use App\Http\Controllers\ServiceSelectedController\ServiceSelectedController;
use App\Http\Controllers\ExteriorSelectedController\ExteriorSelectedController;
use App\Http\Controllers\ConservationStateSelectedController\ConservationStateSelectedController;
use App\Http\Controllers\GeneralCategorySelectedController\GeneralCategorySelectedController;
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
        $insert = [
            'user_id' => $request->user_id,
            'moneda_id' => $request->moneda_id,
            'renta_opcion_id' => $request->renta_opcion_id,
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
            'num_recamaras' => $request->num_recamaras,
            'num_bathroom' => $request->num_bathroom,
            'num_estacionamiento' => $request->num_estacionamiento,
            'superficie_construida' => $request->superficie_construida,
            'superficie_terreno' => $request->superficie_terreno,
        ];
        if(isset($request->otros) && $request->otros != "null") $insert['otros'] = $request->otros;
        if(isset($request->youtubeId) && $request->youtubeId != "null") $insert['youtubeId'] = $request->youtubeId;
        if(isset($request->leflet_map) && $request->leflet_map != "null") $insert['leflet_map'] = $request->leflet_map;
        $insert['ground_id'] = isset($request->ground_id) && is_numeric($request->ground_id) ? $request->ground_id : null;
        $insert['office_id'] = isset($request->office_id) && is_numeric($request->office_id) ? $request->office_id : null;
        $insert['departament_id'] = isset($request->departament_id) && is_numeric($request->departament_id) ? $request->departament_id : null;
        $insert['house_id'] = isset($request->house_id) && is_numeric($request->house_id) ? $request->house_id : null;
        $postClient = PostClient::create($insert);
        return $postClient;
    }

    public function getPostTypeHoseByUserEnterprise(Request $request, $user_id, $post_id=null) {
        $post = PostClient::where('user_id',$user_id)
        ->whereNotNull('house_id')
        ->when($post_id, function ($query) use ($post_id) {
            $query->with(['conservationState','services','generalCategories','exteriors']);
            $query->where('id', $post_id);
        })
        ->with(['house', 'divisa', 'images','rent', 'user'])
        ->paginate(2);
        return response()->json(['valid' => true, 'posts' => $post], 200);
    }

    public function getPostTypeDepartamentByUserEnterprise(Request $request, $user_id, $post_id=null) {
        $post = PostClient::where('user_id',$user_id)
        ->whereNotNull('departament_id')
        ->when($post_id, function ($query) use ($post_id) {
            $query->with(['conservationState','services','generalCategories','exteriors']);
            $query->where('id', $post_id);
        })
        ->with(['user','departament', 'divisa', 'rent', 'images'])
        ->paginate(2);
        return response()->json(['valid' => true, 'posts' => $post], 200);
    }

    public function getPostTypeOfficeByUserEnterprise(Request $request, $user_id, $post_id=null) {
        $post = PostClient::where('user_id',$user_id)
        ->whereNotNull('office_id')
        ->when($post_id, function ($query) use ($post_id) {
            $query->with(['conservationState','services','generalCategories','exteriors']);
            $query->where('id', $post_id);
        })
        ->with(['user','office', 'divisa', 'rent', 'images'])
        ->paginate(2);
        return response()->json(['valid' => true, 'posts' => $post], 200);
    }

    public function getPostTypeGroundByUserEnterprise(Request $request, $user_id, $post_id=null) {
        $post = PostClient::where('user_id',$user_id)
        ->whereNotNull('ground_id')
        ->when($post_id, function ($query) use ($post_id) {
            $query->with(['conservationState','services','generalCategories','exteriors']);
            $query->where('id', $post_id);
        })
        ->with(['user','ground', 'divisa', 'rent', 'images'])
        ->paginate(2);
        return response()->json(['valid' => true, 'posts' => $post], 200);
    }

    public function getPostTypeOthersByUserEnterprise(Request $request, $user_id, $post_id=null) {
        $post = PostClient::where('user_id',$user_id)
        ->whereNotNull('otros')
        ->when($post_id, function ($query) use ($post_id) {
            $query->with(['conservationState','services','generalCategories','exteriors']);
            $query->where('id', $post_id);
        })
        ->with(['user', 'divisa', 'rent', 'images'])
        ->paginate(2);
        return response()->json(['valid' => true, 'posts' => $post], 200);
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
            switch ($property_type_id) {
                case 1:
                # code...
                $getPosts = $this->getPostTypeHoseByUserEnterprise($request, $user->id);
                break;

                case 2:
                # code...
                $getPosts = $this->getPostTypeDepartamentByUserEnterprise($request, $user->id);
                break;

                case 3:
                # code...
                $getPosts = $this->getPostTypeOfficeByUserEnterprise($request, $user->id);
                break;

                case 4:
                # code...
                $getPosts = $this->getPostTypeGroundByUserEnterprise($request, $user->id);
                break;

                case 5:
                # code...
                $getPosts = $this->getPostTypeOthersByUserEnterprise($request, $user->id);
                break;

                default:
                # code...
                break;
            }
            return $getPosts;
        });
        return $query;
    }
}
