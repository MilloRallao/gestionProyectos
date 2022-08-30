<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function assignProject(Request $request)
    {
        $user = User::find($request->user_id);

        $user->projects()->syncWithoutDetaching($request->project_id);
        $user->givePermissionTo($request->permissions);

        foreach ($request->permissions as $permission) {
            $permissionUserProjectCheck = DB::table('permissions_user')->where('permission', $permission)->where('user_id', $request->user_id)->where('project_id', $request->project_id)->exists();
            if (!$permissionUserProjectCheck) {
                DB::table('permissions_user')->insert([
                    'permission' => $permission,
                    'user_id' => $request->user_id,
                    'project_id' => $request->project_id,
                ]);
            }
        }

        return response()->json([
            'message' => 'Succesfully assigned project with permissions',
        ], 200);
    }

    public function unassignProject(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->projects()->detach($request->project_id);

        DB::table('permissions_user')->where('user_id', $request->user_id)->where('project_id', $request->project_id)->delete();

        return response()->json([
            'message' => 'Succesfully unassigned project with permissions',
            'user' => $user
        ], 200);
    }

    public function assignActivity(Request $request)
    {
        $message = "";
        $errorCode = 200;
        $user = User::findOrFail($request->user_id);

        $permissionUserActivityCheck = DB::table('permissions_user')->where('permission', $request->permissions)->where('user_id', $request->user_id)->where('activity_id', $request->activity_id)->exists();
        $permissionUserActivity = DB::table('permissions_user')->where('activity_id', $request->activity_id)->where('user_id', $request->user_id)->get();
        
        if (!$permissionUserActivityCheck && count($permissionUserActivity) < 1) {
            $user->activities()->attach($request->activity_id);
            $user->givePermissionTo($request->permissions);

            DB::table('permissions_user')->insert([
                'permission' => $request->permissions,
                'user_id' => $request->user_id,
                'activity_id' => $request->activity_id,
            ]);

            $message = 'Succesfully assigned activity with permissions';
        } else {
            $message = 'Cannot be assigned this user with this activity';
            $errorCode = 422;
        }

        return response()->json([
            'message' => $message,
        ], $errorCode);
    }

    public function unassignActivity(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->activities()->detach($request->activity_id);

        DB::table('permissions_user')->where('user_id', $request->user_id)->where('activity_id', $request->activity_id)->delete();

        return response()->json([
            'message' => 'Succesfully unassigned activity with permissions',
        ], 200);
    }

    public function assignIncident(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->incidents()->attach($request->incident_id);

        return response()->json([
            'message' => 'Succesfully assigned incident',
        ], 200);
    }

    public function unassignIncident(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->incidents()->detach($request->incident_id);

        return response()->json([
            'message' => 'Succesfully unassigned incident',
        ], 200);
    }
}
