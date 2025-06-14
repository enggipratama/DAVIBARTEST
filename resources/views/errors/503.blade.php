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
    <title>Web Sedang Perbaikan | {{ $web->web_nama ?? 'Nama Website' }}</title>

    <!-- STYLE CSS -->
    <link href="{{ url('/assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ url('/assets/css/dark-style.css') }}" rel="stylesheet" />
    <link href="{{ url('/assets/css/transparent-style.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/css/skin-modes.css') }}" rel="stylesheet" />

    <!--- FONT-ICONS CSS -->
    <link href="{{ url('/assets/css/icons.css') }}" rel="stylesheet" />

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ url('/assets/colors/color1.css') }}" />

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
                        <h1 class="display-1 mb-2">5<span class="custom-emoji"><svg xmlns="http://www.w3.org/2000/svg"
                                    height="80" width="80" data-name="Layer 1" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10" fill="#a2a1ff" />
                                    <path fill="#6563ff"
                                        d="M15.999,17a.99764.99764,0,0,1-.59912-.2002l-.7334-.5498-.73291.5498a.99755.99755,0,0,1-1.20019,0L12,16.25l-.7334.5498a.9999.9999,0,0,1-1.20019-1.5996l1.33349-1a.99757.99757,0,0,1,1.2002,0l.7334.5498.73291-.5498a.99755.99755,0,0,1,1.20019,0l1.3335,1A1.00013,1.00013,0,0,1,15.999,17Z" />
                                    <path fill="#6563ff"
                                        d="M13.33252 17a.9976.9976 0 0 1-.59912-.2002L12 16.25l-.7334.5498a.99755.99755 0 0 1-1.20019 0L9.3335 16.25l-.7334.5498a.9999.9999 0 0 1-1.2002-1.5996l1.3335-1a.99755.99755 0 0 1 1.20019 0l.73291.5498.7334-.5498a.99757.99757 0 0 1 1.2002 0l1.33349 1A1.00013 1.00013 0 0 1 13.33252 17zM8.37109 12.5a1 1 0 0 1-.707-1.707L8.457 10l-.793-.793A.99989.99989 0 0 1 9.07812 7.793l1.5 1.5a.99962.99962 0 0 1 0 1.41406l-1.5 1.5A.99676.99676 0 0 1 8.37109 12.5zM15.87109 12.5a.99678.99678 0 0 1-.707-.293l-1.5-1.5a.99964.99964 0 0 1 0-1.41406l1.5-1.5A.99989.99989 0 0 1 16.57812 9.207l-.793.793.793.793a1 1 0 0 1-.707 1.707z" />
                                </svg></span>3</h1>


                        <h4 class="error-details">
                            Maaf, Website sedang dalam masa perbaikan!!
                        </h4>
                        <h3 class="error-details">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                style="margin: auto; display: block; shape-rendering: auto; background: none;"
                                width="286" height="121" preserveAspectRatio="xMidYMid">
                                <style type="text/css">
                                    text {
                                        text-anchor: middle;
                                        font-size: 57px;
                                        opacity: 0;
                                    }
                                </style>
                                <g style="transform-origin: 143px 60.5px; transform: scale(0.850746);">
                                    <g transform="translate(143,60.5)">
                                        <g transform="translate(0,0)">
                                            <g class="path"
                                                style="transform: scale(0.91); transform-origin: -142.98px -5.26471px; animation: 0.8s linear -0.469333s infinite normal forwards running breath-5eef8543-204a-4da2-938f-6df1cdca9e3c;">
                                                <path
                                                    d="M5.36-46.23L19.90-46.23L19.90-46.23Q26.33-46.23 30.15-42.58L30.15-42.58L30.15-42.58Q33.97-38.93 33.97-32.56L33.97-32.56L33.97-32.56Q33.97-26.20 29.15-21.67L29.15-21.67L29.15-21.67Q24.32-17.15 17.35-17.15L17.35-17.15L13.53-17.15L14.34 0L5.36 0L6.16-16.28L5.36-46.23zM17.49-39.46L17.49-39.46L14.20-39.46L13.74-23.65L18.29-23.65L18.29-23.65Q21.64-23.65 23.48-25.86L23.48-25.86L23.48-25.86Q25.33-28.07 25.33-32.16L25.33-32.16L25.33-32.16Q25.33-39.46 17.49-39.46"
                                                    fill="#ffffff" stroke="none" stroke-width="none"
                                                    transform="translate(-162.64501953125,17.850291002061635)"
                                                    style="fill: rgb(255, 255, 255);"></path>
                                            </g>
                                            <g class="path"
                                                style="transform: scale(0.91); transform-origin: -110.555px -5.26471px; animation: 0.8s linear -0.410667s infinite normal forwards running breath-5eef8543-204a-4da2-938f-6df1cdca9e3c;">
                                                <path
                                                    d="M63.98 0L39.46 0L40.27-16.28L39.46-46.23L64.59-46.23L63.85-39.06L48.78-39.06L48.37-27.20L61.77-27.20L61.04-20.10L48.11-20.10L48.04-17.42L48.51-7.10L64.72-7.10L63.98 0"
                                                    fill="#ffffff" stroke="none" stroke-width="none"
                                                    transform="translate(-162.64501953125,17.850291002061635)"
                                                    style="fill: rgb(255, 255, 255);"></path>
                                            </g>
                                            <g class="path"
                                                style="transform: scale(0.91); transform-origin: -74.235px -4.89471px; animation: 0.8s linear -0.352s infinite normal forwards running breath-5eef8543-204a-4da2-938f-6df1cdca9e3c;">
                                                <path
                                                    d="M84.42-17.82L84.42-17.82L80.60-17.82L80.60-17.42L81.41 0L72.43 0L73.23-16.28L72.43-46.23L86.97-46.23L86.97-46.23Q93.40-46.23 97.22-42.75L97.22-42.75L97.22-42.75Q101.04-39.26 101.04-33.50L101.04-33.50L101.04-33.50Q101.04-29.15 98.79-25.56L98.79-25.56L98.79-25.56Q96.55-21.98 92.73-19.90L92.73-19.90L104.39-3.42L96.28 0.74L85.83-17.89L85.83-17.89Q85.36-17.82 84.42-17.82zM84.55-39.46L84.55-39.46L81.27-39.46L80.80-24.32L85.36-24.32L85.36-24.32Q88.71-24.32 90.55-26.53L90.55-26.53L90.55-26.53Q92.39-28.74 92.39-32.83L92.39-32.83L92.39-32.83Q92.39-39.46 84.55-39.46"
                                                    fill="#ffffff" stroke="none" stroke-width="none"
                                                    transform="translate(-162.64501953125,17.850291002061635)"
                                                    style="fill: rgb(255, 255, 255);"></path>
                                            </g>
                                            <g class="path"
                                                style="transform: scale(0.91); transform-origin: -36.05px -4.89471px; animation: 0.8s linear -0.293333s infinite normal forwards running breath-5eef8543-204a-4da2-938f-6df1cdca9e3c;">
                                                <path
                                                    d="M111.22-46.23L125.76-46.23L125.76-46.23Q132.19-46.23 135.94-43.32L135.94-43.32L135.94-43.32Q139.70-40.40 139.70-35.51L139.70-35.51L139.70-35.51Q139.70-27.67 133.26-24.59L133.26-24.59L133.26-24.59Q141.97-21.57 141.97-13.47L141.97-13.47L141.97-13.47Q141.97-7.37 136.75-3.32L136.75-3.32L136.75-3.32Q131.52 0.74 123.62 0.74L123.62 0.74L123.62 0.74Q119.46 0.74 111.22 0L111.22 0L112.02-16.28L111.22-46.23zM124.89-19.90L124.89-19.90L119.46-19.90L119.39-17.42L119.86-6.50L119.86-6.50Q123.75-6.16 125.83-6.16L125.83-6.16L125.83-6.16Q129.38-6.16 131.35-7.94L131.35-7.94L131.35-7.94Q133.33-9.71 133.33-13.13L133.33-13.13L133.33-13.13Q133.33-16.55 131.32-18.22L131.32-18.22L131.32-18.22Q129.31-19.90 124.89-19.90zM123.35-39.46L123.35-39.46L120.06-39.46L119.66-26.40L124.02-26.40L124.02-26.40Q127.43-26.40 129.24-28.24L129.24-28.24L129.24-28.24Q131.05-30.08 131.05-33.50L131.05-33.50L131.05-33.50Q131.05-39.46 123.35-39.46"
                                                    fill="#ffffff" stroke="none" stroke-width="none"
                                                    transform="translate(-162.64501953125,17.850291002061635)"
                                                    style="fill: rgb(255, 255, 255);"></path>
                                            </g>
                                            <g class="path"
                                                style="transform: scale(0.91); transform-origin: 3.61998px -5.29471px; animation: 0.8s linear -0.234667s infinite normal forwards running breath-5eef8543-204a-4da2-938f-6df1cdca9e3c;">
                                                <path
                                                    d="M186.80-1.14L177.15 0.34L173.87-12.73L157.85-12.73L154.30 0L145.73-0.67L151.62-16.95L160.60-45.76L172.59-46.63L181.24-17.96L186.80-1.14zM171.86-19.83L166.56-37.92L165.69-37.92L159.93-19.83L171.86-19.83"
                                                    fill="#ffffff" stroke="none" stroke-width="none"
                                                    transform="translate(-162.64501953125,17.850291002061635)"
                                                    style="fill: rgb(255, 255, 255);"></path>
                                            </g>
                                            <g class="path"
                                                style="transform: scale(0.91); transform-origin: 35.275px -5.43471px; animation: 0.8s linear -0.176s infinite normal forwards running breath-5eef8543-204a-4da2-938f-6df1cdca9e3c;">
                                                <path
                                                    d="M193.16-44.89L202.68-46.57L201.74-17.42L202.54 0L193.16 0L193.97-16.28L193.16-44.89"
                                                    fill="#ffffff" stroke="none" stroke-width="none"
                                                    transform="translate(-162.64501953125,17.850291002061635)"
                                                    style="fill: rgb(255, 255, 255);"></path>
                                            </g>
                                            <g class="path"
                                                style="transform: scale(0.91); transform-origin: 67.57px -5.06471px; animation: 0.8s linear -0.117333s infinite normal forwards running breath-5eef8543-204a-4da2-938f-6df1cdca9e3c;">
                                                <path
                                                    d="M213.40-44.89L222.91-46.57L222.17-24.72L239.26-46.43L246.09-41.88L230.68-23.99L247.03-4.62L238.45 0.74L222.11-22.38L221.97-17.42L222.78 0L213.40 0L214.20-16.28L213.40-44.89"
                                                    fill="#ffffff" stroke="none" stroke-width="none"
                                                    transform="translate(-162.64501953125,17.850291002061635)"
                                                    style="fill: rgb(255, 255, 255);"></path>
                                            </g>
                                            <g class="path"
                                                style="transform: scale(0.91); transform-origin: 105.66px -5.29471px; animation: 0.8s linear -0.0586667s infinite normal forwards running breath-5eef8543-204a-4da2-938f-6df1cdca9e3c;">
                                                <path
                                                    d="M288.84-1.14L279.19 0.34L275.91-12.73L259.89-12.73L256.34 0L247.77-0.67L253.66-16.95L262.64-45.76L274.63-46.63L283.28-17.96L288.84-1.14zM273.90-19.83L268.60-37.92L267.73-37.92L261.97-19.83L273.90-19.83"
                                                    fill="#ffffff" stroke="none" stroke-width="none"
                                                    transform="translate(-162.64501953125,17.850291002061635)"
                                                    style="fill: rgb(255, 255, 255);"></path>
                                            </g>
                                            <g class="path"
                                                style="transform: scale(0.91); transform-origin: 150.28px -5.26471px; animation: 0.8s linear 0s infinite normal forwards running breath-5eef8543-204a-4da2-938f-6df1cdca9e3c;">
                                                <path
                                                    d="M322.47-45.36L330.65-46.36L329.77-17.42L330.51-1.47L322.61 0.20L302.64-32.09L302.64-17.42L303.58 0L295.20 0L296.01-16.28L295.20-46.03L303.24-46.43L323.14-13.67L322.47-45.36"
                                                    fill="#ffffff" stroke="none" stroke-width="none"
                                                    transform="translate(-162.64501953125,17.850291002061635)"
                                                    style="fill: rgb(255, 255, 255);"></path>
                                            </g>
                                        </g>
                                    </g>
                                </g>
                                <style id="breath-5eef8543-204a-4da2-938f-6df1cdca9e3c" data-anikit="">
                                    @keyframes breath-5eef8543-204a-4da2-938f-6df1cdca9e3c {
                                        0% {
                                            animation-timing-function: cubic-bezier(0.9647, 0.2413, -0.0705, 0.7911);
                                            transform: scale(0.9099999999999999);
                                        }

                                        51% {
                                            animation-timing-function: cubic-bezier(0.9226, 0.2631, -0.0308, 0.7628);
                                            transform: scale(1.02994);
                                        }

                                        100% {
                                            transform: scale(0.9099999999999999);
                                        }
                                    }
                                </style>
                            </svg>
                        </h3>
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
