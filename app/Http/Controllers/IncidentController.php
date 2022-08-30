<?php

namespace App\Http\Controllers;

use App\Http\Resources\IncidentResource;
use App\Models\Activity;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IncidentController extends Controller
{
    public function index()
    {
        $incidents = Incident::all();

        return response()->json([
            'message' => 'Listing all incidents',
            'incidents' => $incidents,
        ], 200);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'activity_id' => 'required', 'Integer'
        ])->validate();

        $incident = Incident::create([
            'name' => $request->name,
            'activity_id' => $request->activity_id,
        ]);

        return response()->json([
            'message' => 'Successfully created incident',
            'incident' => $incident,
        ], 200);
    }

    public function show($id)
    {
        $incident = Incident::findOrFail($id);

        return response()->json([
            'message' => 'Succesfully listed incident',
            'incident' => new IncidentResource($incident),
        ], 200);
    }

    public function activityIncidents(Request $request)
    {
        $checkActivity = DB::table('permissions_user')->where('permission', 'activity responsable')->where('activity_id', $request->activity_id)->where('user_id', $request->user_id)->exists();

        if ($checkActivity) {
            $activityIncidents = Activity::findOrFail($request->activity_id)->incidents;
            return response()->json([
                'message' => 'Listed all incidents of this activity',
                'activityIncidents' => $activityIncidents,
            ]);
        } else {
            return response()->json([
                'message' => 'Forbidden. You do not have permissions',
            ]);
        }
    }
}
