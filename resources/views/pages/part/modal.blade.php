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
                            <label class="control-label" for="unit_detail">Unit :</label>
                            <input type="text" name="unit_detail" class="form-control" id="unit_detail"
                                placeholder="Please Enter Unit" maxlength="100" required>
                            <span class="error invalid-feedback err_unit_detail" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="sn">Serial Number :</label>
                            <input type="text" name="sn" class="form-control" id="sn"
                                placeholder="Please Enter Serial Number" maxlength="100" required>
                            <span class="error invalid-feedback err_sn" style="display: hide;"></span>
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
                            <label class="control-label" for="start_date">Start Date :</label>
                            <input type="text" name="start_date" class="form-control datepicker" id="start_date"
                                placeholder="Please Enter Start Date" required readonly>
                            <span class="error invalid-feedback err_start_date" style="display: hide;"></span>
                        </div>
                        <div class="form-group mb-0">
                            <label class="control-label" for="finish_date">Finish Date :</label>
                            <input type="text" name="finish_date" class="form-control datepicker" id="finish_date"
                                placeholder="Please Enter Start Date" required readonly>
                            <span class="error invalid-feedback err_finish_date" style="display: hide;"></span>
                        </div>
                    </div>
                    <div class="modal-footer pt-0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="fas fa-times mr-1" data-toggle="tooltip" title="Close"></i>Close</button>
                        <button type="submit" id="modal_form_submit" class="btn btn-primary"><i
                                class="fas fa-paper-plane mr-1" data-toggle="tooltip" title="Save"></i>Save</button>

                        <button type="button" id="btn_item_add" class="btn btn-primary" style="display: none"><i
                                class="fas fa-plus mr-1" data-toggle="tooltip" title="Add Item"></i>Add
                            Image</button>
                        <div class="table-responsive" id="div_item" style="display: none">
                            <h6>[ Part Baru : <span class="text-success" id="part_baru"></span> ] [ Part Bekas : <span
                                    class="text-danger" id="part_bekas"></span>
                                ]</h6>
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
                <form id="form_item" class="form-vertical" action="{{ route('api.part_items.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="part" id="part_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label">Type Part :</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="type" value="new" class="selectgroup-input"
                                        checked>
                                    <span class="selectgroup-button">BARU</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="type" value="old" class="selectgroup-input">
                                    <span class="selectgroup-button">BEKAS</span>
                                </label>
                            </div>
                            <span class="error invalid-feedback err_type" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="image">Image :</label>
                            <div class="custom-file mb-2">
                                <input type="file" name="image" class="custom-file-input" id="image"
                                    onchange="readURL('form_item', 'image');" accept="image/jpeg, image/png, image/jpg"
                                    required>
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                            <small class="form-text text-muted">Max Size 5MB</small>
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
