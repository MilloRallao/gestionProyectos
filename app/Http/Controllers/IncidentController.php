<?php

namespace App\Http\Controllers;

use App\Http\Resources\IncidentResource;
use App\Models\Activity;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function index(){
        $incidents = Incident::all();
 
        return response()->json([
            'message' => 'Listing all incidents',
            'incidents' => $incidents,
        ], 200);
    }

    public function store(Request $request){
        $incident = Incident::create([
            'name' => $request->name,
            'activity_id' => $request->activity_id,
        ]);

        return response()->json([
            'message' => 'Successfully created incident',
            'incident' => $incident,
        ], 200);
    }

    public function show($id){
        $incident = Incident::find($id);

        return response()->json([
            'message' => 'Succesfully listed incident',
            'incident' => new IncidentResource($incident),
        ], 200);
    }

    public function activityIncidents(Request $request){
        $activityIncidents = Activity::find($request->activity_id)->incidents;
        $user = User::find($request->user_id);
        if($user->hasPermissionTo('activity responsable')){
            return response()->json([
                'message' => 'All incidents of this activity listed succesfully',
                'activityIncidents' => $activityIncidents,
            ]);
        }else{
            return response()->json([
                'message' => 'Forbidden. You do not have permissions',
            ]);
        }
        
    }
}
