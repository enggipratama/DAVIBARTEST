@extends('Master.Layouts.app', ['title' => $title])

@section('content')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ $title }}</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Davibar House</li>
                <li class="breadcrumb-item text-gray">Menu Laporan</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- ROW -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h3 class="card-title">Data</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12">
                            <label for="" class="fw-bold">Filter Tanggal</label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="tglawal" class="form-control datepicker-date"
                                    placeholder="Tanggal Awal">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <input type="text" name="tglakhir" class="form-control datepicker-date"
                                    placeholder="Tanggal Akhir">
                            </div>
                        </div>
                        <div class="col-md-4 text-center ">
                            <button class="btn btn-success-light mx-2 text-center" onclick="filter()"><i
                                    class="fe fe-filter"></i></button>
                            <button class="btn btn-secondary-light mx-2 text-center" onclick="reset()"><i
                                    class="fe fe-refresh-ccw"></i></button>
                            <button class="btn btn-primary-light mx-2 text-center" onclick="print()"><i
                                    class="fe fe-printer"></i></button>
                            <button class="btn btn-danger-light mx-2 text-center" onclick="pdf()"><i
                                    class="fa fa-file-pdf-o"></i></button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table-1"
                            class="table table-bordered text-nowrap border-bottom dataTable no-footer dtr-inline collapsed">
                            <thead>
                                <th class="border-bottom-0" width="1%">No</th>
                                <th class="border-bottom-0">Kode Barang</th>
                                <th class="border-bottom-0">Barang</th>
                                <th class="border-bottom-0">Total Stok</th>
                                <th class="border-bottom-0">Stok Keluar</th>
                                <th class="border-bottom-0">Tersedia</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ROW -->
@endsection
@section('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        getData();
    });

    function getData() {
        //datatables
        table = $('#table-1').DataTable({

            "processing": true,
            "serverSide": true,
            "info": true,
            "order": [],
            "scrollX": true,
            "stateSave": true,
            "lengthMenu": [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, 'Semua']
            ],
            "pageLength": 10,

            lengthChange: true,

            "ajax": {
                "url": "{{ route('lap-pendapatan.getlap') }}",
                "data": function(d) {
                    d.tglawal = $('input[name="tglawal"]').val();
                    d.tglakhir = $('input[name="tglakhir"]').val();
                }
            },

            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false
                },
                {
                    data: 'barang_kode',
                    name: 'barang_kode',
                    render: function(data, type, row) {
                            data = '<span style="color: rgb(15, 209, 41);">' + data + '</span>';
                            return data;
                        }
                },
                {
                    data: 'barang',
                    name: 'barang_nama',
                    searchable: false,
                    orderable: false,
                },
                {
                    data: 'totalstok',
                    name: 'totalstok',
                    searchable: false,
                    orderable: false,
                },
                {
                    data: 'totalpesan',
                    name: 'totalpesan',
                    searchable: false,
                    orderable: false,
                },
                {
                    data: 'stoksisa',
                    name: 'stoksisa',
                    searchable: false,
                    orderable: false,
                },
            ],

        });
    }

    function filter() {
        var tglawal = $('input[name="tglawal"]').val();
        var tglakhir = $('input[name="tglakhir"]').val();
        if (tglawal != '' && tglakhir != '') {
            table.ajax.reload(null, false);
        } else {
            validasi("Isi dulu Form Filter Tanggal!", 'warning');
        }

    }

    function reset() {
        $('input[name="tglawal"]').val('');
        $('input[name="tglakhir"]').val('');
        table.ajax.reload(null, false);
    }

    function print() {
        var tglawal = $('input[name="tglawal"]').val();
        var tglakhir = $('input[name="tglakhir"]').val();
        if (tglawal != '' && tglakhir != '') {
            window.open(
                "{{route('lap-pendapatan.print')}}?tglawal=" + tglawal + "&tglakhir=" + tglakhir,
                '_blank'
            );
        } else {
            swal({
                title: "Yakin Print Semua Data?",
                type: "warning",
                buttons: true,
                dangerMode: true,
                confirmButtonText: "Yakin",
                cancelButtonText: 'Batal',
                showCancelButton: true,
                showConfirmButton: true,
                closeOnConfirm: false,
                confirmButtonColor: '#09ad95',
            }, function(value) {
                if (value == true) {
                    window.open(
                        "{{route('lap-pendapatan.print')}}",
                        '_blank'
                    );
                    swal.close();
                }
            });

        }

    }

    function pdf() {
        var tglawal = $('input[name="tglawal"]').val();
        var tglakhir = $('input[name="tglakhir"]').val();
        if (tglawal != '' && tglakhir != '') {
            window.open(
                "{{route('lap-pendapatan.pdf')}}?tglawal=" + tglawal + "&tglakhir=" + tglakhir,
                '_blank'
            );
        } else {
            swal({
                title: "Yakin export PDF Semua Data?",
                type: "warning",
                buttons: true,
                dangerMode: true,
                confirmButtonText: "Yakin",
                cancelButtonText: 'Batal',
                showCancelButton: true,
                showConfirmButton: true,
                closeOnConfirm: false,
                confirmButtonColor: '#09ad95',
            }, function(value) {
                if (value == true) {
                    window.open(
                        "{{route('lap-pendapatan.pdf')}}",
                        '_blank'
                    );
                    swal.close();
                }
            });

        }

    }

    function validasi(judul, status) {
        swal({
            title: judul,
            type: status,
            confirmButtonText: "Iya."
        });
    }
</script>
@endsection