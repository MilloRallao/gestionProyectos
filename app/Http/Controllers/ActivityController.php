<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        Validator::make($request->all(), [
            'name' => 'required',
            'project_id' => 'required','Integer'
        ])->validate();
        
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
        $activity = Activity::findOrFail($id);

        return response()->json([
            'message' => 'Succesfully listed activity',
            'activity' => new ActivityResource($activity),
        ], 200);
    }

    public function activityParticipantes($id){
        $activityParticipantes = GlobalFunctions::listAllParticipantes($id, Activity::class, 'activity participante');

        if ($activityParticipantes[0]) {
            return response()->json([
                'message' => 'Listed all participantes of this activity',
                'users' => $activityParticipantes[1],
            ], 200);
        } else {
            return response()->json([
                'message' => 'Error. That permission not exists',
                'users' => $activityParticipantes[1],
            ], 422);
        }
    }
}
