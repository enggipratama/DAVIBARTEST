<!DOCTYPE html>
<html lang="en">

<?php

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
        }

        #table1 th {
            padding-top: 12px;
            padding-bottom: 12px;
            color: black;
            font-size: 12px;
        }

        #table1 td {
            font-size: 11px;
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
    </style>

</head>

<body onload="window.print()">
    <div style="display: flex; align-items: center; ">
        @if ($web->web_logo == '' || $web->web_logo == 'default.png')
            <img src="{{ url('/assets/default/web/default.png') }}" width="50px" alt=""
                style="margin-left: 10px; border-radius: 10%; ">
        @else
            <img src="{{ asset('storage/web/' . $web->web_logo) }}" width="50px" alt=""
                style="margin-left: 10px; border-radius: 10%; ">
        @endif
        <h4 style="margin-left: 10px; text-align: center;">{{ $web->web_nama }}</h4>
    </div>
    <div style="margin-left: 10px; border-top: 2px solid black; margin-top: 10px;">
        <!-- Konten atau elemen lainnya dapat ditambahkan di sini -->
    </div>

    <center>
        <h3>Laporan Barang Keluar</h3>
        @if ($tglawal == '')
            <h4 class="font-medium">Semua Tanggal</h4>
        @else
            <h4 class="font-medium">{{ Carbon::parse($tglawal)->translatedFormat('d F Y') }} -
                {{ Carbon::parse($tglakhir)->translatedFormat('d F Y') }}</h4>
        @endif
    </center>


    <table border="1" id="table1">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th align="center" width="1%">NO</th>
                <th>TGL KELUAR</th>
                <th>KODE BRG KELUAR</th>
                <th>KODE BARANG</th>
                <th>BARANG</th>
                <th>JML KELUAR</th>
                <th>TUJUAN</th>
                <th>HARGA SATUAN</th>
                <th>TOTAL RP.</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalStokRPTotal = 0;
            @endphp
            @php $no=1; @endphp
            @foreach ($data as $d)
                <?php
                $totalStokRP = $d->barang_harga * $d->bk_jumlah;
                $totalStokRPTotal += $totalStokRP;
                ?>
                <tr>
                    <td align="center">{{ $no++ }}</td>
                    <td>{{ Carbon::parse($d->bk_tanggal)->translatedFormat('d F Y') }}</td>
                    <td>{{ $d->bk_kode }}</td>
                    <td>{{ $d->barang_kode }}</td>
                    <td>{{ $d->barang_nama }}</td>
                    <td align="center">{{ $d->bk_jumlah }}</td>
                    <td>{{ $d->bk_tujuan }}</td>
                    <td>Rp. {{ number_format($d->barang_harga, 0, ',', '.') }} / {{ $d->satuan->satuan_nama }}</td>
                    <td>Rp. {{ number_format($totalStokRP, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="container ">
        <b>Total : Rp. {{ number_format($totalStokRPTotal, 0, ',', '.') }}</b>
    </div>
</body>

</html>
