@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('img/slider/slide-1.jpg') }}" class="d-block w-100" alt="..."
                            style="height: 500px; object-fit:cover;">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('img/slider/slide-2.jpg') }}" class="d-block w-100" alt="..."
                            style="height: 500px; object-fit:cover;">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('img/slider/slide-3.jpg') }}" class="d-block w-100" alt="..."
                            style="height: 500px; object-fit:cover;">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls"
                    data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-target="#carouselExampleControls"
                    data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </button>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="jumbotron">
                <h1 class="display-4">Selamat Datang di Taman Wisata Lotus Garden</h1>
                <p class="lead">Rasakan keindahan alam dan kedamaian di Lotus Garden, tempat ideal untuk berlibur bersama
                    keluarga dan teman. Temukan keajaiban flora, nikmati suasana yang menenangkan, dan buat kenangan yang
                    tak terlupakan.</p>
                <hr class="my-4">
                <a class="btn btn-primary btn-lg" href="{{ url('/form-pemesanan') }}" role="button">Pesan Tiket</a>
                <a class="btn btn-warning btn-lg" href="{{ url('/check-tiket') }}" role="button">Cek Tiket</a>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <h3 class="text-center mb-3">Peta Taman Wisata</h3>
            <div id="map" style="height: 550px;border-radius:20px;" class="border border-success"></div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <h3 class="text-center">Fasilitas Unggulan</h3>
            <div class="row justify-content-center align-items-center">
                @foreach (App\Models\Fasilitas::limit(6)->latest()->get() as $item)
                    <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="card text-center" style="width: 18rem;">
                            <img src="{{ Storage::url($item->foto) }}" class="card-img-top" alt="{{ $item->nama }}"
                                style="height: 250px; width:100%; object-fit:cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->nama }}</h5>
                                <p class="card-text">{{ Str::limit($item->keterangan, 50) }}</p>
                                <a href="{{ url('/detail-fasilitas', $item->slug) }}" class="btn btn-primary">Lihat
                                    Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="my-3 d-flex justify-content-center">
                <a href="{{ Url('/semua-fasilitas') }}" class="btn btn-primary">Lihat Semua Fasilitas Wisata</a>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <!-- Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://downtowncarypark.com/wp-content/themes/nmc_carypark/assets/leaflet.css">
    <script src="https://downtowncarypark.com/wp-content/themes/nmc_carypark/assets/leaflet.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var mediaQuery = window.matchMedia('(min-width: 600px)');
            var map = L.map('map', {
                crs: L.CRS.Simple,
                zoomSnap: 0.25,
                zoomDelta: 0.25,
                minZoom: -1,
                attributionControl: false
            });

            var currentMarker = null;

            function handleMobileChange(e) {
                if (e.matches) {
                    map.setZoom(-0.5);
                    map.setView([970, 0]);
                    map.setMaxBounds([
                        [-200, -200],
                        [1200, 1200]
                    ]);
                } else {
                    map.setZoom(-1);
                    map.setView([600, 400]);
                    map.setMaxBounds([
                        [-500, -500],
                        [1500, 1500]
                    ]);
                }
            }

            var bounds = [
                [0, 0],
                [1000, 1000]
            ];
            var image = L.imageOverlay(
                '{{ asset('img/map-wisata-lotus.jpg') }}',
                bounds
            ).addTo(map);

            image.on('load', function() {
                map.fitBounds(bounds);
            });

            mediaQuery.addEventListener('change', handleMobileChange);
            handleMobileChange(mediaQuery);

            // Add a click event listener to the map
            map.on('click', function(e) {
                var pixelCoords = e.latlng; // Directly use pixel coordinates

                document.getElementById('latitude').value = pixelCoords.lat;
                document.getElementById('longitude').value = pixelCoords.lng;

                // Remove the existing marker if any
                if (currentMarker) {
                    map.removeLayer(currentMarker);
                }

                // Add a new marker using pixel coordinates
                currentMarker = L.marker(pixelCoords).addTo(map);
            });

            // Assume facilities data is available as pixel coordinates
            var facilities = @json($fasilitas); // Assuming pixel coordinates are provided

            // Add markers to the map
            facilities.forEach(function(facility) {
                // Directly use pixel coordinates from the facilities data
                var markerCoords = L.latLng(facility.latitude, facility.longitude);

                // Create popup content with photo
                var popupContent = '<h4 class="m-0">' + facility.nama + '</h4><br>' +

                    '<img src="' + facility.photo_url + '" alt="' + facility.nama +
                    '" style="width: 2000px; height: auto;"/>' +
                    '<br><br><a class="btn btn-success p-1 text-white rounded" href="' +
                    '{{ url('/detail-fasilitas') }}/' + facility.slug + '" >Lihat Selengkapnya<a>';

                L.marker(markerCoords, {
                        title: facility.nama
                    }).addTo(map)
                    .bindPopup(popupContent);

            });
        });
    </script>
@endpush
