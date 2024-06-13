<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function listAllProject()
    {
        $dataProject = Project::with('users')->get();

        return response()->json(['message' => 'success', 'data' => $dataProject]);
    }

    public function detailProject($id)
    {
        $dataProject = Project::find($id);

        return response()->json(['message' => 'success', 'data' => $dataProject]);   
    }

    public function createProject(Request $request)
    {
        $dataValidate = $request->validate([
            'client' => 'required', 
            'project' => 'required',
            'dueDate' => 'required',
            'schedule' => 'required'
        ]);

        Project::create([
            'client' => $dataValidate['client'], 
            'project' => $dataValidate['project'],
            'dueDate' => $dataValidate['dueDate'],
            'schedule' => $dataValidate['schedule']
        ]);

        return response()->json(['message' => 'success'], 201);
    }

    public function updateProject(Request $request, $id)
    {
        $dataValidate = $request->validate([
            'client' => 'required', 
            'project' => 'required', 
            'status' => 'required', 
            'schedule' => 'required'
        ]);

        $dataProject = Project::find($id);
        $dataProject->client = $dataValidate['client'];
        $dataProject->project = $dataValidate['project'];
        $dataProject->status = $dataValidate['status'];
        $dataProject->schedule = $dataValidate['schedule'];
        $dataProject->save();

        return response()->json(['message' => 'success'], 200);
    }

    public function actionProject(Request $request)
    {
        $dataValidate = $request->validate([
            'client' => 'required', 
            'project' => 'required', 
            'status' => 'required', 
            'schedule' => 'required'
        ]);

        $dataProject = Project::find($id);
        $dataProject->status = '1';
        $dataProject->save();

        return response()->json(['message' => 'success'], 200);
    }
    
    public function deleteProject($id)
    {
        $dataProject = Project::find($id);
        $dataProject->delete();
        return response()->json(['message' => 'success'], 200);
    }
}
