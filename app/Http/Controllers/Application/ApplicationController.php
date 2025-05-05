<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\Job;
use Exception;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $application = Application::latest()->paginate();

        if($application->isEmpty()){
            return response()->json([
                'status' => 200,
                'message' => 'No records found',
                'applications' => $application
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Applications fetched successfully',
            'applications' => $application
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
    public function store(Request $request, Job $job)
    {
        try{
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'contact_via' => 'required',
                'consent' => 'required|boolean',
                'CV' => 'required|file|mimes:png,jpg,jpeg,doc,docx|max:2048',
                'company_name' => 'required',
                'job_role' => 'required'
            ]);
    
                $cv = $request->file('CV');
                $cv_name = time() . '_' . $cv->getClientOriginalName();
                $cv->storeAs('CVs', $cv_name, 'public');
                
                $application = Application::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'contact_via' => $request->contact_via,
                    'consent' => $request->consent,
                    'CV' => $cv_name,
                    'company_name' => $request->company_name,
                    'job_role' => $request->job_role,
                    'job_id' => $job->id,
                    'ATA_score' => $request->ATA_score ?? 0,
                    'status' => $request->status ?? 'pending',
                ]);
    
                return response()->json([
                    'status' => 200,
                    'message' => 'Application submitted successfully',
                    'application' => $application
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
                'name' => 'required',
                'email' => 'required',
                'contact_via' => 'required',
                'consent' => 'required',
                'CV' => 'required|file|mimes:png,jpg,jpeg,doc,docx|max:2048',
                'company_name' => 'required',
                'job_role' => 'required'
            ]);

            if($request->hasFile('CV')){
                $cv = $request->file('CV');
                $cv_name = time() . '_' . $cv->getClientOriginalName();
                $cv->storeAs('CVs', $cv_name, 'public');

                $application->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'contact_via' => $request->contact_via,
                    'consent' => $request->consent,
                    'CV' => $cv_name,
                    'company_name' => $request->company_name,
                    'job_role' => $request->job_role
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Application Updated Successfully',
                    'application' => $application
                ]);
            }

            return response()->json([
                'status' => 403,
                'message' => 'File not Uploaded'
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
        try{
            $application->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Application deleted successfully'
            ]);

        }catch(Exception $error){
            return response()->json([
                'status' => 500,
                'message' => $error->getMessage(),
            ]);
        }
    }
}
