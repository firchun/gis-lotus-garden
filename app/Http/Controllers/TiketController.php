<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;

class TiketController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'jumlah' => 'required|integer|min:1',
            'total_harga' => 'required|integer',
            'keterangan' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);



        $barcode = Str::random(10);

        // Generate barcode image
        $generator = new BarcodeGeneratorPNG();
        $barcodeImage = $generator->getBarcode($barcode, $generator::TYPE_CODE_128);

        // Save the barcode image
        $barcodePath = 'barcodes/' . $barcode . '.png';
        Storage::put($barcodePath, $barcodeImage);

        DB::beginTransaction();

        try {
            $tiket = new Tiket();
            $tiket->nama = $request->input('nama');
            $tiket->no_hp = $request->input('no_hp');
            $tiket->keterangan = $request->input('keterangan') ?: '-';
            $tiket->tanggal = $request->input('tanggal');
            $tiket->total_harga = $request->input('total_harga');;
            $tiket->jumlah = $request->input('jumlah');
            $tiket->barcode = $barcode;
            $tiket->save();

            // Commit the transaction
            DB::commit();

            // return redirect()->route('detail-tiket', ['barcode' => $barcode])
            //     ->with('success', 'Tiket berhasil disimpan.');
            // Redirect to detail page and trigger PDF download
            return redirect()->route('detail-tiket', ['barcode' => $barcode])
                ->with('success', 'Tiket berhasil disimpan.')
                ->with('downloadPdf', route('download-tiket', ['barcode' => $barcode]));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan tiket: ' . $e->getMessage());
        }
    }
    public function downloadPdf($barcode)
    {
        // Retrieve the ticket using the barcode
        $tiket = Tiket::where('barcode', $barcode)->firstOrFail();
        $imageData = $this->base64_encode_image(public_path('img/logo.png'));
        $barcode = $this->base64_encode_image(Storage_path('app/barcodes/' . $tiket->barcode . '.png'));
        // Load the view and pass the ticket data
        $pdf = PDF::loadView('pages.tiket.pdf', [
            'tiket' => $tiket,
            'logo' => $imageData,
            'barcode' => $barcode
        ]);

        // Set options for the PDF (you may adjust this as needed)
        $pdf->setPaper('A4', 'landscape')
            ->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);

        // Download the PDF
        return $pdf->download('tiket-' . $tiket->barcode . '.pdf');
    }
    function base64_encode_image($path)
    {
        $image = file_get_contents($path);
        return 'data:image/png;base64,' . base64_encode($image);
    }
    public function index()
    {
        $data = [
            'title' => 'Data Tiket',

        ];
        return view('admin.tiket.index', $data);
    }
    public function update_tiket()
    {
        $data = [
            'title' => 'Update Tiket',
            'harga_tiket' => Setting::latest()->first()->harga_tiket,

        ];
        return view('admin.tiket.update', $data);
    }
    public function getOne($barcode)
    {
        $tiket = Tiket::where('barcode', $barcode)->first();

        if ($tiket) {
            if ($tiket->status != 'Pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Tiket telah ' . $tiket->status
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'data' => $tiket
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak ditemukan'
            ]);
        }
    }
    public function update(Request $request)
    {
        $barcode = $request->input('barcode');
        $tiket = Tiket::where('barcode', $barcode)->first();
        $tiket->status = 'Terpakai';
        $tiket->jumlah = $request->input('jumlah');
        $tiket->save();

        return back()->with('success', 'Tiket : ' . $barcode . ' Berhasil diupdate');
    }
    public function getTiketDataTable()
    {
        $tiket = Tiket::orderByDesc('id');

        return DataTables::of($tiket)

            ->addColumn('created', function ($tiket) {
                return $tiket->created_at->format('d/m/Y');
            })
            ->rawColumns(['created'])
            ->make(true);
    }
}
