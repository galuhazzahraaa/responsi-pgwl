<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
        crossorigin="" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @yield('styles')
    <!-- Tambahkan CSS Kustom Anda di sini -->
    <style>
        body {
            background-color: #035ba4 !important;
            /* Ganti dengan warna yang Anda inginkan */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        nav {
            background-color: #035ba4 !important;
            /* Samakan dengan warna body */
        }

        .navbar,
        .navbar-collapse,
        .modal-content {
            background-color: #035ba4 !important;
            /* Samakan dengan warna body */
        }

        .nav-link,
        .navbar-brand,
        .navbar-toggler-icon,
        .dropdown-item,
        .modal-title,
        .modal-body,
        .btn,
        .fa-utensils {
            color: #ffffff !important;
            /* Set font color to white */
        }

        .dropdown-menu {
            background-color: #035ba4 !important;
            /* Warna latar belakang dropdown */
        }

        .dropdown-item {
            color: #ffffff !important;
            /* Warna teks dropdown */
        }

        .dropdown-item:hover,
        .dropdown-item:focus {
            background-color: #035ba4 !important;
            /* Warna latar belakang saat hover */
        }

        .right-icon {
            margin-left: auto;
            /* Biar rata kanan */
            font-size: 1.25rem;
            /* Sesuaikan ukuran ikon agar sama dengan kiri */
        }

        .navbar-brand i {
            margin-right: 10px;
            /* Jarak ikon sebelah kiri */
            font-size: 1.25rem;
            /* Sesuaikan ukuran ikon sebelah kiri */
        }

        #map {
            flex: 1;
            background-color: #ffffff !important;
            /* Warna default untuk peta */
        }

        @media (max-width: 768px) {
            .navbar-nav {
                text-align: center;
            }

            .navbar-collapse {
                background-color: #035ba4 !important;
            }

            .nav-item {
                margin: 5px 0;
            }

            .right-icon {
                display: none;
            }
        }

        .leaflet-marker-icon {
            filter: sepia(1) saturate(100) hue-rotate(0deg) brightness(1.2) contrast(1);
        }
    </style>
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-utensils"></i> Bandung Legendary Craving
                Map</a>
            <i class="fa-solid fa-utensils right-icon"></i>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('index') }}"><i
                                class="fa-solid fa-house-fire"></i> Home</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false"><i class="fa-solid fa-list"></i></i> List </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('table-point') }}"><i
                                        class="fa-solid fa-location-dot"></i></i> Restaurant List </a></li>
                            {{-- <li><a class="dropdown-item" href="{{ route('table-polyline') }}"><i
                                        class="fa-solid fa-table"></i> Table Polyline</a></li> --}}
                            {{-- <li><a class="dropdown-item" href="{{ route('table-polygon') }}"><i
                                        class="fa-solid fa-table"></i> Table Polygon</a></li>
                            <li> --}}
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#infoModal"><i class="fa-solid fa-info"></i> Info</a></li>
                        </ul>
                    </li>

                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#infoModal"><i
                                class="fa-solid fa-info"></i> Info</a>
                    </li> --}}

                    @if (Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}"><i class="fa-solid fa-user"></i>
                                Dashboard</a>
                        </li>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <li class="nav-item">
                                <button class="nav-link text-danger" type="submit"><i
                                        class="fa-solid fa-right-from-bracket"></i> Logout</button>
                            </li>
                        </form>
                    @else
                        <li class="nav-item">
                            <a class="nav-link text-primary" href="{{ route('login') }}"><i
                                    class="fa-solid fa-right-to-bracket"></i> Login</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">INFO</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Selamat datang di peta yang legendaris, tempat Anda bisa menemukan semua kuliner legendaris di
                        Bandung. Selamat menjelajah!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    {{-- jQuery JS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    @include('components.toast')

    @yield('script')

</body>

</html>
