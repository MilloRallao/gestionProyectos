<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::all();

        return response()->json([
            'message' => 'Listing all projects',
            'projects' => $projects,
        ], 200);
    }

    public function store(Request $request){
        $project = Project::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Successfully created project',
            'project' => $project,
        ], 200);
    }

    public function show($id){
        $project = Project::find($id);

        return response()->json([
            'message' => 'Succesfully listed project',
            'project' => new ProjectResource($project),
            
        ], 200);
    }

    public function projectParticipantes($id){
        $projectParticipantes = GlobalFunctions::listAllParticipantes($id, Project::class, 'project participante');

        return response()->json([
            'message' => 'Listed all participantes of this project',
            'users' => $projectParticipantes,
            
        ], 200);
    }
}
