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
                        <div class="card-body hmkm">
                            {{ $datas['hmkm'] }} Data
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <a href="{{ route('oils.index') }}?pool={{ request()->query('pool') }}">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-cubes"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Oil & Coolant</h4>
                        </div>
                        <div class="card-body oil">
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
                        <div class="card-body cbm">
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

    <script>
        // $(document).ready(function() {
        //     setInterval(() => {
        //         $.get("{{ route('api.onboardings.index') }}?pool_id=" + "{{ request()->query('pool') }}")
        //             .done(function(result) {
        //                 $.each(result.data, function(key, value) {
        //                     $('.' + key).text(value + ' Data');
        //                 });
        //             }).fail(function(xhr) {
        //                 handleResponse(xhr)
        //             })
        //     }, 15000);
        // })
    </script>
@endpush
