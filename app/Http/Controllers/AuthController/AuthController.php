<?php

namespace App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\User;
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

        return response()->json([
            'message' => 'User successfully registered'], 201);
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
                $getFullUser = new Helpers();
                $response = ['access_token' => $token, 'user' => $getFullUser->getUserInfo($user)];
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
        $user = User::find($request->input('id'));
        $id = $user->id;
        $validator = Validator::make($request->all(), [
            'name' => ['required','string','between:2,100'],
            'about_me' => ['required','string','between:5,100'],
            'last_name' => ['required','string','between:2,100'],
            'nick' => ['required','string','between:2,20', 'unique:users,nick,'.$id],
            'email' => ['required','unique:users,email,'.$id],
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(),400);
        }else {
            $name = $request->input('name');
            $about_me = $request->input('about_me');
            $last_name = $request->input('last_name');
            $nick = $request->input('nick');
            $email = $request->input('email');
            $user->name = $name;
            $user->last_name = $last_name;
            $user->about_me = $about_me;
            $user->nick = $nick;
            $user->email = $email;
            $user->update();
            $getFullUser = new Helpers();
            return response()->json(['valid' => true, 'message' => 'datos actualizados correctamente', 'user' => $getFullUser->getUserInfo($user)], 200);
        }
    }

    public function updateImageUser(Request $request) {
        $user = User::find($request->input('user_id'));
        //subir imagen
        if($request->hasFile('image')) {
            $image = $request->file('image');
            //asignarle un nombre unico
            $image_full = \time().'.'.$image->extension();
            //guardarla en la carpeta storage/app/users
            Storage::disk('usersImg')->put($image_full, File::get($image));
            //setear el nombre de la imagen en el objeto user
            $user->image = $image_full;
            if($user->update()){
                $getFullUser = new Helpers();
                return response()->json(['valid' => true, 'message' => 'datos actualizados correctamente', 'user' => $getFullUser->getUserInfo($user)],200);
            }else {
            return response()->json(['error' => "xxxxxxxxxxxx"], 400);

            }

        }else {
            return response()->json(['invalid' => "error imagen vacia"], 400);
        }
        
    }
}
