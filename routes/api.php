<?php

use App\Http\Controllers\Interview\InterviewController;
use App\Http\Controllers\Job\JobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Job
Route::resource('/jobs', JobController::class);

// Interview
Route::prefix('/{job}')->group(function(){
    Route::resource('/interview', InterviewController::class)->only(['store']);
});

// Interview
Route::resource('/interview', InterviewController::class)->except(['store']);

// Interview with AI
Route::post('generate-interview/{job}', [InterviewController::class, 'store_ai_generated']);