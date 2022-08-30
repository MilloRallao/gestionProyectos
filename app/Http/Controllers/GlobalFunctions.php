<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

class GlobalFunctions
{

    public static function listAllParticipantes($projectId, $model, $permissionName)
    {
        $projectUsers = $model::find($projectId)->users;
        $participantUsers = [];

        foreach ($projectUsers as $user) {
            if($user->permissions->contains('name', $permissionName)){
                $participantUsers[] = $user;
            }
        }

        return $participantUsers;
    }
}
