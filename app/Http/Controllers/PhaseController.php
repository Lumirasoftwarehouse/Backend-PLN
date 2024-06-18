<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phase;

class PhaseController extends Controller
{
    public function createPhase(Request $request)
    {
        $validateData = $request->validate([
            'phase' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'id_project' => 'required'
        ]);

        Phase::create([
            'phase' => $validateData['phase'],
            'start_date' => $validateData['start_date'],
            'end_date' => $validateData['end_date'],
        ]);

        return response()->json(['message' => 'success'],200);
    }

    public function phaseByProject($id)
    {
        $dataPhaseByProject = Phase::where('id_project', $id)->get();

        return response()->json(['message' => 'success', 'data' => $dataPhaseByProject], 200);
    }

    public function updatePhase(Request $request, $id)
    {
        $validateData = $request->validate([
            'phase' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'id_project' => 'required'
        ]);

        $dataPhase = Phase::find($id);
        $dataPhase->phase = $validateData['phase'];
        $dataPhase->start_date = $validateData['start_date'];
        $dataPhase->end_date = $validateData['end_date'];
        $dataPhase->id_project = $validateData['id_project'];
        $dataPhase->save();

        return response()->json(['message' => 'success'], 200);
    }
    
    public function deletePhase($id)
    {
        $dataPhase = Phase::find($id);   
        $dataPhase->delete();
        
        return response()->json(['message' => 'success'], 200);
    }
}
