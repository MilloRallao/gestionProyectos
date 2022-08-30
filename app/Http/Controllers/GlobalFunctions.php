<?php

namespace App\Http\Controllers;

class GlobalFunctions
{

    public static function listAllParticipantes($projectId, $model, $permissionName)
    {
        $permissions = ['project responsable', 'project participante', 'activity responsable', 'activity participante'];
        $participantUsers = [];

        if (!in_array($permissionName, $permissions)) {
            return [false, $participantUsers];
        } else {
            $projectUsers = $model::findOrFail($projectId)->users;
            foreach ($projectUsers as $user) {
                if ($user->permissions->contains('name', $permissionName)) {
                    $participantUsers[] = $user;
                }
            }
            return [true, $participantUsers];
        }
    }
}
