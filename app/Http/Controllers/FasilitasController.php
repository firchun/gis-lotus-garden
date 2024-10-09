<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Tiket;
use App\Models\TiketItems;
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

        // Handle file upload if a new file is present
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = $foto->store('public/foto');
            $fasilitasData['foto'] = 'foto/' . basename($fotoPath);
        }

        // If updating an existing record
        if ($request->filled('id')) {
            $Fasilitas = Fasilitas::find($request->input('id'));

            if (!$Fasilitas) {
                return response()->json(['message' => 'Fasilitas not found'], 404);
            }

            // Only update 'foto' if a new file is uploaded
            if (!$request->hasFile('foto')) {
                $fasilitasData['foto'] = $Fasilitas->foto; // Retain the existing 'foto' value
            }

            $Fasilitas->update($fasilitasData);
            $message = 'Fasilitas updated successfully';
        }
        // If creating a new record
        else {
            Fasilitas::create($fasilitasData);
            $message = 'Fasilitas created successfully';
        }

        return response()->json(['message' => $message]);
    }

    public function destroy($id)
    {
        $fasilitas = Fasilitas::find($id);

        TiketItems::where('id_fasilitas', $id)->delete();

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
