<!DOCTYPE html>


<html lang="en-us">

<head>
    <meta charset="utf-8">
    <title>{{ $title }} - {{ env('APP_NAME') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    <meta name="description" content="This is meta description">
    <meta name="author" content="Themefisher">
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/xs-icon">

    <!-- # Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Neuton:wght@700&family=Work+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- # CSS Plugins -->
    {{-- <link rel="stylesheet" href="{{ asset('frontend_theme/') }}/plugins/bootstrap/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <!-- # Main Style Sheet -->
    <link rel="stylesheet" href="{{ asset('frontend_theme/') }}/css/style.css">
    @stack('css')
    <style>
        .leaflet-popup-content-wrapper {
            width: 250px;
            /* Adjust width as needed */
            max-height: 300px;
            /* Adjust max height as needed */
            overflow: auto;
            /* Enable scrolling if content exceeds max height */
        }

        .leaflet-popup-content img {
            max-width: 90%;
            /* Ensure images fit within popup */
            height: auto;
        }

        .leaflet-popup-tip {
            display: none;
            /* Hide the popup tip if you prefer */
        }
    </style>

</head>

<body>

    <header class="navigation">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light px-0">
                <a class="navbar-brand order-1 py-0" href="{{ url('/') }}">
                    <img loading="prelaod" decoding="async" class="img-fluid" src="{{ asset('img/logo.png') }}"
                        alt="Reporter Hugo" style="height: 80px;">
                </a>
                <div class="navbar-actions order-3 ml-0 ml-md-4">
                    <button aria-label="navbar toggler" class="navbar-toggler border-0" type="button"
                        data-toggle="collapse" data-target="#navigation"> <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse text-center order-lg-2 order-4" id="navigation">
                    <ul class="navbar-nav mx-auto mt-3 mt-lg-0">
                        <li class="nav-item"> <a class="nav-link" href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="{{ url('/maps') }}">Maps</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="{{ url('/about') }}">About</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="{{ url('/form-pemesanan') }}">Pesan Tiket</a>
                        </li>
                        <li class="nav-item"> <a class="nav-link" href="{{ url('/check-tiket') }}">Cek Tiket</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-dark mt-5">
        <div class="container section">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center">
                    <a class="d-inline-block mb-4 pb-2" href="{{ url('/') }}">
                        <img loading="prelaod" decoding="async" class="img-fluid" src="{{ asset('img/logo.png') }}"
                            alt="Reporter Hugo" style="height:100px;">
                    </a>
                    <ul class="p-0 d-flex navbar-footer mb-0 list-unstyled">
                        <li class="nav-item my-0"> <a class="nav-link" href="{{ url('/') }}">Home</a></li>
                        <li class="nav-item my-0"> <a class="nav-link" href="{{ url('/maps') }}">Maps</a></li>
                        <li class="nav-item my-0"> <a class="nav-link" href="{{ url('/about') }}">About</a>
                        </li>
                        <li class="nav-item my-0"> <a class="nav-link" href="{{ url('/check-tiket') }}">Check TIket</a>
                        </li>
                        @guest
                            <li class="nav-item my-0"> <a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        @else
                            <li class="nav-item my-0"> <a class="nav-link" href="{{ route('home') }}">Dashboard</a></li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
        <div class="copyright bg-dark content">Designed &amp; Developed By <a
                href="{{ url('/') }}">{{ env('APP_NAME') }}</a></div>
    </footer>


    <!-- # JS Plugins -->
    <script src="{{ asset('frontend_theme/') }}/plugins/jquery/jquery.min.js"></script>
    <script src="{{ asset('frontend_theme/') }}/plugins/bootstrap/bootstrap.min.js"></script>

    <!-- Main Script -->
    <script src={{ asset('frontend_theme/') }}/js/script.js"></script>
    @stack('js')

</body>

</html>
