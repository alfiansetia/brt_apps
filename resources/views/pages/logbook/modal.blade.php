@push('modal')
    <div class="modal animated fade fadeInDown" id="modal_form" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_form_title">Add Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" data-toggle="tooltip" title="Close">&times;</span>
                    </button>
                </div>
                <form id="form" class="form-vertical" action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label" for="date">Date :</label>
                            <input type="text" name="date" class="form-control datepicker" id="date"
                                placeholder="Please Enter date" value="{{ date('Y-m-d') }}" required readonly>
                            <span class="error invalid-feedback err_date" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="unit">Unit :</label>
                            <div class="input-group">
                                <select name="unit" id="unit" class="custom-select select2" style="width: 100%;"
                                    required>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" data-toggle="modal"
                                        data-target="#qrScannerModal"><i class="fas fa-qrcode"></i></button>
                                </div>
                            </div>
                            <span class="error invalid-feedback err_unit" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="component">Component :</label>
                            <div class="input-group">
                                <select name="component" id="component" class="custom-select select2" style="width: 100%;"
                                    required>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" data-toggle="modal"
                                        data-target="#qrScannerModal"><i class="fas fa-qrcode"></i></button>
                                </div>
                            </div>
                            <span class="error invalid-feedback err_component" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="location">Location :</label>
                            <textarea name="location" id="location" class="form-control" maxlength="200" placeholder="Please Enter Location"></textarea>
                            <span class="error invalid-feedback err_location" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="pre">Pre :</label>
                            <input type="text" name="pre" class="form-control timepickerd" id="pre"
                                placeholder="Please Enter Pre" required readonly>
                            <span class="error invalid-feedback err_pre" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="start">Start :</label>
                            <input type="text" name="start" class="form-control timepickerd" id="start"
                                placeholder="Please Enter Start" required readonly>
                            <span class="error invalid-feedback err_start" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="finish">Finish :</label>
                            <input type="text" name="finish" class="form-control timepickerd" id="finish"
                                placeholder="Please Enter Finish" required readonly>
                            <span class="error invalid-feedback err_finish" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="problem">Problem :</label>
                            <textarea name="problem" id="problem" class="form-control" maxlength="200" placeholder="Please Enter Problem"></textarea>
                            <span class="error invalid-feedback err_problem" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="action">Action :</label>
                            <textarea name="action" id="action" class="form-control" maxlength="200" placeholder="Please Enter Action"></textarea>
                            <span class="error invalid-feedback err_action" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status :</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="status" value="pending" class="selectgroup-input"
                                        checked>
                                    <span class="selectgroup-button">Pending</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="status" value="done" class="selectgroup-input">
                                    <span class="selectgroup-button">Done</span>
                                </label>
                            </div>
                            <span class="error invalid-feedback err_status" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="users">Man Powers :</label>
                            <select name="users[]" id="users" class="form-control" style="width: 100%;" required>
                            </select>
                            <span class="error invalid-feedback err_users" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="desc">Desc :</label>
                            <textarea name="desc" id="desc" class="form-control" maxlength="200" placeholder="Please Enter Desc"></textarea>
                            <span class="error invalid-feedback err_desc" style="display: hide;"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="fas fa-times mr-1" data-toggle="tooltip" title="Close"></i>Close</button>
                        <button type="submit" id="modal_form_submit" class="btn btn-primary"><i
                                class="fas fa-paper-plane mr-1" data-toggle="tooltip" title="Save"></i>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="qrScannerModal" tabindex="-1" aria-labelledby="qrScannerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrScannerModalLabel">SCAN QR UNIT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="reader" style="width:100%"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endpush
