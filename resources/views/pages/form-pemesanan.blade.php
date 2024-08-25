@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h2 class="text-center">{{ $title }}</h2>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-8">
                    <form action="{{ route('tiket.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="my-3 d-flex justify-content-end">
                            <div class="p-2 border rounded bg-success text-white" style="min-width:150px;">
                                <small>Total Tagihan : </small>
                                <h1 class="text-white">Rp <span
                                        id="total-harga">{{ number_format($setting->harga_tiket) }}</span></h1>
                            </div>
                        </div>
                        <input type="hidden" name="total_harga" id="input-total-harga">
                        <div class="mb-3">
                            <label>Nama Pemesan <span class="text-danger">*</span></label>
                            <input type="text" placeholder="Nama Pemesan" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Nomor HP/WA <span class="text-danger">*</span></label>
                            <input type="text" placeholder="+628xxxxxxxxx" name="no_hp" class="form-control"
                                value="+62" required>
                        </div>
                        <div class="mb-3">
                            <label>Jumlah Pengunjung <span class="text-danger">*</span></label>
                            <input type="number" id="jumlah-pengunjung" name="jumlah" class="form-control" min="1"
                                value="1" required>
                        </div>
                        <div class="mb-3">
                            <label>Tanggal Kunjungan</label>
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Keterangan Pemesanan (jika ada)</label>
                            <textarea class="form-control" name="keterangan">-</textarea>
                        </div>
                        <div class="my-2">
                            <button type="submit" class="btn btn-primary">Pesan Tiket</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const hargaTiket = {{ $setting->harga_tiket }};
                const jumlahInput = document.getElementById('jumlah-pengunjung');
                const totalHargaElement = document.getElementById('total-harga');
                const totalHargaInput = document.getElementById('input-total-harga');

                function updateTotal() {
                    const jumlah = parseInt(jumlahInput.value, 10);
                    const total = hargaTiket * jumlah;
                    totalHargaElement.textContent = total.toLocaleString('id-ID');
                    totalHargaInput.value = total;
                }

                jumlahInput.addEventListener('input', updateTotal);

                // Initial calculation
                updateTotal();
            });
        </script>
    @endpush
@endsection