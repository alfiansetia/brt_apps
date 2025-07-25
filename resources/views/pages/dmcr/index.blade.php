@extends('layouts.template', ['title' => 'Data DMCR'])
@push('css')
    <link rel="stylesheet" href="{{ asset('lib/datatable-new/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
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
                    <form action="" id="formSelected">
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
                                    <th style="width: 50px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover" id="table-item" style="width: 100%;cursor: pointer;">
                    <thead>
                        <tr>
                            <th>Desc</th>
                            <th>Action</th>
                            <th>Component</th>
                            <th>Part Number</th>
                            <th>Part Name</th>
                            <th>Part Qty</th>
                            <th>Man Power</th>
                            <th style="width: 50px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
    @include('pages.dmcr.modal')
@endsection

@push('js')
    <script src="{{ asset('lib/datatable-new/datatables.min.js') }}"></script>

    <script src="{{ asset('lib/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('lib/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
    <script src="{{ asset('lib/jquery-validation-1.20.1/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('lib/Inputmask-5.0.9/dist/jquery.inputmask.min.js') }}"></script>

    <script src="{{ asset('lib/html5-qrcode/html5-qrcode.min.js') }}"></script>

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
        var url_index_item = "{{ route('api.dmcr_items.index') }}"
        var id = 0
        var id_item = 0
        var perpage = 50
        var pool_id = "{{ request()->query('pool') }}"
        var url_index_with_pool = url_index + "?pool_id=" + pool_id
        var url_truncate = "{{ route('api.dmcrs.truncate') }}"
        var table_item

        $(".select2").select2()

        $('.mask_angka').inputmask({
            alias: 'numeric',
            groupSeparator: '.',
            autoGroup: true,
            digits: 0,
            rightAlign: false,
            removeMaskOnSubmit: true,
            autoUnmask: true,
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

        // $("#users").select2({
        //     placeholder: 'Select User!',
        //     allowClear: true,
        //     multiple: true,
        // })

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
                        pool_id: pool_id,
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

        $('#btn_export').click(function() {
            let from = $('#range').data('daterangepicker').startDate.format('DD/MM/YYYY');
            let to = $('#range').data('daterangepicker').endDate.format('DD/MM/YYYY');
            let url = "{{ route('api.dmcrs.export') }}?from=" + from + '&to=' + to + '&pool_id=' + pool_id
            download_file(url)
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
            dom: "<'dt--top-section'<'row mb-2'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-0'f>>>" +
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
                [7, 'desc'],
                [1, 'desc'],
            ],
            columns: [{
                data: 'id',
                searchable: false,
                sortable: false,
                width: '30px',
                render: function(data, type, row, meta) {
                    return `<div class="custom-checkbox custom-control"><input type="checkbox" id="check${data}" data-checkboxes="mygroup" name="id[]" value="${data}" class="custom-control-input child-chk select-customers-info"><label for="check${data}" class="custom-control-label">&nbsp;</label></div>`
                }
            }, {
                data: 'date',
            }, {
                data: 'shift',
            }, {
                name: 'unit_id',
                data: 'unit.code',
                defaultContent: '',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return row.unit_id != null ? `${row.unit.code} (${row.unit.type})` : '';
                    } else {
                        return data
                    }
                }
            }, {
                data: 'type',
            }, {
                data: 'start',
                searchable: false,
            }, {
                data: 'finish',
                searchable: false,
            }, {
                data: 'id',
                sortable: false,
                searchable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `<button type="button" class="btn btn-danger btn-sm btn-delete">Delete</button>`;
                    } else {
                        return data
                    }
                }
            }, ],
            buttons: [{
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
            }, {
                text: '<i class="fa fa-tools"></i> Action',
                className: 'btn btn-sm btn-warning bs-tooltip',
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Action'
                },
                extend: 'collection',
                autoClose: true,
                buttons: [{
                    text: 'Delete Selected Data',
                    className: 'btn btn-danger',
                    action: function(e, dt, node, config) {
                        delete_batch(url_index);
                    }
                }, {
                    text: 'Delete All Data in Pool',
                    className: 'btn btn-danger',
                    action: function(e, dt, node, config) {
                        truncate(url_truncate, pool_id);
                    }
                }]
            }, ],
            initComplete: function() {
                $('#table').DataTable().buttons().container().appendTo(
                    '#tableData_wrapper .col-md-6:eq(0)');
            },
            drawCallback: function(settings) {
                var api = this.api();
                text = `(${hrg(api.page.info().recordsDisplay)} data)`
                $('#total_data').text(text);
            },
            headerCallback: function(e, a, t, n, s) {
                e.getElementsByTagName("th")[0].innerHTML =
                    '<div class="custom-checkbox custom-control"><input type="checkbox" class="custom-control-input chk-parent select-customers-info" id="checkbox-all"><label for="checkbox-all" class="custom-control-label">&nbsp;</label></div>'
            },
        });

        $('#btn_item_add').click(function() {
            modal_item_add()
            $('#dmcr_id').attr('value', id)
        })

        $('#modal_form_item').on('hidden.bs.modal', function() {
            $('body').addClass('modal-open');
        });

        multiCheck(table);



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

                $('#form').attr('action', url_index + '/' + id)
                $('#modal_form_title').html('Edit Data')
                $('#modal_form_submit').val('PUT')
                $('#modal_form_password_help').show()
                $('#modal_form').modal('show')

                $('#btn_item_add').show()
                $('#div_item').show()

                $('#table_item').DataTable().clear().destroy();

                table_item = $("#table_item").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: url_index_item + "?dmcr_id=" + id,
                    dom: "<'dt--top-section'<'row mb-2'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-0'f>>>" +
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
                    lengthChange: false,
                    searching: false,
                    paging: false,
                    info: false,
                    columnDefs: [],
                    order: [
                        [7, 'desc'],
                    ],
                    columns: [{
                        data: 'desc',
                    }, {
                        data: 'action',
                    }, {
                        name: 'component_id',
                        data: 'component.name',
                        defaultContent: '',
                    }, {
                        data: 'part_number',
                    }, {
                        data: 'part_name',
                    }, {
                        data: 'part_qty',
                        searchable: false,
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                return hrg(data)
                            } else {
                                return data
                            }
                        }
                    }, {
                        data: 'id',
                        searchable: false,
                        sortable: false,
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                return row.man_powers.map(element => element.user.name)
                                    .join(', ');
                            } else {
                                return data
                            }
                        }
                    }, {
                        data: 'id',
                        searchable: false,
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                return `<button type="button" class="btn btn-danger btn-sm btn-delete">Delete</button>`;
                            } else {
                                return data
                            }
                        }
                    }, ],
                    buttons: [],
                });
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

        $('#form_item').submit(function(e) {
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
                send_ajax_custom('form_item', $('#modal_form_item_submit').val())
            }
        })

        $('#modal_form').on('shown.bs.modal', function() {
            $('#desc').focus();
        })

        $('#table_item tbody').on('click', 'tr td:not(:first-child):not(:last-child)', function() {
            clear_validate('form_item')
            row = $(this).parents('tr')[0];
            id_item = table_item.row(row).data().id
            $.get(url_index_item + '/' + id_item).done(function(result) {
                $('#action').val(result.data.action)
                $('#desc').val(result.data.desc)
                $('#part_number').val(result.data.part_number)
                $('#part_name').val(result.data.part_name)
                $('#part_qty').val(result.data.part_qty)

                if (result.data.component_id != null) {
                    let option = new Option(`${result.data.component.name}`,
                        result
                        .data.component_id,
                        true, true);
                    $('#component').append(option).trigger('change');
                } else {
                    $('#component').val('').change()
                }

                // $('#users').val(result.data.man_power_ids).change();
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

                $('#form_item').attr('action', url_index_item + '/' + id_item)
                $('#modal_form_item_title').html('Edit Data')
                $('#modal_form_item_submit').val('PUT')
                $('#modal_form_item').modal('show')

            }).fail(function(xhr) {
                show_toast('error', xhr.responseJSON.message || 'server Error!')
            })
        });

        $('#table_item tbody').on('click', 'tr .btn-delete', function() {
            row = $(this).parents('tr')[0];
            id_item = table_item.row(row).data().id
            send_delete_custom("{{ route('api.dmcr_items.index') }}" + "/" + id_item)
        });

        function modal_add() {
            clear_validate('form')
            $('#form').attr('action', url_index)
            $('#modal_form_submit').val('POST')
            $('#modal_form_title').html('Tambah Data')
            $('#modal_form').modal('show')

            set_date('date')
            let date_time = "{{ date('d/m/Y H:i:s') }}"
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
            // $('#users').val([]).change()
            $('#part_number').val('')
            $('#part_name').val('')
            $('#part_qty').val(0)

            $('#btn_item_add').hide()
            $('#div_item').hide()
        }

        function modal_item_add() {
            clear_validate('form')
            $('#form_item').attr('action', url_index_item)
            $('#modal_form_item_submit').val('POST')
            $('#modal_form_item_title').html('Tambah Data')
            $('#modal_form_item').modal('show')

            $('#component').val('').change()
            $('#desc').val('')
            $('#action').val('')
            $('#users').val(null).empty()
            // $('#users').val([]).change()
            $('#part_number').val('')
            $('#part_name').val('')
            $('#part_qty').val(0)
        }

        function send_ajax_custom(formID, method) {
            ajax_setup()
            let data = new FormData($('#' + formID)[0])
            data.append('_method', method)
            $.ajax({
                url: $('#' + formID).attr('action'),
                method: 'POST',
                processData: false,
                contentType: false,
                data: data,
                // data: $('#' + formID).serialize(),
                success: function(result) {
                    show_toast('success', result.message || 'Success!')
                    table_item.ajax.reload()
                    $('#modal_form_item').modal('hide')
                },
                error: function(xhr, status, error) {
                    handleResponseForm(xhr, formID)
                }
            })
        }

        function send_delete_custom(url) {
            swal({
                    title: 'Are you sure?',
                    text: 'Delete Data?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        ajax_setup()
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            success: function(result) {
                                show_toast('success', result.message || 'Success!')
                                table_item.ajax.reload()
                            },
                            error: function(xhr, status, error) {
                                show_toast('error', xhr.responseJSON.message || 'Server Error!')
                            }
                        })
                    }
                });
        }
    </script>
@endpush
