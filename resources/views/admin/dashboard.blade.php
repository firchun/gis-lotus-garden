@extends('layouts.backend.admin')

@section('content')
    <div class="title pb-20">
        <h2 class="h3 mb-0">Dashboard Overview</h2>
    </div>
    <div class="my-3">
        <div class="card">
            <div class="card-body">
                <canvas id="tiketChart" style="max-height: 250px;"></canvas>

            </div>
        </div>
    </div>
    <hr>
    <div class="row justify-content-center">
        @include('admin.dashboard_component.card1', [
            'count' => $users,
            'title' => 'Users',
            'subtitle' => 'Total users',
            'color' => 'primary',
            'icon' => 'user',
        ])
        @include('admin.dashboard_component.card1', [
            'count' => $tiket,
            'title' => 'Tiket',
            'subtitle' => 'Total Pemesanan Tiket',
            'color' => 'warning',
            'icon' => 'ticket',
        ])
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
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function renderChart() {
            const ctx = document.getElementById('tiketChart').getContext('2d');

            // Data dari controller
            const days = @json($days); // Ubah 'weeks' menjadi 'days'
            const totals = @json($totals);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: days, // Ubah 'weeks' menjadi 'days'
                    datasets: [{
                        label: 'Jumlah Tiket Terpakai',
                        data: totals,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 1,
                        fill: true // Tidak mengisi area di bawah garis
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        tooltip: {
                            mode: 'index',
                            intersect: true
                        },
                        annotation: {
                            annotations: {
                                line1: {
                                    type: 'line',
                                    xMin: days.length - 1, // Mengatur pada titik terakhir
                                    xMax: days.length - 1, // Mengatur pada titik terakhir
                                    borderColor: 'red',
                                    borderWidth: 2,
                                    label: {
                                        content: 'Waktu Sekarang',
                                        enabled: true,
                                        position: 'top'
                                    }
                                }
                            }
                        }
                    },
                    elements: {
                        line: {
                            tension: 0.4 // Mengatur kelengkungan garis untuk visualisasi lebih smooth
                        }
                    }
                }
            });
        }
        renderChart();
    </script>
@endpush
