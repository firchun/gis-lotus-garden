<?php

namespace App\Http\Controllers;

use App\Models\Tiket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class LaporanController extends Controller
{
    public function keuangan()
    {
        $data = [
            'title' => 'Laporan Keuangan'
        ];
        return view('admin.laporan.keuangan', $data);
    }
    public function tiket()
    {
        $data = [
            'title' => 'Laporan Pemesanan Tiket'
        ];
        return view('admin.laporan.tiket', $data);
    }
    public function print_tiket(Request $request)
    {
        $tiket = Tiket::orderByDesc('id');
        if ($request->input('status') != '' && $request->has('status')) {
            $tiket = $tiket->where('status', $request->input('status'));
        }
        if ($request->has('from_date') && $request->from_date) {
            $startDate = Carbon::parse($request->from_date)->startOfDay();
            $tiket->where('created_at', '>=', $startDate);
        }

        if ($request->has('to_date') && $request->to_date) {
            $endDate = Carbon::parse($request->to_date)->endOfDay();
            $tiket->where('created_at', '<=', $endDate);
        }
        $data = $tiket->get();

        $pdf = PDF::loadview('admin/laporan/pdf/tiket', ['data' => $data])->setPaper("A4", "portrait");
        return $pdf->stream('laporan_tiket_' . date('His') . '.pdf');
    }
    public function print_keuangan(Request $request)
    {
        $tiket = Tiket::where('status', 'Terpakai')->orderByDesc('id');

        if ($request->has('from_date') && $request->from_date) {
            $startDate = Carbon::parse($request->from_date)->startOfDay();
            $tiket->where('created_at', '>=', $startDate);
        }

        if ($request->has('to_date') && $request->to_date) {
            $endDate = Carbon::parse($request->to_date)->endOfDay();
            $tiket->where('created_at', '<=', $endDate);
        }
        $data = $tiket->get();

        $pdf = PDF::loadview('admin/laporan/pdf/keuangan', ['data' => $data])->setPaper("A4", "portrait");
        return $pdf->stream('laporan_keuangan_' . date('His') . '.pdf');
    }
}
