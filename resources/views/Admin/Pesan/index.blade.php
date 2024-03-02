@extends('Master.Layouts.app', ['title' => $title])

@section('content')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ $title }}</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Pesan Produk</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW -->
    <div class="row row-sm">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h3 class="card-title">List Produk</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-1" class="table table-bordered text-nowrap border-bottom">
                            <thead>
                                <th class="border-bottom-0">No</th>
                                <th class="border-bottom-0">Gambar</th>
                                <th class="border-bottom-0">Nama</th>
                                <th class="border-bottom-0">Stok</th>
                                <th class="border-bottom-0">Harga</th>
                                <th class="border-bottom-0">Jumlah</th>
                                <th class="border-bottom-0">Pilih</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h3 class="card-title">Rincian Order</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="rincian-order-table" class="table table-bordered text-nowrap border-bottom">
                            <thead>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Pilih</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-header justify-content-between">
                    <h3 class="card-title">
                        <div id="total-harga">Total Harga: Rp. 0</div>
                    </h3>
                    <a class="modal-effect btn btn-primary-light" data-bs-effect="effect-super-scaled"
                        data-bs-toggle="modal" href="#modaldemo8">Rincian
                    </a>
                </div>
            </div>
        </div>
    </div> <!-- END ROW -->
    @include('Admin.Pesan.tambah')
@endsection

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table;
        $(document).ready(function() {
            //datatables
            table = $('#table-1').DataTable({
                "processing": true,
                "serverSide": true,
                "info": true,
                "order": [],
                "stateSave": true,
                "scrollX": true,
                "lengthMenu": [
                    [5, 10, 25, 50, 100],
                    [5, 10, 25, 50, 100]
                ],
                "pageLength": 5,
                lengthChange: true,
                "ajax": {
                    "url": "{{ route('pesan.getpesan') }}",
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false

                    },
                    {
                        data: 'img',
                        name: 'barang_gambar',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'barang_nama',
                        name: 'barang_nama'
                    },
                    {
                        data: 'totalstok',
                        name: 'total_stok',
                        render: function(data, type, row) {
                            var color = '';
                            if (data > 0) {
                                color = 'green';
                            } else if (data < 0) {
                                color = 'red';
                            } else {
                                color = 'red';
                                data = 'Kosong';
                            }
                            return '<span style="color:' + color + ';">' + data + '</span>';
                        }
                    },
                    {
                        data: 'currency',
                        name: 'barang_harga'
                    },
                    {
                        data: 'inputjml',
                        name: 'inputjml',
                        searchable: false,
                        orderable: false,
                    },
                    {
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row) {
                            return '<button class="btn modal-effect text-success btn-sm fa fa-plus-square fs-20 btn-plus"></button>';
                        },
                    },
                ],

            });

            function hitungTotalHarga() {
                var totalHarga = 0;
                $('#rincian-order-table tbody tr').each(function() {
                    var inputVal = parseInt($(this).find('td:nth-last-child(2)').text());
                    var hargaPerItem = parseFloat($(this).find('td:nth-last-child(3)').text().replace(
                        /[^0-9.-]+/g, ""));
                    var subtotal = inputVal * hargaPerItem;
                    totalHarga += subtotal;
                });
                $('#total-harga').text('Total Harga: Rp. ' + formatUang(
                    totalHarga));
                $('#total-harga-2').text('Total Harga: Rp. ' + formatUang(
                    totalHarga));
            }

            function formatUang(angka) {
                var formatted = angka.toFixed(2).replace(/\.00$/, '');
                return formatted.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                ribuan
            }
            $('#table-1 tbody').on('click', 'button.btn-plus', function() {
                var data = table.row($(this).parents('tr')).data();
                var inputVal = $(this).closest('tr').find('input[name="inputjml[]"]').val();
                var totalStokDiinput = 0;
                var totalStokTersedia = data.totalstok;
                if (inputVal.trim() == 0) {
                    swal({
                        title: "Masukkan Jumlah Barang!",
                        type: "error",
                        button: "OK",
                    });
                    return;
                }
                if (data.totalstok == 0) {
                    swal({
                        title: "Stok Kosong!",
                        type: "error",
                        button: "OK",
                    });
                    return;
                }
                var existingRow = $('#rincian-order-table tbody tr').filter(function() {
                    return $(this).find('td:first').text() === data.barang_nama;
                });
                if (existingRow.length > 0) {
                    var currentVal = parseInt(existingRow.find('td:nth-last-child(2)').text());
                    var newTotal = currentVal + parseInt(inputVal);
                    if (newTotal > totalStokTersedia + totalStokDiinput) {
                        swal({
                            title: "Jumlah Melebihi Total Stok Tersedia!",
                            type: "error",
                            button: "OK",
                        });
                        return;
                    }
                    existingRow.find('td:nth-last-child(2)').text(newTotal);
                    existingRow.find('td:last').html(
                        '<button class="btn btn-danger btn-hapus fa fa-trash"></button>'
                    );
                    swal({
                        title: "Item Diperbarui!",
                        text: "Jumlah " + data.barang_nama + " telah diperbarui.",
                        type: "success",
                        button: "OK",
                    });
                } else {
                    swal({
                        title: "Item Ditambahkan!",
                        text: data.barang_nama + " telah ditambahkan ke pesanan.",
                        type: "success",
                        button: "OK",
                    });
                    if (parseInt(inputVal) > totalStokTersedia + totalStokDiinput) {
                        swal({
                            title: "Jumlah Melebihi Total Stok Tersedia!",
                            type: "error",
                            button: "OK",
                        });
                        return;
                    }
                    var newRow =
                        '<tr>' +
                        '<td>' + data.barang_nama + '</td>' +
                        '<td>' + data.currency + '</td>' +
                        '<td>' + inputVal + '</td>' +
                        '<td><button class="btn btn-danger btn-hapus fa fa-trash"></button></td>' +
                        '</tr>';
                    var rincianRow =
                        '<tr>' +
                        '<td>' + data.barang_nama + '</td>' +
                        '<td>' + data.currency + '</td>' +
                        '<td>' + inputVal + '</td>' +
                        '</tr>';
                    totalStokDiinput += parseInt(inputVal);
                    $('#rincian-order-table tbody').append(newRow);
                    $('#rincian-order-table-2 tbody').append(rincianRow);
                    hitungTotalHarga();
                }
                $('#rincian-order-table tbody').on('click', 'button.btn-hapus', function() {
                    $(this).closest('tr').remove();
                    hitungTotalHarga();
                });
                hitungTotalHarga();
            });
        });
    </script>
@endsection
