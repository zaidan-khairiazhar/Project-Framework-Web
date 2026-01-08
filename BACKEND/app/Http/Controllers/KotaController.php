<?php

namespace App\Http\Controllers; // [cite: 35]

use Illuminate\Http\Request; // [cite: 36]
use App\Models\Kota;
use App\Models\Propinsi; // [cite: 338]

class KotaController extends Controller // [cite: 37]
{
    /**
     * Menampilkan daftar kota dengan data propinsi terkait [cite: 39]
     */
    public function index()
    {
        // Mengambil data kota beserta relasi propinsinya 
        $kota = Kota::with('propinsi')->paginate(5);
        return view('kota.index', compact('kota')); // [cite: 339]
    }

    /**
     * Menampilkan form tambah kota dengan pilihan propinsi [cite: 43]
     */
    public function create()
    {
        $propinsi = Propinsi::all(); // Diperlukan untuk dropdown di view 
        return view('kota.create', compact('propinsi'));
    }

    /**
     * Menyimpan data kota baru [cite: 46]
     */
    public function store(Request $request) // [cite: 340]
    {
        $this->validate($request, [
            'propinsi_id' => 'required',
            'nama_kota' => 'required',
        ]);

        // Menyimpan semua input dari form [cite: 340]
        Kota::create($request->all()); 

        return redirect()->route('kota.index')
                         ->with('message', 'Kota berhasil ditambahkan!'); // [cite: 340]
    }

    /**
     * Menampilkan form ubah data kota [cite: 54]
     */
    public function edit($id)
    {
        $kota = Kota::findOrFail($id);
        $propinsi = Propinsi::all();
        return view('kota.edit', compact('kota', 'propinsi'));
    }

    /**
     * Memperbarui data kota di database [cite: 58]
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'propinsi_id' => 'required',
            'nama_kota' => 'required',
        ]);

        $kota = Kota::findOrFail($id);
        $kota->update($request->all()); // [cite: 340]

        return redirect()->route('kota.index')
                         ->with('message', 'Data kota berhasil diubah!'); // [cite: 340]
    }

    /**
     * Menghapus rekaman kota [cite: 62]
     */
    public function destroy($id)
    {
        $kota = Kota::findOrFail($id);
        $kota->delete();

        return redirect()->route('kota.index')
                         ->with('message', 'Kota berhasil dihapus!');
    }
}