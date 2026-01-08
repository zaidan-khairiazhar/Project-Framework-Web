<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kota;

class KotaController extends Controller
{
    public function index()
    {
        $kota = Kota::with('propinsi')->get();
        return response()->json([
            'success' => true,
            'message' => 'List Data Kota',
            'data'    => $kota
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'propinsi_id' => 'required',
            'nama_kota'   => 'required',
        ]);

        $kota = Kota::create([
            'propinsi_id' => $request->propinsi_id,
            'nama_kota'   => $request->nama_kota
        ]);

        if($kota) {
            return response()->json([
                'success' => true,
                'message' => 'Kota Created',
                'data'    => $kota
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kota Failed to Save',
            ], 409);
        }
    }

    public function show($id)
    {
        $kota = Kota::with('propinsi')->whereId($id)->first();

        if ($kota) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Kota',
                'data'    => $kota
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kota Not Found',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'propinsi_id' => 'required',
            'nama_kota'   => 'required',
        ]);

        $kota = Kota::findOrFail($id);
        
        $kota->update([
            'propinsi_id' => $request->propinsi_id,
            'nama_kota'   => $request->nama_kota
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kota Updated',
            'data'    => $kota
        ], 200);
    }

    public function destroy($id)
    {
        $kota = Kota::findOrFail($id);
        $kota->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kota Deleted',
        ], 200);
    }
}
