@extends('layouts.template', ['title' => 'Tes'])
@push('css')
    <!-- CSS Libraries -->
@endpush
@section('content')
    <div class="row">
        <table class="table table-hovered">
            <thead>
                <tr>
                    <th>UNIT</th>
                    @foreach ($speeds as $item)
                        <th>{{ $item->date }}</th>
                    @endforeach
                </tr>
            </thead>
            @foreach ($units as $item)
                <tr>
                    <td>{{ $item->code }}</td>
                    @foreach ($speeds as $speed)
                        <td>{{ $speed->items()->where('unit_id', $item->id)->first()->value ?? 0 }}</td>
                    @endforeach
                </tr>
            @endforeach
            <tbody>

            </tbody>
        </table>
    </div>
@endsection

@push('js')
@endpush
