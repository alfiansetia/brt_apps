@extends('layouts.template', ['title' => 'Data CBM Project'])
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
            <div class="row mb-2">
                <div class="col-sm-12 col-lg-8 mb-2">
                    <input type="search" id="input_search" class="form-control" placeholder="Seearch">
                </div>
                <div class="col-sm-12 col-lg-4  mb-2 d-flex justify-content-between">
                    <button type="button" id="btn_search" class="btn btn-primary flex-grow-1 mr-1" onclick="get_data()"><i
                            class="fas fa-search"></i> Search</button>
                    <button type="button" class="btn btn-primary flex-grow-1 ml-1" onclick="modal_add()"><i
                            class="fas fa-plus"></i> Add</button>
                </div>
            </div>
            <div class="row" id="card_content">
            </div>

            <div class="card" id="card_table" style="display: none">
                <div class="card-body">
                    <form action="" id="formSelected">
                        <table class="table table-hover" id="table" style="width: 100%;cursor: pointer;">
                            <thead>
                                <tr>
                                    <th style="width: 30px;">#</th>
                                    <th>Part Number</th>
                                    <th>Project</th>
                                    <th>Target</th>
                                    <th>Actual</th>
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
    @include('pages.cbm_project.modal')
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
    <script src="{{ asset('lib/jquery-validation-1.20.1/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('lib/Inputmask-5.0.9/dist/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('lib/html5-qrcode/html5-qrcode.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            get_data()
        });
        var url_index = "{{ route('api.cbm_projects.index') }}"
        var id = 0
        var perpage = 50
        var pool_id = "{{ request()->query('pool') }}"
        var url_index_with_pool = url_index + "?pool_id=" + pool_id
        var url_truncate = "{{ route('api.cbm_projects.truncate') }}"

        function get_data() {
            $.get(url_index_with_pool + '&name=' + $('#input_search').val()).done(function(result) {
                $('#card_content').html('')
                if (result.data.length > 0) {
                    result.data.forEach(element => {
                        let percent = element.percent;
                        let percent_bg = 'success'
                        if (percent >= 80) {
                            percent_bg = 'success'
                        } else if (percent >= 60) {
                            percent_bg = 'info'
                        } else if (percent >= 40) {
                            percent_bg = 'warning'
                        } else {
                            percent_bg = 'danger'
                        }
                        let title =
                            `PN: ${element.pn}, Project : ${element.name}, Target: ${element.target}, Actual: ${element.actual}`
                        let text = `<div class="col-lg-2 col-sm-3 col-xs-6 col-6 text-center mb-3"
                    data-toggle="tooltip" title="${title}">
                                <div class="card d-flex flex-column justify-content-between h-100" style="cursor:pointer;" onclick="edit(${element.id})">
                                    <h6 class="flex-grow-1 d-flex align-items-center justify-content-center">${element.name}</h6>
                                    <h5 class="bg-${percent_bg} mb-0">${percent.toFixed(0)}%</h5>
                                </div>
                            </div>`
                        $('#card_content').append(text)
                    });
                } else {
                    let text = `<div class="col-12">
                        <div class="alert alert-warning alert-has-icon alert-dismissible show fade">
                            <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                            <div class="alert-body">
                                <div class="alert-title">No Data!</div>
                            </div>
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                    </div>`
                    $('#card_content').append(text)
                }
                let t = `(${hrg(result.data.length)} data)`
                $('#total_data').text(t);
                tooltip()
            })
        }

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

        $('#btn_export').click(function() {
            let from = $('#range').data('daterangepicker').startDate.format('DD/MM/YYYY');
            let to = $('#range').data('daterangepicker').endDate.format('DD/MM/YYYY');
            let url = "{{ route('api.cbms.export') }}?from=" + from + '&to=' + to + '&pool_id=' + pool_id
            download_file(url)
        })

        // var table = $("#table").DataTable({
        //     processing: true,
        //     serverSide: true,
        //     searchDelay: 500,
        //     ajax: {
        //         url: url_index_with_pool,
        //         error: function(xhr, textStatus, errorThrown) {
        //             show_toast('error', xhr.responseJSON.message || 'server Error!')
        //         },
        //     },
        //     dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
        //         "<'table-responsive'tr>" +
        //         "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        //     oLanguage: {
        //         oPaginate: {
        //             sPrevious: '<i class="fas fa-chevron-left"></i>',
        //             sNext: '<i class="fas fa-chevron-right"></i>'
        //         },
        //         sSearch: '',
        //         sSearchPlaceholder: "Search...",
        //         sLengthMenu: "Results :  _MENU_",
        //     },
        //     lengthMenu: [
        //         [10, 50, 100, 500, 1000],
        //         ['10 rows', '50 rows', '100 rows', '500 rows', '1000 rows']
        //     ],
        //     pageLength: 10,
        //     lengthChange: true,
        //     columnDefs: [],
        //     order: [
        //         [1, 'desc'],
        //         [0, 'desc'],
        //     ],
        //     columns: [{
        //         data: 'id',
        //         searchable: false,
        //         sortable: false,
        //         render: function(data, type, row, meta) {
        //             return `<div class="custom-checkbox custom-control"><input type="checkbox" id="check${data}" data-checkboxes="mygroup" name="id[]" value="${data}" class="custom-control-input child-chk select-customers-info"><label for="check${data}" class="custom-control-label">&nbsp;</label></div>`
        //         }
        //     }, {
        //         data: 'pn',
        //     }, {
        //         data: 'name',
        //     }, {
        //         data: 'target',
        //         searchable: false,
        //     }, {
        //         data: 'actual',
        //         searchable: false,
        //     }, {
        //         data: 'id',
        //         searchable: false,
        //         sortable: false,
        //         render: function(data, type, row, meta) {
        //             if (type == 'display') {
        //                 return `<button type="button" class="btn btn-danger btn-sm btn-delete">Delete</button>`;
        //             } else {
        //                 return data
        //             }
        //         }
        //     }],
        //     buttons: [, {
        //         text: '<i class="fa fa-plus mr-1"></i>Add',
        //         className: 'btn btn-sm btn-primary bs-tooltip',
        //         attr: {
        //             'data-toggle': 'tooltip',
        //             'title': 'Add Data'
        //         },
        //         action: function(e, dt, node, config) {
        //             modal_add()
        //         }
        //     }, {
        //         extend: "colvis",
        //         attr: {
        //             'data-toggle': 'tooltip',
        //             'title': 'Column Visible'
        //         },
        //         className: 'btn btn-sm btn-primary'
        //     }, {
        //         extend: "pageLength",
        //         attr: {
        //             'data-toggle': 'tooltip',
        //             'title': 'Page Length'
        //         },
        //         className: 'btn btn-sm btn-info'
        //     }, {
        //         text: '<i class="fa fa-file-excel mr-1"></i>Export',
        //         className: 'btn btn-sm btn-info bs-tooltip',
        //         attr: {
        //             'data-toggle': 'tooltip',
        //             'title': 'Export'
        //         },
        //         action: function(e, dt, node, config) {
        //             $('#modal_export').modal('show')
        //         }
        //     }, {
        //         text: '<i class="fa fa-tools"></i> Action',
        //         className: 'btn btn-sm btn-warning bs-tooltip',
        //         attr: {
        //             'data-toggle': 'tooltip',
        //             'title': 'Action'
        //         },
        //         extend: 'collection',
        //         autoClose: true,
        //         buttons: [{
        //             text: 'Delete Selected Data',
        //             className: 'btn btn-danger',
        //             action: function(e, dt, node, config) {
        //                 delete_batch(url_index);
        //             }
        //         }, {
        //             text: 'Delete All Data in Pool',
        //             className: 'btn btn-danger',
        //             action: function(e, dt, node, config) {
        //                 truncate(url_truncate, pool_id);
        //             }
        //         }]
        //     }, ],
        //     initComplete: function() {
        //         $('#table').DataTable().buttons().container().appendTo(
        //             '#tableData_wrapper .col-md-6:eq(0)');
        //     },
        //     drawCallback: function(settings) {
        //         var api = this.api();
        //         text = `(${hrg(api.page.info().recordsDisplay)} data)`
        //         $('#total_data').text(text);
        //     },
        //     headerCallback: function(e, a, t, n, s) {
        //         e.getElementsByTagName("th")[0].innerHTML =
        //             '<div class="custom-checkbox custom-control"><input type="checkbox" class="custom-control-input chk-parent select-customers-info" id="checkbox-all"><label for="checkbox-all" class="custom-control-label">&nbsp;</label></div>'
        //     },
        // });

        // multiCheck(table);

        // $(".dataTables_filter input").unbind().bind("input", function(e) {
        //     if (this.value.length >= 3 || e.keyCode == 13) {
        //         table.search(this.value).draw();
        //     }
        //     if (this.value == "") {
        //         table.search("").draw();
        //     }
        //     return;
        // });

        // $('#table tbody').on('click', 'tr td:not(:first-child):not(:last-child)', function() {
        //     clear_validate('form')
        //     row = $(this).parents('tr')[0];
        //     id = table.row(row).data().id
        //     edit(ids)
        // });

        function edit(ids) {
            id = ids
            $.get(url_index + '/' + ids).done(function(result) {
                $('#modal_form_delete').prop('disabled', false)
                $('#name').val(result.data.name)
                var newValue = result.data.pn;
                var selectElement = $('#part_number');
                if (selectElement.find("option[value='" + newValue + "']").length === 0) {
                    selectElement.append(new Option(newValue, newValue));
                }
                selectElement.val(newValue).trigger('change');
                $('#target').val(result.data.target)

                $('#form').attr('action', url_index + '/' + ids)
                $('#modal_form_title').html('Edit Data')
                $('#modal_form_submit').val('PUT')
                $('#modal_form_password_help').show()
                $('#modal_form').modal('show')
            }).fail(function(xhr) {
                show_toast('error', xhr.responseJSON.message || 'server Error!')
            })
        }

        // $('#table tbody').on('click', 'tr .btn-delete', function() {
        //     row = $(this).parents('tr')[0];
        //     id = table.row(row).data().id
        //     send_delete(url_index + "/" + id)
        // });

        $('#modal_form_delete').on('click', function() {
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
                            url: url_index + "/" + id,
                            type: 'DELETE',
                            success: function(result) {
                                show_toast('success', result.message || 'Success!')
                                get_data()
                                // table.ajax.reload()
                                $('#modal_form').modal('hide')
                            },
                            error: function(xhr, status, error) {
                                show_toast('error', xhr.responseJSON.message || 'Server Error!')
                            }
                        })
                    }
                });
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
                send_ajax_custom('form', $('#modal_form_submit').val())
            }
        })

        $('#modal_form').on('shown.bs.modal', function() {
            $('#name').focus();
        })

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
                success: function(result) {
                    show_toast('success', result.message || 'Success!')
                    // table.ajax.reload()
                    get_data()
                    $('#modal_form').modal('hide')
                },
                error: function(xhr, status, error) {
                    handleResponseForm(xhr, 'form')
                }
            })
        }

        function modal_add() {
            clear_validate('form')
            $('#form').attr('action', url_index)
            $('#modal_form_submit').val('POST')
            $('#modal_form_title').html('Tambah Data')
            $('#modal_form').modal('show')

            $('#part_number').val('').change()
            $('#name').val('')
            $('#target').val(0)
            $('#modal_form_delete').prop('disabled', true)
        }
    </script>
@endpush
