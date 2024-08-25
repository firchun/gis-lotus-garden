@extends('layouts.auth.app')

@section('content')
    @php
        $title = 'login';
    @endphp
    <div class="row align-items-center">
        <div class="col-md-6 col-lg-7">
            <img src="{{ asset('img/logo.png') }}" alt="" />
        </div>
        <div class="col-md-6 col-lg-5">
            <div class="login-box bg-white box-shadow border-radius-10">
                <div class="login-title">
                    <h2 class="text-center text-success">Login To {{ env('APP_NAME') }}</h2>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    {{-- <div class="select-role">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn active">
                                <input type="radio" name="options" id="admin" />
                                <div class="icon">
                                    <img src="{{ asset('backend_theme') }}/vendors/images/briefcase.svg" class="svg"
                                        alt="" />
                                </div>
                                <span>I'm</span>
                                Manager
                            </label>
                            <label class="btn">
                                <input type="radio" name="options" id="user" />
                                <div class="icon">
                                    <img src="{{ asset('backend_theme') }}/vendors/images/person.svg" class="svg"
                                        alt="" />
                                </div>
                                <span>I'm</span>
                                Employee
                            </label>
                        </div>
                    </div> --}}
                    <div class="input-group custom">
                        <input type="email" class="form-control form-control-lg" placeholder="Email address"
                            name="email" required />
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                        </div>
                    </div>
                    @error('email')
                        <span class="text-danger" role="alert">
                            <small>{{ $message }}</small>
                        </span>
                    @enderror
                    <div class="input-group custom">
                        <input type="password" class="form-control form-control-lg" placeholder="**********"
                            name="password" />
                        <div class="input-group-append custom">
                            <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                        </div>
                    </div>
                    @error('password')
                        <span class="text-danger" role="alert">
                            <small>{{ $message }}</small>
                        </span>
                    @enderror
                    <div class="row pb-30">
                        <div class="col-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input"name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }} />
                                <label class="custom-control-label" for="remember">Remember</label>
                            </div>
                        </div>
                        {{-- <div class="col-6">
                            <div class="forgot-password">
                                <a href="{{ route('password.request') }}">Forgot Password</a>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="input-group mb-0">
                                <button type="submit" class="btn btn-success btn-lg btn-block">Sign
                                    In</button>
                            </div>
                            {{-- <div class="font-16 weight-600 pt-10 pb-10 text-center" data-color="#707373">
                                OR
                            </div>
                            <div class="input-group mb-0">
                                <a class="btn btn-outline-primary btn-lg btn-block" href="{{ route('register') }}">Register
                                    To Create
                                    Account</a>
                            </div> --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
