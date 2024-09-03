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
        $startDate = $endDate->copy()->subWeeks(4);

        // Mengelompokkan tiket per minggu dengan tahun
        $data = DB::table('tiket')
            ->select(DB::raw('YEARWEEK(created_at, 1) as year_week, COUNT(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'Terpakai')
            ->groupBy(DB::raw('YEARWEEK(created_at, 1)'))
            ->orderBy('year_week')
            ->get();

        // Mengubah data untuk dikirim ke frontend
        $weeks = [];
        $totals = [];

        foreach ($data as $item) {
            $year = substr($item->year_week, 0, 4);
            $weekNumber = intval(substr($item->year_week, 4));

            // Format year_week menjadi Week X, YYYY
            $weeks[] = 'Minggu ' . $weekNumber . ', ' . $year;
            $totals[] = $item->total;
        }
        $data = [
            'title' => 'Dashboard',
            'weeks' => $weeks,
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
