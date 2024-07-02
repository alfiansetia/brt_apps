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
                            <label class="control-label" for="user">User :</label>
                            <select name="user" id="user" class="form-control select2" style="width: 100%;"
                                required>
                            </select>
                            <span class="error invalid-feedback err_user" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="unit">Unit :</label>
                            <div class="input-group">
                                <select name="unit" id="unit" class="custom-select select2" style="width: 100%;"
                                    required>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" data-toggle="modal" value="unit"
                                        data-target="#qrScannerModal"><i class="fas fa-qrcode"></i></button>
                                </div>
                            </div>
                            <span class="error invalid-feedback err_unit" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="product">Product :</label>
                            <div class="input-group">
                                <select name="product" id="product" class="custom-select select2" style="width: 100%;"
                                    required>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" data-toggle="modal" value="product"
                                        data-target="#qrScannerModal"><i class="fas fa-qrcode"></i></button>
                                </div>
                            </div>
                            <span class="error invalid-feedback err_product" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="date">Date :</label>
                            <input type="text" name="date" class="form-control datepicker" id="date"
                                placeholder="Please Enter date" value="{{ date('Y-m-d') }}" required readonly>
                            <span class="error invalid-feedback err_date" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="amount">Amount Liter :</label>
                            <input type="text" name="amount" class="form-control mask_angka" id="amount"
                                placeholder="Please Enter Amount Liter" min="0" required>
                            <span class="error invalid-feedback err_amount" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Type :</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="type" value="service" class="selectgroup-input" checked>
                                    <span class="selectgroup-button">Service</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="type" value="levelling" class="selectgroup-input">
                                    <span class="selectgroup-button">Levelling</span>
                                </label>
                            </div>
                            <span class="error invalid-feedback err_type" style="display: hide;"></span>
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

    @include('components.modal.scan')

    @include('components.modal.export')
@endpush
