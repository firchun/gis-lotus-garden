<!-- Modal for Create and Edit -->
<div class="modal fade" id="customersModal" tabindex="-1" aria-labelledby="customersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Fasilitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="editUserForm">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="edit-photo-preview" src="" alt="Current Photo" class="img-fluid mb-3"
                                style="max-height: 150px;">
                            <div class="mb-3">
                                <label for="edit-foto" class="form-label">Foto Fasilitas</label>
                                <input type="file" class="form-control" id="edit-foto" name="foto">
                            </div>
                            <div class="mb-3">
                                <label for="edit-nama" class="form-label">Nama Fasilitas</label>
                                <input type="text" class="form-control" id="edit-nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit-type" class="form-label">Type Fasilitas</label>
                                <select class="form-control" id="edit-type" name="type">
                                    <option value="Gratis">Gratis</option>
                                    <option value="Berbayar">Berbayar</option>
                                </select>
                            </div>
                            <div class="mb-3" id="edit-biaya-container">
                                <label for="edit-biaya" class="form-label">Biaya Tiket Fasilitas</label>
                                <input type="number" class="form-control" id="edit-biaya" name="biaya">
                            </div>
                            <div class="mb-3">
                                <label for="edit-keterangan" class="form-label">Keterangan Fasilitas</label>
                                <textarea class="form-control" id="edit-keterangan" name="keterangan" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div id="map-edit" style="height: 400px;"></div>
                            <div class="row mt-3">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="edit-latitude" class="form-label">Latitude</label>
                                        <input type="number" class="form-control" id="edit-latitude" name="latitude"
                                            step="any" required readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="edit-longitude" class="form-label">Longitude</label>
                                        <input type="number" class="form-control" id="edit-longitude" name="longitude"
                                            step="any" required readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updateFacilityBtn">Update</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="create" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Tambah Fasilitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for Create and Edit -->
                <form id="createUserForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="foto" class="form-label">Foto Fasilitas</label>
                                <input type="file" class="form-control" id="foto" name="foto" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Fasilitas</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">Type Fasilitas</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="Gratis">Gratis</option>
                                    <option value="Berbayar">Berbayar</option>
                                </select>
                            </div>
                            <div class="mb-3" id="biaya-container">
                                <label for="biaya" class="form-label">Biaya Tiket Fasilitas</label>
                                <input type="number" class="form-control" id="biaya" name="biaya">
                            </div>
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan Fasilitas</label>
                                <textarea class="form-control" id="keterangan" name="keterangan" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div id="map" style="height: 400px;"></div>
                            <div class="row mt-3">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="latitude" class="form-label">Latitude</label>
                                        <input type="number" class="form-control" id="latitude" name="latitude"
                                            step="any" required readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="longitude" class="form-label">Longitude</label>
                                        <input type="number" class="form-control" id="longitude" name="longitude"
                                            step="any" required readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="createCustomerBtn">Save</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var typeSelect = document.getElementById('type');
            var biayaContainer = document.getElementById('biaya-container');
            var biayaInput = document.getElementById('biaya');
            var typeSelectEdit = document.getElementById('edit-type');
            var biayaContainerEdit = document.getElementById('edit-biaya-container');
            var biayaInputEdit = document.getElementById('edit-biaya');

            function toggleBiayaVisibility() {
                if (typeSelect.value === 'Berbayar') {
                    biayaContainer.style.display = 'block';
                    biayaInput.required = true;
                    biayaInput.value = '1000';
                } else {
                    biayaContainer.style.display = 'none';
                    biayaInput.required = false;
                    biayaInput.value = '0';
                }
                if (typeSelectEdit.value === 'Berbayar') {
                    biayaContainerEdit.style.display = 'block';
                    biayaInputEdit.required = true;
                    biayaInputEdit.value = '1000';
                } else {
                    biayaContainerEdit.style.display = 'none';
                    biayaInputEdit.required = false;
                    biayaInputEdit.value = '0';
                }
            }

            toggleBiayaVisibility();
            typeSelect.addEventListener('change', toggleBiayaVisibility);
            typeSelectEdit.addEventListener('change', toggleBiayaVisibility);
        });
    </script>

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

            var centerLat = -8.3982281;
            var centerLng = 140.4206513;
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
                var pixelCoords = e.latlng;

                // Update latitude and longitude input fields
                document.getElementById('latitude').value = pixelCoords.lat;
                document.getElementById('longitude').value = pixelCoords.lng;

                // Remove the existing marker if any
                if (currentMarker) {
                    map.removeLayer(currentMarker);
                }

                // Add a new marker
                currentMarker = L.marker(pixelCoords).addTo(map);
            });
        });
    </script>
    <script>
        // Initialize Leaflet map function
        function initializeMap(mapId) {
            var map = L.map(mapId, {
                crs: L.CRS.Simple,
                zoomSnap: 0.25,
                zoomDelta: 0.25,
                minZoom: -1,
                attributionControl: false
            });

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

            var mediaQuery = window.matchMedia('(min-width: 600px)');

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

            mediaQuery.addEventListener('change', handleMobileChange);
            handleMobileChange(mediaQuery);

            return map;
        }

        // Initialize maps for Create and Edit modals
        var editMap = initializeMap('map-edit');
        var createMap = initializeMap('map');

        // Handle map click and place marker
        function handleMapClick(map, latitudeField, longitudeField) {
            var currentMarker = null;

            map.on('click', function(e) {
                var pixelCoords = e.latlng;
                latitudeField.val(pixelCoords.lat);
                longitudeField.val(pixelCoords.lng);

                // Remove the existing marker if any
                if (currentMarker) {
                    map.removeLayer(currentMarker);
                }

                currentMarker = L.marker(pixelCoords).addTo(map);
            });
        }

        handleMapClick(createMap, $('#latitude'), $('#longitude'));
        handleMapClick(editMap, $('#edit-latitude'), $('#edit-longitude'));
    </script>
@endpush
