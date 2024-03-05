@extends('Master.Layouts.app', ['title' => $data['title']])


@section('content')
    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title">{{ $data['title'] }}</h1>
        <div>
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-gray">Davibar House</li>
                <li class="breadcrumb-item active" aria-current="page">{{ $data['title'] }}</li>
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
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex align-items-center justify-content-center">
                <div class="card bg-primary img-card" style="width: 15rem;">
                    <span
                        class="position-absolute top-0 start-100 translate-middle badge @if ($item['total_real'] <= 0) bg-danger
                        @elseif($item['total_real'] < 100) bg-warning  @else bg-success @endif">
                        @if ($item['total_real'] <= 0)
                            Kosong
                        @else
                            {{ $item['total_real'] }}++
                        @endif
                    </span>
                    <div class="card-body" style="width: 15rem; height: auto; overflow: hidden;">
                            @if ($item['gambar'] == 'image.png')
                        <div style="position: relative; width: 100%; height: 100%; padding-bottom: 100%;">
                            <img src="{{ url('/assets/default/barang/image.png') }}"
                                class="rounded-4 w-100 h-100  position-absolute" alt="produk"
                                style="object-fit: cover;">
                        </div>
                    @else
                        <div style="position: relative; width: 100%; height: 60%; padding-bottom: 100%;">
                            <img src="{{ asset('storage/barang/' . $item['gambar']) }}"
                                class="rounded-4 w-100 h-100 position-absolute" alt="produk"
                                style="object-fit: cover;">
                        </div>
                    @endif
                        
                        <h5 class="text-white mt-2 text-center"><b>{{ $item['nama'] }}</b></h5>
                        </h5>
                        <p class="text-white mb-2 mt-2 text-center"><strong>
                           Rp. {{ number_format($item['harga'], 0) }}</strong></p>
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
