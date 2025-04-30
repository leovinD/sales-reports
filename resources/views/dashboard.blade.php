@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1 class="mb-5 text-center fw-bold">Nicamae Macay</h1>

        <div class="row g-4 mb-5">
            <!-- Total Sales Value -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title text-muted">Total Sales Value</h5>
                        <p class="display-6 fw-bold text-pink mb-0">
                            ₱{{ number_format($totalSalesValue, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        
            <!-- Number of Sales Records -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title text-muted">Number of Sales Records</h5>
                        <p class="display-6 fw-bold text-pink mb-0">
                            {{ $numberOfSales }}
                        </p>
                    </div>
                </div>
            </div>
        
            <!-- Total Products Sold & Products Per Region -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title text-muted">
                            Total Products Sold: <span class="fw-bold text-pink">{{ $totalSalesUnits }}</span>
                        </h5>
                        <hr class="my-3" />
                        <h6 class="fw-bold mb-3">Products Sold Per Region</h6>
                        <ul class="list-unstyled">
                            @foreach ($salesPerRegion as $region)
                                <li class="h6 fw-semibold text-pink mb-1">
                                    {{ $region->region }}: {{ $region->total_units }} units
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        

        <style>
            .text-pink {
                color: #E91E63 !important;
            }
        </style>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent fw-bold border-0">
                        Sales Count Per Region
                    </div>
                    <div class="card-body">
                        <canvas id="salesPerRegionChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent fw-bold border-0">
                        Products Sold Per Month
                    </div>
                    <div class="card-body">
                        <canvas id="salesPerMonthChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Line Chart
        const salesPerMonthCtx = document.getElementById('salesPerMonthChart').getContext('2d');
        new Chart(salesPerMonthCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($salesPerMonth->pluck('month')) !!},
                datasets: [{
                    label: 'Units Sold',
                    data: {!! json_encode($salesPerMonth->pluck('units_sold')) !!},
                    borderColor: '#EC407A',
                    backgroundColor: 'rgba(236, 64, 122, 0.2)', 
                    pointBackgroundColor: '#D81B60',
                    pointBorderColor: '#AD1457',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Bar Chart
        const salesPerRegionCtx = document.getElementById('salesPerRegionChart').getContext('2d');
        new Chart(salesPerRegionCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($salesPerRegion->pluck('region')) !!},
                datasets: [{
                    label: 'Units Sold',
                    data: {!! json_encode($salesPerRegion->pluck('total_units')) !!},
                    backgroundColor: '#F06292', 
                    borderColor: '#C2185B',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
