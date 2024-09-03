@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <div class="dt-action-buttons text-end pt-3 pt-md-0 mb-4">
        <div class=" btn-group " role="group">
            <button class="btn btn-secondary refresh btn-default" type="button">
                <span>
                    <i class="bi bi-arrow-clockwise me-sm-1"> </i>
                    <span class="d-none d-sm-inline-block">Refresh Data</span>
                </span>
            </button>

        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card-box mb-30">
                <div class="card-body">
                    <h2>{{ $title }}</h2>
                </div>
                <hr>
                <div class="m-2">
                    <div class="my-2">
                        <label>Filter data : </label>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">Tanggal</span>
                                <input type="date" class="form-control" name="from_date" id="fromDate">
                                <span class="input-group-text">Sampai</span>
                                <input type="date" class="form-control" name="to_date" id="toDate">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary" id="btnFilter"><i
                                    class="bi bi-filter"></i>Filter</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">

                    <table id="datatable-pembayaran" class="table table-h0ver  display mb-3">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kunjungan</th>
                                <th>code</th>
                                <th>Nama</th>
                                <th>Harga</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kunjungan</th>
                                <th>code</th>
                                <th>Nama</th>
                                <th>Harga</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            table = $('#datatable-pembayaran').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                ajax: {
                    url: '{{ url('pembayaran-datatable') }}',
                    data: function(d) {
                        d.from_date = $('#fromDate').val();
                        d.to_date = $('#toDate').val();
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'created',
                        name: 'created'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },

                    {
                        data: 'barcode',
                        name: 'barcode'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },

                    {
                        data: 'total_harga',
                        name: 'total_harga'
                    },
                ],

                dom: 'lBfrtip',
                buttons: [{
                    extend: 'pdf',
                    text: '<i class=" i bi-file-pdf"> </i> PDF ',
                    className: 'btn-danger mx-3',
                    action: function(e, dt, button, config) {
                        var from_date = document.getElementById('fromDate').value;
                        var to_date = document.getElementById('toDate').value;
                        var url = '{{ url('laporan/print-keuangan') }}' + '?from_date=' +
                            encodeURIComponent(from_date) + '&to_date=' + encodeURIComponent(
                                to_date);
                        window.open(url, '_blank');
                    }
                }, {
                    extend: 'excelHtml5',
                    text: '<i class="bi bi-file-excel"></i> Excel',
                    className: 'btn-success',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }]
            });
            // Event handler untuk tombol filter
            $('#btnFilter').click(function() {
                table.ajax.reload();
            });

            // Event handler untuk tombol refresh
            $('.refresh').click(function() {
                $('#formDate').val(''); // Reset filter tanggal
                $('#toDate').val(''); // Reset filter tanggal
                table.ajax.reload();
            });
        });
    </script>
    <!-- Moment.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <!-- JS DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
@endpush
