<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
          try{

            $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'work_email' => 'required|email|unique:users,work_email',
            'phone_number' => 'required',
            'password' => 'required',
            'company_name' => 'required',
            'company_headquartered_at' => 'required',
            'industry' => 'required',
            'terms_and_conditions' => 'required'
        ]);

        $user = User::create($validated);

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
            'work_email' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt(['work_email' => $request->work_email, 'password' => $request->password])){
            $user = Auth::user();

            $token = $user->createToken('ScoutIn');
            $access_token = $token->accessToken;
            $refresh_token = $token->token->refresh_token;

            return response()->json([
                'access_token' => $access_token,
                'refresh_token' => $refresh_token,
            ]); 
        }

             return response()->json([
                'status' => 403,
                'message' => 'Invalid credentials'
            ]); 
    }
}
