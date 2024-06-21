@extends('layouts.template', ['title' => 'Onboarding'])
@push('css')
    <!-- CSS Libraries -->
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info alert-has-icon alert-dismissible show fade">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                    <div class="alert-title">Hello {{ $user->name }}!</div>
                    Silahkan Pilih Pool!
                </div>
                <button class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        </div>
        @php
            $color = ['primary', 'warning', 'success', 'danger', 'info'];
        @endphp
        @foreach ($data as $item)
            @php
                $rand = array_rand($color);
            @endphp
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{ route('onboarding.menu') }}?pool={{ $item->id }}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-{{ $color[$rand] }}">
                            <i class="fas fa-building"></i>
                            {{-- <img src="{{ $item['image'] }}" alt="" width="100%" height="100%"> --}}
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                {{-- <h4>{{ $item->name }}</h4> --}}
                            </div>
                            <div class="card-body">
                                <h4>{{ $item->name }}</h4>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach

        {{-- <div class="col-lg-3 col-md-6 col-sm-6 col-12">
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
        </div> --}}

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('logbooks.index') }}">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-tags"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            {{-- <h4 style="font-weight: bold">Logbook</h4> --}}
                        </div>
                        <div class="card-body">
                            <h4>Logbook</h4>
                            {{-- {{ $datas['logbook'] }} Data --}}
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- <div class="col-lg-3 col-md-6 col-sm-6 col-12">
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
        </div> --}}

        {{-- <div class="col-lg-3 col-md-6 col-sm-6 col-12">
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
        </div> --}}

    </div>
@endsection

@push('js')
    <script src="{{ asset('lib/chart.js/dist/Chart.min.js') }}"></script>

    <script></script>
@endpush
