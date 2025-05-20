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
            // 'company_name' => 'required',
            // 'company_headquartered_at' => 'required',
            // 'industry' => 'required',
            // 'first_name' => 'required',
            // 'last_name' => 'required',
            // 'work_email' => 'required|email',
            // 'phone_number' => 'required',
            // 'password' => 'required',
            // 'terms_and_conditions' => 'required'

            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::create($validated);

        $token = $user->createToken('MyApp')->accessToken;

        return response()->json([
            'status' => 200,
            'message' => 'signed up successfully',
            'user' => $user,
            'token' => $token
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
            'email' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();

            $access_token = $user->createToken('MyApp')->accessToken;
            $refresh_token = $user->createToken('MyApp')->refreshToken;

            return response()->json([
                'access_token' => $access_token,
                'refresh_token' => $refresh_token,
            ]); 
        }

             return response()->json([
                'message' => 'No records found'
            ]); 
    }
}
