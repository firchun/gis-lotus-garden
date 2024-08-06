@extends('layouts.backend.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box mb-4">
                <div class="user-profile-header-banner">
                    <img src="{{ asset('img') }}/profile-banner.png" alt="Banner image" class="rounded-top"
                        style="object-fit: cover; width:100%;">
                </div>
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img src="{{ asset('img/user.png') }}" style="height: 100px;" alt="user image"
                            class="d-block ms-0 ms-sm-4 rounded user-profile-img">
                    </div>
                    <div class="flex-grow-1 mt-3 mt-sm-5">
                        <div
                            class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                            <div class="user-profile-info">
                                <h4>{{ Auth::user()->name }}</h4>
                                <ul
                                    class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                    <li class="list-inline-item fw-medium">
                                        <i class="bx bx-pen"></i>{{ Auth::user()->role ?? 'None' }}
                                    </li>
                                    <li class="list-inline-item fw-medium">
                                        <i class="bx bx-calendar-alt"></i> {{ Auth::user()->created_at->format('d F Y') }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12  order-lg-1">
            <div class="card-box shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">My Account</h6>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('profile.update') }}" autocomplete="off">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <input type="hidden" name="_method" value="PUT">

                        <h6 class="heading-small text-muted mb-4">User information</h6>

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group focused mb-3">
                                        <label class="form-control-label" for="name">Name<span
                                                class="small text-danger">*</span></label>
                                        <input type="text" id="name"
                                            class="form-control  @error('name') is-invalid @enderror" name="name"
                                            placeholder="Name" value="{{ Auth::user()->name }}">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group  mb-3">
                                        <label class="form-control-label" for="email">Email address<span
                                                class="small text-danger">*</span></label>
                                        <input type="email" id="email"
                                            class="form-control  @error('email') is-invalid @enderror" name="email"
                                            placeholder="example@example.com"
                                            value="{{ old('email', Auth::user()->email) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group focused  mb-3">
                                        <label class="form-control-label" for="current_password">Current
                                            password</label>
                                        <input type="password" id="current_password"
                                            class="form-control  @error('current_password') is-invalid @enderror"
                                            name="current_password" placeholder="Current password">
                                        @error('current_password')
                                            <span class="text-danger" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused  mb-3">
                                        <label class="form-control-label" for="new_password">New password</label>
                                        <input type="password" id="new_password"
                                            class="form-control  @error('new_password') is-invalid @enderror"
                                            name="new_password" placeholder="New password">
                                        @error('new_password')
                                            <span class="text-danger" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group focused  mb-3">
                                        <label class="form-control-label" for="confirm_password">Confirm
                                            password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="confirm_password"
                                                class="form-control  @error('password_confirmation') is-invalid @enderror"
                                                name="password_confirmation" placeholder="Confirm password">

                                            @error('password_confirmation')
                                                <span class="text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <button type="submit" class="btn btn-primary">Save
                                        Changes</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection
