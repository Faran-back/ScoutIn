<?php

namespace App\Http\Controllers\Interview;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Interview;
use App\Models\InterviewQuestion;
use App\Models\Job;
use Exception;
use Illuminate\Support\Facades\Http;

class InterviewQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $interview = InterviewQuestion::all();

        if($interview->isEmpty()){
            return response()->json([
                'status' => 200,
                'message' => 'No Records Found',
                'interview' => $interview
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Questions Fetched Successfully',
            'interview' => $interview
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
                'question' => 'required',
                'answer' => 'required'
            ]);
    
            $interview = InterviewQuestion::create([
                'question' => $request->question,
                'answer' => $request->answer,
                'job_id' => $job->id
            ]);
    
            return response()->json([
                'status' => 200,
                'message' => 'Interview Created Successfully',
                'interview' => $interview,
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
    public function update(Request $request, string $id)
    {
        try{
            $interview = InterviewQuestion::findOrFail($id);

            $validated = $request->validate([
                'question' => 'required',
                'answer' => 'required',
                'job_id' => $id,
            ]);

            $interview->update($validated);

            return response()->json([
                'status' => '200',
                'message' => 'Interview Updated Successfully',
                'interview' => $interview,
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
    public function destroy(string $id)
    {
        try{
            $interview = InterviewQuestion::findOrFail($id);

            if(!$interview){
                return response()->json([
                    'status' => 200,
                    'message' => 'No records found',
                    'interview' => $interview
                ]);
            }

            $interview->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Interview deleted Successfully'
            ]);
        }catch(Exception $error){
            return response()->json([
                'status' => 500,
                'message' => $error->getMessage()
            ]);
        }
    }

    public function store_ai_generated(Request $request, Job $job){

        $prompt = "Generate 3 interview questions (don't specify the reason of question), based on the job title {$job->title}. Use description for context {$job->description}";

        try{
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->withOptions([
            'verify' => false
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . env('GEMINI_API_KEY'), [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        if($response->successful()){
            $questions = $response->json()['candidates'][0]['content']['parts'][0]['text'];
            return response()->json([
                'status' => 200,
                'message' => 'questions generated successfully',
                'questions' => explode("\n", trim($questions))
            ]);
        }

        return response()->json([
            'status' => 500,
            'message' => 'Failed to generate questions ' . $response->json()['error']['message'] ?? 'Unknown Error'
        ]);
    }catch(Exception $error){
        return response()->json([
            'status' => 500,
            'message' => $error->getMessage()
        ]);
    }

    }
}
