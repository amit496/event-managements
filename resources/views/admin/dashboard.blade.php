@extends('admin.layout.app')
@section('title', 'Dashboard')
@section('content_header')
    <h1 class="m-0">Dashboard</h1>
@stop
@section('content')
@include('admin.partials.flash')

<div class="row">
    <div class="col-md-3 col-6">
        <div class="small-box bg-info dashboard-kpi dashboard-kpi-users">
            <div class="inner">
                <h3>{{ $totalUsers }}</h3>
                <p>Users</p>
            </div>
            <div class="icon dashboard-kpi-icon"><i class="fas fa-users"></i></div>
            <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                Manage Users <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="small-box bg-success dashboard-kpi dashboard-kpi-events">
            <div class="inner">
                <h3>{{ $totalEvents }}</h3>
                <p>Total Events</p>
            </div>
            <div class="icon dashboard-kpi-icon"><i class="fas fa-calendar-check"></i></div>
            <a href="{{ route('admin.events.index') }}" class="small-box-footer">
                View Events <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="small-box bg-warning dashboard-kpi dashboard-kpi-upcoming">
            <div class="inner">
                <h3>{{ $upcomingEvents }}</h3>
                <p>Upcoming</p>
            </div>
            <div class="icon dashboard-kpi-icon"><i class="fas fa-hourglass-half"></i></div>
            <a href="{{ route('admin.events.index', ['sort' => 'start_at', 'dir' => 'asc']) }}" class="small-box-footer">
                Upcoming List <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="small-box bg-primary dashboard-kpi dashboard-kpi-featured">
            <div class="inner">
                <h3>{{ $featuredEvents }}</h3>
                <p>Featured</p>
            </div>
            <div class="icon dashboard-kpi-icon"><i class="fas fa-award"></i></div>
            <a href="{{ route('admin.events.index') }}" class="small-box-footer">
                Featured Events <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h3 class="card-title mb-0">6-Month Activity Trend</h3>
                <div class="btn-group btn-group-sm" role="group" aria-label="Trend chart type">
                    <button type="button" class="btn btn-outline-secondary active js-trend-type" data-type="bar">Bar</button>
                    <button type="button" class="btn btn-outline-secondary js-trend-type" data-type="line">Line</button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="dashboardTrendChart" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h3 class="card-title mb-0">Event Status Mix</h3>
                <div class="btn-group btn-group-sm" role="group" aria-label="Status chart type">
                    <button type="button" class="btn btn-outline-secondary active js-status-type" data-type="pie">Pie</button>
                    <button type="button" class="btn btn-outline-secondary js-status-type" data-type="bar">Bar</button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="dashboardStatusChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0">Collection By Client</h3>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Expected</th>
                            <th>Received</th>
                            <th>Due</th>
                            <th>Collection</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($clientCollections as $row)
                            <tr>
                                <td>{{ $row['client_name'] }}</td>
                                <td>{{ number_format($row['expected_total'], 2) }}</td>
                                <td>{{ number_format($row['received_total'], 2) }}</td>
                                <td>{{ number_format($row['due_total'], 2) }}</td>
                                <td>
                                    <span class="badge {{ $row['collection_percent'] >= 100 ? 'badge-success' : ($row['collection_percent'] > 0 ? 'badge-info' : 'badge-secondary') }}">
                                        {{ number_format($row['collection_percent'], 1) }}%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">No collection data found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0">Overdue Receivables</h3>
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-sm table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Booking</th>
                            <th>Client</th>
                            <th>Event Date</th>
                            <th>Due</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($overdueReceivables as $row)
                            <tr>
                                <td>
                                    {{ $row['booking_code'] }}<br>
                                    <small class="text-muted">{{ $row['event_title'] }}</small>
                                </td>
                                <td>{{ $row['client_name'] }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($row['event_date'])->format('d M Y') }}</td>
                                <td>{{ number_format($row['due_total'], 2) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center">No overdue receivables.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('css')
    @vite(['resources/css/app.css'])
    <style>
        .dashboard-kpi {
            position: relative;
            overflow: hidden;
            border-radius: .5rem;
        }

        .dashboard-kpi .inner {
            position: relative;
            z-index: 2;
        }

        .dashboard-kpi .small-box-footer {
            position: relative;
            z-index: 2;
        }

        .dashboard-kpi .dashboard-kpi-icon {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 52px;
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 1.35rem;
            line-height: 1;
            transition: transform .2s ease;
            z-index: 2;
        }

        .dashboard-kpi:hover .dashboard-kpi-icon {
            transform: translateY(-2px);
        }

        .dashboard-kpi-users .dashboard-kpi-icon {
            color: #0a3d62;
            background: rgba(255, 255, 255, .88);
        }

        .dashboard-kpi-events .dashboard-kpi-icon {
            color: #166534;
            background: rgba(255, 255, 255, .9);
        }

        .dashboard-kpi-upcoming .dashboard-kpi-icon {
            color: #92400e;
            background: rgba(255, 255, 255, .9);
        }

        .dashboard-kpi-featured .dashboard-kpi-icon {
            color: #1e3a8a;
            background: rgba(255, 255, 255, .88);
        }
    </style>
@stop
@section('js')
    @vite(['resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const labels = @json($chartLabels);
            const eventSeries = @json($eventSeries);
            const paymentSeries = @json($paymentSeries);
            const statusLabels = @json($statusLabels);
            const statusSeries = @json($statusSeries);

            let trendType = 'bar';
            let statusType = 'pie';
            let trendChart = null;
            let statusChart = null;

            const trendCanvas = document.getElementById('dashboardTrendChart');
            const statusCanvas = document.getElementById('dashboardStatusChart');

            function renderTrendChart() {
                if (!trendCanvas) {
                    return;
                }

                if (trendChart) {
                    trendChart.destroy();
                }

                trendChart = new Chart(trendCanvas, {
                    type: trendType,
                    data: {
                        labels,
                        datasets: [
                            {
                                label: 'Events Created',
                                data: eventSeries,
                                backgroundColor: 'rgba(0, 123, 255, 0.45)',
                                borderColor: 'rgba(0, 123, 255, 1)',
                                borderWidth: 2,
                                tension: 0.3,
                            },
                            {
                                label: 'Payments Created',
                                data: paymentSeries,
                                backgroundColor: 'rgba(40, 167, 69, 0.45)',
                                borderColor: 'rgba(40, 167, 69, 1)',
                                borderWidth: 2,
                                tension: 0.3,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true, ticks: { precision: 0 } },
                        },
                    },
                });
            }

            function renderStatusChart() {
                if (!statusCanvas) {
                    return;
                }

                if (statusChart) {
                    statusChart.destroy();
                }

                statusChart = new Chart(statusCanvas, {
                    type: statusType,
                    data: {
                        labels: statusLabels,
                        datasets: [
                            {
                                label: 'Events',
                                data: statusSeries,
                                backgroundColor: [
                                    'rgba(0, 123, 255, 0.75)',
                                    'rgba(40, 167, 69, 0.75)',
                                    'rgba(255, 193, 7, 0.75)',
                                    'rgba(220, 53, 69, 0.75)',
                                ],
                                borderWidth: 1,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: statusType === 'bar' ? { y: { beginAtZero: true, ticks: { precision: 0 } } } : {},
                    },
                });
            }

            function bindToggleButtons(selector, callback) {
                document.querySelectorAll(selector).forEach(function (button) {
                    button.addEventListener('click', function () {
                        document.querySelectorAll(selector).forEach(function (b) {
                            b.classList.remove('active');
                        });
                        button.classList.add('active');
                        callback(button.dataset.type);
                    });
                });
            }

            bindToggleButtons('.js-trend-type', function (nextType) {
                trendType = nextType;
                renderTrendChart();
            });

            bindToggleButtons('.js-status-type', function (nextType) {
                statusType = nextType;
                renderStatusChart();
            });

            renderTrendChart();
            renderStatusChart();
        });
    </script>
@stop
