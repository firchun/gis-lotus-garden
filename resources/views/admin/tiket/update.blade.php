@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-6">
            <div class="card-box mb-30">
                <div class="card-body">
                    <div class="mb-3">
                        {{ $title }}
                    </div>
                    <!-- Barcode Scanner -->
                    <div class="form-group">
                        <div style="display: none;" id="scanner-group">
                            <div id="loadingMessage">🎥 Tidak dapat mengakses kamera (Mohon untuk mengaktifkan pengaturan
                                kamera)</div>
                            <div id="scanner" style="width: 100%; height: 480px; position: relative;">
                                <!-- Scanner container will handle responsiveness -->
                            </div>
                            <div id="output" hidden>
                                <div id="outputMessage">No barcode detected.</div>
                                <div hidden><b>Data:</b> <span id="outputData"></span></div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="button" id="btnActivateScanner" class="btn btn-success">Aktifkan Scanner</button>
                            <button type="button" id="btnDeactivateScanner" class="btn btn-danger" disabled>Non-Aktifkan
                                Scanner</button>
                        </div>
                    </div>
                    <form id="formUpdate">
                        <div class="d-flex form-group">
                            <input type="text" id="barcode" class="form-control form-group" placeholder="Kode Tiket"
                                required autofocus>
                            <button type="button" id="btnUpdate" class="btn btn-primary form-group">Update</button>
                        </div>
                    </form>

                    <!-- Display result here -->
                    <div id="result" class="mt-3"></div>

                    <!-- Update form -->
                    <div id="updateForm" style="display:none;">
                        <hr>
                        <h3>Konfirmasi Jumlah Pengunjung</h3>
                        <form id="formUpdateDetails" action="{{ route('tiket.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="updateBarcode" name="barcode">
                            <div class="form-group">
                                <label for="updateJumlah">Jumlah Pengunjung Dewasa</label>
                                <input type="number" id="updateJumlah" name="jumlah_dewasa" class="form-control"
                                    min="1" required>
                            </div>
                            <div class="form-group">
                                <label for="updateJumlahAnak">Jumlah Pengunjung Anak-anak</label>
                                <input type="number" id="updateJumlahAnak" name="jumlah_anak" class="form-control"
                                    min="0" required>
                            </div>
                            <hr>
                            <strong class="mb-3">Tambah Fasilitas</strong>
                            @foreach ($fasilitas as $item)
                                <div class="border p-2 shadow-sm rounded">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="id_fasilitas[]"
                                            value="{{ $item->id }}" id="fasilitas-{{ $item->id }}">
                                        <label class="form-check-label" for="defaultCheck1">
                                            {{ $item->nama }} - Rp {{ number_format($item->harga) }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                            <hr>
                            <div class="form-group">
                                <label for="total_harga">Total Harga</label>
                                <input type="text" id="total_harga" class="form-control" name="total_harga" readonly>
                            </div>
                            <button type="submit" id="btnSave" class="btn btn-lg btn-success btn-block">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://unpkg.com/@ericblade/quagga2@0.0.1/dist/quagga.min.js"></script>
    <script>
        $(document).ready(function() {
            var scannerActive = false;

            function initializeQuagga() {
                Quagga.init({
                    inputStream: {
                        name: "Live",
                        type: "LiveStream",
                        target: document.querySelector(
                            '#scanner'), // The DOM element where the video will be displayed
                        constraints: {
                            facingMode: "environment"
                        }
                    },
                    decoder: {
                        readers: ["code_128_reader", "ean_reader", "ean_8_reader",
                            "upc_reader"
                        ] // List of supported barcode formats
                    }
                }, function(err) {
                    if (err) {
                        console.error(err);
                        return;
                    }
                    Quagga.start();
                    $('#loadingMessage').hide();
                });
            }

            function startScanner() {
                if (!scannerActive) {
                    initializeQuagga();
                    scannerActive = true;
                    $('#updateForm').hide();
                    $('#result').hide();
                    $('#barcode').val(''); // Corrected ID
                    $('#scanner-group').show(); // Corrected ID
                    $('#btnActivateScanner').prop('disabled', true);
                    $('#btnDeactivateScanner').prop('disabled', false);
                }
            }

            function stopScanner() {
                if (scannerActive) {
                    Quagga.stop();
                    $('#scanner').hide();
                    $('#scanner-group').hide(); // Corrected ID
                    scannerActive = false;
                    $('#btnActivateScanner').prop('disabled', false);
                    $('#btnDeactivateScanner').prop('disabled', true);
                }
            }

            $('#btnActivateScanner').click(function() {
                $('#scanner').show();
                startScanner();
            });

            $('#btnDeactivateScanner').click(function() {
                stopScanner();
            });

            Quagga.onDetected(function(result) {
                var code = result.codeResult.code;
                $('#barcode').val(code);
                $('#btnUpdate').click(); // Trigger the update button click
                stopScanner(); // Hide scanner after detection
            });

            Quagga.onProcessed(function(result) {
                if (result && result.codeResult) {
                    var barcode = result.codeResult.code;
                    $('#outputData').text(barcode);
                    $('#outputMessage').hide();
                    $('#output').show();
                } else {
                    $('#outputMessage').show();
                }
            });

            // Adjust scanner size based on window resize
            $(window).resize(function() {
                adjustScannerSize();
            });

            function adjustScannerSize() {
                var scanner = $('#scanner');

                scanner.css({
                    width: '100%',
                    height: '100%'
                });

                if (scannerActive) {
                    Quagga.init({
                        inputStream: {
                            name: "Live",
                            type: "LiveStream",
                            target: document.querySelector(
                                '#scanner'), // The DOM element where the video will be displayed
                            constraints: {
                                facingMode: "environment"
                            }
                        }
                    }, function(err) {
                        if (err) {
                            console.error(err);
                            return;
                        }
                        Quagga.start();
                    });
                }
            }

            adjustScannerSize(); // Initial call to set size

            // Handle Enter key press
            $('#barcode').keypress(function(event) {
                if (event.which === 13) { // Enter key
                    event.preventDefault(); // Prevent default form submission
                    $('#btnUpdate').click(); // Trigger the update button click
                }
            });

            var hargaTiket = {{ $harga_tiket }}; // Pass the ticket price to the script
            var hargaTiketAnak = {{ $harga_tiket_anak }}; // Pass the ticket price to the script

            $('#btnUpdate').click(function() {
                $('#scanner').hide();
                var barcode = $('#barcode').val().trim();
                if (barcode === '') {
                    alert('Please enter a barcode.');
                    return;
                }

                $.ajax({
                    url: '/tiket/get-one/' + barcode,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#result').show();
                        if (response.success) {
                            var data = response.data;
                            $('#result').html(`
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <h3>Update Tiket</h3>
                                    <h3 id="total_harga_display" class="text-danger">Rp ${data.total_harga}</h3>
                                </div>
                                <hr>
                                <p><strong>Barcode:</strong> ${data.barcode}</p>
                                <p><strong>Nama:</strong> ${data.nama}</p>
                                <p><strong>No HP/WA:</strong> ${data.no_hp}</p>
                                <p><strong>Tanggal Kunjungan:</strong> ${data.tanggal}</p>
                                `);

                            // Populate the form
                            $('#updateBarcode').val(data.barcode);
                            $('#updateJumlah').val(data.jumlah_dewasa);
                            $('#updateJumlahAnak').val(data.jumlah_anak);
                            $('#total_harga').val(((data.jumlah_dewasa *
                                hargaTiket) + (data.jumlah_anak *
                                hargaTiketAnak))); // Initial total price

                            // Show the update form
                            $('#updateForm').show();
                        } else {
                            $('#result').html(
                                `<p class="text-danger"> ${response.message} </p>`);
                            $('#updateForm').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#result').html(
                            '<p class="text-danger">Terjadi kesalahan saat mengambil data.</p>'
                        );
                        $('#updateForm').hide();
                    }
                });
            });

            // Update total price when quantity changes
            // $('#updateJumlah, #updateJumlahAnak').on('input', function() {
            //     var jumlahDewasa = $('#updateJumlah').val();
            //     var jumlahAnak = $('#updateJumlahAnak').val();


            //     var totalHargaDewasa = jumlahDewasa ? jumlahDewasa * hargaTiket : 0;
            //     var totalHargaAnak = jumlahAnak ? jumlahAnak * hargaTiketAnak : 0;

            //     var totalHarga = totalHargaDewasa + totalHargaAnak;

            //     $('#total_harga').val(totalHarga);
            //     $('#total_harga_display').text('Rp ' + totalHarga);
            // });
            // Update total price when quantity changes or facilities are selected/deselected
            $('#updateJumlah, #updateJumlahAnak, .form-check-input').on('input change', function() {
                var jumlahDewasa = $('#updateJumlah').val();
                var jumlahAnak = $('#updateJumlahAnak').val();

                // Calculate total price for tickets
                var totalHargaDewasa = jumlahDewasa ? jumlahDewasa * hargaTiket : 0;
                var totalHargaAnak = jumlahAnak ? jumlahAnak * hargaTiketAnak : 0;

                // Calculate total price for selected facilities
                var totalHargaFasilitas = 0;
                var fasilitasRequests = [];
                // $('.form-check-input:checked').each(function() {
                //     totalHargaFasilitas += parseFloat($(this).val());
                // });
                $('.form-check-input:checked').each(function() {
                    var facilityId = $(this).val();
                    if (facilityId) {
                        fasilitasRequests.push(
                            $.ajax({
                                url: '/fasilitas/edit/' + facilityId,
                                method: 'GET',
                                dataType: 'json'
                            })
                        );
                    }
                });
                $.when.apply($, fasilitasRequests).done(function() {
                    // Convert arguments object to an array
                    var responses = Array.prototype.slice.call(arguments);

                    responses.forEach(function(response) {
                        var data = response; // The data returned from the AJAX request
                        // console.log(data);
                        totalHargaFasilitas += parseFloat(data.harga) || 0;
                    });


                    // Calculate total price
                    var totalHarga = totalHargaDewasa + totalHargaAnak + totalHargaFasilitas;

                    // Update display
                    $('#total_harga').val(totalHarga);
                    $('#total_harga_display').text('Rp ' + totalHarga.toLocaleString());
                });
                // // Calculate total price
                // var totalHarga = totalHargaDewasa + totalHargaAnak + totalHargaFasilitas;

                // // Update display
                // $('#total_harga').val(totalHarga);
                // $('#total_harga_display').text('Rp ' + totalHarga);
            });

        });
    </script>
@endpush
