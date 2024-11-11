@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h2 class="text-center">{{ $title }}</h3>
        </div>
    </section>
    <section class="section">
        <div class="container d-flex justify-content-center">
            <div class="card shadow border-0" style="max-width: 80%; border-radius:10px;">
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <img src="{{ Storage::url($fasilitas->foto) }}" class="img-fluid rounded shadow-sm"
                            alt="{{ $fasilitas->nama }}"
                            style="width:90%;max-height: 300px; object-fit: cover; border: 5px solid #04c401; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    </div>
                    <div class="py-4 px-2 m-2 shadow-sm border-success" style="border-radius: 10px;">
                        <b>Keterangan Fasilitas : </b><br> {{ $fasilitas->keterangan }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <h3 class="text-center mb-3">Fasilitas Lainnya</h3>
            <div class="row justify-content-center align-items-center">
                @foreach (App\Models\Fasilitas::where('id', '!=', $fasilitas->id)->limit(3)->latest()->get() as $item)
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
        </div>
    </section>
@endsection
