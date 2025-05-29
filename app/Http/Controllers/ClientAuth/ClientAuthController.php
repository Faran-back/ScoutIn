<?php

namespace App\Http\Controllers\ClientAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientAuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'email' => 'required|unique:users',
            'password' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'terms_and_conditions' => 'required',
        ]);

        $user = User::create($validated);

        $token = $user->createToken('ScoutIn')->accessToken;

        return response()->json([
            'access_token' => $token
        ]);
    }

    public function login(Request $request){
         $request->validate([
            'email' => 'required|exists:users',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
               'status' => 401, 
               'message' => 'Invalid credentials', 
               'user' => $user 
            ]);
        }

        $token = $user->createToken('ScoutIn')->accessToken;

        return response()->json([
            'access_token' => $token
        ]);
    }
}
