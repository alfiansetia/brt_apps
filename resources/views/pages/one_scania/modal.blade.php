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
                            <label class="control-label" for="name">Part Name :</label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Please Enter Part Name" required>
                            <span class="error invalid-feedback err_name" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="unit">Unit :</label>
                            <input type="text" name="unit" class="form-control" id="unit"
                                placeholder="Please Enter Part Unit" required>
                            <span class="error invalid-feedback err_unit" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="component">Component :</label>
                            <input type="text" name="component" class="form-control" id="component"
                                placeholder="Please Enter Part Component" required>
                            <span class="error invalid-feedback err_component" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="number">Part Number :</label>
                            <input type="text" name="number" class="form-control" id="number"
                                placeholder="Please Enter Part Number" required>
                            <span class="error invalid-feedback err_number" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="satuan_map">Satuan :</label>
                            <input type="text" name="satuan_map" class="form-control" id="satuan_map"
                                placeholder="Please Enter Part Satuan" required>
                            <span class="error invalid-feedback err_satuan_map" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="price_map">Price MAP :</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp.</div>
                                </div>
                                <input type="text" name="price_map" class="form-control mask_angka" id="price_map"
                                    placeholder="Please Enter Part Price MAP" value="0">
                            </div>
                            <span class="error invalid-feedback err_price_map" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="satuan_vendor">Satuan :</label>
                            <input type="text" name="satuan_vendor" class="form-control" id="satuan_vendor"
                                placeholder="Please Enter Part Satuan" required>
                            <span class="error invalid-feedback err_satuan_vendor" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="price_vendor">Price Vendor :</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp.</div>
                                </div>
                                <input type="text" name="price_vendor" class="form-control mask_angka"
                                    id="price_vendor" placeholder="Please Enter Part Price Vendor" value="0">
                            </div>
                            <span class="error invalid-feedback err_price_vendor" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="vendor">Vendor :</label>
                            <input type="text" name="vendor" class="form-control" id="vendor"
                                placeholder="Please Enter Part Vendor" required>
                            <span class="error invalid-feedback err_vendor" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="brand">Brand :</label>
                            <input type="text" name="brand" class="form-control" id="brand"
                                placeholder="Please Enter Part Brand" required>
                            <span class="error invalid-feedback err_brand" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="remark">Remark :</label>
                            <textarea name="remark" id="remark" class="form-control" maxlength="200" placeholder="Please Enter Remark"></textarea>
                            <span class="error invalid-feedback err_remark" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="file">File :</label>
                            <div class="custom-file mb-2">
                                <input type="file" name="file" class="custom-file-input" id="file">
                                <label class="custom-file-label" for="file">Choose file</label>
                            </div>
                            <small class="form-text text-muted">PDF/Image Max Size 10MB</small>
                            <span class="error invalid-feedback err_file"></span>
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

    <div class="modal fade" id="modal_import" tabindex="-1" aria-labelledby="modal_importLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_importLabel">Import From File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_import" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="control-label" for="import_file">Pilih File :</label>
                            <div class="custom-file">
                                <input name="file" type="file" class="custom-file-input" id="import_file"
                                    accept=".xlsx,.xls,.csv">
                                <label class="custom-file-label" for="import_file">Choose file</label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="{{ asset('master_import/onescania.xlsx') }}" class="btn btn-info" target="_blank">
                        <i class="fas fa-download mr-1" data-toggle="tooltip" title="Download Sample"></i>Download Sample
                    </a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"
                            data-toggle="tooltip" title="Close"></i>Close</button>
                    <button type="button" id="btn_import" class="btn btn-primary"><i class="fas fa-upload mr-1"
                            data-toggle="tooltip" title="Import"></i>Upload</button>
                </div>
            </div>
        </div>
    </div>
@endpush
