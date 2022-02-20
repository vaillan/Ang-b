<?php

namespace App\Http\Controllers\PostClientController;

use App\Http\Controllers\ServiceSelectedController\ServiceSelectedController;
use App\Http\Controllers\ExteriorSelectedController\ExteriorSelectedController;
use App\Http\Controllers\ConservationStateSelectedController\ConservationStateSelectedController;
use App\Http\Controllers\GeneralCategorySelectedController\GeneralCategorySelectedController;
use App\Http\Controllers\Controller;
use App\Models\PostClient\PostClient;
use Illuminate\Http\Request;
use App\Models\Images\Images;
use App\Helpers\Helpers;
use App\Models\User;
use Validator;
use File;
use Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
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
                if($request->hasFile('images')) {
                    $files = $request->images;
                    $postClient = PostClient::create($this->clearRequest($request));
                    if($postClient) {
                        $postClientId = $postClient->id;
                        $serviceSelected->store($request, $postClientId);
                        $exteriorSelected->store($request, $postClientId);
                        $conservationStateSelected->store($request, $postClientId);
                        $generalCategorySelected->store($request, $postClientId);
                    }
                    foreach ($files as $image) {
                        //asignarle un nombre unico
                        $image_full = \time()+$count.'.'.$image->extension();
                        //guardarla en la carpeta storage/app/public/usersClientImg
                        Storage::disk('usersClientImg')->put($image_full, File::get($image));
                        $img = Images::create([
                            'post_client_id' => $postClient->id,
                            'image' => $image_full,
                        ]);
                        $count = $count+1;
                        $imgUrl = Storage::disk('usersClientImg')->url($img->image);
                        $Imgcontent = Storage::disk('usersClientImg')->get($img->image);
                        $img->url = $imgUrl;
                        $img->content = "data:image/".$image->extension().";base64,".base64_encode($Imgcontent);
                        $img->save();
                    }
                }else {
                    return ['valid' => false, 'message' => 'Fallo al cargar imagenes'];
                }
                return ['valid' => true, 'message' => 'La publiación se ha creado correctamente'];
            }
        });

        return response()->json($query);
    }

    public function clearRequest(Request $request) {
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
        return $insert;
    }

    public function editPostClientEnterprise(Request $request) {
        $query = \DB::transaction(function() use($request) {
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
                if($request->hasFile('images')) {
                    $files = $request->images;
                    $_files = new Collection($request->images);
                    $imagesCollection = $_files->map(function ($item, $key) {
                        return ['image' => $item->getClientOriginalName()];
                    });
                    if($request->input('post_client_id')) {
                        $serviceSelected->update($request, $request->input('post_client_id'));
                        $exteriorSelected->update($request, $request->input('post_client_id'));
                        $conservationStateSelected->update($request, $request->input('post_client_id'));
                        $generalCategorySelected->update($request, $request->input('post_client_id'));
                    }

                    $storedImages = Images::where('post_client_id', $request->input('post_client_id'))->get();
                    foreach ($storedImages as $storedImage) {
                        if(!$imagesCollection->contains('image', $storedImage->image)) {
                            $storedImage->delete();
                            Storage::disk('usersClientImg')->delete($storedImage->image);
                        }
                    }

                    foreach ($files as $image) {
                        $storedImage = Images::where('post_client_id', $request->input('post_client_id'))
                        ->where('image', $image->getClientOriginalName())->first();
                        if(empty($storedImage)) {
                            //asignarle un nombre unico
                            $image_full = \time()+$count.'.'.$image->extension();
                            //guardarla en la carpeta storage/app/public/usersClientImg
                            Storage::disk('usersClientImg')->put($image_full, File::get($image));
                            $img = Images::create([
                                'post_client_id' => $request->input('post_client_id'),
                                'image' => $image_full,
                            ]);
                            $count = $count+1;
                            $imgUrl = Storage::disk('usersClientImg')->url($img->image);
                            $Imgcontent = Storage::disk('usersClientImg')->get($img->image);
                            $img->url = $imgUrl;
                            $img->content = "data:image/".$image->extension().";base64,".base64_encode($Imgcontent);
                            $img->save();
                        }
                    }

                    $postUserEnterPrise = PostClient::find($request->input('post_client_id'));
                    if($postUserEnterPrise->update($this->clearRequest($request))){
                        return response()->json(['valid' => true, 'message' => 'La publiación se ha actualizado correctamente'],200);
                    }else {
                        return response()->json(['valid' => false, 'message' => 'A ocurrido un error, notifica este error a soporte técnico'],422);
                    }
                }
            }
        });
        return $query;
    }

    public function update(Request $request) {
        $post = PostClient::find($request->input('id'));
        $post->update($request->all());
        return $post;
    }

    public function getPostTypeHoseByUserEnterprise(Request $request, $user_id, $type_post, $post_id=null) {
        $post = PostClient::where('user_id',$user_id)
        ->where('type_post',$type_post)
        ->whereNotNull('house_id')
        ->when($post_id && $type_post, function ($query) use ($post_id, $type_post) { // Ejecusion cuando se edita
            $query->with(['conservationState','services','generalCategories','exteriors']);
            $query->where('id', $post_id);
            $query->where('type_post', $type_post);
        })
        ->with(['house', 'divisa', 'images','rent', 'user'])
        ->paginate(12);
        return response()->json(['valid' => true, 'posts' => $post], 200);
    }

    public function getPostTypeDepartamentByUserEnterprise(Request $request, $user_id, $type_post, $post_id=null) {
        $post = PostClient::where('user_id',$user_id)
        ->where('type_post',$type_post)
        ->whereNotNull('departament_id')
        ->when($post_id && $type_post, function ($query) use ($post_id, $type_post) {
            $query->with(['conservationState','services','generalCategories','exteriors']);
            $query->where('id', $post_id);
            $query->where('type_post', $type_post);
        })
        ->with(['user','departament', 'divisa', 'rent', 'images'])
        ->paginate(12);
        return response()->json(['valid' => true, 'posts' => $post], 200);
    }

    public function getPostTypeOfficeByUserEnterprise(Request $request, $user_id, $type_post, $post_id=null) {
        $post = PostClient::where('user_id',$user_id)
        ->where('type_post',$type_post)
        ->whereNotNull('office_id')
        ->when($post_id && $type_post, function ($query) use ($post_id, $type_post) {
            $query->with(['conservationState','services','generalCategories','exteriors']);
            $query->where('id', $post_id);
            $query->where('type_post', $type_post);
        })
        ->with(['user','office', 'divisa', 'rent', 'images'])
        ->paginate(12);
        return response()->json(['valid' => true, 'posts' => $post], 200);
    }

    public function getPostTypeGroundByUserEnterprise(Request $request, $user_id, $type_post, $post_id=null) {
        $post = PostClient::where('user_id',$user_id)
        ->where('type_post',$type_post)
        ->whereNotNull('ground_id')
        ->when($post_id && $type_post, function ($query) use ($post_id, $type_post) {
            $query->with(['conservationState','services','generalCategories','exteriors']);
            $query->where('id', $post_id);
            $query->where('type_post', $type_post);
        })
        ->with(['user','ground', 'divisa', 'rent', 'images'])
        ->paginate(12);
        return response()->json(['valid' => true, 'posts' => $post], 200);
    }

    public function getPostTypeOthersByUserEnterprise(Request $request, $user_id, $type_post, $post_id=null) {
        $post = PostClient::where('user_id',$user_id)
        ->where('type_post',$type_post)
        ->whereNotNull('otros')
        ->when($post_id && $type_post, function ($query) use ($post_id, $type_post) {
            $query->with(['conservationState','services','generalCategories','exteriors']);
            $query->where('id', $post_id);
            $query->where('type_post', $type_post);
        })
        ->with(['user', 'divisa', 'rent', 'images'])
        ->paginate(12);
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
                Storage::disk('usersClientImg')->delete($image->image);
            }
            $serviceSelected->destroy($postUserEnterprise->id);
            $exteriorSelected->destroy($postUserEnterprise->id);
            $conservationStateSelected->destroy($postUserEnterprise->id);
            $generalCategorySelected->destroy($postUserEnterprise->id);
            $postUserEnterprise->delete();
            $getPosts = null;
            switch ($property_type_id) {
                case 1:
                # code...
                $getPosts = $this->getPostTypeHoseByUserEnterprise($request, $user->i, $type_post);
                break;

                case 2:
                # code...
                $getPosts = $this->getPostTypeDepartamentByUserEnterprise($request, $user->id, $type_post);
                break;

                case 3:
                # code...
                $getPosts = $this->getPostTypeOfficeByUserEnterprise($request, $user->id, $type_post);
                break;

                case 4:
                # code...
                $getPosts = $this->getPostTypeGroundByUserEnterprise($request, $user->id, $type_post);
                break;

                case 5:
                # code...
                $getPosts = $this->getPostTypeOthersByUserEnterprise($request, $user->id, $type_post);
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
