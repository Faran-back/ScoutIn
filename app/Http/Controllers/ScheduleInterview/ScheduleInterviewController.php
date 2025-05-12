<?php

namespace App\Http\Controllers\ScheduleInterview;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleInterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            
        }catch(Exception $error){
            return response()->json([
                'status' => 500,
                'message' => $error->getMessage()
            ]);
        }
        $applications = Application::where('status', 'pending')->chunk(100, function($applications){
            foreach($applications as $application){
                $schedule_interviews = ScheduleInterview::create([
                    'day' => $request->day,
                    'month' => $request->month,
                    'year' => $request->year,
                    'application_id' => $application->id
                ]);
            }
        });

        return response()->json([
            'status' => 200,
            'message' => 'Interviews Scheduled Successfully',
            'interviews' => $schedule_interviews
        ]);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
