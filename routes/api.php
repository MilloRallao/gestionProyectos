<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource("projects", ProjectController::class);
Route::GET("project-participantes/{project}", [ProjectController::class, "projectParticipantes"]);
Route::apiResource("activities", ActivityController::class);
Route::GET("activity-participantes/{activity}", [ActivityController::class, "activityParticipantes"]);
Route::apiResource("incidents", IncidentController::class);
Route::POST("activity-incidents", [IncidentController::class, "activityIncidents"]);
Route::POST("assign-project", [UserController::class, "assignProject"]);
Route::POST("unassign-project", [UserController::class, "unassignProject"]);
Route::POST("assign-activity", [UserController::class, "assignActivity"]);
Route::POST("unassign-activity", [UserController::class, "unassignActivity"]);
Route::POST("assign-incident", [UserController::class, "assignIncident"]);
Route::POST("unassign-incident", [UserController::class, "unassignIncident"]);
