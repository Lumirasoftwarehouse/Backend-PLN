<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Phase;
use App\Models\Deliverable;
use App\Models\UserProject;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

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
        $dataPhase = Phase::where('id_project', $id)->get();
        $dataDeliverable = Deliverable::where('id_project', $id)->get();
        $dataUserProject = DB::table('user_projects')
            ->join('users', 'user_projects.userId', '=', 'users.id')
            ->where('user_projects.projectId', $id)
            ->select('users.name', 'users.position', 'users.id as userId', 'user_projects.projectId')
            ->get();

        $data =[
            'dataProject' => $dataProject,
            'dataPhase' => $dataPhase,
            'dataDeliverable' => $dataDeliverable,
            'dataUserProject' => $dataUserProject
        ];


        return response()->json(['message' => 'success', 'data' => $data]);   
    }

public function detailPhaseProjectByUserId($projectId, $userId)
{
    $phases = Phase::where('id_project', $projectId)->get();
    $result = [];

    foreach ($phases as $phase) {
        $start = Carbon::parse($phase->start_date);
        $end = Carbon::parse($phase->end_date);
        $dates = [];

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $laporanExists = \App\Models\LaporanPhase::where('id_phase', $phase->id)
                ->where('id_user', $userId)
                ->whereDate('tanggal', $date->toDateString())
                ->exists();

            $dates[] = [
                'tanggal' => $date->toDateString(),
                'status' => $laporanExists ? 1 : 0
            ];
        }

        $result[] = [
            'phase_id' => $phase->id,
            'phase_name' => $phase->phase,
            'tanggal_status' => $dates
        ];
    }

    return response()->json(['message' => 'success', 'data' => $result]);
}


    public function createProject(Request $request)
    {
        // Validasi data
        $dataValidate = $request->validate([
            'client' => 'required', 
            'project' => 'required',
            'dueDate' => 'required',
            'phases' => 'required|array', // Validasi phases sebagai array
            'phases.*.phase' => 'required|string',
            'phases.*.start_date' => 'required|date',
            'phases.*.end_date' => 'required|date',
            'deliverables' => 'required|array', // Validasi deliverables sebagai array
            'deliverables.*.deliverable' => 'required|string',
            'deliverables.*.file' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048', // Menambahkan validasi file
            'deliverables.*.notes' => 'required',
            'users.*.id' => 'required',
        ]);

        DB::beginTransaction();

        try {
            // Buat project baru
            $project = Project::create([
                'client' => $dataValidate['client'], 
                'project' => $dataValidate['project'],
                'dueDate' => $dataValidate['dueDate']
            ]);

            // Tambahkan phases ke dalam project
            foreach ($dataValidate['phases'] as $phase) {
                Phase::create([
                    'phase' => $phase['phase'],
                    'start_date' => $phase['start_date'],
                    'end_date' => $phase['end_date'],
                    'id_project' => $project->id
                ]);
            }
            foreach ($dataValidate['users'] as $user) {
                UserProject::create([
                    'userId' => $user['id'],
                    'projectId' => $project->id
                ]);
            }

            // Tambahkan deliverables ke dalam project
            foreach ($dataValidate['deliverables'] as $deliverable) {
                // Simpan file ke dalam storage
                $file = $deliverable['file'];
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('deliverables', $fileName);

                Deliverable::create([
                    'deliverable' => $deliverable['deliverable'],
                    'file' => $fileName,
                    'notes' => $deliverable['notes'],
                    'id_project' => $project->id
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'success'], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'failed', 'error' => $e->getMessage()], 500);
        }
    }

    public function updateProject(Request $request, $id)
    {
        $dataValidate = $request->validate([
            'client' => 'required', 
            'project' => 'required', 
            'status' => 'required'
        ]);

        $dataProject = Project::find($id);
        $dataProject->client = $dataValidate['client'];
        $dataProject->project = $dataValidate['project'];
        $dataProject->status = $dataValidate['status'];
        $dataProject->save();

        return response()->json(['message' => 'success'], 200);
    }

    public function actionProject(Request $request)
    {
        $dataValidate = $request->validate([ 
            'status' => 'required', 
            'id' => 'required'
        ]);

        $dataProject = Project::find($dataValidate['id']);
        $dataProject->status = $dataValidate['status'];
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
