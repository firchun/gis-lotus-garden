@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h2 class="text-center">{{ $title }}</h3>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <h5>Tentang :</h5>
            <p>
                {{ $about->about }}
            </p>
            <h5>Kontak :</h5>
            <p>
            <ol>
                <li>No. HP/WA : {{ $about->no_hp }}</li>
                <li>Alamat : {{ $about->alamat }}</li>
            </ol>
            </p>
        </div>
    </section>
@endsection
