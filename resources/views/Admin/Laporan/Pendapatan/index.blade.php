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
                                <th class="border-bottom-0">Stok Awal</th>
                                <th class="border-bottom-0">Jumlah Masuk</th>
                                <th class="border-bottom-0">Jumlah Keluar</th>
                                <th class="border-bottom-0">Jumlah Pesan</th>
                                <th class="border-bottom-0">Total Stok</th>
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