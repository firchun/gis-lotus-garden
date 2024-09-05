@extends('layouts.backend.admin')
@push('css')
    <style>
        ol,
        li {
            list-style-type: desimal;
        }
    </style>
@endpush
@section('content')
    @include('layouts.backend.alert')
    <div class="dt-action-buttons text-end pt-3 pt-md-0 mb-4">
        <div class=" btn-group " role="group">
            <button class="btn btn-secondary refresh btn-default" type="button">
                <span>
                    <i class="bi bi-arrow-clockwise me-sm-1"> </i>
                    <span class="d-none d-sm-inline-block">Refresh Data</span>
                </span>
            </button>

        </div>
    </div>
    <div class="my-3">
        <div class="row">
            @include('admin.dashboard_component.card1', [
                'count' => $tiket_pending,
                'title' => 'Tiket Pending',
                'subtitle' => 'Total Pemesanan Tiket Pending',
                'color' => 'warning',
                'icon' => 'ticket',
            ])
            @include('admin.dashboard_component.card1', [
                'count' => $tiket_terpakai,
                'title' => 'Tiket Terpakai',
                'subtitle' => 'Total Pemesanan Tiket Terpakai',
                'color' => 'success',
                'icon' => 'ticket',
            ])
            @include('admin.dashboard_component.card1', [
                'count' => $pendapatan,
                'title' => 'Pendapatan',
                'subtitle' => 'Total Pendapatan Tiket',
                'color' => 'danger',
                'icon' => 'money',
            ])
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card-box mb-30">
                <div class="card-body">
                    <h2>{{ $title }}</h2>
                </div>
                <div class="table-responsive">

                    <table id="datatable-tiket" class="table table-h0ver  display mb-3">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kunjungan</th>
                                <th>code</th>
                                <th>Nama</th>
                                <th>No. HP/WA</th>
                                <th>Dewasa</th>
                                <th>Anak-anak</th>
                                <th>Harga</th>
                                <th>Booking</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kunjungan</th>
                                <th>code</th>
                                <th>Nama</th>
                                <th>No. HP/WA</th>
                                <th>Dewasa</th>
                                <th>Anak-anak</th>
                                <th>Harga</th>
                                <th>Booking</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.tiket.script')
