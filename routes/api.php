<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Interview\InterviewController;
use App\Http\Controllers\Job\JobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/signup', [AuthController::class, 'signup']); 
Route::post('/signin', [AuthController::class, 'signin']); 

// Job
Route::resource('/jobs', JobController::class)->middleware('auth:sanctum');

// Interview
Route::prefix('/{job}')->group(function(){
    Route::resource('/interview', InterviewController::class)->only(['store'])->middleware('auth:sanctum');
});

// Interview
Route::resource('/interview', InterviewController::class)->except(['store'])->middleware('auth:sanctum');

// Interview with AI
Route::post('generate-interview/{job}', [InterviewController::class, 'store_ai_generated'])->middleware('auth:sanctum');

// Application
// Route::prefix('/{job}')->group(function(){
//     Route::resource('application', ApplicationController::class)->except(['update', 'destroy']);
// });

// Route::prefix('/{application}')->group(function(){
//     Route::resource('application', ApplicationController::class)->only(['update', 'destroy']);
// });

// Route::get('application', [ApplicationController::class, 'index']);
// Route::post('{job}/application', [ApplicationController::class, 'store']);
// Route::post('application/{application}', [ApplicationController::class, 'update']);
// Route::delete('application/{application}', [ApplicationController::class, 'destroy']);