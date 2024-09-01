@extends('Master.Layouts.app', ['title' => $title])

@section('content')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ $title }}</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Davibar House</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW -->
    <div class="row row-sm">
        <!-- Daftar Produk -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h3 class="card-title">List Status Order</h3>
                    <a href="{{ url('admin/pesan') }}" class="btn btn-primary text-center">PESAN SEKARANG</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-1" class="table table-bordered text-nowrap border-bottom">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">Nama</th>
                                    <th class="border-bottom-0">Alamat</th>
                                    <th class="border-bottom-0">Total Harga</th>
                                    <th class="border-bottom-0">Tanggal Pesan</th>
                                    <th class="border-bottom-0">Kode Pesan</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($arr as $a)
                                    @if (in_array(Session::get('user')->role_id, ['1', '2', '4']) || Session::get('user')->user_id === $a['id_user'])
                                        <tr>
                                            <td>{{ $a['namauser'] }}</td>
                                            <td>{{ $a['alamat'] }}</td>
                                            <td>
                                                <!-- Menampilkan diskon hanya jika ada -->
                                                @if ($a['diskon'] > 0)
                                                    <small>Rp</small>
                                                    <strong
                                                        style="font-size: larger; color: rgb(15, 209, 41); text-decoration: {{ $a['diskon'] > 0 ? 'line-through' : 'none' }};">
                                                        {{ number_format($a['total_harga'], 0, ',', '.') }}
                                                    </strong>
                                                    <br>
                                                    <small>Diskon:</small>
                                                    <span style="color: rgb(209, 77, 15);">(-) Rp
                                                        {{ number_format($a['diskon'], 0, ',', '.') }}</span>
                                                    <br>
                                                    <!-- Menampilkan total harga setelah diskon -->
                                                    <small>Total setelah diskon:</small>
                                                    <strong style="font-size: larger; color: rgb(15, 209, 41);">
                                                        <small>Rp</small>
                                                        <?php
                                                        $totalSetelahDiskon = $a['total_harga'] - $a['diskon'];
                                                        if ($totalSetelahDiskon > 0) {
                                                            echo number_format($totalSetelahDiskon, 0, ',', '.');
                                                        } else {
                                                            echo "0 (Free)";
                                                        }
                                                        ?>
                                                    </strong>
                                                    
                                                @else
                                                    <small>Rp</small>
                                                    <strong
                                                        style="font-size: larger; color: rgb(15, 209, 41); text-decoration: {{ $a['diskon'] > 0 ? 'line-through' : 'none' }};">
                                                        {{ number_format($a['total_harga'], 0, ',', '.') }}
                                                    </strong>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($a['date_pesan'])
                                                    {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $a['date_pesan'])->isoFormat('D MMMM YYYY') }}<br>
                                                    ( {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $a['date_pesan'])->isoFormat('H:mm') . ' ' . ucfirst(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $a['date_pesan'])->isoFormat('A')) }} )
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td><span style="color: rgb(15, 209, 41);">{{ $a['kode_pesan'] }}</span></td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <span
                                                        class="badge @if ($a['status'] == 'Pending') bg-warning 
                                                                @elseif($a['status'] == 'Dikirim') bg-success 
                                                                @elseif($a['status'] == 'Dibatalkan') bg-danger 
                                                                @elseif($a['status'] == 'Selesai') bg-primary @endif badge-sm  me-1 mb-1 mt-1">
                                                        {{ $a['status'] }}
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('detailpesan', ['id' => $a['kode_pesan']]) }}"
                                                        class="btn btn-primary">Detail</a>&nbsp;
                                                    @if (in_array(Session::get('user')->role_id, ['1', '2', '4']))
                                                        <button class="btn btn-danger fa fa-trash"
                                                            onclick="remove('{{ $a['kode_pesan'] }}')"></button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- END ROW -->
@endsection
@section('scripts')
    <style>
        #table-1_filter input {
            width: 150px !important;
            margin-bottom: 10px;
        }
    </style>
    <script>
        function remove(kode_pesan) {
            swal({
                title: "Konfirmasi",
                text: "Apakah Anda yakin ingin menghapus pesanan dengan kode: " + kode_pesan + "?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                closeOnConfirm: false
            }, function(isConfirmed) {
                if (isConfirmed) {
                    $.ajax({
                        url: '/admin/pesan/status/' + kode_pesan,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            swal({
                                title: "Pesanan telah dihapus!",
                                type: "success",
                            }, function() {
                                location.reload();
                            });
                        },
                        error: function(error) {
                            console.error(error);
                            swal("Terjadi kesalahan saat menghapus pesanan.", {
                                type: "error",
                            });
                        }
                    });
                } else {
                    swal("Penghapusan dibatalkan.");
                }
            });
        }

        $(document).ready(function() {
            $('#table-1').DataTable({
                "paging": true,
                "scrollX": true,
                "searching": true,
                "info": true,
                "autoWidth": false,
                "lengthMenu": [
                    [5, 10, 25, 50, 100],
                    [5, 10, 25, 50, 100]
                ],
                "pageLength": 5,
                lengthChange: true,
            });
        });
    </script>
@endsection
