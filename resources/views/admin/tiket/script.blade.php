@push('js')
    <script>
        $(function() {
            $('#datatable-tiket').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                ajax: '{{ url('tiket-datatable') }}',
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
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'total_harga',
                        name: 'total_harga'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                ]
            });
            $('.refresh').click(function() {
                $('#datatable-tiket').DataTable().ajax.reload();
            });


        });
    </script>
@endpush
