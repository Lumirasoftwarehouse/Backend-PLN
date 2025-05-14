<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Divisi;
use App\Models\UserDivisi;
use App\Models\User;

class DivisiController extends Controller
{
    public function listDivisi()
    {
        $divisi = Divisi::with('atasan')->get();

        // Format data yang akan dikembalikan
        $data = $divisi->map(function ($item) {
            return [
                'id' => $item->id,
                'nama_divisi' => $item->nama_divisi,
                'nama_atasan' => $item->atasan ? $item->atasan->name : null, // Cek jika relasi null
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function listUserDivisi()
    {
        $divisi = Divisi::where('id_atasan', auth()->user()->id)->first();

        if (!$divisi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Divisi tidak ditemukan untuk atasan ini',
            ], 404);
        }

        // Mengambil user di divisi tersebut dengan relasi
        $usersInDivisi = UserDivisi::where('id_divisi', $divisi->id)
            ->with(['user', 'divisi'])
            ->get();

        // Mapping data untuk format respons JSON
        $data = $usersInDivisi->map(function ($item) {
            return [
                'id_user_divisi' => $item->id,
                'nama_user' => $item->user ? $item->user->name : null,
                'nama_divisi' => $item->divisi ? $item->divisi->nama_divisi : null,
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    public function createDivisi(Request $request)
    {
        $validateData = $request->validate([
            'nama_divisi' => 'required',
            'id_atasan' => 'required'
        ]);

        $divisi = Divisi::create($request->all());
        return response()->json([
            'id' => '1',
            'data' => $divisi
        ]);
    }

    public function createUserInDivisi(Request $request)
    {
        $validateData = $request->validate([
            'id_divisi' => 'required',
            'name' => 'required',
            'position' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $validateData['name'],
            'position' => $validateData['position'],
            'email' => $validateData['email'],
            'password' => bcrypt($validateData['password']),
        ]);

        $userDivisi = UserDivisi::create([
            'id_divisi' => $validateData['id_divisi'],
            'id_user' => $user->id,
        ]);

        return response()->json([
            'id' => '1',
            'data' => $userDivisi
        ]);
    }

    public function updateDivisi(Request $request, $id)
    {
        $divisi = Divisi::find($id);
        $divisi->update($request->all());
        return response()->json([
            'id' => '1',
            'data' => $divisi
        ]);
    }

    public function deleteDivisi($id)
    {
        $divisi = Divisi::find($id);
        $divisi->delete();
        return response()->json([
            'id' => '1',
            'data' => $divisi
        ]);
    }
}
