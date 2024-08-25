<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Str;

class FasilitasController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Fasilitas',
        ];
        return view('admin.fasilitas.index', $data);
    }
    public function getFasilitasDataTable()
    {
        $fasilitas = Fasilitas::orderByDesc('id');

        return DataTables::of($fasilitas)
            ->addColumn('action', function ($fasilitas) {
                return view('admin.fasilitas.components.actions', compact('fasilitas'));
            })
            ->addColumn('foto', function ($fasilitas) {
                return '<img src="' . Storage::url($fasilitas->foto) . '" style="width:100px;">';
            })


            ->rawColumns(['action', 'foto'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'type' => 'required|string',
        ]);

        $fasilitasData = [
            'nama' => $request->input('nama'),
            'keterangan' => $request->input('keterangan'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'type' => $request->input('type'),
            'harga' => $request->input('harga'),
            'slug' => Str::slug($request->input('nama')),
        ];
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = $foto->store('public/foto');
            $fasilitasData['foto'] = 'foto/' . basename($fotoPath);
        }
        if ($request->filled('id')) {
            $Fasilitas = Fasilitas::find($request->input('id'));
            if (!$Fasilitas) {
                return response()->json(['message' => 'Fasilitas not found'], 404);
            }

            $Fasilitas->update($fasilitasData);
            $message = 'Fasilitas updated successfully';
        } else {
            Fasilitas::create($fasilitasData);
            $message = 'Fasilitas created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function destroy($id)
    {
        $fasilitas = Fasilitas::find($id);

        if (!$fasilitas) {
            return response()->json(['message' => 'Fasilitas not found'], 404);
        }
        // Ambil path file foto
        $fotoPath = $fasilitas->foto_path;

        // Hapus entitas dari database
        $fasilitas->delete();

        if ($fotoPath && Storage::exists($fotoPath)) {
            Storage::delete($fotoPath);
        }

        return response()->json(['message' => 'Fasilitas deleted successfully']);
    }
    public function edit($id)
    {
        $fasilitas = Fasilitas::find($id);

        if (!$fasilitas) {
            return response()->json(['message' => 'fasilitas not found'], 404);
        }
        // Add photo URL if the photo exists
        $fasilitas->photo_url = $fasilitas->foto ? Storage::url($fasilitas->foto) : null;

        return response()->json($fasilitas);
    }
}
