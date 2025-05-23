<?php

namespace App\Http\Controllers\CompanyDetails;

use App\Http\Controllers\Controller;
use App\Models\CompanyDetail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class CompanyDetailController extends Controller
{

    use AuthorizesRequests;


    public function index(){
        try{

            $user = Auth::user();
            
            $company_details = CompanyDetail::where('user_id', $user->id)->first();
        
            if($company_details->isEmpty()){

                return response()->json([
                    'status' => 404,
                    'message' => 'No records found',
                    'company_details' => $company_details
                ]);
            } 

            return response()->json([
                'status' => 200,
                'message' => 'Company details fetched successfully',
                'company_details' => $company_details
            ]);

        }catch(Exception $error){
            return response()->json([
                'status' => 500,
                'message' => $error->getMessage()
            ]);
        }
    }

    public function store(Request $request, User $user){

        try{

            $request->validate([
                    'company_logo' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
                    'company_name' => 'required',
                    'company_website' => 'required',
                    'number_of_employees' => 'required',
                    'industry' => 'required',
                    'country' => 'nullable',
                    'social_media' => 'nullable',
                    'about_your_company' => 'nullable',
                    'mission' => 'nullable',
                    'benefits' => 'nullable',
                    'values' => 'nullable',
            ]);

            if($request->hasFile('company_logo')){

                $logo = $request->file('company_logo');
                $logo_name = time() . '_' . str_replace(' ', '_', $logo->getClientOriginalName());
                $logo->storeAs('company_logos', $logo_name, 'public');
            
                $company_details = CompanyDetail::create([
                    'company_logo' => $logo_name,
                    'company_name' => $request->company_name,
                    'company_website' => $request->company_website,
                    'number_of_employees' => $request->number_of_employees,
                    'industry' => $request->industry,
                    'country' => $request->country,
                    'social_media' => $request->social_media,
                    'about_your_company' => $request->about_your_company,
                    'mission' => $request->mission,
                    'benefits' => $request->benefits,
                    'values' => $request->values,
                    'user_id' => $user->id
            ]);

             return response()->json([
                'status' => 200,
                'message' => 'Company Details saved successfully',
                'company_details' => $company_details,
                'company_logo' => asset( 'storage/company_logos/' .$company_details->company_logo)
            ]);

            }

            $company_details = CompanyDetail::create([
                    'company_name' => $request->company_name,
                    'company_website' => $request->company_website,
                    'number_of_employees' => $request->number_of_employees,
                    'industry' => $request->industry,
                    'country' => $request->country,
                    'social_media' => $request->social_media,
                    'about_your_company' => $request->about_your_company,
                    'mission' => $request->mission,
                    'benefits' => $request->benefits,
                    'values' => $request->values,
                    'user_id' => $user->id
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Company Details saved successfully',
                'company_details' => $company_details,
            ]);

        }catch(Exception $error){
            return response()->json([
                'status' => 500,
                'message' => $error->getMessage(),
            ]);
        }
    }

    public function update(Request $request, CompanyDetail $company){

        try{

            $request->validate([
                    'company_logo' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',
                    'company_name' => 'required',
                    'company_website' => 'required',
                    'number_of_employees' => 'required',
                    'industry' => 'required',
                    'country' => 'nullable',
                    'social_media' => 'nullable',
                    'about_your_company' => 'nullable',
                    'mission' => 'nullable',
                    'benefits' => 'nullable',
                    'values' => 'nullable',
            ]);

            if($request->hasFile('company_logo')){

            $logo = $request->file('company_logo');
            $logo_name = time() . '_' . str_replace(' ', '_', $logo->getClientOriginalName());
            $logo->storeAs('company_logos', $logo_name, 'public');

            $company->update([
                    'user_id' => $company->user_id,
                    'company_logo' => $logo_name,
                    'company_name' => $request->company_name,
                    'company_website' => $request->company_website,
                    'number_of_employees' => $request->number_of_employees,
                    'industry' => $request->industry,
                    'country' => $request->country,
                    'social_media' => $request->social_media,
                    'about_your_company' => $request->about_your_company,
                    'mission' => $request->mission,
                    'benefits' => $request->benefits,
                    'values' => $request->values,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Company Details updated successfully',
                'company_details' => $company,
            ]);
            }

            $company_details = $company->update([
                    'user_id' => $company->user_id,
                    'company_name' => $request->company_name,
                    'company_website' => $request->company_website,
                    'number_of_employees' => $request->number_of_employees,
                    'industry' => $request->industry,
                    'country' => $request->country,
                    'social_media' => $request->social_media,
                    'about_your_company' => $request->about_your_company,
                    'mission' => $request->mission,
                    'benefits' => $request->benefits,
                    'values' => $request->values,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Company Details updated successfully',
                'company_details' => $company,
            ]);

        }catch(Exception $error){
            return response()->json([
                'status' => 500,
                'message' => $error->getMessage(),
            ]);
        }
    }

    public function destroy(Request $request, CompanyDetail $company){

         try{

            $company->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Company details deleted successfully'
            ]);

         }catch(Exception $error){
            return response()->json([
                'status' => 500,
                'message' => $error->getMessage(),
            ]);
        }
    }



}
