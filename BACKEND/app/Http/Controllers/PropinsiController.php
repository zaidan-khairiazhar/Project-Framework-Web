<?php

namespace App\Http\Controllers; // [cite: 465]

use Illuminate\Http\Request; // [cite: 466]
use App\Models\Propinsi; // [cite: 467]

class PropinsiController extends Controller // [cite: 468]
{
    /**
     * Menampilkan daftar data propinsi dengan paginasi.
     */
    public function index() // [cite: 474]
    {
        $propinsi = Propinsi::orderBy('id', 'DESC')->paginate(5); // [cite: 477]
        return view('propinsi.index', compact('propinsi')); // [cite: 477]
    }

    /**
     * Menampilkan form untuk menambah data propinsi baru.
     */
    public function create() // [cite: 565]
    {
        return view('propinsi.create'); // [cite: 567]
    }

    /**
     * Menyimpan data propinsi baru ke database.
     */
    public function store(Request $request) // [cite: 574]
    {
        $this->validate($request, [ // [cite: 576]
            'propinsi' => 'required', // [cite: 577]
        ]);

        Propinsi::create($request->all()); // [cite: 580]

        return redirect()->route('propinsi.index') // [cite: 581]
            ->with('message', 'Propinsi baru berhasil ditambahkan!'); // [cite: 582, 583]
    }

    /**
     * Menampilkan form untuk mengubah data propinsi.
     */
    public function edit($id) // [cite: 619]
    {
        $propinsi = Propinsi::findOrFail($id); // [cite: 621]
        return view('propinsi.edit', compact('propinsi')); // [cite: 622]
    }

    /**
     * Memperbarui data propinsi yang sudah ada.
     */
    public function update(Request $request, $id) // [cite: 631]
    {
        $this->validate($request, [ // [cite: 633]
            'propinsi' => 'required', // [cite: 634]
        ]);

        Propinsi::findOrFail($id)->update($request->all()); // [cite: 637, 638]

        return redirect()->route('propinsi.index') // [cite: 640]
            ->with('message', 'Propinsi baru berhasil diubah!'); // [cite: 641]
    }

    /**
     * Menampilkan detail satu data propinsi.
     */
    public function show($id) // [cite: 670]
    {
        $propinsi = Propinsi::findOrFail($id); // [cite: 672]
        return view('propinsi.show', compact('propinsi')); // [cite: 674]
    }
}