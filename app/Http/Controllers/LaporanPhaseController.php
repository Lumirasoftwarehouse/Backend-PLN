<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanPhase;
use App\Models\Phase;

class LaporanPhaseController extends Controller
{
    public function listLaporanByIdProject($id)
    {
        // Ambil phases dan eager load relasi laporan dan user dari laporan
        $phases = Phase::with(['laporanPhases.user']) // eager load user dari laporan
            ->where('id_project', $id)
            ->get();

        // Format response
        $result = $phases->map(function ($phase) {
            return [
                'id_phase' => $phase->id,
                'phase_name' => $phase->phase,
                'start_date' => $phase->start_date,
                'end_date' => $phase->end_date,
                'laporans' => $phase->laporanPhases->map(function ($laporan) {
                    return [
                        'id' => $laporan->id,
                        'tanggal' => $laporan->tanggal,
                        'laporan' => $laporan->laporan,
                        'lampiran' => $laporan->lampiran,
                        'user' => [
                            'name' => $laporan->user->name ?? null,
                            'level' => $laporan->user->level ?? null,
                        ]
                    ];
                }),
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $result
        ]);
    }


    public function listLaporanByPhase(Request $request)
    {
        $validateData = $request->validate([
            'id_phase' => 'required',
            'tanggal' => 'required'
        ]);

        $laporan = LaporanPhase::where('id_phase', $validateData['id_phase'])->where('tanggal', $validateData['tanggal'])->get();

        return response()->json([
            'id' => '1',
            'data' => $laporan
        ]);
    }

    public function addLaporan(Request $request)
    {
        $validateData = $request->validate([
            'id_phase' => 'required',
            'tanggal' => 'required',
            'laporan' => 'required',
            'lampiran' => 'required|file|mimes:jpeg,png,jpg,gif,pdf,doc,docx|max:2048'
        ]);

        $lampiran = $validateData['lampiran'];
        $lampiran->storeAs('public/lampiran-laporan-phase', $lampiran->hashName());

        LaporanPhase::create([
            'id_phase' => $validateData['id_phase'],
            'id_user' => auth()->user()->id,
            'tanggal' => $validateData['tanggal'],
            'laporan' => $validateData['laporan'],
            'lampiran' => $lampiran->hashName()
        ]);

        return response()->json([
            'id' => '1',
            'data' => 'Laporan berhasil ditambahkan'
        ]);
    }

    public function updateLaporan(Request $request)
    {
        $validateData = $request->validate([
            'id' => 'required',
            'id_phase' => 'required',
            'id_user' => 'required',
            'tanggal' => 'required',
            'laporan' => 'required',
            'lampiran' => 'required'
        ]);

        LaporanPhase::where('id', $validateData['id'])->update([
            'id_phase' => $validateData['id_phase'],
            'id_user' => $validateData['id_user'],
            'tanggal' => $validateData['tanggal'],
            'laporan' => $validateData['laporan'],
            'lampiran' => $validateData['lampiran']
        ]);

        return response()->json([
            'id' => '1',
            'data' => 'Laporan berhasil diupdate'
        ]);
    }

    public function deleteLaporan(Request $request)
    {
        $validateData = $request->validate([
            'id' => 'required'
        ]);

        LaporanPhase::where('id', $validateData['id'])->delete();

        return response()->json([
            'id' => '1',
            'data' => 'Laporan berhasil dihapus'
        ]);
    }
}
