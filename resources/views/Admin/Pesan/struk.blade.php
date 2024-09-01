<!-- resources/views/struk.blade.php -->

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

        /* Container utama */
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
        }

        /* Gaya untuk mengelola header dan informasi umum */
        .header-info {
            display: flex;
            justify-content: space-between;
            font-size: 0.8em;
        }

        .header-info img {
            max-width: 100%;
            height: auto;
        }

        /* Gaya untuk mengelola informasi pengiriman dan status pesanan */
        .delivery-info {
            font-size: 0.7em;
            margin-top: 10px;
        }

        /* Gaya untuk mengelola tabel barang */
        table {
            width: 100%;
            font-size: 0.6em;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        tfoot tr td {
            font-weight: bold;
        }

        /* Gaya untuk mengelola total dan diskon */
        .total-section {
            margin-top: 10px;
            font-size: 0.6em;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container">
        <div class="logo-container">
            @if ($data->web_logo == '' || $data->web_logo == 'default.png')
                <img src="{{ url('/assets/default/web/default.png') }}" alt="">
            @else
                <img src="{{ asset('storage/web/' . $data->web_logo) }}" alt="">
            @endif
            <div class="delivery-info">
                <h3>{{ $data->web_nama }}</h3>
                <p>{{ $data->web_alamat }}. No.Tlp {{ $data->web_tlpn }}</p>
            </div>
        </div>
        <hr>

        <div class="header-info">
            <strong>Kode Invoice: <span style="color: #09d636;">{{ $statusOrder->kode_inv }}</span></strong>
        </div>

        <div class="delivery-info">
            <div>
                <strong>Dari:</strong> {{ $data->web_nama }}
                <br>{{ $data->web_alamat }}
                <br>{{ $data->web_tlpn }}
            </div>
            <strong>Ke:</strong> {{ $userInfo->user_nmlengkap }}
            <br>{{ $userInfo->user_alamat }}
            <br>{{ $userInfo->user_notlp }}
            <br>
            <br><strong>Status:</strong>
            <span
                style="color: 
                @if ($statusOrder->status == 'Pending') yellow;
                @elseif($statusOrder->status == 'Dikirim') green;
                @elseif($statusOrder->status == 'Selesai') blue;
                @elseif($statusOrder->status == 'Dibatalkan') red;
                @else black; @endif
            ">{{ $statusOrder->status }}</span>

            @if ($statusOrder->created_at)
                <div class="text-center mt-2">
                    <strong>Tanggal Pesan :</strong>
                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $statusOrder->created_at)->isoFormat('D MMMM YYYY') }}
                    /
                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $statusOrder->created_at)->isoFormat('H:mm') . ' ' . ucfirst(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $statusOrder->created_at)->isoFormat('A')) }}
                </div>
            @else
                <div class="text-center mt-2">
                    -
                </div>
            @endif
            @if ($statusOrder->status_tanggal)
                <div class="text-center mt-2">
                    <strong>Update :</strong>
                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $statusOrder->status_tanggal)->isoFormat('D MMMM YYYY') }}
                    /
                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $statusOrder->status_tanggal)->isoFormat('H:mm') . ' ' . ucfirst(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $statusOrder->status_tanggal)->isoFormat('A')) }}
                </div>
            @else
                <div class="text-center mt-2">
                    -
                </div>
            @endif
        </div>

        <table>
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
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->barang_nama }}</td>
                        <td>Rp. {{ number_format($item->barang_harga, 0, ',', '.') }}</td>
                        <td>{{ $item->pesan_jumlah }} {{ $item->satuan_nama }}</td>
                        <td>Rp. {{ number_format($item->pesan_jumlah * $item->barang_harga, 0, ',', '.') }}</td>
                    </tr>
                    @php
                        $totalHarga += $item->pesan_jumlah * $item->barang_harga; // Accumulate the total harga
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: lightgray;">
                    <td colspan="3" align="right"><strong>Total</strong></td>
                    <td colspan="4" align="left" style="color: rgb(15, 209, 41);"><small>Rp</small> <strong style="font-size: larger;">{{ number_format($totalHarga, 0, ',', '.') }}</strong></td>
                </tr>
                <tr style="background-color: lightgray;">
                    <td colspan="3" align="right"><strong>Total Diskon</strong></td>
                    <td colspan="4" align="left" style="color: rgb(209, 77, 15);"><small>Rp</small> <strong style="font-size: larger;">{{ number_format($statusOrder->diskon, 0, ',', '.') }} ( - )</strong></td>
                </tr>
                <tr style="background-color: lightgray;">
                    <td colspan="3" align="right"><strong>Total Setelah Diskon</strong></td>
                    <td colspan="4" align="left" style="color: rgb(15, 209, 41);"><small>Rp</small> <strong style="font-size: larger;">{{ number_format($totalHarga - $statusOrder->diskon, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
