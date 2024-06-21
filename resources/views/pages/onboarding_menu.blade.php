@extends('layouts.template', ['title' => 'Onboarding'])
@push('css')
    <!-- CSS Libraries -->
@endpush
@section('content')
    <div class="row">

        @include('components.alert', ['pool' => $pool])

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('hmkms.index') }}?pool={{ request()->query('pool') }}">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="fas fa-bus"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>HM KM</h4>
                        </div>
                        <div class="card-body">
                            {{ $datas['hmkm'] }} Data
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('logbooks.index') }}">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Logbook</h4>
                        </div>
                        <div class="card-body">
                            {{ $datas['logbook'] }} Data
                        </div>
                    </div>
                </div>
            </a>
        </div> --}}

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('oils.index') }}?pool={{ request()->query('pool') }}">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-cubes"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Oil & Coolant</h4>
                        </div>
                        <div class="card-body">
                            {{ $datas['oil'] }} Data
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('cbms.index') }}?pool={{ request()->query('pool') }}">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-wrench"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>CBM</h4>
                        </div>
                        <div class="card-body">
                            {{ $datas['cbm'] }} Data
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>
@endsection

@push('js')
    <script src="{{ asset('lib/chart.js/dist/Chart.min.js') }}"></script>

    <script></script>
@endpush
