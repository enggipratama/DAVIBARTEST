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
    @if ($data->web_logo == '' || $data->web_logo == 'default.png')
        <link rel="shortcut icon" type="image/x-icon" href="{{ url('/assets/default/web/default.png') }}" />
    @else
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/web/' . $data->web_logo) }}" />
    @endif

    <title>Invoice Davibar House</title>

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
        @if ($data->web_logo == '' || $data->web_logo == 'default.png')
            <img src="{{ url('/assets/default/web/default.png') }}" alt="">
        @else
            <img src="{{ asset('storage/web/' . $data->web_logo) }}" alt="">
        @endif
        <div class="text-center">
            <h3 style="font-size: 0.8em;">{{ $data->web_nama }}</h3>
            <p style="font-size: 0.7em;">{{ $data->web_alamat }}. No.Tlp {{ $data->web_tlpn }}</p>
        </div>
    </div>
    <hr>

    <div style="font-size: 0.7em;">
        <strong>Kode Invoice: <span style="color: #09d636;">{{ $statusOrder->kode_inv }}</span></strong>
        <br><strong>Dari: </strong>{{ $data->web_nama }}
        <br>{{ $data->web_alamat }}
        <br>{{ $data->web_tlpn }}
    </div>
    <div style="font-size: 0.7em; ">
        <br><strong>Ke: </strong>{{ $userInfo->user_nmlengkap }}
        <br>{{ $userInfo->user_alamat }}
        <br>{{ $userInfo->user_notlp }}
        <br>
        <br><strong>Status: <span
            style="color: 
    @if ($statusOrder->status == 'Pending') yellow;
    @elseif($statusOrder->status == 'Dikirim') green;
    @elseif($statusOrder->status == 'Selesai') blue;
    @elseif($statusOrder->status == 'Dibatalkan') red;
    @else black; @endif
">{{ $statusOrder->status }}</strong></span>

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
            @foreach ($items as $items)
                <tr>
                    <td>{{ $items->barang_nama }}</td>
                    <td>Rp. {{ number_format($items->barang_harga, 0, ',', '.') }}</td>
                    <td>{{ $items->pesan_jumlah }} {{ $items->satuan_nama }}</td>
                    <td>Rp. {{ number_format($items->pesan_jumlah * $items->barang_harga, 0, ',', '.') }}</td>
                </tr>
                @php
                    $totalHarga += $items->pesan_jumlah * $items->barang_harga; // Accumulate the total harga
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
