<?php

use App\Http\Controllers\Application\ApplicationController;
use App\Http\Controllers\ApplicationStatus\ApplicationStatusController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ClientAuth\ClientAuthController;
use App\Http\Controllers\CompanyDetails\CompanyDetailController;
use App\Http\Controllers\Interview\InterviewQuestionController;
use App\Http\Controllers\Job\JobController;
use App\Http\Controllers\ScheduleInterview\ScheduleInterviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;






Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']); 
Route::post('/login', [AuthController::class, 'login']); 

/**
 * Job
 */
Route::middleware('auth:api')->group(function(){
    Route::resource('/jobs', JobController::class);
});


/**
 * Interview
 */
Route::middleware('auth:api')->group(function (){
    Route::get('interview-questions', [InterviewQuestionController::class, 'index']);
    Route::post('/{job}/interview-questions', [InterviewQuestionController::class, 'store']);
    Route::post('interview-questions-ai/{job}', [InterviewQuestionController::class, 'store_ai_generated']);
    Route::post('interview-params/{job}', [InterviewQuestionController::class, 'store_ai_generated']);
    Route::patch('interview-questions/{interview}', [InterviewQuestionController::class, 'update']);
    Route::delete('interview-questions/{interview}', [InterviewQuestionController::class, 'destroy']);
});

/**
 * Schedule Interview
 */
Route::middleware('auth:api')->group(function (){
    Route::get('/schedule-interview', [ScheduleInterviewController::class, 'index']);
    Route::post('/schedule-interview', [ScheduleInterviewController::class, 'store']);
    Route::post('/schedule-interview/{application}', [ScheduleInterviewController::class, 'store_one']);
    Route::patch('/schedule-interview/{application}', [ScheduleInterviewController::class, 'update']);
    Route::delete('/schedule-interview/{application}', [ScheduleInterviewController::class, 'destroy']);
});

/**
 * Application
 */
Route::middleware('auth:api')->group(function(){
    Route::get('{job?}/application', [ApplicationController::class, 'index']);
    Route::post('{job}/application', [ApplicationController::class, 'store']);
    Route::post('application/{application}', [ApplicationController::class, 'update']);
    Route::delete('application/{application}', [ApplicationController::class, 'destroy']);
});

/**
 * Company Detail
 */
Route::middleware('auth:api')->group(function(){
    Route::get('/company-detail', [CompanyDetailController::class, 'index']);
    Route::post('/{user}/company-detail', [CompanyDetailController::class, 'store']);
    Route::patch('/company-detail/{company}', [CompanyDetailController::class, 'update']);
    Route::delete('/company-detail/{company}', [CompanyDetailController::class, 'destroy']);
});

/**
 * Social Accounts Integration
 */
Route::middleware('auth:api')->group(function(){
    Route::get('/social-integration', [CompanyDetailController::class, 'index']);
    Route::post('/social-integration', [CompanyDetailController::class, 'store']);
    Route::patch('/social-integration/{social}', [CompanyDetailController::class, 'update']);
    Route::delete('/social-integration/{social}', [CompanyDetailController::class, 'destroy']);
});

/**
 * Client Auth
 */
Route::post('/client-register', [ClientAuthController::class, 'register']);
Route::post('/client-login', [ClientAuthController::class, 'login']);


/**
 * Application Status Tracking
 */
Route::middleware('auth:api')->group(function(){
    Route::get('/application-progress', [ApplicationStatusController::class, 'index']);
});