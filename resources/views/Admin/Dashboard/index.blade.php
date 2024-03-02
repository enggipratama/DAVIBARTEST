@extends('Master.Layouts.app', ['title' => $data['title']])


@section('content')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">Dashbord</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Davibar</li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6">
            <div class="card bg-primary img-card box-primary-shadow">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font">Halo, {{ $data['userLogin']->user_nmlengkap }}</h2>
                            <h3 class="text-white mb-0">Selamat Datang </h3>
                        </div>
                        <div class="ms-auto"> <i class="fe fe-user text-white fs-40 me-2 mt-2"></i> </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- COL END -->
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
            <div class="card bg-success img-card box-secondary-shadow">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font">{{ $data['barang'] }}</h2>
                            <p class="text-white mb-0">Total Produk</p>
                        </div>
                        <div class="ms-auto"> <i class="fe fe-package text-white fs-40 me-2 mt-2"></i> </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- COL END -->
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
            <div class="card  bg-success img-card box-success-shadow">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font">{{ $data['user'] }}</h2>
                            <p class="text-white mb-0">Total Pengguna</p>
                        </div>
                        <div class="ms-auto"> <i class="fe fe-user text-white fs-40 me-2 mt-2"></i> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <h1 class="page-title mt-4 mb-3 text-center">Produk Terbaru</h1>
        </div>
    </div>
    <div class="row">
        @foreach ($arr as $item)
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                <div class="card bg-primary img-card box-secondary-shadow">
                    <div class="card-body">

                        <div class="text-white">
                        </div>
                        <div class="ms-auto text-center">
                            @if ($item['gambar'] == 'image.png')
                                <img src="{{ url('/assets/default/barang/image.png') }}" class="rounded-3" width="150"
                                    height="150" alt="produk">
                            @else
                                <img src="{{ asset('storage/barang/' . $item['gambar']) }}" class="rounded-3" width="150"
                                    height="150" alt="produk">
                            @endif
                        </div>

                        <h5 class="text-white mt-2 text-center"><b>{{ $item['nama'] }}</b></h5>

                        <h5 class="text-white mt-2 text-center"> Stok : {{ $item['total_stok'] }} - {{ $item['satuan'] }}
                        </h5>
                        <p class="text-white mb-2 mt-2 text-center">Rp.
                            {{ number_format($item['harga'], 0, ',', '.') }}</p>
                        <div class="col-lg-12 text-center">
                            <a href="{{ url('admin/pesan') }}" class="btn btn-success text-center">PESAN</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

<style>

</style>
