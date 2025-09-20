@extends('layouts.template', ['title' => 'Data Part'])
@push('css')
    <link rel="stylesheet" href="{{ asset('lib/datatable-new/datatables.min.css') }}">
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
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Unit</th>
                                    <th>KM</th>
                                    <th>Date Last Service</th>
                                    <th>KM Last Service</th>
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
    @include('pages.service.modal')
@endsection

@push('js')
    <script src="{{ asset('lib/datatable-new/datatables.min.js') }}"></script>

    <script src="{{ asset('lib/select2/dist/js/select2.full.min.js') }}"></script>
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
        var url_index = "{{ route('api.parts.index') }}"
        var url_index_item = "{{ route('api.part_items.index') }}"
        var id = 0
        var perpage = 50
        var pool_id = "{{ request()->query('pool') }}"
        var url_index_with_pool = url_index + "?pool_id=" + pool_id
        var url_truncate = "{{ route('api.hmkms.truncate') }}"
        var table_item
        var type = ''

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

        $("input[name='type']").change(function() {
            type = $("input[name='type']:checked").val();
            console.log(type);
            labels = get_label(type)
            $('#label').empty()
            $('#label').append(new Option('other', 'other',
                true, true));
            labels.forEach(element => {
                let option = new Option(element, element,
                    true, true);
                $('#label').append(option);
            });
            $('#label').val('other').change()
        })

        $("#label").change(function() {
            let label = $('#label').val()
            if (label == 'other') {
                $('#input_custom_label').show()
                $('#custom_label').val('')
            } else {
                $('#input_custom_label').hide()
                $('#custom_label').val('')
            }
            console.log(label);
        })

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

        $("#filter_unit").select2({
            placeholder: 'ALL',
            allowClear: true,
            dropdownParent: $('#modal_export'),
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
                data: 'type',
            }, {
                data: 'date',
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
                data: 'km',
                searchable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return hrg(data);
                    } else {
                        return data
                    }
                }
            }, {
                data: 'last_date',
            }, {
                data: 'last_km',
                searchable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return hrg(data);
                    } else {
                        return data
                    }
                }
            }, {
                data: 'id',
                searchable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        let text =
                            `<button type="button" class="btn m-1 btn-success btn-sm btn-download">Download</button>
                            <button type="button" class="btn m-1 btn-info btn-sm btn-view">View</button>
                            <button type="button" class="btn m-1 btn-danger btn-sm btn-delete">Delete</button>`;
                        return text
                    } else {
                        return data
                    }
                }
            }],
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
            $('#service_id').attr('value', id)
        })

        $('#modal_form_item').on('hidden.bs.modal', function() {
            $('body').addClass('modal-open');
        });

        $('#modal_image').on('hidden.bs.modal', function() {
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
                $("#last_date").data('daterangepicker').setStartDate(result.data.last_date);
                $("#last_date").data('daterangepicker').setEndDate(result.data.date);
                $('#km').val(result.data.km)
                $('#last_km').val(result.data.last_km)

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

                $('#btn_item_add').show()
                $('#div_item').show()
                $('#table_item').DataTable().clear().destroy();

                table_item = $("#table_item").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: url_index_item + "?service_id=" + id,
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
                        [2, 'desc'],
                    ],
                    columns: [{
                        data: 'label',
                    }, {
                        data: 'image',
                        searchable: false,
                        sortable: false,
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                return `<img src="${data}" width="50">`;
                            } else {
                                return data
                            }
                        }
                    }, {
                        data: 'id',
                        searchable: false,
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                let text = `
                                <button type="button" class="btn m-1 btn-info btn-sm btn-view">View</button>
                                <button type="button" class="btn m-1 btn-danger btn-sm btn-delete">Delete</button>`;
                                return text
                            } else {
                                return data
                            }
                        }
                    }, ],
                    buttons: [],
                });

                $('#form').attr('action', url_index + '/' + id)
                $('#modal_form_title').html('Edit Data')
                $('#modal_form_submit').val('PUT')
                $('#modal_form_password_help').show()
                $('#modal_form').modal('show')
                type = result.data.type

            }).fail(function(xhr) {
                show_toast('error', xhr.responseJSON.message || 'server Error!')
            })
        });

        $('#table tbody').on('click', 'tr .btn-delete', function() {
            row = $(this).parents('tr')[0];
            id = table.row(row).data().id
            send_delete(url_index + "/" + id)
        });


        $('#table tbody').on('click', 'tr .btn-view', function() {
            row = $(this).parents('tr')[0];
            id = table.row(row).data().id
            window.open('/service/' + id, '_blank')
        });

        $('#table tbody').on('click', 'tr .btn-download', function() {
            row = $(this).parents('tr')[0];
            id = table.row(row).data().id
            window.open('/service/' + id + '/download', '_blank')
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
            $('#hm').focus();
        })

        $('#table_item tbody').on('click', 'tr .btn-delete', function() {
            row = $(this).parents('tr')[0];
            id_item = table_item.row(row).data().id
            send_delete_custom(url_index_item + "/" + id_item)
        });

        $('#table_item tbody').on('click', 'tr .btn-view', function() {
            row = $(this).parents('tr')[0];
            let label = table_item.row(row).data().label
            let image = table_item.row(row).data().image
            $('#detail_image').attr('src', image)
            $('#modal_image_title').text(label)
            $('#modal_image').modal('show')
        });

        function modal_add() {
            clear_validate('form')
            $('#form').attr('action', url_index)
            $('#modal_form_submit').val('POST')
            $('#modal_form_title').html('Tambah Data')
            $('#modal_form').modal('show')

            $("input[name='type'][value='S']").prop('checked', true).trigger('change');
            $('#km').val(0)
            $('#last_km').val(0)
            $('#unit').val('').change()
            set_date('date')
            set_date('last_date')

            $('#btn_item_add').hide()
            $('#div_item').hide()
        }

        function modal_item_add() {
            clear_validate('form')
            $('#form_item').attr('action', url_index_item)
            $('#modal_form_item_submit').val('POST')
            $('#modal_form_item_title').html('Add Image')
            $('#modal_form_item').modal('show')

            $('#label').val('')
            $('#form_item')[0].reset()

            $('#form_item .image_preview').attr('src', '#');
            $('#form_item .image_preview').hide();
            $('#label').val('other').change()

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

        function get_label(type) {
            if (type == 'S') {
                return ['REPLACE FUEL FILTER',
                    'REPLACE PRE FUEL FILTER',
                    'REPLACE ENGINE OIL FILTER',
                    'FILL OIL ENGINE',
                    'REPLACE PAPER CENTRIFUGAL',
                    'KM',
                    'O-RING KIT & SEALING WASHER',
                    'CHECK BATTERY',
                    'RETORQUE BRACKET PROPELLER SHAFT',
                    'REPLACE V-BELT AC',
                ]
            } else if (type == 'M') {
                return [
                    'REPLACE FUEL FILTER',
                    'REPLACE PRE FUEL FILTER',
                    'REPLACE ENGINE OIL FILTER',
                    'O-RING KIT & SEALING WASHER',
                    'REPLACE AIR FILTER ELEMENT',
                    'REPLACE FILTER DESSICANT APS',
                    'REPLACE FILTER OIL DIFFERENTIAL',
                    'REPLACE PAPER CENTRIFUGAL',
                    'FILL OIL ENGINE',
                    'CHECK BATTERY',
                    'KM',
                    'REPLACE POLY V-BELT ENGINE',
                    'RETORQUE BRACKET PROPELLER SHAFT',
                ]
            } else if (type == 'L') {
                return [
                    'REPLACE FUEL FILTER',
                    'REPLACE PRE FUEL FILTER',
                    'REPLACE ENGINE OIL FILTER',
                    'O-RING KIT & SEALING WASHER',
                    'REPLACE FILTER OIL HYRAULIC',
                    'REPLACE AIR FILTER ELEMENT',
                    'REPLACE FILTER DESSICANT APS',
                    'FILL OIL ENGINE',
                    'REPLACE FILTER STEERING',
                    'REPLACE FILTER OIL DIFFERENTIAL',
                    'REPLACE PAPER CENTRIFUGAL',
                    'CHECK BATTERY',
                    'KM',
                    'RETORQUE BRACKET PROPELLER SHAFT',
                ]
            } else {
                return []
            }
        }
    </script>
@endpush
