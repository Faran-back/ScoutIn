<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Exception;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function index(){
        $user = auth('api')->user();

        $offices = $user->offices;

        if($offices->isEmpty()){
            return response()->json([
                'status' => 404,
                'message' => 'No records found',
                'office' => $offices,
            ]);
        };

        return response()->json([
            'status' => 200,
            'message' => 'Offices Fetched Successfully',
            'office' => $offices,
        ]);
    }

    public function store(Request $request){

        try{

            $user = auth('api')->user();

           $validated = $request->validate([
                'office_name' => 'required',
                'street_name' => 'required',
                'house_number' => 'required',
                'country' => 'required',
                'is_default' => 'required',
            ]);

            $office = Office::create([
                'office_name' => $request->office_name,
                'street_name' => $request->street_name,
                'house_number' => $request->house_number,
                'country' => $request->country,
                'is_default' => $request->is_default,
                'user_id' => $user->id
            ]);

             return response()->json([
                'status' => 200,
                'message' => 'Office created successfully',
                'office' => $office,
            ]);

        }catch(Exception $error){
            return response()->json([
                'status' => 500,
                'message' => $error->getMessage(),
            ]);
        }
    }

    public function update(Request $request, Office $office){
         try{

           $validated = $request->validate([
                'office_name' => 'required',
                'street_name' => 'required',
                'house_number' => 'required',
                'country' => 'required',
                'is_default' => 'required',
            ]);

            $office->update($validated);

             return response()->json([
                'status' => 200,
                'message' => 'Office Updated successfully',
                'office' => $office,
            ]);

        }catch(Exception $error){
            return response()->json([
                'status' => 500,
                'message' => $error->getMessage(),
            ]);
        }
    }

    public function destroy(Request $request, Office $office){
         try{

            $office->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Office deleted successfully'
            ]);

        }catch(Exception $error){
            return response()->json([
                'status' => 500,
                'message' => $error->getMessage(),
            ]);
        }
    }
}
