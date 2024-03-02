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
    <!-- ROW List-->
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
        <!-- End ROW List-->
        <!-- ROW Rincian Order-->
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
                <h6 class="text-center">
                    <div id="info">Cek Kembali Pesanan Anda!</div>
                </h6>
                <div class="card-header justify-content-between">
                    <h3 class="card-title">
                        <div id="total-harga">Total Harga: Rp. 0</div>
                    </h3>
                    <a id="pesanButton" class="modal-effect btn btn-primary-light" onclick="generateID()"
                        data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modaldemo8">Pesan</a>
                </div>
            </div>
        </div>
        <!-- End ROW Rincian Order-->
    </div>
@endsection
