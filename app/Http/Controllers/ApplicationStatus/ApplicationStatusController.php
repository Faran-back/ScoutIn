<?php

namespace App\Http\Controllers\ApplicationStatus;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApplicationStatusController extends Controller
{
    public function index(){
        $user = Auth::user();

        $applications = $user->applications;

        foreach($applications as $application){
            if($application->ATA_score >= 80){
                if(!$application->status === 'Interview Scheduled'){
                    $application->update([
                        'status' => 'Waiting For Interview to be scheduled'
                    ]);
                }else{
                    $application->update([
                        'status' => 'Interview Scheduled'
                    ]);
                }
            }else{
                $application->update([
                    'status' => 'The ATS score does not meets the minimum requirement'
                ]);
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'Applications fetched successfully',
            'application' => $applications,
        ]);
    }
}
