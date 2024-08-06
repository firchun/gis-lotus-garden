<!DOCTYPE html>

<html lang="en">

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <title>{{ $title ?? 'Home' }} - {{ env('APP_NAME') ?? 'Laravel' }}</title>
    @stack('css')
    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('backend_theme') }}/vendors/images/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('backend_theme') }}/vendors/images/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('backend_theme') }}/vendors/images/favicon-16x16.png" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend_theme') }}/vendors/styles/core.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend_theme') }}/vendors/styles/icon-font.min.css" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend_theme') }}/src/plugins/datatables/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('backend_theme') }}/src/plugins/datatables/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend_theme') }}/vendors/styles/style.css" />


    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());

        gtag("config", "G-GBZ3SGGX85");
    </script>

</head>

<body>
    {{-- <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo">
                <img src="{{ asset('backend_theme') }}/vendors/images/deskapp-logo.svg" alt="" />
            </div>
            <div class="loader-progress" id="progress_div">
                <div class="bar" id="bar1"></div>
            </div>
            <div class="percent" id="percent1">0%</div>
            <div class="loading-text">Loading...</div>
        </div>
    </div> --}}
    @include('layouts.backend.navbar')
    @include('layouts.backend.menu')
    <div class="mobile-menu-overlay"></div>
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="" style="min-height: calc(90vh - 120px);">
                @include('layouts.backend.breadcrumbs')
                @yield('content')
            </div>
            @include('layouts.backend.footer')

        </div>
    </div>

    <!-- js -->
    <script src="{{ asset('backend_theme') }}/vendors/scripts/core.js"></script>
    <script src="{{ asset('backend_theme') }}/vendors/scripts/script.min.js"></script>
    <script src="{{ asset('backend_theme') }}/vendors/scripts/process.js"></script>
    <script src="{{ asset('backend_theme') }}/vendors/scripts/layout-settings.js"></script>
    <script src="{{ asset('backend_theme') }}/src/plugins/apexcharts/apexcharts.min.js"></script>
    <script src="{{ asset('backend_theme') }}/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('backend_theme') }}/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('backend_theme') }}/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('backend_theme') }}/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('backend_theme') }}/vendors/scripts/dashboard3.js"></script>
    <!-- buttons for Export datatable -->
    <script src="{{ asset('backend_theme') }}/src/plugins/datatables/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('backend_theme') }}/src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('backend_theme') }}/src/plugins/datatables/js/buttons.print.min.js"></script>
    <script src="{{ asset('backend_theme') }}/src/plugins/datatables/js/buttons.html5.min.js"></script>
    <script src="{{ asset('backend_theme') }}/src/plugins/datatables/js/buttons.flash.min.js"></script>
    <script src="{{ asset('backend_theme') }}/src/plugins/datatables/js/pdfmake.min.js"></script>
    <script src="{{ asset('backend_theme') }}/src/plugins/datatables/js/vfs_fonts.js"></script>
    <!-- Datatable Setting js -->
    <script src="{{ asset('backend_theme') }}/vendors/scripts/datatable-setting.js"></script>
    @stack('js')
    <script>
        $(".delete-button").on('click', function(e) {
            e.preventDefault();
            let form = $(this).parents('form');

            swal.fire({
                title: 'Apakah Anda yakin ingin menghapus data ini?',
                text: 'Data yang dihapus tidak bisa dikembalikan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit()

                    swal.fire(
                        'Dikonfirmasi!',
                        'Data akan dihapus.',
                        'success'
                    )
                }
            })
        })
        $(document).ready(function() {
            $('#datatable').DataTable({
                // responsive: true,
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ ",
                    "zeroRecords": "Maaf belum ada data",
                    "info": "Tampilkan data _PAGE_ dari _PAGES_",
                    "infoEmpty": "belum ada data",
                    "infoFiltered": "(saring from _MAX_ total data)",
                    "search": "Cari : ",
                    "paginate": {
                        "previous": "Sebelumnya ",
                        "next": "Selanjutnya"
                    }
                }

            });
        });
        $(document).ready(function() {
            $('#datatable2').DataTable({
                // responsive: true,
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ ",
                    "zeroRecords": "Maaf belum ada data",
                    "info": "Tampilkan data _PAGE_ dari _PAGES_",
                    "infoEmpty": "belum ada data",
                    "infoFiltered": "(saring from _MAX_ total data)",
                    "search": "Cari : ",
                    "paginate": {
                        "previous": "Sebelumnya ",
                        "next": "Selanjutnya"
                    }
                }
            });
        });
        $(document).ready(function() {
            $('#datatable-export').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf'
                ]
            });
        });
    </script>
    <script>
        flatpickr("input[type=date]");
    </script>
    @if (Session::has('danger'))
        <script>
            Swal.fire({
                title: 'Error!',
                text: ' {{ Session::get('danger') }}',
                type: 'error',
                icon: 'error',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            })
        </script>
    @endif

    @if (Session::has('success'))
        <script>
            Swal.fire({
                title: 'Good job!',
                text: '{{ Session::get('success') }}',
                type: 'success',
                icon: 'success',
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            })
        </script>
    @endif
</body>

</html>
