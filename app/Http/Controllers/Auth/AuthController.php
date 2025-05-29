<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
          try{

            $validated = $request->validate([
            'company_name' => 'required',
            'company_location' => 'required',
            'work_email' => 'required|email|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'password' => 'required',
            'terms_and_conditions' => 'required'
        ]);

        $user = User::create([
            'company_name' => $request->company_name,
            'company_location' => $request->company_location,
            'email' => $request->work_email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'password' => $request->password,
            'terms_and_conditions' => $request->terms_and_conditions
        ]);

        $token = $user->createToken('ScoutIn');
        $access_token = $token->accessToken;
        $refresh_token = $token->token->refresh_token;

        return response()->json([
            'access_token' => $access_token,
            'refresh_token' => $refresh_token,
        ]);

        } catch(Exception $error){
            return response()->json([
                'status' => 500,
                'message' => $error->getMessage()
            ]);
        }
    }


    public function login(Request $request){
        $request->validate([
            'work_email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where($request->work_email, 'email')->first();

        if(!$user || !Hash::check($request->password, $user->password)){
             return response()->json([
                'status' => 403,
                'message' => 'Invalid credentials',
                'user' => $user
            ]); 
        }

        $token = $user->createToken('ScoutIn')->access_token;

        return response()->json([
            'access_token' => $token
        ]); 
    }
}
