<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use App\Models\Setting;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::all();
        $fasilitas->map(function ($item) {
            $item->photo_url = Storage::url($item->foto);
            return $item;
        });
        $data = [
            'title' => 'Home',
            'fasilitas' => $fasilitas,
        ];
        return view('pages.index', $data);
    }
    public function about()
    {
        $data = [
            'title' => 'About',
            'about' => Setting::latest()->first(),
        ];
        return view('pages.about', $data);
    }
    public function maps()
    {
        $fasilitas = Fasilitas::all();
        $fasilitas->map(function ($item) {
            $item->photo_url = Storage::url($item->foto);
            return $item;
        });
        $data = [
            'title' => 'Maps',
            'fasilitas' => $fasilitas,
        ];
        return view('pages.maps', $data);
    }
    public function tiket()
    {
        $data = [
            'title' => 'Check Tiket'
        ];
        return view('pages.tiket', $data);
    }
    public function search_tiket(Request $request)
    {
        $barcode = $request->input('barcode');
        $tiket = Tiket::where('barcode', $barcode)->first();
        if ($tiket) {
            return redirect()->route('detail-tiket', ['barcode' => $tiket->barcode]);
        } else {
            return back()->with('error', 'Tiket tidak ditemukan')->withInput();
        }
    }
    public function detail_tiket($barcode)
    {
        $data = [
            'title' => 'Detail Tiket : ' . $barcode,
            'tiket' => Tiket::where('barcode', $barcode)->first()
        ];
        return view('pages.detail-tiket', $data);
    }
    public function form()
    {
        $data = [
            'title' => 'Formulir Pemesanan Tiket Wisata',
            'setting' => Setting::latest()->first(),
        ];
        return view('pages.form-pemesanan', $data);
    }
    public function fasilitas()
    {
        $data = [
            'title' => 'Fasilitas Wisata',
            'fasilitas' => Fasilitas::latest()->paginate(6)
        ];
        return view('pages.fasilitas', $data);
    }
    public function detail($slug)
    {
        $fasilitas = Fasilitas::where('slug', $slug)->first();
        $data = [
            'title' => 'Fasilitas : ' . $fasilitas->nama,
            'fasilitas' => $fasilitas,
        ];
        return view('pages.detail-fasilitas', $data);
    }
}
