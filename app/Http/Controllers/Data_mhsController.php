<?php

namespace App\Http\Controllers;

use App\Models\Datamhs;
use Illuminate\Http\Request;

class Data_mhsController extends Controller
{
    public function index()
    {
        $data = Datamhs::all();
        return view('data_mhs.index', compact('data'));
    }

    public function adddatamhs(Request $request)
    {
        // Validasi data
        $request->validate([
            'nim' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
        ]);

        // Simpan data ke database
        Datamhs::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('data_mhs.index')->with('success', 'Data Mahasiswa berhasil ditambahkan!');
    }

    public function editdata($id)
    {
        $data = Datamhs::findOrFail($id);
        return view('data_mhs.edit', compact('data'));
    }

    public function editdata_action(Request $request, $id)
    {
        $request->validate([
            'nim' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
        ]);

        $data = Datamhs::findOrFail($id);
        $data->update([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('data_mhs.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function delete($id)
    {
        $data = Datamhs::findOrFail($id);
        $data->delete();

        return redirect()->route('data_mhs.index')->with('success', 'Data berhasil dihapus!');
    }

    public function dataapi()
    {
        return view('data_mhs.dataapi');
    }

    public function savedataapi(Request $request)
    {
        $data = $request->input('data');

        foreach ($data as $item) {
            Datamhs::updateOrCreate(
                [
                    'nim' => $item['nim'],
                    'nama' => $item['nama'],
                    'tanggal' => $item['tanggal']
                ]
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan ke database.',
            'redirect' => route('data_mhs.index')
        ]);
    }

    public function destroyAll()
    {
        Datamhs::truncate();
        return redirect()->route('data_mhs.index')->with('success', 'Semua data berhasil dihapus.');
    }
    

}