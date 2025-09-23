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
                                    <th>Unit</th>
                                    <th>Unit Detail</th>
                                    <th>SN</th>
                                    <th>HM</th>
                                    <th>KM</th>
                                    <th>Start Date</th>
                                    <th>Finish Date</th>
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
    @include('pages.part.modal')
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
                data: 'unit_detail',
                className: 'text-start',
            }, {
                data: 'sn',
                className: 'text-start',
            }, {
                data: 'hm',
                className: 'text-center',
                searchable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return hrg(data);
                    } else {
                        return data
                    }
                }
            }, {
                data: 'km',
                className: 'text-center',
                searchable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return hrg(data);
                    } else {
                        return data
                    }
                }
            }, {
                data: 'start_date',
            }, {
                data: 'finish_date',
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
            $('#part_id').attr('value', id)
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
                $("#start_date").data('daterangepicker').setStartDate(result.data.start_date);
                $("#start_date").data('daterangepicker').setEndDate(result.data.start_date);
                $("#finish_date").data('daterangepicker').setStartDate(result.data.finish_date);
                $("#finish_date").data('daterangepicker').setEndDate(result.data.finish_date);
                $('#unit_detail').val(result.data.unit_detail)
                $('#sn').val(result.data.sn)
                $('#hm').val(result.data.hm)
                $('#km').val(result.data.km)

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
                    ajax: url_index_item + "?part_id=" + id,
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
                        data: 'type',
                        render: function(data, type, row, meta) {
                            if (type == 'display') {
                                return data == 'new' ? 'PART BARU' : 'PART BEKAS';
                            } else {
                                return data
                            }
                        }
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

                    drawCallback: function(settings) {
                        var api = this.api();
                        let data = api.data().toArray()
                        let countNew = data.filter(item => item.type === "new").length;
                        let countOld = data.filter(item => item.type === "old").length;
                        $('#part_baru').text(countNew)
                        $('#part_bekas').text(countOld)

                    }
                }, );

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
            window.open('/part/' + id, '_blank')
        });

        $('#table tbody').on('click', 'tr .btn-download', function() {
            row = $(this).parents('tr')[0];
            id = table.row(row).data().id
            window.open('/part/' + id + '/download')
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
            $('#unit_detail').focus();
        })

        $('#table_item tbody').on('click', 'tr .btn-delete', function() {
            row = $(this).parents('tr')[0];
            id_item = table_item.row(row).data().id
            send_delete_custom(url_index_item + "/" + id_item)
        });

        $('#table_item tbody').on('click', 'tr .btn-view', function() {
            row = $(this).parents('tr')[0];
            let type = table_item.row(row).data().type
            let image = table_item.row(row).data().image
            $('#detail_image').attr('src', image)
            $('#modal_image_title').text('Image ' + type)
            $('#modal_image').modal('show')
        });

        function modal_add() {
            clear_validate('form')
            $('#form').attr('action', url_index)
            $('#modal_form_submit').val('POST')
            $('#modal_form_title').html('Tambah Data')
            $('#modal_form').modal('show')

            $('#unit').val('').change()
            $('#unit_detail').val('')
            $('#sn').val('')
            $('#hm').val(0)
            $('#km').val(0)
            set_date('start_date')
            set_date('finish_date')

            $('#btn_item_add').hide()
            $('#div_item').hide()
        }

        function modal_item_add() {
            clear_validate('form')
            $('#form_item').attr('action', url_index_item)
            $('#modal_form_item_submit').val('POST')
            $('#modal_form_item_title').html('Add Image')
            $('#modal_form_item').modal('show')

            $('#form_item')[0].reset()

            $('#form_item .image_preview').attr('src', '#');
            $('#form_item .image_preview').hide();
            $('#type').val('new').change()

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
