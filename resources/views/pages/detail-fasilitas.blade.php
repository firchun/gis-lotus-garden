@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h2 class="text-center">{{ $title }}</h3>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <center>
                <img src="{{ Storage::url($fasilitas->foto) }}" class="img-fluid text-center" alt="{{ $fasilitas->nama }}">
            </center>
            <p class="mt-3">
                {{ $fasilitas->keterangan }}
            </p>
        </div>
    </section>
@endsection
