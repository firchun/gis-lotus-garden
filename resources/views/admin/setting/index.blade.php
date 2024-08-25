@extends('layouts.backend.admin')

@section('content')
    @include('layouts.backend.alert')
    <form class="mb-30" action="{{ route('setting.update') }}" method="POST">
        @csrf
        {{-- step --}}
        <div class="row mb-3 align-items-center">
            <div class="col-lg-6 col-md-4 mb-3">
                <h3>Tentang Wisata</h3>
            </div>
            <div class="col-lg-6 col-md-4">
                <div class="card-box">
                    <div class="card-body">
                        <textarea class="form-control" name="about">{{ $setting->about }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        {{-- step --}}
        <div class="row mb-3 align-items-center">
            <div class="col-lg-6 col-md-4 mb-3">
                <h3>Alamat Wisata</h3>
            </div>
            <div class="col-lg-6 col-md-4">
                <div class="card-box">
                    <div class="card-body">
                        <textarea class="form-control" name="alamat">{{ $setting->alamat }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        {{-- step --}}
        <div class="row mb-3 align-items-center">
            <div class="col-lg-6 col-md-4 mb-3">
                <h3>No. HP/WA</h3>
            </div>
            <div class="col-lg-6 col-md-4">
                <div class="card-box">
                    <div class="card-body">
                        <input type="text" class="form-control" name="no_hp" value="{{ $setting->no_hp }}">
                    </div>
                </div>
            </div>
        </div>
        {{-- step --}}
        <div class="row mb-3 align-items-center">
            <div class="col-lg-6 col-md-4 mb-3">
                <h3>Harga Tiket Masuk Wisata</h3>
            </div>
            <div class="col-lg-6 col-md-4">
                <div class="card-box">
                    <div class="card-body">
                        <input type="text" class="form-control" name="harga_tiket" value="{{ $setting->harga_tiket }}">
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg btn-block">Simpan Perubahan</button>
        </div>
    </form>
@endsection
