<?php

namespace App\Http\Controllers\AuthController;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Models\User;
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
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
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
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
