<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //Register API, Login API, Profile API, Logount API

    // POST [name, email, password]
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|string",
            "email" => "required|string|email|unique:users",
            "password" => "required|confirmed"
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);

        $token = $user->createToken("token")->plainTextToken;

        return response()->json([
            "status" => true,
            "message" => "Usuario registrado correctamente",
            "user" => $user,
            "token" => $token
        ]);
    }

    // POST [email, password]
    public function login(Request $request)
    {

        $request->validate([
            "email" => "required|string",
            "password" => "required"
        ]);

        $user = User::where("email", $request->email)->first();

        if (!empty($user)) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken("token")->plainTextToken;

                return response()->json([
                    "status" => true,
                    "message" => "Usuario logueado correctamente",
                    "user" => $user,
                    "token" => $token
                ]);

            } else {
                return response()->json([
                    "status" => false,
                    "message" => "Password incorrecto"
                ]);
            }
        } else {
            return response()->json([
                "status" => false,
                "message" => "El email no se encuentra registrado"
            ]);
        }

    }

    // GET [Auth: token]
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            "status" => true,
            "message" => "Usuario deslogueado",
        ]);

    }
}
