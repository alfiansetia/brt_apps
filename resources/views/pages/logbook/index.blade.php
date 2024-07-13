@extends('layouts.template', ['title' => 'Data Logbook'])
@push('css')
    <link rel="stylesheet" href="{{ asset('lib/datatables.net-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="" id="formSelected">
                        <table class="table table-hover" id="table" style="width: 100%;cursor: pointer;">
                            <thead>
                                <tr>
                                    <th style="width: 30px;">#</th>
                                    <th>Date</th>
                                    <th>Unit</th>
                                    <th>Component</th>
                                    <th>Location</th>
                                    <th>Pre</th>
                                    <th>Start</th>
                                    <th>Finish</th>
                                    <th>KM RFU</th>
                                    <th>Problem</th>
                                    <th>Action</th>
                                    <th>Respon</th>
                                    <th>Status</th>
                                    <th>Remark</th>
                                    <th>Man Power</th>
                                    <th style="width: 50px">#</th>
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
    @include('pages.logbook.modal')
@endsection

@push('js')
    <script src="{{ asset('lib/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('lib/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('lib/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('lib/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('lib/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

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
                    $("input[name='type'][value='" + result.data.type + "']").prop('checked', true)
                        .trigger('change');

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
        var url_index = "{{ route('api.logbooks.index') }}"
        var id = 0
        var perpage = 50
        var url_truncate = "{{ route('api.logbooks.truncate') }}"

        $(".select2").select2()

        $(".timepickerd").timepicker({
            icons: {
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down'
            },
            showSeconds: true,
            showMeridian: false,
            timeFormat: "H:i:s",
            minuteStep: 1,
            secondStep: 1,
            maxHours: 24,
            showInputs: false,
        });

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
            $('#unit').val('').change()
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
                        type: $("input[name='type']:checked").val()
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
        })

        // $("#users").select2({
        //     placeholder: 'Select User!',
        //     allowClear: true,
        //     multiple: true,
        //     ajax: {
        //         url: "{{ route('api.users.paginate') }}",
        //         data: function(params) {
        //             return {
        //                 name: params.term || '',
        //                 page: params.page || 1,
        //                 limit: perpage,
        //                 role: 'user',
        //             };
        //         },
        //         processResults: function(data, params) {
        //             params.page = params.page || 1;
        //             return {
        //                 results: $.map(data.data, function(item) {
        //                     return {
        //                         text: `${item.name}`,
        //                         id: item.id,
        //                     }
        //                 }),
        //                 pagination: {
        //                     more: (params.page * perpage) < (data.meta.total || 0)
        //                 }
        //             };
        //         },
        //     }
        // })

        $('#btn_export').click(function() {
            let from = $('#range').data('daterangepicker').startDate.format('DD/MM/YYYY');
            let to = $('#range').data('daterangepicker').endDate.format('DD/MM/YYYY');
            let url = "{{ route('api.logbooks.export') }}?from=" + from + '&to=' + to
            download_file(url)
        })

        var table = $("#table").DataTable({
            processing: true,
            serverSide: true,
            searchDelay: 500,
            ajax: {
                url: url_index,
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
                sortable: false,
                render: function(data, type, row, meta) {
                    return `<div class="custom-checkbox custom-control"><input type="checkbox" id="check${data}" data-checkboxes="mygroup" name="id[]" value="${data}" class="custom-control-input child-chk select-customers-info"><label for="check${data}" class="custom-control-label">&nbsp;</label></div>`
                }
            }, {
                data: 'date',
            }, {
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
                data: 'component.name',
                defaultContent: '',
            }, {
                data: 'location',
            }, {
                data: 'pre',
                searchable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return parse_hm(data)
                    } else {
                        return data
                    }
                }
            }, {
                data: 'start',
                searchable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return parse_hm(data)
                    } else {
                        return data
                    }
                }
            }, {
                data: 'finish',
                searchable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return parse_hm(data)
                    } else {
                        return data
                    }
                }
            }, {
                data: 'km_rfu',
                searchable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return hrg(data)
                    } else {
                        return data
                    }
                }
            }, {
                data: 'problem',
            }, {
                data: 'respon',
            }, {
                data: 'action',
            }, {
                data: 'status',
            }, {
                data: 'desc',
            }, {
                data: 'id',
                searchable: false,
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
                    text: 'Delete All Data',
                    className: 'btn btn-danger',
                    action: function(e, dt, node, config) {
                        truncate_all(url_truncate);
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

        multiCheck(table);

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
                $('#location').val(result.data.location)
                $('#pre').timepicker('setTime', result.data.pre)
                $('#start').timepicker('setTime', result.data.start)
                $('#finish').timepicker('setTime', result.data.finish)
                $('#km_rfu').val(result.data.km_rfu)
                $('#problem').val(result.data.problem)
                $('#action').val(result.data.action)
                $('#desc').val(result.data.desc)
                $('#users').val(result.data.man_power_ids).change()
                // $('#users').val(null).empty();
                // if (result.data.man_powers.length > 0) {
                //     let options = [];
                //     result.data.man_powers.forEach(function(item) {
                //         let option = new Option(item.user.name, item.user_id, true, true);
                //         options.push(option);
                //         $('#users').append(option).trigger('change');
                //     });
                //     $('#users').val(result.data.man_powers.map(item => item.user_id)).trigger('change');
                // }


                $("input[name='status'][value='" + result.data.status + "']").prop('checked', true)
                    .trigger('change');

                $("input[name='respon'][value='" + result.data.respon + "']").prop('checked', true)
                    .trigger('change');


                if (result.data.unit_id != null) {
                    $("input[name='type'][value='" + result.data.unit.type + "']").prop('checked', true)
                        .trigger('change');

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
            $('#location').focus();
        })

        function modal_add() {
            clear_validate('form')
            $('#form').attr('action', url_index)
            $('#modal_form_submit').val('POST')
            $('#modal_form_title').html('Tambah Data')
            $('#modal_form').modal('show')

            set_date('date')
            let time = "{{ date('H:i:s') }}"
            $('#unit').val('').change()
            $('#component').val('').change()
            $('#location').val('')
            $('#pre').timepicker('setTime', time);
            $('#start').timepicker('setTime', time);
            $('#finish').timepicker('setTime', time);
            $('#km_rfu').val(0)
            $('#problem').val('')
            $('#action').val('')
            $("input[name='respon'][value='UT']").prop('checked', true).trigger('change');
            $("input[name='status'][value='pending']").prop('checked', true).trigger('change');
            $("input[name='type'][value='maxi']").prop('checked', true).trigger('change');
            $('#desc').val('')
            $('#users').val([]).change()
            // $('#users').val(null).empty()
        }
    </script>
@endpush
