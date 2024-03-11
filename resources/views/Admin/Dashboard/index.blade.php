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
                <div class="card-body col-12">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font"
                                style="max-height: 2.8em; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                Halo, {{ $data['userLogin']->user_nmlengkap }}
                            </h2>
                            <h3 class="text-white mb-0">Selamat Datang</h3>
                        </div>
                        <div class="ms-auto"> <i class="fe fe-user text-white fs-40 me-2 mt-2"></i> </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- COL END -->
        <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-3">
            <div class="card bg-success img-card box-secondary-shadow">
                <div class="card-body col-12">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font">
                                @if ($data['barang'] > 100)
                                    100++
                                @else
                                    {{ $data['barang'] }}
                                @endif
                            </h2>
                            <p class="text-white mb-0">Produk</p>
                        </div>
                        <div class="ms-auto"> <i class="fe fe-package text-white fs-40 me-2 mt-2"></i> </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- COL END -->
        <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-3">
            <div class="card  bg-success img-card box-success-shadow">
                <div class="card-body col-12">
                    <div class="d-flex">
                        <div class="text-white">
                            <h2 class="mb-0 number-font">
                                @if ($data['user'] > 100)
                                    100++
                                @else
                                    {{ $data['user'] }}
                                @endif
                            </h2>
                            <p class="text-white mb-0">Pengguna</p>
                        </div>
                        <div class="ms-auto">
                            <i class="fe fe-user text-white fs-40 me-2 mt-2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Page halaman status -->
    <div class="row">
        @foreach ($data['statusToCount'] as $status)
            @if (Session::get('user')->role_id == 1 || Session::get('user')->role_id == 2 || Session::get('user')->role_id == 4)
                <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                    <a href="{{ route('statustransaksi') }}">
                        <div
                            class="card 
                        @if ($status == 'Pending') bg-warning   <!-- Orange for Pending -->
                        @elseif($status == 'Dikirim')
                            bg-success   <!-- Green for Dikirim -->
                        @elseif($status == 'Selesai')
                            bg-primary   <!-- Blue for Selesai -->
                        @elseif($status == 'Dibatalkan')
                            bg-danger    <!-- Red for Dibatalkan --> @endif
                        img-card box-primary-shadow">
                            <div class="card-body col-12">
                                <div class="d-flex">
                                    <div class="text-white">
                                        <h4 class="number-font mb-0">{{ $status }}</h4>
                                    </div>
                                    <div class="ms-auto">
                                        @if ($status == 'Pending')
                                            <i class="fe fe-clock text-white fs-20 fs-md-20 me-2 mt-2"></i>
                                            <!-- Icon for Pending -->
                                        @elseif($status == 'Dikirim')
                                            <i class="fe fe-truck text-white fs-20 fs-md-20 me-2 mt-2"></i>
                                            <!-- Icon for Dikirim -->
                                        @elseif($status == 'Selesai')
                                            <i class="fe fe-check-circle text-white fs-20 fs-md-20 me-2 mt-2"></i>
                                            <!-- Icon for Selesai -->
                                        @elseif($status == 'Dibatalkan')
                                            <i class="fe fe-alert-circle text-white fs-20 fs-md-20 me-2 mt-2"></i>
                                            <!-- Icon for Dibatalkan -->
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if ($data[$status . 'Count'] > 100)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge
                                    @if ($data[$status . 'Count'] < 100) bg-danger @else bg-success @endif">
                                    100++
                                </span>
                            @elseif ($data[$status . 'Count'] > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge
                                    @if ($data[$status . 'Count'] < 100) bg-danger @else bg-success @endif">
                                    {{ $data[$status . 'Count'] }}
                                </span>
                            @endif

                        </div>
                    </a>
                </div>
            @endif
        @endforeach
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="card bg-success img-card box-success-shadow">
            <div class="text-white">
                <h1 class="page-title mt-4 mb-3 text-center">Produk Terbaru</h1>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($arr as $item)
            <div class="col-6 col-sm-6 col-md-4 col-lg-4 col-xl-3 d-flex align-items-center justify-content-center">
                <div class="card bg-primary img-card" style="width: 13rem;">
                    <span
                        class="position-absolute top-0 start-50 translate-middle badge
                        @if ($item['total_real'] <= 0) bg-danger
                        @elseif($item['total_real'] < 100) bg-warning
                        @elseif($item['total_real'] >= 100) bg-success @endif">
                        @if ($item['total_real'] <= 0)
                            Kosong
                        @elseif($item['total_real'] > 200)
                            200+ {{ $item['satuan'] }}
                        @else
                            {{ $item['total_real'] }} {{ $item['satuan'] }}
                        @endif
                    </span>

                    <div class="card-body text-center" style="width: 12rem; height: 12rem; overflow: hidden;">
                        @if ($item['gambar'] == 'image.png')
                            <img src="{{ url('/assets/default/barang/image.png') }}"
                                class="w-100 h-100 img-fluid rounded-3" alt="produk" style="object-fit: cover;">
                        @else
                            <img src="{{ asset('storage/barang/' . $item['gambar']) }}"
                                class="w-100 h-100 img-fluid rounded-3" alt="produk" style="object-fit: cover;">
                        @endif
                    </div>
                    <div class="card-body text-center" style="max-width: 200px;">
                        <h5 class="text-white clamp-two-lines">
                            <b>{{ $item['nama'] }}</b>
                        </h5>
                        <p class="text-white mb-2 mt-2"><strong>Rp. {{ number_format($item['harga'], 0) }}</strong></p>
                        <div class="col-lg-12">
                            <a href="{{ url('admin/pesan') }}" class="btn btn-success">PESAN</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

<style>
    .clamp-two-lines {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        overflow: hidden;
        -webkit-line-clamp: 2;
        /* Menampilkan maksimal 2 baris */
    }

    .img-card {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
</style>
