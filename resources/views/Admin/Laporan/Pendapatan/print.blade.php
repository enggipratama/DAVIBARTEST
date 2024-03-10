<!DOCTYPE html>
<html lang="en">

<?php

use App\Models\Admin\BarangkeluarModel;
use App\Models\Admin\BarangmasukModel;
use Carbon\Carbon;
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $web->web_deskripsi }}">
    <meta name="author" content="{{ $web->web_nama }}">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- FAVICON -->
    @if ($web->web_logo == '' || $web->web_logo == 'default.png')
        <link rel="shortcut icon" type="image/x-icon" href="{{ url('/assets/default/web/default.png') }}" />
    @else
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/web/' . $web->web_logo) }}" />
    @endif

    <title>{{ $title }}</title>

    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        #table1 {
            border-collapse: collapse;
            width: 100%;
            margin-top: 32px;
        }

        #table1 td,
        #table1 th {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: x-small;
        }

        #table1 th {
            padding-top: 12px;
            padding-bottom: 12px;
            color: black;
            font-size: 12px;
            font-size: x-small;
        }

        #table1 td {
            font-size: 11px;
            font-size: x-small;
        }

        .font-medium {
            font-weight: 500;
        }

        .font-bold {
            font-weight: 600;
        }

        .d-2 {
            display: flex;
            align-items: flex-start;
            margin-top: 32px;
        }
        body {
            margin: 0;
            padding: 0;
        }
        .container {
            text-align: right;
            padding: 10px;
            background-color: #f0f0f0;
        }

        b {
            font-size: 15px;
        }
        hr {
            border: 1px solid #ccc;
            margin: 10px;
        }

        .logo-container {
            text-align: center;
        }

        .logo-container img {
            width: 50px;
            border-radius: 10%;
        }
    </style>

</head>

<body onload="window.print()">

    <div class="logo-container">
        @if ($web->web_logo == '' || $web->web_logo == 'default.png')
            <img src="{{ url('/assets/default/web/default.png') }}" alt="">
        @else
            <img src="{{ asset('storage/web/' . $web->web_logo) }}" alt="">
        @endif
        <div class="text-center">
            <h3 style="font-size: 0.8em;">{{ $web->web_nama }}</h3>
            <p style="font-size: 0.7em;">{{ $web->web_alamat }}. No.Tlp {{ $web->web_tlpn }}</p>
        </div>
    </div>
    <hr>

    <center>
        <h3 >Laporan Pendapatan</h3>
        @if ($tglawal == '')
            <h4 class="font-medium">Semua Tanggal</h4>
        @else
            <h4 class="font-medium">{{ Carbon::parse($tglawal)->translatedFormat('d F Y') }} -
                {{ Carbon::parse($tglakhir)->translatedFormat('d F Y') }}</h4>
        @endif
    </center>

    <table border="1" id="table1">
        <thead>
            <tr style="background-color: lightgray;">
                <th align="center" width="1%">NO</th>
                <th>KODE BARANG</th>
                <th>BARANG</th>
                <th>STOK KELUAR</th>
                <th>HARGA SATUAN</th>
                <th>TOTAL RP.</th>
                <th>TOTAL disc</th>
            </tr>
        </thead>
        <tbody>
            @php $no=1; @endphp
            @foreach ($stokData as $d)
                <tr>
                    <td align="center">{{ $no++ }}</td>
                    <td>{{ $d['barang_kode'] }}</td>
                    <td>{{ $d['barang_nama']}}</td>
                    <td align="center">{{ $d['jmlkeluar'] }}</td>
                    <td>Rp. {{ number_format($d['barang_harga'], 0, ',', '.') }} / {{ $d['satuan'] }}</td>
                    <td>Rp. {{ number_format($d['totalStokRP'], 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($d['diskon_total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: lightgray;">
                <td colspan="5" align="right" ><strong> Total </strong></td>
                <td colspan="1" align="left"><strong> Rp. {{ number_format($totalStokRPTotal, 0, ',', '.') }}</strong></td>
                <td colspan="0" align="left"><strong> Rp. <span id="total-harga" style="color: rgb(228, 115, 9);">- {{ number_format($diskon, 0, ',', '.') }}</strong></td>
            </tr>
            <tr style="background-color: lightgray;">
                <td colspan="5" align="right" ></td>
                <td colspan="1" align="right"><strong><b> Total</b></strong></td>
                <td colspan="0" align="left"><strong><b> Rp. {{ number_format($totalStokRPTotal-$diskon, 0, ',', '.') }}</b></strong></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
