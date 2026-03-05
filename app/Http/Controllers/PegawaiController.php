<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawai = Pegawai::all();
        return view('pegawai.pegawai', compact('pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'nip' => 'required|size:5|unique:pegawais,nip',
            'email' => 'required|email|max:255|unique:pegawais,email',
            'bidang' => 'required|max:255'
        ]);

        Pegawai::create($validated);

        return redirect('/pegawai')->with('success', 'Data pegawai berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawai.edit', compact('pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'nip' => 'required|size:5|unique:pegawais,nip,' . $id,
            'email' => 'required|email|max:255|unique:pegawais,email,' . $id,
            'bidang' => 'required|max:255'
        ]);

        $pegawai->update($validated);

        return redirect('/pegawai')->with('success', 'Data pegawai berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();

        return redirect('/pegawai')->with('success', 'Data pegawai berhasil dihapus!');
    }
}
