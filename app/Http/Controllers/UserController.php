<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function assignProject(Request $request)
    {
        $message = "";
        $user = User::find($request->user_id);

        if ($user->hasPermissionTo('project participante') && $request->permissions == "project participante") {
            $message = 'User already has this permission in this project';
        } else if ($user->hasPermissionTo('project rsponsable') && $request->permissions == "project responsable") {
            $message = 'User already has this permission in this project';
        } else {
            $user->projects()->attach($request->project_id);
            $user->givePermissionTo($request->permissions);
            $message = 'Succesfully assigned project with permissions';
        }

        return response()->json([
            'message' => $message,
        ], 200);
    }

    public function unassignProject(Request $request)
    {
        $user = User::find($request->user_id);
        $user->projects()->detach($request->project_id);
        $user->revokePermissionTo($request->permissions);

        return response()->json([
            'message' => 'Succesfully unassigned project with permissions',
            'user' => $user
        ], 200);
    }

    public function assignActivity(Request $request)
    {
        $message = "";
        $user = User::find($request->user_id);

        if (!$user->hasAnyPermission(['activity participante', 'activity responsable'])) {
            if ($user->hasPermissionTo('project participante')) {
                $user->activities()->attach($request->activity_id);
                $user->givePermissionTo($request->permissions);

                $message = 'Succesfully assigned activity with permissions';
            } else {
                $message = 'Cannot be assigned this user with this activity';
            }
        } else {
            $message = 'User already has a permission in this activity';
        }

        return response()->json([
            'message' => $message,
        ], 200);
    }

    public function unassignActivity(Request $request)
    {
        $user = User::find($request->user_id);
        $user->activities()->detach($request->activity_id);
        $user->givePermissionTo($request->permissions);

        return response()->json([
            'message' => 'Succesfully unassigned activity with permissions',
        ], 200);
    }

    public function assignIncident(Request $request)
    {
        $user = User::find($request->user_id);
        $user->incidents()->attach($request->incident_id);

        return response()->json([
            'message' => 'Succesfully assigned incident',
        ], 200);
    }

    public function unassignIncident(Request $request)
    {
        $user = User::find($request->user_id);
        $user->incidents()->detach($request->incident_id);

        return response()->json([
            'message' => 'Succesfully unassigned incident',
        ], 200);
    }
}
