<?php

use App\Http\Controllers\Application\ApplicationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Interview\InterviewController;
use App\Http\Controllers\InterviewQuestions\InterviewQuestionController;
use App\Http\Controllers\Job\JobController;
use App\Http\Controllers\ScheduleInterview\ScheduleInterviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/signup', [AuthController::class, 'signup']); 
Route::post('/signin', [AuthController::class, 'signin']); 

// Job
Route::resource('/jobs', JobController::class);

// Interview    
Route::prefix('/{job}')->group(function(){
    Route::resource('/interview', InterviewQuestionController::class)->only(['store']);
});

// Interview
Route::resource('/interview', InterviewQuestionController::class)->except(['store']);

// Interview with AI
Route::post('generate-interview/{job}', [InterviewQuestionController::class, 'store_ai_generated']);

// Schedule Interview
// Route::apiResource('/schedule-interview', ScheduleInterviewController::class);
Route::get('/schedule-interview', [ScheduleInterviewController::class, 'index']);
Route::post('/schedule-interview', [ScheduleInterviewController::class, 'store']);
Route::post('/schedule-interview/{application}', [ScheduleInterviewController::class, 'store_one']);
Route::patch('/schedule-interview/{application}', [ScheduleInterviewController::class, 'update']);
Route::delete('/schedule-interview/{application}', [ScheduleInterviewController::class, 'destroy']);

// Application
// Route::prefix('/{job}')->group(function(){
//     Route::resource('application', ApplicationController::class)->except(['update', 'destroy']);
// });

// Route::prefix('/{application}')->group(function(){
//     Route::resource('application', ApplicationController::class)->only(['update', 'destroy']);
// });

Route::get('application', [ApplicationController::class, 'index']);
Route::post('{job}/application', [ApplicationController::class, 'store']);
Route::post('application/{application}', [ApplicationController::class, 'update']);
Route::delete('application/{application}', [ApplicationController::class, 'destroy']);