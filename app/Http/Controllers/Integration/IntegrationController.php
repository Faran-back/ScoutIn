<?php

namespace App\Http\Controllers\Integration;

use App\Http\Controllers\Controller;
use App\Models\Integration;
use Exception;
use Illuminate\Http\Request;

class IntegrationController extends Controller
{
    public function index(){

        try{

            $user = auth('api')->user();

            $integrations = $user->integrations;

            if(!$integrations){
                return response()->json([
                    'status' => 404,
                    'message' => 'No records found',
                    'integration' => $integrations,
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'Social Links Fetched Successfully',
                'socials' => $integrations,
            ]);
            
            }catch(Exception $error){
                return response()->json([
                'status' => 500,
                'message' => $error->getMessage()
            ]);
        
        }
    }

    public function store(Request $request){

        try{ 

            $user = auth('api')->user();

            $request->validate([
                'linkedin_company_profile_url' => 'required'
            ]);

            $socials = Integration::create([
                'linkedin_company_profile_url' => $request->linkedin_company_profile_url,
                'user_id' => $user->id
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Socials Account Integrated Successfully',
                'socials' => $socials,
            ]);

         }catch(Exception $error){
            return response()->json([
                'status' => 500,
                'message' => $error->getMessage()
        ]);
        
        }
    }

    public function update(Request $request, Integration $integration){
        try{

            $request->validate([
                'linkedin_company_profile_url' => 'required'
            ]);

            $integration->update([
                'linkedin_company_profile_url' => $request->linkedin_company_profile_url
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Socials Account Updated Successfully',
                'socials' => $integration
            ]);

        }catch(Exception $error){
            return response()->json([
            'status' => 500,
            'message' => $error->getMessage()
        ]);
        
        }
    }

    public function destroy(Integration $integration){

        try{

        $integration->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Social Deleted Successfully'
        ]);

        }catch(Exception $error){
            return response()->json([
            'status' => 200,
            'message' => $error->getMessage()
        ]);
        
        }
    }
}
