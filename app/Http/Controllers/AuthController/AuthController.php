<?php

namespace App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\usersType\UserType;
use App\Helpers\Helpers;
use File;
use Storage;
use Validator;
class AuthController extends Controller
{
  
  public function signUp(Request $request) {
    $validator = Validator::make($request->all(), [
      'role' => 'required|string',
      'about_me' => 'required|string',
      'name' => 'required|string|between:2,100',
      'last_name' => 'required|string|between:2,100',
      'nick' => 'required|string|between:2,20',
      'email' => 'required|string|email|max:100|unique:users',
      'password' => 'required|string|min:6',
    ]);

    if($validator->fails()){
      return response()->json($validator->errors(), 422);
    }

    $user = $request->all();
    $user['password'] = Hash::make($request->password);
    User::create($user);
    return response()->json(['message' => 'User successfully registered'], 201);
  }

  public function login(Request $request) {
      $validator = Validator::make($request->all(), [
          'email' => 'required|email',
          'password' => 'required|string',
      ]);

      if ($validator->fails()) {
          return response()->json($validator->errors(), 422);
      }

      $user = User::where('email', $request->email)->first();
      if($user) {
          if(Hash::check($request->password, $user->password)) {
              $token = $user->createToken('Ang-app Password')->accessToken;
  
              $response = ['access_token' => $token, 'user' => $user];
              return response()->json($response, 200);
          }else {
              $response = ["msg" => "Password invalid"];
              return response()->json($response, 422);
          }
      }else {
          $response = ["msg" =>'User does not exist'];
          return response()->json($response, 422);
      }

  }

  public function logout(Request $request) {
      $token = $request->user()->token();
      $token->revoke();
      $response = ['valid' => true, 'message' => 'You have been successfully logged out!'];
      return response()->json($response, 200);
  }

  public function update(Request $request) {
      $query =  \DB::transaction(function () use($request) {
          $user = User::find($request->input('user_id'));
          $id = $user->id;
          $validator = Validator::make($request->all(), [
              'name' => ['string','between:2,100'],
              'last_name' => ['string','between:2,100'],
              'nick' => ['string','between:2,20', 'unique:users,nick,'.$id],
              'about_me' => ['string','between:5,100'],
              'email' => ['string','unique:users,email,'.$id],
          ]);
  
          if($validator->fails()) {
              return response()->json($validator->errors(),400);
          }else {
            //subir imagen
            if($request->hasFile('image')) {
              $image = $request->file('image');
              //asignarle un nombre unico
              $image_full = \time().'.'.$image->extension();
              //guardarla en la carpeta storage/app/users
              Storage::disk('usersImg')->put($image_full, File::get($image));
              //setear el nombre de la imagen en el objeto user
              $user->image = $image_full;
              $imgUrl = Storage::disk('usersImg')->url($user->image);
              $user->url_image = $imgUrl;
            }
            $updatedUserValues = collect($request->all())->filter(function($item, $key) {
              return $item != 'null';
            })->toArray();
            $user->update($updatedUserValues);
            return response()->json(['valid' => true, 'message' => 'datos actualizados correctamente', 'user' => $user], 200);
          }
      });
      return $query;
  }

  /**
   * Create a new user
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function createUserEnterprise(Request $request) {
    $query =  \DB::transaction(function () use($request) {
      $helper = new Helpers();
      $first_key = $helper->first_key;
      $second_key = $helper->second_key;
      $cipher = $helper->cipher;

      $validator = Validator::make($request->all(), [
        'name' => 'required|string|between:2,100',
        'user_type_id' => 'required|integer',
        'category_id' => 'required|integer',
        'email' => 'required|string|email|max:100|unique:users',
        'password' => 'required|string|min:6',
      ]);

      if($validator->fails()) return response()->json($validator->errors(), 422);
      $userType = UserType::find($request->user_type_id)->role;
      $user = collect($request->all());
      $user->put('password', Hash::make($request->password));
      $user->put('role', $userType);
      $user->put('password_encryp', $helper->encrypt($request->password, base64_encode($first_key), base64_encode($second_key), $cipher));
      $user->put('created_by', Auth::id());
      $user->put('updated_by', Auth::id());
      if(User::create($user->all())) return response()->json(['mssg' => 'User successfully registered'],200);
    });
    return $query;
  }

  public function updateUserEnterprise(Request $request, $id) {
    $query =  \DB::transaction(function () use($request, $id) {
      $user = User::find($id);
      $helper = new Helpers();
      $first_key = $helper->first_key;
      $second_key = $helper->second_key;
      $cipher = $helper->cipher;
      $validator = Validator::make($request->all(), [
        'name' => ['string','between:2,100'],
        'user_type_id' => ['integer'],
        'category_id' => ['integer'],
        'email' => ['string','unique:users,email,'.$id],
        'password' => ['string','min:6'],
      ]);

      if($validator->fails()) return response()->json($validator->errors(), 422);
      $userType = UserType::find($request->user_type_id)->role;
      $updateUserData = collect($request->all());
      $updateUserData['role'] = $userType;
      $updateUserData['password'] =  Hash::make($request->password);
      $updateUserData['updated_by'] = Auth::id();
      $updateUserData['password_encryp'] = $helper->encrypt($request->password, base64_encode($first_key), base64_encode($second_key), $cipher);

      if($user->update($updateUserData->all())) {
        $users = $this->getUsersByClientEnterprise($request, Auth::id());
        return response()->json(['mssg' => 'User successfully updated', 'users' => $users->original["users"]],200);
      }
    });
    return $query;
  }
  
  public function updateConfiguration(Request $request) {
    $user = User::find($request->input('user_id'));
    $configuration = $request->input('configuration');
    $user->configuration = json_decode($configuration);
    if($user->save()) {
      return response()->json(['valid' =>true, 'message' => "Configuración actualizada", 'user' => $user], 200);
    }else {
      return response()->json(['valid' =>false, 'message' => "Configuración rechazada"], 422);
    }
  }

  public function getUsersByClientEnterprise(Request $request, $user_enterprise_id) {
    $users = User::where('created_by', $user_enterprise_id)->with('category')->get();
    return response()->json(['users' => $users], 200);
  }

  public function getUsersEnterpriseByCategory(Request $request, $user_enterprise_id ,$category_id) {
    $users = User::where('created_by', $user_enterprise_id)
    ->where('category_id', $category_id)
    ->with('category')->get();
    return response()->json(['users' => $users], 200);
  }
}
