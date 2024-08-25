@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h2 class="text-center">{{ $title }}</h3>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="mb-4 d-flex justify-content-end">
                        <a href="{{ route('download-tiket', ['barcode' => $tiket->barcode]) }}"
                            class="btn btn-sm btn-danger">Download ulang Tiket</a>
                    </div>
                    <img src="{{ url('barcode/' . $tiket->barcode . '.png') }}" alt="Barcode" style="width: 100%;">
                    <div class="mt-3">
                        <table class="table table-hover">
                            <tr>
                                <td>Tiket</td>
                                <td><b>{{ $tiket->barcode }}</b></td>
                            </tr>
                            <tr>
                                <td>Nama</td>
                                <td>{{ $tiket->nama }}</td>
                            </tr>
                            <tr>
                                <td>No HP/WA</td>
                                <td>{{ $tiket->no_hp }}</td>
                            </tr>
                            <tr>
                                <td>Jumlah Pengunjung</td>
                                <td>{{ $tiket->jumlah }} Pengunjung</td>
                            </tr>
                            <tr>
                                <td>Tanggal Kunjungan</td>
                                <td>{{ $tiket->tanggal }} <span
                                        class="badge {{ $tiket->status == 'Pending' ? 'badge-warning' : 'badge-danger' }}">{{ $tiket->status }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Tagihan</td>
                                <td>
                                    <h2 class="text-danger">Rp {{ number_format($tiket->total_harga) }}</h2>
                                </td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>{{ $tiket->keterangan }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
    @if (session('downloadPdf'))
        <script>
            window.onload = function() {
                window.open('{{ session('downloadPdf') }}');
            }
        </script>
    @endif
@endsection
