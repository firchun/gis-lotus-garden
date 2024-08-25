<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::latest()->first();
        $data = [
            'title' => 'Pengaturan Website',
            'setting' => $setting,
        ];
        return view('admin.setting.index', $data);
    }
    public function update(Request $request)
    {
        $setting = Setting::first();
        if ($request->has('about')) {
            $setting->about = $request->input('about');
        }
        if ($request->has('no_hp')) {
            $setting->no_hp = $request->input('no_hp');
        }
        if ($request->has('alamat')) {
            $setting->alamat = $request->input('alamat');
        }
        if ($request->has('harga_tiket')) {
            $setting->harga_tiket = $request->input('harga_tiket');
        }
        $setting->save();
        return back()->with('success', 'Berhasil memperbaharui pengaturan website');
    }
}
