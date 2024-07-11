@extends('layouts.template', ['title' => 'Data Speed Limit'])
@push('css')
    <link rel="stylesheet" href="{{ asset('lib/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endpush
@section('content')
    <div class="row">

        @isset($pool)
            @include('components.alert', ['pool' => $pool])
        @endisset

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover" id="table" style="width: 100%;cursor: pointer;">
                        <thead>
                            <tr>
                                <th style="width: 30px;">#</th>
                                <th>Date</th>
                                <th style="width: 50px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('pages.speed.modal')
@endsection

@push('js')
    <script src="{{ asset('lib/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('lib/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('lib/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('lib/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('lib/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('lib/jquery-validation-1.20.1/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('lib/Inputmask-5.0.9/dist/jquery.inputmask.min.js') }}"></script>

    <script src="{{ asset('lib/html5-qrcode/html5-qrcode.min.js') }}"></script>

    <script>
        var url_index = "{{ route('api.speeds.index') }}"
        var id = 0
        var perpage = 50
        var pool_id = "{{ request()->query('pool') }}"
        var url_index_with_pool = url_index + "?pool_id=" + pool_id

        $(".select2").select2()

        $('.mask_angka').inputmask({
            alias: 'numeric',
            groupSeparator: '.',
            autoGroup: true,
            digits: 2,
            rightAlign: false,
            removeMaskOnSubmit: true,
            autoUnmask: true,
            digitsOptional: false,
            min: 0,
        });

        $('#btn_export').click(function() {
            let from = $('#range').data('daterangepicker').startDate.format('DD/MM/YYYY');
            let to = $('#range').data('daterangepicker').endDate.format('DD/MM/YYYY');
            window.open("{{ route('speeds.export') }}?from=" + from + '&to=' + to + '&pool_id=' + pool_id,
                '_blank')
        })

        var table = $("#table").DataTable({
            processing: true,
            serverSide: true,
            searchDelay: 500,
            ajax: {
                url: url_index_with_pool,
                error: function(xhr, textStatus, errorThrown) {
                    show_toast('error', xhr.responseJSON.message || 'server Error!')
                },
            },
            dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            oLanguage: {
                oPaginate: {
                    sPrevious: '<i class="fas fa-chevron-left"></i>',
                    sNext: '<i class="fas fa-chevron-right"></i>'
                },
                sSearch: '',
                sSearchPlaceholder: "Search...",
                sLengthMenu: "Results :  _MENU_",
            },
            lengthMenu: [
                [10, 50, 100, 500, 1000],
                ['10 rows', '50 rows', '100 rows', '500 rows', '1000 rows']
            ],
            pageLength: 10,
            lengthChange: true,
            columnDefs: [],
            order: [
                [1, 'desc'],
                [0, 'desc'],
            ],
            columns: [{
                data: 'id',
                searchable: false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            }, {
                data: 'date',
                searchable: false,
            }, {
                data: 'id',
                searchable: false,
                sortable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button class="btn btn-info btn-sm btn-detail">Detail</button>
                            <button class="btn btn-danger btn-sm btn-delete">Delete</button>
                        </div>`;
                    } else {
                        return data
                    }
                }
            }],
            buttons: [, {
                text: '<i class="fa fa-plus mr-1"></i>Add',
                className: 'btn btn-sm btn-primary bs-tooltip',
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Add Data'
                },
                action: function(e, dt, node, config) {
                    modal_add()
                }
            }, {
                extend: "colvis",
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Column Visible'
                },
                className: 'btn btn-sm btn-primary'
            }, {
                extend: "pageLength",
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Page Length'
                },
                className: 'btn btn-sm btn-info'
            }, {
                text: '<i class="fa fa-file-excel mr-1"></i>Export',
                className: 'btn btn-sm btn-info bs-tooltip',
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Export'
                },
                action: function(e, dt, node, config) {
                    $('#modal_export').modal('show')
                }
            }],
            initComplete: function() {
                $('#table').DataTable().buttons().container().appendTo(
                    '#tableData_wrapper .col-md-6:eq(0)');
            },
        });

        var table_detail = $("#table_detail").DataTable({
            dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            oLanguage: {
                oPaginate: {
                    sPrevious: '<i class="fas fa-chevron-left"></i>',
                    sNext: '<i class="fas fa-chevron-right"></i>'
                },
                sSearch: '',
                sSearchPlaceholder: "Search...",
                sLengthMenu: "Results :  _MENU_",
            },
            lengthMenu: [
                [10, 50, 100, 500, 1000],
                ['10 rows', '50 rows', '100 rows', '500 rows', '1000 rows']
            ],
            pageLength: 10,
            lengthChange: true,
            paging: false,
            lengthChange: false,
            columnDefs: [],
            columns: [{
                data: 'id',
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            }, {
                data: 'unit.code',
            }, {
                data: 'value',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return data + 'kpj'
                    } else {
                        return data
                    }
                }
            }],
            buttons: [],
            initComplete: function() {
                $('#table').DataTable().buttons().container().appendTo(
                    '#tableData_wrapper .col-md-6:eq(0)');
            },
        });

        $('#table tbody').on('click', 'tr td:not(:first-child):not(:last-child)', function() {
            clear_validate('form')
            row = $(this).parents('tr')[0];
            id = table.row(row).data().id
            $.get(url_index + '/' + id).done(function(result) {
                $('#units').html('')
                $("#date").data('daterangepicker').setStartDate(result.data.date);
                $("#date").data('daterangepicker').setEndDate(result.data.date);

                result.data.items.forEach(item => {
                    set_form_edit(item)
                });

                $('#modal_form').modal('show')
                $('#form').attr('action', url_index + '/' + id)
                $('#modal_form_title').html('Edit Data')
                $('#modal_form_submit').val('PUT')
                $('#modal_form_password_help').show()
                $('#modal_form').modal('show')
            }).fail(function(xhr) {
                show_toast('error', xhr.responseJSON.message || 'server Error!')
            })
        });

        $('#table tbody').on('click', 'tr .btn-delete', function() {
            row = $(this).parents('tr')[0];
            id = table.row(row).data().id
            send_delete(url_index + "/" + id)
        });

        $('#table tbody').on('click', 'tr .btn-detail', function() {
            row = $(this).parents('tr')[0];
            id = table.row(row).data().id
            get_detail()
        });

        $('#form').submit(function(e) {
            e.preventDefault()
        }).validate({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
                $(element).addClass('is-valid');
            },
            submitHandler: function(form) {
                send_ajax('form', $('#modal_form_submit').val())
            }
        })

        $('#modal_form').on('shown.bs.modal', function() {
            $('#date').focus();
        })

        function modal_add() {
            clear_validate('form')
            $('#form').attr('action', url_index)
            $('#modal_form_submit').val('POST')
            $('#modal_form_title').html('Tambah Data')
            $('#units').html('')
            $.get("{{ route('api.units.index') }}?pool_id=" + pool_id).done(function(result) {
                result.data.forEach(item => {
                    set_form_add(item)
                });
                $('#modal_form').modal('show')
            }).fail(function(xhr) {
                show_toast('error', xhr.responseJSON.message || 'server Error!')
            })
            set_date('date')
        }

        function set_form_add(data) {
            let teks = `<div class="form-group row">
                <div class="col-5" style="vertical-align: middle">
                    <label>${data.code}</label>
                    <input type="hidden" name="units[]" value="${data.id}">
                </div>
                <div class="col-7">
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="values[${data.id}]" value="35" class="selectgroup-input"
                                checked>
                            <span class="selectgroup-button">35kpj</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="values[${data.id}]" value="45" class="selectgroup-input">
                            <span class="selectgroup-button">45kpj</span>
                        </label>
                    </div>
                </div>
            </div>`
            $('#units').append(teks)
        }

        function set_form_edit(data) {
            let teks = `<div class="form-group row">
                <div class="col-5" style="vertical-align: middle">
                    <label>${data.unit.code}</label>
                    <input type="hidden" name="units[]" value="${data.unit_id}">
                </div>
                <div class="col-7">
                    <div class="selectgroup w-100">
                        <label class="selectgroup-item">
                            <input type="radio" name="values[${data.unit_id}]" value="35" class="selectgroup-input"
                                ${data.value == 35 ? "checked" : ''}>
                            <span class="selectgroup-button">35kpj</span>
                        </label>
                        <label class="selectgroup-item">
                            <input type="radio" name="values[${data.unit_id}]" value="45" class="selectgroup-input" 
                            ${data.value == 45 ? "checked" : ''}>
                            <span class="selectgroup-button">45kpj</span>
                        </label>
                    </div>
                </div>
            </div>`
            $('#units').append(teks)
        }

        function get_detail() {
            $.get(url_index + '/' + id).done(function(result) {
                table_detail.clear().draw();
                table_detail.rows.add(result.data.items).draw();
                $('#modal_detail_title').text('Detail Data : ' + result.data.date)
                $('#modal_detail').modal('show')
            }).fail(function(xhr) {
                show_toast('error', xhr.responseJSON.message || 'server Error!')
            })
        }
    </script>
@endpush
