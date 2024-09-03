@php
    function terbilang($number)
    {
        $number = (int) $number;
        $words = [
            0 => 'Nol',
            1 => 'Satu',
            2 => 'Dua',
            3 => 'Tiga',
            4 => 'Empat',
            5 => 'Lima',
            6 => 'Enam',
            7 => 'Tujuh',
            8 => 'Delapan',
            9 => 'Sembilan',
            10 => 'Sepuluh',
            11 => 'Sebelas',
            12 => 'Dua Belas',
            13 => 'Tiga Belas',
            14 => 'Empat Belas',
            15 => 'Lima Belas',
            16 => 'Enam Belas',
            17 => 'Tujuh Belas',
            18 => 'Delapan Belas',
            19 => 'Sembilan Belas',
            20 => 'Dua Puluh',
            30 => 'Tiga Puluh',
            40 => 'Empat Puluh',
            50 => 'Lima Puluh',
            60 => 'Enam Puluh',
            70 => 'Tujuh Puluh',
            80 => 'Delapan Puluh',
            90 => 'Sembilan Puluh',
        ];

        if ($number < 20) {
            return $words[$number];
        } elseif ($number < 100) {
            $tens = intval($number / 10) * 10;
            $units = $number % 10;
            return $words[$tens] . ($units > 0 ? ' ' . $words[$units] : '');
        } elseif ($number < 1000) {
            $hundreds = intval($number / 100);
            $remainder = $number % 100;
            return $words[$hundreds] . ' Ratus' . ($remainder > 0 ? ' ' . terbilang($remainder) : '');
        } elseif ($number < 1000000) {
            $thousands = intval($number / 1000);
            $remainder = $number % 1000;
            return terbilang($thousands) . ' Ribu' . ($remainder > 0 ? ' ' . terbilang($remainder) : '');
        } elseif ($number < 1000000000) {
            $millions = intval($number / 1000000);
            $remainder = $number % 1000000;
            return terbilang($millions) . ' Juta' . ($remainder > 0 ? ' ' . terbilang($remainder) : '');
        } elseif ($number < 1000000000000) {
            $billions = intval($number / 1000000000);
            $remainder = $number % 1000000000;
            return terbilang($billions) . ' Miliar' . ($remainder > 0 ? ' ' . terbilang($remainder) : '');
        } else {
            $trillions = intval($number / 1000000000000);
            $remainder = $number % 1000000000000;
            return terbilang($trillions) . ' Triliun' . ($remainder > 0 ? ' ' . terbilang($remainder) : '');
        }
    }
@endphp

<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            width: 100%;
            background-color: red;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 40px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 400px;
            text-align: center;
        }

        .table {
            width: 100%;
            border: 0px;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 8px 12px;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            text-align: left;
            background-color: #f2f2f2;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: bold;
            color: #fff;
            text-align: center;
            border-radius: 4px;
        }

        .badge-warning {
            background-color: #ffc107;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .text-danger {
            color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="{{ $logo }}" alt="Logo">
        </div>
        <div class="header">
            <h1>TIKET MASUK WISATA</h1>
        </div>
        <img src="{{ $barcode }}" alt="barcode" style="width: 100%; margin-bottom:10px;">

        <table class="table">
            <tr>
                <th>Kode Tiket</th>
                <td><b>{{ $tiket->barcode }}</b></td>
            </tr>
            <tr>
                <th>Nama Pengunjung</th>
                <td>{{ $tiket->nama }}</td>
            </tr>

            <tr>
                <th>Jumlah Pengunjung</th>
                <td>Dewasa : {{ $tiket->jumlah_dewasa }}<br> Anak-anak : {{ $tiket->jumlah_anak }}</td>
            </tr>
            <tr>
                <th>Tanggal Kunjungan</th>
                <td>{{ $tiket->tanggal }}

                </td>
            </tr>
            <tr>
                <th>Biaya Masuk</th>
                <td>
                    <h2 class="text-danger" style="margin-bottom: 5px;">Rp {{ number_format($tiket->total_harga) }}</h2>
                    <small><i>({{ terbilang($tiket->total_harga) }} Rupiah)</i></small>
                </td>
            </tr>

        </table>


    </div>

</body>

</html>
