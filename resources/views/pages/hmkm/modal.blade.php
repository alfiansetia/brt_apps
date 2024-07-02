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
                            <label class="control-label" for="date">Date :</label>
                            <input type="text" name="date" class="form-control datepicker" id="date"
                                placeholder="Please Enter date" value="{{ date('Y-m-d') }}" required readonly>
                            <span class="error invalid-feedback err_date" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="hm">HM Unit :</label>
                            <input type="text" name="hm" class="form-control mask_angka" id="hm"
                                placeholder="Please Enter HM Unit" min="0" required>
                            <span class="error invalid-feedback err_hm" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="km">KM Unit :</label>
                            <input type="text" name="km" class="form-control mask_angka" id="km"
                                placeholder="Please Enter KM Unit" min="0" required>
                            <span class="error invalid-feedback err_km" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="hm_ac">HM AC Unit :</label>
                            <input type="text" name="hm_ac" class="form-control mask_angka" id="hm_ac"
                                placeholder="Please Enter HM AC Unit" min="0" required>
                            <span class="error invalid-feedback err_hm_ac" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="desc">Desc :</label>
                            <textarea name="desc" id="desc" class="form-control" maxlength="200" placeholder="Please Enter Desc"></textarea>
                            <span class="error invalid-feedback err_desc" style="display: hide;"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"
                                data-toggle="tooltip" title="Close"></i>Close</button>
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

    <div class="modal fade" id="modal_export" tabindex="-1" aria-labelledby="modal_exportLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_exportLabel">Export To File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="range">Range Date :</label>
                        <input type="text" name="range" class="form-control daterange-cus" id="range"
                            placeholder="Please Enter Range Date" value="{{ date('Y-m-d') }}" required readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btn_export" class="btn btn-primary"><i class="fas fa-download mr-1"
                            data-toggle="tooltip" title="Export"></i>Download</button>
                </div>
            </div>
        </div>
    </div>
@endpush
