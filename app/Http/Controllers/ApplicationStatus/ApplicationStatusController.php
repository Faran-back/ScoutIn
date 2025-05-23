<?php

namespace App\Http\Controllers\ApplicationStatus;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationStatusController extends Controller
{
    public function index(){
        $user = Auth::user();

        $applications = $user->applications;

        // if(!$applications){
        //     return response()->json([
        //         'status' => 404,
        //         'message' => 'No records found',
        //         'application' => $applications,
        //     ]);
        // }



        return response()->json([
            'status' => 404,
            'message' => 'Applications fetched successfully',
            'application' => $applications,
        ]);
    }
}
