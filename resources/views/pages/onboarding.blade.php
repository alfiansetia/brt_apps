@extends('layouts.template', ['title' => 'Dashboard'])
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
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-{{ $color[$rand] }}">
                        {!! $item['icon'] !!}
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            {{-- <h4>{{ $item->name }}</h4> --}}
                        </div>
                        <div class="card-body">
                            {{ $item['name'] }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection

@push('js')
    <script src="{{ asset('lib/chart.js/dist/Chart.min.js') }}"></script>

    <script></script>
@endpush
