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
                            <label class="form-label">Type Service :</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="type" value="S" class="selectgroup-input" checked>
                                    <span class="selectgroup-button">S</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="type" value="M" class="selectgroup-input">
                                    <span class="selectgroup-button">M</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="type" value="L" class="selectgroup-input">
                                    <span class="selectgroup-button">L</span>
                                </label>
                            </div>
                            <span class="error invalid-feedback err_type" style="display: hide;"></span>
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
                            <label class="control-label" for="date">Date :</label>
                            <input type="text" name="date" class="form-control datepicker" id="date"
                                placeholder="Please Enter date" required readonly>
                            <span class="error invalid-feedback err_date" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="km">KM Unit :</label>
                            <input type="text" name="km" class="form-control mask_angka" id="km"
                                placeholder="Please Enter KM Unit" min="0" required>
                            <span class="error invalid-feedback err_km" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="last_date">Date Last Service :</label>
                            <input type="text" name="last_date" class="form-control datepicker" id="last_date"
                                placeholder="Please Enter Date Last Service" required readonly>
                            <span class="error invalid-feedback err_last_date" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="last_km">KM Last Service :</label>
                            <input type="text" name="last_km" class="form-control mask_angka" id="last_km"
                                placeholder="Please Enter KM Last Service" min="0" required>
                            <span class="error invalid-feedback err_last_km" style="display: hide;"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="fas fa-times mr-1" data-toggle="tooltip" title="Close"></i>Close</button>
                        <button type="submit" id="modal_form_submit" class="btn btn-primary"><i
                                class="fas fa-paper-plane mr-1" data-toggle="tooltip" title="Save"></i>Save</button>

                        <button type="button" id="btn_item_add" class="btn btn-primary" style="display: none"><i
                                class="fas fa-plus mr-1" data-toggle="tooltip" title="Add Item"></i>Add
                            Image</button>
                        <div class="table-responsive" id="div_item" style="display: none">
                            <table class="table table-hover" id="table_item" style="width: 100%;cursor: pointer;">
                                <thead>
                                    <tr>
                                        <th>Label</th>
                                        <th>Image</th>
                                        <th style="width: 30px">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal animated fade fadeInDown" id="modal_form_item" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_form_item_title">Add Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" data-toggle="tooltip" title="Close">&times;</span>
                    </button>
                </div>
                <form id="form_item" class="form-vertical" action="{{ route('api.service_items.store') }}"
                    method="POST">
                    @csrf
                    <input type="hidden" name="service" id="service_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label" for="label">Label :</label>
                            <select name="label" id="label" class="form-control select2" style="width: 100%;"
                                required>
                            </select>
                            <span class="error invalid-feedback err_label" style="display: hide;"></span>
                        </div>

                        <div class="form-group" id="input_custom_label">
                            <label class="control-label" for="custom_label">Custom Label :</label>
                            <textarea name="custom_label" id="custom_label" class="form-control" maxlength="200"
                                placeholder="Please Enter Custom Label" required></textarea>
                            <span class="error invalid-feedback err_custom_label" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="image">Image :</label>
                            <div class="custom-file mb-2">
                                <input type="file" name="image" class="custom-file-input" id="image"
                                    onchange="readURL('form_item', 'image');" accept="image/jpeg, image/png, image/jpg"
                                    required>
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                            <small class="form-text text-muted">Max Size 3MB</small>
                            <span class="error invalid-feedback err_image"></span>
                            <br><img class="image_preview mt-1" src="#" style="display: none;max-width: 200px" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="fas fa-times mr-1" data-toggle="tooltip" title="Close"></i>Close</button>
                        <button type="submit" id="modal_form_item_submit" class="btn btn-primary"><i
                                class="fas fa-paper-plane mr-1" data-toggle="tooltip" title="Save"></i>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('components.modal.scan')

    <div class="modal animated fade fadeInDown" id="modal_image" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_image_title">Detail Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" data-toggle="tooltip" title="Close">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="width: 100%">
                    <img src="" alt="" id="detail_image" style="width: 100%">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"
                            data-toggle="tooltip" title="Close"></i>Close</button>
                </div>
            </div>
        </div>
    </div>
@endpush
