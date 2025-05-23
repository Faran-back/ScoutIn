<?php

namespace App\Http\Controllers\ClientAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientAuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => $request->password
        ]);

        $token = $user->createToken('ScoutIn')->accessToken;

        return response()->json([
            'access_token' => $token
        ]);
    }

    public function login(Request $request){
         $request->validate([
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
        ]);

        $user = User::where('email', $request->email);
        $password = User::where($user->password, $request->password);

        if(!$user && !$password){
            return response()->json([
               'status' => 403, 
               'message' => 'No records found', 
               'user' => $user 
            ]);
        }

        $token = $user->createToken('ScoutIn')->accessToken;

        return response()->json([
            'access_token' => $token
        ]);
    }
}
