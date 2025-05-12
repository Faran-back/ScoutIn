<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class AuthController extends Controller
{
    public function signup(Request $request){

        try{

            $validated = $request->validate([
            'company_name' => 'required',
            'company_headquartered_at' => 'required',
            'industry' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'work_email' => 'required|email',
            'phone_number' => 'required',
            'password' => 'required',
            'terms_and_conditions' => 'required'
        ]);

        $user = User::create($validated);

        $token = $user->createToken('auth:sanctum')->plainTextToken;

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

    public function signin(Request $request){
        $request->validate([
            'work_email' => 'required',
            'password' => 'required',
        ]);
    }
}