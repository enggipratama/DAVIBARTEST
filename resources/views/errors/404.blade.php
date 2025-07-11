<!doctype html>
<html lang="en" dir="ltr">

<?php
use App\Models\Admin\WebModel;

$web = WebModel::first();
?>

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="{{ $web?->web_deskripsi ?? 'Deskripsi website default' }}">
    <meta name="author" content="{{$web?->web_nama ?? 'Nama website default'}}">
    <meta name="keywords" content="">

    <!-- FAVICON -->
    @php
        $logo = $web?->web_logo ?? 'default.png';
        $isDefault = $logo === '' || $logo === 'default.png';
    @endphp

    @if($isDefault)
        <link rel="shortcut icon" type="image/x-icon" href="{{ url('/assets/default/web/default.png') }}" />
    @else
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/web/' . $logo) }}" />
    @endif

    <!-- TITLE -->
    <title>404 Error | {{ $web->web_nama ?? 'Nama Website' }}</title>

    <!-- STYLE CSS -->
    <link href="{{ url('/assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ url('/assets/css/dark-style.css') }}" rel="stylesheet" />
    <link href="{{ url('/assets/css/transparent-style.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/css/skin-modes.css') }}" rel="stylesheet" />

    <!--- FONT-ICONS CSS -->
    <link href="{{ url('/assets/css/icons.css') }}" rel="stylesheet" />

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all"
        href="{{ url('/assets/colors/color1.css') }}" />

</head>

<body class="">

    <!-- BACKGROUND-IMAGE -->
    <div class="login-img">

        <!-- GLOBAL-LOADER -->
        <div id="global-loader">
            <img src="{{ url('/assets/images/loader.svg') }}" class="loader-img" alt="Loader">
        </div>
        <!-- End GLOBAL-LOADER -->

        <!-- PAGE -->
        <div class="page">
            <!-- PAGE-CONTENT OPEN -->
            <div class="page-content error-page error2 text-white">
                <div class="container text-center">
                    <div class="error-template">
                        <h1 class="display-1 mb-2">4<span class="custom-emoji"><svg xmlns="http://www.w3.org/2000/svg"
                                    height="80" width="80" data-name="Layer 1" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" fill="#a2a1ff" />
                                    <path fill="#6563ff"
                                        d="M15.999,17a.99764.99764,0,0,1-.59912-.2002l-.7334-.5498-.73291.5498a.99755.99755,0,0,1-1.20019,0L12,16.25l-.7334.5498a.9999.9999,0,0,1-1.20019-1.5996l1.33349-1a.99757.99757,0,0,1,1.2002,0l.7334.5498.73291-.5498a.99755.99755,0,0,1,1.20019,0l1.3335,1A1.00013,1.00013,0,0,1,15.999,17Z" />
                                    <path fill="#6563ff"
                                        d="M13.33252 17a.9976.9976 0 0 1-.59912-.2002L12 16.25l-.7334.5498a.99755.99755 0 0 1-1.20019 0L9.3335 16.25l-.7334.5498a.9999.9999 0 0 1-1.2002-1.5996l1.3335-1a.99755.99755 0 0 1 1.20019 0l.73291.5498.7334-.5498a.99757.99757 0 0 1 1.2002 0l1.33349 1A1.00013 1.00013 0 0 1 13.33252 17zM8.37109 12.5a1 1 0 0 1-.707-1.707L8.457 10l-.793-.793A.99989.99989 0 0 1 9.07812 7.793l1.5 1.5a.99962.99962 0 0 1 0 1.41406l-1.5 1.5A.99676.99676 0 0 1 8.37109 12.5zM15.87109 12.5a.99678.99678 0 0 1-.707-.293l-1.5-1.5a.99964.99964 0 0 1 0-1.41406l1.5-1.5A.99989.99989 0 0 1 16.57812 9.207l-.793.793.793.793a1 1 0 0 1-.707 1.707z" />
                                </svg></span>4</h1>
                        <h5 class="error-details">
                            Maaf, telah terjadi kesalahan, Halaman yang diminta tidak ditemukan!
                        </h5>
                        <div class="text-center">
                            <a class="btn btn-primary mt-5 mb-5" href="{{ url('/admin') }}"> <i
                                    class="fa fa-long-arrow-left"></i> Kembali </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- PAGE-CONTENT OPEN CLOSED -->
        </div>
        <!-- End PAGE -->

    </div>
    <!-- BACKGROUND-IMAGE -->

    <!-- JQUERY JS -->
    <script src="{{ url('/assets/js/jquery.min.js') }}"></script>

    <!-- BOOTSTRAP JS -->
    <script src="{{ url('/assets/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ url('/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Perfect SCROLLBAR JS-->
    <script src="{{ url('/assets/plugins/p-scroll/perfect-scrollbar.js') }}"></script>

    <!-- Color Theme js -->
    <script src="{{ url('/assets/js/themeColors.js') }}"></script>

    <!-- Sticky js -->
    <script src="{{ url('/assets/js/sticky.js') }}"></script>

    <!-- CUSTOM JS -->
    <script src="{{ url('/assets/js/custom.js') }}"></script>

</body>

</html>
