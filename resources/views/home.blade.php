@extends('layouts.template', ['title' => 'Dashboard'])
@push('css')
    <!-- CSS Libraries -->
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-cubes"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Aset</h4>
                    </div>
                    <div class="card-body">
                        {{ $data['jumlah'] }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Nilai</h4>
                    </div>
                    <div class="card-body">
                        Rp. {{ hrg($data['nilai']) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-calculator"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Aset Terpakai</h4>
                    </div>
                    <div class="card-body">
                        {{ $data['terpakai'] }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Aset Rusak</h4>
                    </div>
                    <div class="card-body">
                        {{ $data['rusak'] }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <canvas id="myChart" height="180"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <canvas id="myChart3" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('lib/chart.js/dist/Chart.min.js') }}"></script>

    <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: [
                        "{{ $data['terpakai'] }}",
                        "{{ $data['tidak_terpakai'] }}",
                    ],
                    backgroundColor: [
                        '#6777ef',
                        '#ffa426',
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    'Terpakai',
                    'Tidak Terpakai',
                ],
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
            }
        });

        var ctx = document.getElementById("myChart3").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [
                        "{{ $data['baik'] }}",
                        "{{ $data['rusak'] }}",
                    ],
                    backgroundColor: [
                        '#63ed7a',
                        '#fc544b',
                    ],
                    label: 'Dataset 1'
                }],
                labels: [
                    'Baik',
                    'Rusak',
                ],
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
            }
        });
    </script>
@endpush
