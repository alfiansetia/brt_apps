<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} &mdash; {{ env('APP_NAME') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/stisla.svg') }}" />

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('lib/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/@fortawesome/fontawesome-free/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/bootstrap-daterangepicker/daterangepicker.css') }}">

    @stack('css')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

    <link rel="stylesheet" href="{{ asset('lib/izitoast/dist/css/iziToast.min.css') }}">

    <style>
        .input-group>.select2-container--default {
            width: auto !important;
            flex: 1 1 auto !important;
        }

        .input-group>.select2-container--default .select2-selection--single {
            height: 100% !important;
            line-height: inherit !important;
        }

        textarea.form-control {
            min-height: 64px !important;
        }
    </style>

</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>

            @include('components.nav')
            @include('components.sidebar')

            <!-- Main Content -->
            <div class="main-content">

                @stack('modal')

                <section class="section">
                    <div class="section-header">
                        <h1>{{ $title }} <span id="total_data"></span></h1>
                        <div class="section-header-breadcrumb">
                            {{-- <div class="breadcrumb-item {{ $title != 'Dashboard' ? 'active' : '' }}">
                                <a href="{{ route('home') }}">Dashboard</a>
                            </div> --}}
                            <div class="breadcrumb-item {{ $title != 'Onboarding' ? 'active' : '' }}">
                                <a href="{{ route('onboarding.index') }}">Onboarding</a>
                            </div>
                            @if ($title != 'Menu' && $title != 'Onboarding')
                                <div class="breadcrumb-item">
                                    <a
                                        href="{{ route('onboarding.menu') }}?pool={{ request()->query('pool') }}">Menu</a>
                                </div>
                            @endif
                            @if ($title != 'Onboarding')
                                <div class="breadcrumb-item">{{ $title }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="section-body">

                        @yield('content')

                    </div>
                </section>
            </div>

            @include('components.footer')

        </div>
    </div>

    <form action="{{ route('logout') }}" method="post" id="form_logout">
        @csrf
    </form>

    <!-- General JS Scripts -->
    <script src="{{ asset('lib/jquery/dist/jquery.js') }}"></script>
    <script src="{{ asset('lib/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('lib/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('lib/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>

    <script src="{{ asset('lib/moment/min/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <script src="{{ asset('lib/izitoast/dist/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('lib/blockui-2.70/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('lib/bs-custom-file-input-1.3.4/dist/bs-custom-file-input.min.js') }}"></script>
    <script src="{{ asset('lib/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script src="{{ asset('lib/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <script>
        function hrg(x) {
            return parseInt(x).toLocaleString('id-ID')
        }

        function hrgd(x) {
            const num = parseFloat(x);
            return num.toLocaleString('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function parse_date(dateString) {
            return moment(dateString).format('DD/MM/YYYY');
        }

        function set_date(id = 'date') {
            let date = "{{ date('d/m/Y') }}"
            $("#" + id).data('daterangepicker').setStartDate(date);
            $("#" + id).data('daterangepicker').setEndDate(date);
        }

        function parse_hm(data) {
            if (data && data.length === 8) {
                var timeParts = data.split(':');
                var formattedTime = timeParts[0] + ':' + timeParts[1];
                return formattedTime;
            }
            return data;
        }

        function ajax_setup() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json',
                    // 'Content-Type': 'application/x-www-form-urlencoded'
                }
            });
        }

        function readURL(formID, inputName) {
            let obj = $(`#${formID} input[name="${inputName}"]`);
            if (obj.length < 0) {
                return
            }
            if (obj[0].files && obj[0].files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + formID + ' .image_preview').show()
                    $('#' + formID + ' .image_preview').attr('src', e.target.result)
                };
                reader.readAsDataURL(obj[0].files[0]);
            }
        }

        function logout_() {
            swal({
                    title: 'Are you sure?',
                    text: 'Logout?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#form_logout').submit();
                    }
                });
        }

        function show_toast(type = 'success', message = '') {
            if (type == 'success') {
                iziToast.success({
                    title: 'Success!',
                    message: message,
                    position: 'topRight'
                });
            } else if (type == 'warning') {
                iziToast.warning({
                    title: 'Warning!',
                    message: message,
                    position: 'topRight'
                });
            } else {
                iziToast.error({
                    title: 'Error!',
                    message: message,
                    position: 'topRight'
                });
            }
        }

        function send_ajax(formID, method) {
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
                    table.ajax.reload()
                    $('#modal_form').modal('hide')
                },
                error: function(xhr, status, error) {
                    handleResponseForm(xhr, 'form')
                }
            })
        }

        function send_delete(url) {
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
                                table.ajax.reload()
                            },
                            error: function(xhr, status, error) {
                                show_toast('error', xhr.responseJSON.message || 'Server Error!')
                            }
                        })
                    }
                });
        }

        function handleResponseForm(jqXHR, formID) {
            let message = jqXHR.responseJSON.message
            if (jqXHR.status != 422) {
                show_toast('error', message)
            } else {
                let errors = jqXHR.responseJSON.errors || {};
                let errorKeys = Object.keys(errors);

                for (let i = 0; i < errorKeys.length; i++) {
                    let fieldName = errorKeys[i];
                    let errorMessage = errors[fieldName][0];
                    $('#' + formID + ' [name="' + fieldName + '"]').addClass('is-invalid');
                    $('#' + formID + ' [name="' + fieldName + '"]').removeClass('is-valid');
                    $('#' + formID + ' .err_' + fieldName).text(errorMessage).show();
                }
            }
        }

        function clear_validate(formID) {
            let form = $('#' + formID);
            form.find('.error.invalid-feedback').each(function() {
                $(this).hide().text('');
            });
            form.find('input.is-invalid, textarea.is-invalid, select.is-invalid').each(function() {
                $(this).removeClass('is-invalid');
                $(this).removeClass('is-valid');
            });
        }

        function truncate_all(url, pool_id) {
            swal({
                    title: 'Are you sure?',
                    text: 'Delete All Data?',
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
                                table.ajax.reload()
                            },
                            error: function(xhr, status, error) {
                                show_toast('error', xhr.responseJSON.message || 'Server Error!')
                            }
                        })
                    }
                });
        }

        function truncate(url, pool_id) {
            swal({
                    title: 'Are you sure?',
                    text: 'Delete All Data in this Pool?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        ajax_setup()
                        $.ajax({
                            url: url,
                            data: {
                                pool_id: pool_id
                            },
                            type: 'DELETE',
                            success: function(result) {
                                show_toast('success', result.message || 'Success!')
                                table.ajax.reload()
                            },
                            error: function(xhr, status, error) {
                                show_toast('error', xhr.responseJSON.message || 'Server Error!')
                            }
                        })
                    }
                });
        }

        function selected() {
            let id = $('input[name="id[]"]:checked').length;
            if (id <= 0) {
                show_toast('error', "No Selected Data!")
                return false
            } else {
                return true
            }
        }

        function delete_batch(url) {

            if (!selected()) {
                return
            }

            swal({
                    title: 'Are you sure?',
                    text: 'Delete Selection Data?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        ajax_setup()
                        $.ajax({
                            url: url,
                            data: $("#formSelected").serialize(),
                            type: 'DELETE',
                            success: function(result) {
                                show_toast('success', result.message || 'Success!')
                                table.ajax.reload()
                            },
                            error: function(xhr, status, error) {
                                show_toast('error', xhr.responseJSON.message || 'Server Error!')
                            }
                        })
                    }
                });
        }

        function multiCheck(tb_var) {
            tb_var.on("change", ".chk-parent", function() {
                    var e = $(this).closest("table").find("td:first-child .child-chk"),
                        a = $(this).is(":checked");
                    $(e).each(function() {
                        a ? ($(this).prop("checked", !0), $(this).closest("tr").addClass("active")) : ($(this)
                            .prop("checked", !1), $(this).closest("tr").removeClass("active"))
                    })
                }),
                tb_var.on("change", "tbody tr .new-control", function() {
                    $(this).parents("tr").toggleClass("active")
                })
        }

        function checkall(clickchk, relChkbox) {

            var checker = $('#' + clickchk);
            var multichk = $('.' + relChkbox);
            checker.click(function() {
                multichk.prop('checked', $(this).prop('checked'));
            });
        }

        $(document).ready(function() {
            $(document).ajaxStart(function() {
                $.blockUI({
                    message: '<img src="{{ asset('assets/img/loading.gif') }}" width="20px" height="20px" /> Just a moment...',
                    // baseZ: 2000,
                });
            }).ajaxStop($.unblockUI);

            bsCustomFileInput.init()

            $('[data-toggle="tooltip"]').on('shown.bs.tooltip', function() {
                var $this = $(this);
                setTimeout(function() {
                    $this.tooltip('hide');
                }, 3000);
            });

        })
    </script>
    <!-- JS Libraies -->
    @stack('js')

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js?v=1') }}"></script>
    <script src="{{ asset('assets/js/custom.js?v=1') }}"></script>

    @if (session()->has('success'))
        <script>
            show_toast("success", "{{ session('success') }}");
        </script>
    @elseif(session()->has('error'))
        <script>
            show_toast("error", "{{ session('error') }}");
        </script>
    @endif
</body>

</html>
