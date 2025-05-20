<?php

namespace App\Http\Controllers\ScheduleInterview;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ScheduleInterview;
use Exception;
use Illuminate\Http\Request;

class ScheduleInterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $scheduled_interviews = ScheduleInterview::paginate(5);

        if(!$scheduled_interviews){
            return response()->json([
                'status' => 404,
                'message' => 'No records found',
                'scheduled_interviews' => $scheduled_interviews,
            ]);
        }

         return response()->json([
                'status' => 200,
                'message' => 'Scheduled Interviews Fetched Successfully',
                'scheduled_interviews' => $scheduled_interviews,
            ]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
             
            $request->validate([
                'date' => 'required',
                'time' => 'required'
            ]);

            $applications = Application::where('status', 'pending')->get();

            if($applications->isEmpty()){
                return response()->json([
                    'status' => 200,
                    'message' => 'No pending applications found',
                    'applications' => $applications,
                ]);
            }
            
            $scheduled_interviews = [];  

            foreach($applications as $application){

            $scheduled_interviews[] = ScheduleInterview::create([
                'date' => $request->date,
                'month' => $request->month,
                'year' => $request->year,
                'time' => $request->time,
                'application_id' => $application->id
            ]);

            }

            return response()->json([
                'status' => 200,
                'message' => 'Interviews scheduled successfully',
                'schedule' => $scheduled_interviews
            ]);
            
        }catch(Exception $error){
            return response()->json([
                'status' => 500,
                'message' => $error->getMessage()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_one(Request $request, Application $application){
       try{
             
            $request->validate([
                'date' => 'required',
                'time' => 'required'
            ]);

            $scheduled_interview = ScheduleInterview::create([
                'date' => $request->date,
                'time' => $request->time,
                'application_id' => $application->id
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Interviews scheduled successfully',
                'scheduled_interview' => $scheduled_interview
            ]);
            
        }catch(Exception $error){
            return response()->json([
                'status' => 500,
                'message' => $error->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Application $application)
    {
     try{
            $request->validate([
                'date' => 'required',
                'time' => 'required'
            ]);

            $schedule_interview = ScheduleInterview::where('application_id', $application->id)->first();

            $schedule_interview->update([
                'date' => $request->date,
                'time' => $request->time,
                'application_id' => $application->id
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Scheduled Interview Updated successfully',
                'schedule' => $schedule_interview
            ]);
            
        }catch(Exception $error){
            return response()->json([
                'status' => 500,
                'message' => $error->getMessage()
            ]);
        }   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application)
{
    try {
        $schedule_interview = ScheduleInterview::where('application_id', $application->id)->first();

        if (!$schedule_interview) {
            return response()->json([
                'status' => 404,
                'message' => 'No scheduled interview found for this application'
            ]);
        }

        $schedule_interview->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Scheduled Interview Deleted Successfully'
        ]);

    } catch (Exception $error) {
        return response()->json([
            'status' => 500,
            'message' => $error->getMessage()
        ]);
    }
}

}
