@extends('layouts.template')

@section('styles')
    <style>
        html,
        body {
            height: 100%;
            width: 100%;
        }

        #map {
            height: calc(100vh - 56px);
            width: 100%;
            margin: 0;
        }

        .leaflet-control-layers-toggle,
        .leaflet-control-zoom,
        .leaflet-bar {
            background-color: white !important;
            border: 1px solid #ccc !important;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.65) !important;
        }

        .leaflet-control-layers-toggle {
            width: 36px !important;
            height: 36px !important;
            background-size: 26px !important;
        }

        .leaflet-container a {
            color: #0078A8 !important;
        }

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/2.9.9/leaflet-search.min.css" />
@endsection

@section('content')
    <div id="map" style="width: 100vw; height: 100vh; margin: 0"></div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script src="https://unpkg.com/terraformer@1.0.7/terraformer.js"></script>
<script src="https://unpkg.com/terraformer-wkt-parser@1.1.2/terraformer-wkt-parser.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-providers/1.5.1/leaflet-providers.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
<script src="https://cdn.jsdelivr.net/gh/shramov/leaflet-plugins@gh-pages/layer/tile/Google.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-search/2.9.9/leaflet-search.min.js"></script>
<script>
    //map
    var map = L.map('map').setView([-6.9159330363648746, 107.61099573717676], 13);

    // Basemap Google Maps
    var googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    }).addTo(map);

    /* GeoJSON Point */
    var point = L.geoJson(null, {
        onEachFeature: function(feature, layer) {
            var popupContent = "Name: " + feature.properties.name + "<br>" +
                "Description: " + feature.properties.description + "<br>" +
                "Foto: <img src='{{ asset('storage/images/') }}/" + feature.properties.image +
                "' class='img-thumbnail' alt='...'>" + "<br>" +
                "<div class='d-flex flex-row mt-3'>" +
                "<form action='{{ url('delete-point') }}/" + feature.properties.id + "' method='POST'>" +
                '{{ csrf_field() }}' +
                '{{ method_field('DELETE') }}' +
                "<button type='submit' class='btn btn-danger' onclick='return confirm(Yakin Anda akan menghapus data ini?)'>" +
                "<i class='fa-solid fa-trash'></i></button>" +
                "</form>" +
                "<a href='{{ url('edit-point') }}/" + feature.properties.id +
                "' class='btn btn-sm btn-warning'><i class='fa-solid fa-edit'></i></a>" +
                "</div>";

            layer.on({
                click: function(e) {
                    layer.bindPopup(popupContent).openPopup();
                },
                mouseover: function(e) {
                    layer.bindTooltip(feature.properties.kab_kota).openTooltip();
                },
            });
        },
    });

    $.getJSON("{{ route('api.points') }}", function(data) {
        point.addData(data);
        map.addLayer(point);
    });

    /* GeoJSON Polyline */
    var polyline = L.geoJson(null, {
        onEachFeature: function(feature, layer) {
            var popupContent = "Name: " + feature.properties.name + "<br>" +
                "Description: " + feature.properties.description + "<br>" +
                "Foto: <img src='{{ asset('storage/images/') }}/" + feature.properties.image +
                "' class='img-thumbnail' alt='...'>" + "<br>";

            layer.on({
                click: function(e) {
                    polyline.bindPopup(popupContent);
                },
                mouseover: function(e) {
                    polyline.bindTooltip(feature.properties.name);
                },
            });
        },
    });

    $.getJSON("{{ route('api.polylines') }}", function(data) {
        polyline.addData(data);
        map.addLayer(polyline);
    });

    /* GeoJSON Polygon */
    var polygon = L.geoJson(null, {
        onEachFeature: function(feature, layer) {
            var popupContent = "Name: " + feature.properties.name + "<br>" +
                "Description: " + feature.properties.description + "<br>" +
                "Foto: <img src='{{ asset('storage/images/') }}/" + feature.properties.image +
                "' class='img-thumbnail' alt='...'>" + "<br>";

            layer.on({
                click: function(e) {
                    polygon.bindPopup(popupContent);
                },
                mouseover: function(e) {
                    polygon.bindTooltip(feature.properties.name);
                },
            });
        },
    });

    $.getJSON("{{ route('api.polygons') }}", function(data) {
        polygon.addData(data);
        map.addLayer(polygon);
    });

    // Create a GeoJSON layer for polygon data
    var Bandung = L.geoJson(null, {
            style: function(feature) {
                // Adjust this function to define styles based on your polygon properties
                var value = feature.properties.nama; // Change this to your actual property name
                return {
                    fillColor: getColor(value),
                    weight: 2,
                    opacity: 0,
                    color: "green",
                    dashArray: "3",
                    fillOpacity: 0,
                };
            },
            onEachFeature: function(feature, layer) {
                // Adjust the popup content based on your polygon properties
                var content =
                    "WADMKC: " +
                    feature.properties.WADMKC +
                    "<br>";

                layer.bindPopup(content);
            },
        });

        // Function to generate a random color //
        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        // Load GeoJSON //
        fetch('storage/shapefile/Admin_Bandung.geojson')
            .then(response => response.json())
            .then(data => {
                L.geoJSON(data, {
                    style: function(feature) {
                        return {
                            opacity: 1,
                            color: "blue",
                            weight: 0.5,
                            fillOpacity: 0.5,
                            fillColor: getRandomColor(),
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        var content = "WADMKC : " + feature.properties.WADMKC;
                        layer.on({
                            click: function(e) {
                                // Fungsi ketika objek diklik
                                layer.bindPopup(content).openPopup();
                            },
                            mouseover: function(e) {
                                // Tidak ada perubahan warna saat mouse over
                                layer.bindPopup("WADMKC : " + feature.properties.WADMKC, {
                                    sticky: false
                                }).openPopup();
                            },
                            mouseout: function(e) {
                                // Fungsi ketika mouse keluar dari objek
                                layer.resetStyle(e
                                    .target); // Mengembalikan gaya garis ke gaya awal
                                map.closePopup(); // Menutup popup
                            },
                        });
                    }

                }).addTo(map);
            })
            .catch(error => {
                console.error('Error loading the GeoJSON file:', error);
            });

    // Layer control
    var overlayMaps = {
        "Point": point,
        "Polyline": polyline,
        "Polygon": polygon
    };

    var layerControl = L.control.layers(null, overlayMaps).addTo(map);

    // Search control
    var searchControl = new L.Control.Search({
        layer: point,
        propertyName: 'name',
        moveToLocation: function(latlng, title, map) {
            // Set the view to the selected point
            map.setView(latlng, 17);
        }
    });

    searchControl.on('search:locationfound', function(e) {
        // Open the popup when the search location is found
        e.layer.openPopup();
    });

    map.addControl(searchControl);

    // Directly open search control
    searchControl._input.style.display = 'block';
    searchControl._container.style.display = 'block';
</script>
@endsection
