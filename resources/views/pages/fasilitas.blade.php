@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h2 class="text-center">{{ $title }}</h3>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                @foreach ($fasilitas as $item)
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
            <div class="my-3 d-flex justify-content-center">
                {{ $fasilitas->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </section>
@endsection
