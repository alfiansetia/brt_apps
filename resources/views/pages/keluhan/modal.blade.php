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
                    <input type="hidden" name="pool_id" value="{{ request()->query('pool') }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label" for="date">Date :</label>
                            <input type="text" name="date" class="form-control datepicker-down" id="date"
                                placeholder="Please Enter date" required readonly>
                            <span class="error invalid-feedback err_date" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Name Pramudi / Mekanik :</label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Please Enter Name" maxlength="200" required>
                            <span class="error invalid-feedback err_name" style="display: hide;"></span>
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
                            <label class="control-label" for="km">KM Unit :</label>
                            <input type="text" name="km" class="form-control mask_angka" id="km"
                                placeholder="Please Enter KM Unit" min="0" required>
                            <span class="error invalid-feedback err_km" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="keluhan">Keluhan :</label>
                            <textarea name="keluhan" id="keluhan" class="form-control" maxlength="200" placeholder="Please Enter Keluhan"
                                required></textarea>
                            <span class="error invalid-feedback err_keluhan" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Responsible :</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="responsible" value="UT" class="selectgroup-input"
                                        checked>
                                    <span class="selectgroup-button">UT</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="responsible" value="MB" class="selectgroup-input">
                                    <span class="selectgroup-button">MB</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="responsible" value="TJ" class="selectgroup-input">
                                    <span class="selectgroup-button">TJ</span>
                                </label>
                            </div>
                            <span class="error invalid-feedback err_responsible" style="display: hide;"></span>
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
                            <label class="control-label" for="activity">Activity :</label>
                            <textarea name="activity" id="activity" class="form-control" maxlength="200" placeholder="Please Enter Activity"></textarea>
                            <span class="error invalid-feedback err_activity" style="display: hide;"></span>
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

    @include('components.modal.scan')

    @include('components.modal.export')
@endpush
