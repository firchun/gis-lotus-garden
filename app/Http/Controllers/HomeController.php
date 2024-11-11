<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Tiket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //chart
        // Mendapatkan tanggal saat ini dan 4 minggu sebelumnya

        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subMonth();

        $data = DB::table('tiket')
            ->select(DB::raw("DATE(tanggal) as day, COUNT(*) as total"))
            // ->whereBetween(DB::raw("DATE(tanggal)"), [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->where('status', 'Terpakai')
            ->groupBy(DB::raw("DATE(tanggal)"))
            ->orderBy('day')
            ->get();

        // Mengubah data untuk dikirim ke frontend
        $days = [];
        $totals = [];

        foreach ($data as $item) {
            $days[] = $item->day;
            $totals[] = $item->total;
        }

        $data = [
            'title' => 'Dashboard',
            'days' => $days,
            'totals' => $totals,
            'users' => User::count(),
            'tiket' => Tiket::count(),
            'tiket_pending' => Tiket::where('status', 'Pending')->count(),
            'tiket_terpakai' => Tiket::where('status', 'Terpakai')->count(),
            'pendapatan' => Tiket::where('status', 'Terpakai')->sum('total_harga'),
        ];
        return view('admin.dashboard', $data);
    }
}
