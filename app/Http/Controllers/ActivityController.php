<?php

namespace App\Http\Controllers;

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
            'activity' => $activity,
        ], 200);
    }
}
