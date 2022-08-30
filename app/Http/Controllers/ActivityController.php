<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(){
        $activities = Activity::all();

        return response()->json([
            'message' => 'Listing all activities',
            'activities' => $activities,
        ], 200);
    }

    public function store(Request $request){
        $activity = Activity::create([
            'name' => $request->name,
            'project_id' => $request->project_id,
        ]);

        return response()->json([
            'message' => 'Successfully created activity',
            'activity' => $activity,
        ], 200);
    }

    public function show($id){
        $activity = Activity::find($id);

        return response()->json([
            'message' => 'Succesfully listed activity',
            'activity' => new ActivityResource($activity),
        ], 200);
    }

    public function activityParticipantes($id){
        $activityParticipantes = GlobalFunctions::listAllParticipantes($id, Activity::class, 'activity participante');

        return response()->json([
            'message' => 'Listed all participantes of this activity',
            'users' => $activityParticipantes,
            
        ], 200);
    }
}
