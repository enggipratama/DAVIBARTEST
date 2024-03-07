<!doctype html>
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

    <!-- FAVICON -->
    @if ($web->web_logo == '' || $web->web_logo == 'default.png')
        <link rel="shortcut icon" type="image/x-icon" href="{{ url('/assets/default/web/default.png') }}" />
    @else
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/web/' . $web->web_logo) }}" />
    @endif

    <title>{{ $title }}</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
            text-align: left;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
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

    <div style="font-size: 0.7em;">
        <strong>Kode Invoice: <span style="color: #09d636;">{{ $results->first()->kode_inv }}</span></strong>
        <br><strong>Dari: </strong>{{ $web->web_nama }}
        <br>{{ $web->web_alamat }}
        <br>{{ $web->web_tlpn }}
    </div>
    <div style="font-size: 0.7em; ">
        <br><strong>Ke: </strong>{{ Session::get('user')->user_nmlengkap }}
        <br>{{ Session::get('user')->user_alamat }}
        <br>{{ Session::get('user')->user_notlp }}
        <br>
        <br><strong>Status: <span
            style="color: 
    @if ($results->first()['status'] == 'Pending') yellow;
    @elseif($results->first()['status'] == 'Dikirim') green;
    @elseif($results->first()['status'] == 'Selesai') blue;
    @elseif($results->first()['status'] == 'Dibatalkan') red;
    @else black; @endif
">{{ $results->first()['status'] }}</strong></span>

    </div>
    <br>

    <table width="100%">
        <thead style="background-color: lightgray;">
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalHarga = 0; // Initialize total harga variable outside the loop
            @endphp
            @foreach ($results as $result)
                <tr>
                    <td>{{ $result->barang_nama }}</td>
                    <td>Rp. {{ number_format($result->barang_harga, 0, ',', '.') }}</td>
                    <td>{{ $result->pesan_jumlah }} {{ $result->satuan_nama }}</td>
                    <td>Rp. {{ number_format($result->pesan_jumlah * $result->barang_harga, 0, ',', '.') }}</td>
                </tr>
                @php
                    $totalHarga += $result->pesan_jumlah * $result->barang_harga; // Accumulate the total harga
                @endphp
            @endforeach
        </tbody>

        <tfoot>
            <tr style="background-color: lightgray;">
                <td colspan="3" align="right"> Total Harga</td>
                <td colspan="4" align="left"> Rp. {{ number_format($totalHarga, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>


</body>

</html>
