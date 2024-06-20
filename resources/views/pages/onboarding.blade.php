@extends('layouts.template', ['title' => 'Onboarding'])
@push('css')
    <!-- CSS Libraries -->
@endpush
@section('content')
    <div class="row">
        @php
            $color = ['primary', 'secondary', 'warning', 'success', 'danger', 'info', 'dark'];
        @endphp
        @foreach ($data as $item)
            @php
                $rand = array_rand($color);
            @endphp
            {{-- <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-{{ $color[$rand] }}">
                        <img src="{{ $item['image'] }}" alt="" width="100%" height="100%">
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ $item->name }}</h4>
                        </div>
                    </div>
                </div>
            </div> --}}
        @endforeach

        <div class="col-12">
            <div class="alert alert-info alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                    <div class="alert-title">Welcome {{ $user->name }}!</div>
                    @if (empty($user->pool))
                        You don't have a pool, Please Contact Admin!
                    @else
                        You are at the {{ $user->pool->name }} pool
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('hmkms.index') }}">
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

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
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
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('oils.index') }}">
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
            <a href="{{ route('cbms.index') }}">
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
