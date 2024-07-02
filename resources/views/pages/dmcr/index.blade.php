@extends('layouts.template', ['title' => 'Data DMCR'])
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css"
        integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('lib/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/inputmask@5.0.9/dist/colormask.min.css"> --}}
    {{-- <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css"> --}}
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
                                <th>Shift</th>
                                <th>Unit</th>
                                <th>Type</th>
                                <th>Start</th>
                                <th>Finish</th>
                                <th>Desc</th>
                                <th>Action</th>
                                <th>Component</th>
                                <th>Man Power</th>
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
    @include('pages.dmcr.modal')
@endsection

@push('js')
    <script src="{{ asset('lib/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('lib/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('lib/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('lib/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('lib/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('lib/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('lib/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.20.1/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.9/dist/jquery.inputmask.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"
        integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            var html5QrCode;
            var qrCodeSuccessCallback = function(decodedText, decodedResult) {
                console.log(`Code matched = ${decodedText}`, decodedResult);
                let code = decodedText;
                $.get("{{ url('api/unit-findcode') }}/" + code).done(function(result) {
                    let option = new Option(`${result.data.code} (${result.data.type})`,
                        result
                        .data.id,
                        true, true);
                    $('#unit').append(option).trigger('change');
                }).fail(function(xhr) {
                    show_toast('error', xhr.responseJSON.message || "Server Error!")
                })
                $('#qrScannerModal').modal('hide');
                html5QrCode.stop().then(() => {
                    console.log("QR Code scanning stopped.");
                }).catch(err => {
                    console.error("Unable to stop scanning.", err);
                });
            };

            $('#qrScannerModal').on('shown.bs.modal', function() {
                html5QrCode = new Html5Qrcode("reader");
                html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 250
                }, qrCodeSuccessCallback).catch(err => {
                    show_toast('error', 'Unable to start scanning : ' + err)
                    console.error("Unable to start scanning.", err);
                });
            });

            $('#qrScannerModal').on('hidden.bs.modal', function() {
                $('body').addClass('modal-open');
                if (html5QrCode) {
                    html5QrCode.stop().then(() => {
                        console.log("QR Code scanning stopped.");
                    }).catch(err => {
                        console.error("Unable to stop scanning.", err);
                    });
                }
            });
        });
        var url_index = "{{ route('api.dmcrs.index') }}"
        var id = 0
        var perpage = 50
        var pool_id = "{{ request()->query('pool') }}"
        var url_index_with_pool = url_index + "?pool_id=" + pool_id

        $(".select2").select2()

        $('.datepicker').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            singleDatePicker: true,
        });

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

        $("#unit").select2({
            placeholder: 'Select Unit',
            allowClear: true,
            ajax: {
                url: "{{ route('api.units.paginate') }}",
                data: function(params) {
                    return {
                        code: params.term || '',
                        page: params.page || 1,
                        limit: perpage,
                        pool_id: pool_id,
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data.data, function(item) {
                            return {
                                text: `${item.code} (${item.type})`,
                                id: item.id,
                            }
                        }),
                        pagination: {
                            more: (params.page * perpage) < (data.meta.total || 0)
                        }
                    };
                },
            }
        })

        $("#component").select2({
            placeholder: 'Select component',
            allowClear: true,
            ajax: {
                url: "{{ route('api.components.paginate') }}",
                data: function(params) {
                    return {
                        name: params.term || '',
                        page: params.page || 1,
                        limit: perpage,
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data.data, function(item) {
                            return {
                                text: `${item.name}`,
                                id: item.id,
                            }
                        }),
                        pagination: {
                            more: (params.page * perpage) < (data.meta.total || 0)
                        }
                    };
                },
            }
        })

        $("#users").select2({
            placeholder: 'Select User!',
            allowClear: true,
            multiple: true,
            ajax: {
                url: "{{ route('api.users.paginate') }}",
                data: function(params) {
                    return {
                        name: params.term || '',
                        page: params.page || 1,
                        limit: perpage,
                        role: 'user',
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data.data, function(item) {
                            return {
                                text: `${item.name}`,
                                id: item.id,
                            }
                        }),
                        pagination: {
                            more: (params.page * perpage) < (data.meta.total || 0)
                        }
                    };
                },
            }
        })

        $('.daterange-cus').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                'Last 31 Days': [moment().subtract(30, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment()],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                    'month')],
            },
            showDropdowns: true,
            startDate: moment().startOf('month'),
            endDate: moment(),
            parentEl: "#modal_export",
        });

        $('#btn_export').click(function() {
            let from = $('#range').data('daterangepicker').startDate.format('YYYY-MM-DD');
            let to = $('#range').data('daterangepicker').endDate.format('YYYY-MM-DD');
            window.open("{{ route('dmcrs.export') }}?from=" + from + '&to=' + to + '&pool_id=' + pool_id, '_blank')
        })

        var table = $("#table").DataTable({
            processing: true,
            serverSide: true,
            searchDelay: 500,
            ajax: url_index_with_pool,
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
                [0, 'desc']
            ],
            columns: [{
                data: 'id',
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            }, {
                data: 'date',
            }, {
                data: 'shift',
            }, {
                data: 'unit_id',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return data != null ? `${row.unit.code} (${row.unit.type})` : '';
                    } else {
                        return data
                    }
                }
            }, {
                data: 'type',
            }, {
                data: 'start',
            }, {
                data: 'finish',
            }, {
                data: 'desc',
            }, {
                data: 'action',
            }, {
                data: 'component_id',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return data != null ? `${row.component.name}` : '';
                    } else {
                        return data
                    }
                }
            }, {
                data: 'id',
                sortable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return row.man_powers.map(element => element.user.name).join(', ');
                    } else {
                        return data
                    }
                }
            }, {
                data: 'id',
                sortable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `<button class="btn btn-danger btn-sm btn-delete">Delete</button>`;
                    } else {
                        return data
                    }
                }
            }, ],
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

        $(".dataTables_filter input").unbind().bind("input", function(e) {
            if (this.value.length >= 3 || e.keyCode == 13) {
                table.search(this.value).draw();
            }
            if (this.value == "") {
                table.search("").draw();
            }
            return;
        });

        $('#table tbody').on('click', 'tr td:not(:first-child):not(:last-child)', function() {
            clear_validate('form')
            row = $(this).parents('tr')[0];
            id = table.row(row).data().id
            $.get(url_index + '/' + id).done(function(result) {
                $("#date").data('daterangepicker').setStartDate(result.data.date);
                $("#date").data('daterangepicker').setEndDate(result.data.date);
                $("#start").data('daterangepicker').setStartDate(result.data.start);
                $("#start").data('daterangepicker').setEndDate(result.data.start);
                $("#finish").data('daterangepicker').setStartDate(result.data.finish);
                $("#finish").data('daterangepicker').setEndDate(result.data.finish);
                $('#action').val(result.data.action)
                $('#desc').val(result.data.desc)
                $('#users').val(null).empty();
                if (result.data.man_powers.length > 0) {
                    let options = [];
                    result.data.man_powers.forEach(function(item) {
                        let option = new Option(item.user.name, item.user_id, true, true);
                        options.push(option);
                        $('#users').append(option).trigger('change');
                    });
                    $('#users').val(result.data.man_powers.map(item => item.user_id)).trigger('change');
                }

                $("input[name='shift'][value='" + result.data.shift + "']").prop('checked', true)
                    .trigger('change');
                $("input[name='type'][value='" + result.data.type + "']").prop('checked', true)
                    .trigger('change');

                if (result.data.unit_id != null) {
                    let option = new Option(`${result.data.unit.code} (${result.data.unit.type})`, result
                        .data.unit_id,
                        true, true);
                    $('#unit').append(option).trigger('change');
                } else {
                    $('#unit').val('').change()
                }
                if (result.data.component_id != null) {
                    let option = new Option(`${result.data.component.name}`,
                        result
                        .data.component_id,
                        true, true);
                    $('#component').append(option).trigger('change');
                } else {
                    $('#component').val('').change()
                }

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
            $('#desc').focus();
        })

        function modal_add() {
            clear_validate('form')
            $('#form').attr('action', url_index)
            $('#modal_form_submit').val('POST')
            $('#modal_form_title').html('Tambah Data')
            $('#modal_form').modal('show')

            let date_time = "{{ date('Y-m-d H:i:s') }}"
            let date = "{{ date('Y-m-d') }}"
            $("#date").data('daterangepicker').setStartDate(date);
            $("#date").data('daterangepicker').setEndDate(date);

            $("#start").data('daterangepicker').setStartDate(date_time);
            $("#start").data('daterangepicker').setEndDate(date_time);
            $("#finish").data('daterangepicker').setStartDate(date_time);
            $("#finish").data('daterangepicker').setEndDate(date_time);

            $('#unit').val('').change()
            $('#component').val('').change()
            $("input[name='shift'][value='day']").prop('checked', true).trigger('change');
            $("input[name='type'][value='schedule']").prop('checked', true).trigger('change');

            $('#desc').val('')
            $('#action').val('')
            $('#users').val(null).empty()
        }
    </script>
@endpush
