@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="container">
            <h2 class="text-center">{{ $title }}</h3>
        </div>
    </section>
    <section class="section">
        <div class="container">
            @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    {{ Session::get('error') }}

                </div>
            @endif
            <form action="{{ url('/search-tiket') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="d-flex">
                    <input type="text" name="barcode" class="form-control" placeholder="Kode Tiket" required
                        value="{{ old('barcode') ?? '' }}">
                    <button type="submit" class="btn btn-primary">Check</button>
                </div>
            </form>
        </div>
    </section>
@endsection
