<?php

namespace App\Http\Controllers\Integration;

use App\Http\Controllers\Controller;
use App\Models\Integration;
use Exception;
use Illuminate\Http\Request;

class IntegrationController extends Controller
{
    public function index(){
        $integration = Integration::all();

        if(!$integration){
            return response()->json([
                'status' => 404,
                'message' => 'No records found',
                'integration' => $integration,
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Social Links Fetched Successfully',
            'socials' => $integration,
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'linkedin_company_profile_url' => 'nullable'
        ]);

        $socials = Integration::create([
            'linkedin_company_profile_url' => $request->linkedin_company_profile_url
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Socials Account Integrated Successfully',
            'socials' => $socials,
        ]);
    }

     public function update(Request $request, Integration $integration){
        $request->validate([
            'linkedin_company_profile_url' => 'nullable'
        ]);

        $integration->update([
            'linkedin_company_profile_url' => $request->linkedin_company_profile_url
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Socials Account Updated Successfully Successfully',
            'socials' => $integration
        ]);
    }

    public function delete(Integration $integration){

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
