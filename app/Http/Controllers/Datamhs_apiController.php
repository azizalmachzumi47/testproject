<?php

namespace App\Http\Controllers;

use App\Models\Datamhs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Datamhs_apiController extends Controller
{
    public function index()
    {
        $mahasiswa = Datamhs::all();
        return response()->json($mahasiswa);
    }

    public function show($id)
    {
        $mahasiswa = Datamhs::find($id);
        
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        return response()->json($mahasiswa);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|unique:datamhs,nim',
            'nama' => 'required',
            'tanggal' => 'required|date',
        ]);

        $mahasiswa = Datamhs::create($validated);
        return response()->json($mahasiswa, 201);
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Datamhs::find($id);
        
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'nim' => 'required|unique:datamhs,nim,' . $mahasiswa->id,
            'nama' => 'required',
            'tanggal' => 'required|date',
        ]);

        $mahasiswa->update($validated);
        return response()->json($mahasiswa);
    }

    public function destroy($id)
    {
        $mahasiswa = Datamhs::find($id);
        
        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa tidak ditemukan'], 404);
        }

        $mahasiswa->delete();
        return response()->json(['message' => 'Data mahasiswa berhasil dihapus']);
    }

    public function searchByName($name)
    {
        $mahasiswa = Datamhs::where('nama', 'like', '%' . $name . '%')->get();

        if ($mahasiswa->isEmpty()) {
            return response()->json(['message' => 'Mahasiswa dengan nama ' . $name . ' tidak ditemukan'], 404);
        }

        return response()->json($mahasiswa);
    }

    public function searchByNim($nim)
    {
        $mahasiswa = Datamhs::where('nim', $nim)->first();

        if (!$mahasiswa) {
            return response()->json(['message' => 'Mahasiswa dengan NIM ' . $nim . ' tidak ditemukan'], 404);
        }

        return response()->json($mahasiswa);
    }

    public function searchByDate($date)
    {
        $mahasiswa = Datamhs::where('tanggal', $date)->get();

        if ($mahasiswa->isEmpty()) {
            return response()->json(['message' => 'Mahasiswa dengan tanggal ' . $date . ' tidak ditemukan'], 404);
        }

        return response()->json($mahasiswa);
    }

    public function fetchData()
    {
        $response = Http::get('https://ogienurdiana.com/career/ecc694ce4e7f6e45a5a7912cde9fe131');
    
        if ($response->successful()) {
            $data = $response->json();
    
            // Ambil isi 'DATA' dari response
            $raw = $data['DATA'];
    
            // Pisahkan per baris
            $rows = explode("\n", trim($raw));
    
            // Ambil header (NAMA|NIM|YMD)
            $header = explode("|", array_shift($rows));
    
            $result = [];
    
            foreach ($rows as $row) {
                $cols = explode("|", $row);
                $mapped = array_combine($header, $cols);
    
                // Reorder jadi YMD, NIM, NAMA
                $result[] = [
                    'YMD' => $mapped['YMD'] ?? '',
                    'NIM' => $mapped['NIM'] ?? '',
                    'NAMA' => $mapped['NAMA'] ?? '',
                ];
            }
    
            return response()->json($result);
        } else {
            return response()->json(['error' => 'Unable to fetch data'], 400);
        }
    }
    
    
    
    
    
    
}