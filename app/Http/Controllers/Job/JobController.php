<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use Exception;

use function PHPUnit\Framework\isEmpty;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $job = Job::latest()->paginate(5);

        if($job->isEmpty()){
            return response()->json([
                'status' => 200,
                'message' => 'No records found',
                'jobs' => $job
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Jobs fetched successfully',
            'jobs' => $job
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         try{
            $validated = $request->validate([
                'title' => 'required',
                'experience' => 'required',
                'salary_offered' => 'required',
                'timings' => 'required',
                'job_type' => 'required',
                'description' => 'required'
            ]);
    
            $job = Job::create($validated);
    
            return response()->json([
                'status' => 200,
                'message' => 'Job created successfully',
                'job' => $job,
            ]);
        }catch(Exception $error){
            return response()->json([
                'status' => 500,
                'message' => $error->getMessage(),
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
    public function update(Request $request, string $id)
    {
        try{

            $job = Job::findOrFail($id);

            $validated = $request->validate([
                'title' => 'required',
                'experience' => 'required',
                'salary_offered' => 'required',
                'timings' => 'required',
                'job_type' => 'required',
                'description' => 'required'
            ]);

            if(!$job){
                return response()->json([
                    'status' => 404,
                    'message' => 'No records found',
                    'job' => $job
                ]);
            }

            $job->update($validated);

            return response()->json([
                'status' => 200,
                'message' => 'Job updated successfully',
                'job' => $job
            ]);

        }catch(Exception $error){
            return response()->json([
                'status' => 500,
                'message' => $error->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $job = Job::findOrFail($id);

            if(!$job){
                return response()->json([
                    'status' => 404,
                    'message' => 'No records found',
                    'job' => $job,
                ]);
            }

            $job->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Job deleted successfully'
            ]);


        }catch(Exception $error){
            return response()->json([
                'status' => 500,
                'message' => $error->getMessage(),
            ]);
        }
    }
}
