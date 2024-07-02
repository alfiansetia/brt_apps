@extends('layouts.template', ['title' => 'Data PPM'])
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css"
        integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('lib/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/inputmask@5.0.9/dist/colormask.min.css"> --}}
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css">
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
                                <th>Unit</th>
                                <th>PPM</th>
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
    @include('pages.ppm_data.modal')
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
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.20.1/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.9/dist/jquery.inputmask.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"
        integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            var html5QrCode;
            var currentType;

            var qrCodeSuccessCallback = function(decodedText, decodedResult) {
                console.log(`Code matched = ${decodedText}`, decodedResult);
                let code = decodedText;
                if (currentType == 'unit') {
                    $.get("{{ url('api/unit-findcode') }}/" + code).done(function(result) {
                        let option = new Option(`${result.data.code} (${result.data.type})`,
                            result
                            .data.id,
                            true, true);
                        $('#unit').append(option).trigger('change');
                    }).fail(function(xhr) {
                        show_toast('error', xhr.responseJSON.message || "Server Error!")
                    })
                } else {
                    $.get("{{ url('api/product-findcode') }}/" + code).done(function(result) {
                        let option = new Option(`${result.data.name}`,
                            result
                            .data.id,
                            true, true);
                        $('#product').append(option).trigger('change');
                    }).fail(function(xhr) {
                        show_toast('error', xhr.responseJSON.message || "Server Error!")
                    })
                }
                $('#qrScannerModal').modal('hide');
                html5QrCode.stop().then(() => {
                    console.log("QR Code scanning stopped.");
                }).catch(err => {
                    console.error("Unable to stop scanning.", err);
                });
            };

            $('#qrScannerModal').on('shown.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                currentType = button.val();

                console.log(currentType);

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
            // var html5QrCode;
            // var qrCodeSuccessCallback = function(decodedText, decodedResult) {
            //     console.log(`Code matched = ${decodedText}`, decodedResult);
            //     let code = decodedText;
            //     $.get("{{ url('api/unit-findcode') }}/" + code).done(function(result) {
            //         let option = new Option(`${result.data.code} (${result.data.type})`,
            //             result
            //             .data.id,
            //             true, true);
            //         $('#unit').append(option).trigger('change');
            //     }).fail(function(xhr) {
            //         show_toast('error', xhr.responseJSON.message || "Server Error!")
            //     })
            //     $('#qrScannerModal').modal('hide');
            //     html5QrCode.stop().then(() => {
            //         console.log("QR Code scanning stopped.");
            //     }).catch(err => {
            //         console.error("Unable to stop scanning.", err);
            //     });
            // };

            // $('#qrScannerModal').on('shown.bs.modal', function() {
            //     html5QrCode = new Html5Qrcode("reader");
            //     html5QrCode.start({
            //         facingMode: "environment"
            //     }, {
            //         fps: 10,
            //         qrbox: 250
            //     }, qrCodeSuccessCallback).catch(err => {
            //         show_toast('error', 'Unable to start scanning : ' + err)
            //         console.error("Unable to start scanning.", err);
            //     });
            // });

            // $('#qrScannerModal').on('hidden.bs.modal', function() {
            //     $('body').addClass('modal-open');
            //     if (html5QrCode) {
            //         html5QrCode.stop().then(() => {
            //             console.log("QR Code scanning stopped.");
            //         }).catch(err => {
            //             console.error("Unable to stop scanning.", err);
            //         });
            //     }
            // });
        });
        var url_index = "{{ route('api.ppmdatas.index') }}"
        var id = 0
        var perpage = 50
        var pool_id = "{{ request()->query('pool') }}"

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

        $("#ppm").select2({
            placeholder: 'Select PPM!',
            allowClear: true,
            ajax: {
                url: "{{ route('api.ppms.paginate') }}",
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
            window.open("{{ route('ppms_data.export') }}?from=" + from + '&to=' + to, '_blank')
        })

        var table = $("#table").DataTable({
            processing: true,
            serverSide: true,
            searchDelay: 500,
            ajax: url_index,
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
                data: 'unit_id',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return data != null ? `${row.unit.code} (${row.unit.type})` : '';
                    } else {
                        return data
                    }
                }
            }, {
                data: 'ppm_id',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return data != null ?
                            `${row.ppm.name}` : '';
                    } else {
                        return data
                    }
                }
            }, {
                data: 'id',
                sortable: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `<div class="btn-group" role="group" aria-label="Basic example">
                                    <button class="btn btn-info btn-sm btn-download">Download</button>
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
                $('#file').attr('required', false)
                $('#form')[0].reset()
                $("#date").data('daterangepicker').setStartDate(result.data.date);
                $("#date").data('daterangepicker').setEndDate(result.data.date);
                if (result.data.unit_id != null) {
                    let option = new Option(`${result.data.unit.code} (${result.data.unit.type})`, result
                        .data.unit_id,
                        true, true);
                    $('#unit').append(option).trigger('change');
                } else {
                    $('#unit').val('').change()
                }
                if (result.data.ppm_id != null) {
                    let option = new Option(`${result.data.ppm.name}`,
                        result.data.ppm_id,
                        true, true);
                    $('#ppm').append(option).trigger('change');
                } else {
                    $('#ppm').val('').change()
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

        $('#table tbody').on('click', 'tr .btn-download', function() {
            row = $(this).parents('tr')[0];
            id = table.row(row).data().id
            let file = table.row(row).data().file
            if (file == null) {
                return
            }
            window.open(file, '_blank')
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
            $('#form')[0].reset()
            $('#file').attr('required', true)
            clear_validate('form')
            $('#form').attr('action', url_index)
            $('#modal_form_submit').val('POST')
            $('#modal_form_title').html('Tambah Data')
            $('#modal_form').modal('show')
            $('#unit').val('').change()
            $('#ppm').val('').change()
            let date = "{{ date('Y-m-d') }}"
            $("#date").data('daterangepicker').setStartDate(date);
            $("#date").data('daterangepicker').setEndDate(date);
        }
    </script>
@endpush
