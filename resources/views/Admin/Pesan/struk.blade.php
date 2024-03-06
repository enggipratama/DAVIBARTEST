<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        /* Atur gaya cetak struk sesuai kebutuhan Anda */
        body {
            font-family: Arial, sans-serif;
            width: 50%; /* Tentukan lebar struk */
            margin: 0 auto; /* Pusatkan struk di tengah layar */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h1, h2 {
            text-align: center;
        }

        /* Tambahkan gaya lain sesuai kebutuhan */
    </style>
</head>
<body>

    <h1>{{ $title }}</h1>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($results as $index => $result)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $result->nama_barang }}</td>
                    <td>{{ $result->jumlah }}</td>
                    <td>{{ $result->harga_satuan }}</td>
                    <td>{{ $result->total }}</td>
                </tr>
            @endforeach --}}
        </tbody>
    </table>

    <h2>Total Pembelian: </h2>

    <!-- Tambahkan elemen-elemen lain sesuai kebutuhan -->

</body>
</html>
