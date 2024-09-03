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
                        data: 'barcode',
                        name: 'barcode'
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
                        data: 'jumlah_dewasa',
                        name: 'jumlah_dewasa'
                    },
                    {
                        data: 'jumlah_anak',
                        name: 'jumlah_anak'
                    },
                    {
                        data: 'total_harga',
                        name: 'total_harga'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
            $('.refresh').click(function() {
                $('#datatable-tiket').DataTable().ajax.reload();
            });
            window.deleteTiket = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus tiket ini?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/tiket/delete/' + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // alert(response.message);
                            $('#datatable-tiket').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            alert('Terjadi kesalahan: ' + xhr.responseText);
                        }
                    });
                }
            };

        });
    </script>
@endpush
