<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        return response()->json([
            'message' => 'Listing all projects',
            'projects' => $projects,
        ], 200);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
        ])->validate();

        $project = Project::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Successfully created project',
            'project' => $project,
        ], 200);
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);

        return response()->json([
            'message' => 'Succesfully listed project',
            'project' => new ProjectResource($project),

        ], 200);
    }

    public function projectParticipantes($id)
    {
        $projectParticipantes = GlobalFunctions::listAllParticipantes($id, Project::class, 'project participante');

        if ($projectParticipantes[0]) {
            return response()->json([
                'message' => 'Listed all participantes of this project',
                'users' => $projectParticipantes[1],
            ], 200);
        } else {
            return response()->json([
                'message' => 'Error. That permission not exists',
                'users' => $projectParticipantes[1],
            ], 422);
        }
    }
}
