@extends('layouts.template', ['title' => 'Data One Scania'])
@push('css')
@endpush
@section('content')
    <div class="row">

        <div class="col-12">
            <form action="" method="GET">
                <div class="input-group mb-3">
                    <input type="search" name="search" id="input_search" class="form-control form-control-lg"
                        placeholder="Cari Part Number" value="{{ request()->query('search') }}">
                    <div class="input-group-append">
                        <button type="button" id="btn_search" class="btn btn-primary"><i
                                class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12" id="container_data">

        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            search()

            $('#btn_search').click(function() {
                search()
            })

            $('#input_search').change(function() {
                search()
            })

            $('form').submit(function(e) {
                e.preventDefault()
                search()
            })
        });

        function search() {
            let input = $('#input_search').val()
            $('#container_data').html('')
            if (input == null || input == '') {
                show_toast('error', 'Isi Part Number Untuk Mencari Data!')
                return
            }

            $.ajax({
                url: '{{ route('api.one_scanias.index') }}',
                type: 'GET',
                data: {
                    number: input
                },
                success: function(result) {
                    $('#container_data').html('')
                    result.data.forEach(item => {
                        $('#container_data').append(`
                        <div class="card mb-3">
                                <div class="card-body p-0">
                                    <table class="table table-sm table-bordered">
                                        <tbody>
                                            <tr>
                                                <td class="col-5">Part Number Scania</td>
                                                <td class="col-7"><b>${item.number || ''}</b></td>
                                            </tr>
                                            <tr>
                                                <td class="col-5">Nama Part Subtitusi</td>
                                                <td class="col-7"><b>${item.name || ''}</b></td>
                                            </tr>
                                            <tr>
                                                <td class="col-5">Unit</td>
                                                <td class="col-7">${item.unit || ''}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-5">Component</td>
                                                <td class="col-7">${item.component || ''}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-5">Satuan</td>
                                                <td class="col-7">${item.satuan_map || ''}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-5">Price MAP</td>
                                                <td class="col-7">Rp ${item.price_map_parse || ''}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-5">Satuan</td>
                                                <td class="col-7">${item.satuan_vendor || ''}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-5">Price Vendor</td>
                                                <td class="col-7">Rp ${item.price_vendor_parse || ''}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-5">Vendor</td>
                                                <td class="col-7">${item.vendor || ''}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-5">Brand</td>
                                                <td class="col-7">${item.brand || ''}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-5">Remark</td>
                                                <td class="col-7">${item.remark || ''}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-5">Lampiran</td>
                                                <td class="col-7">${
                                                                item.file
                                                                    ? `<b><a href="${item.file}" target="_blank">Download Lampiran</a></b>`
                                                                    : `<span class="text-muted">Tidak ada lampiran</span>`
                                                            }</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `)
                    });
                },
                error: function(xhr, status, error) {
                    show_toast('error', xhr.responseJSON.message || 'Error!')
                }
            })
        }
    </script>
@endpush
