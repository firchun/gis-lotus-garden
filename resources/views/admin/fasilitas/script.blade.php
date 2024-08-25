@push('js')
    <script>
        $(function() {
            $('#datatable-customers').DataTable({
                processing: true,
                serverSide: false,
                responsive: false,
                ajax: '{{ url('fasilitas-datatable') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'foto',
                        name: 'foto'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },

                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'harga',
                        name: 'harga'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
            $('.create-new').click(function() {
                $('#create').modal('show');
            });
            $('.refresh').click(function() {
                $('#datatable-customers').DataTable().ajax.reload();
            });
            window.editCustomer = function(id) {
                $.ajax({
                    type: 'GET',
                    url: '/fasilitas/edit/' + id,
                    success: function(response) {
                        $('#edit-nama').val(response.nama);
                        $('#edit-keterangan').val(response.keterangan);
                        $('#edit-type').val(response.type);
                        $('#edit-biaya').val(response.biaya);
                        $('#edit-latitude').val(response.latitude);
                        $('#edit-longitude').val(response.longitude);
                        if (response.photo_url) {
                            document.getElementById('edit-photo-preview').src = response.photo_url;
                        } else {
                            document.getElementById('edit-photo-preview').src = '';
                        }
                        editMap.setView([response.latitude, response.longitude]);
                        L.marker([response.latitude, response.longitude]).addTo(editMap);


                        $('#customersModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            };
            $('#saveCustomerBtn').click(function() {
                var formData = $('#userForm').serialize();

                $.ajax({
                    type: 'POST',
                    url: '/fasilitas/store',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        // Refresh DataTable setelah menyimpan perubahan
                        $('#datatable-customers').DataTable().ajax.reload();
                        $('#customersModal').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });
            $('#createCustomerBtn').click(function() {
                var formData = new FormData($('#createUserForm')[0]);

                $.ajax({
                    type: 'POST',
                    url: '/fasilitas/store',
                    data: formData,
                    processData: false, // Prevent jQuery from automatically transforming the data into a query string
                    contentType: false, // Prevent jQuery from setting content-type header
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#datatable-customers').DataTable().ajax.reload();
                        $('#create').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            });

            window.deleteCustomers = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus fasilitas ini?')) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/fasilitas/delete/' + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // alert(response.message);
                            $('#datatable-customers').DataTable().ajax.reload();
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
