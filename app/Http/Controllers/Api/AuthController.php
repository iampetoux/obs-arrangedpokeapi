<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'remember_token' => Str::random(10)
        ]);

        return response()->json(['registered' => true], Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(["message" => 'Wrong credentials'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(["message" => 'Wrong credentials'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $token = $user->createToken('Laravel Password Grant Client')->accessToken;

        return response()->json(['token' => $token], Response::HTTP_OK);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();

        $token->revoke();

        return response()->json(['message' => 'You have been successfully logged out!'], Response::HTTP_OK);
    }
}
