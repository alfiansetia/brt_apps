@extends('layouts.template', ['title' => 'Tes'])
@push('css')
    <!-- CSS Libraries -->
@endpush
@section('content')
    <div class="row">
        <table class="table table-hovered">
            <thead>
                <tr>
                    @foreach ($results['column'] as $item)
                        <th>{{ $item }}</th>
                    @endforeach
                </tr>
            </thead>
            @foreach ($results['row'] as $item)
                <tr>
                    @foreach ($item as $row)
                        <td>{{ $row }}</td>
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
