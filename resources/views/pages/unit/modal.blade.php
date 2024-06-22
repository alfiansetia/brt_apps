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
                            <label class="control-label" for="pool">Pool :</label>
                            <select name="pool" id="pool" class="form-control select2" style="width: 100%;"
                                required>
                            </select>
                            <span class="error invalid-feedback err_pool" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="code">Code :</label>
                            <input type="text" name="code" class="form-control" id="code"
                                placeholder="Please Enter Code" maxlength="200" onchange="qr()" required>
                            <span class="error invalid-feedback err_code" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Type :</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="type" value="maxi" class="selectgroup-input" checked>
                                    <span class="selectgroup-button">Maxi</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="type" value="artic" class="selectgroup-input">
                                    <span class="selectgroup-button">Artic</span>
                                </label><label class="selectgroup-item">
                                    <input type="radio" name="type" value="low entry" class="selectgroup-input">
                                    <span class="selectgroup-button">Low Entry</span>
                                </label>
                            </div>
                            <span class="error invalid-feedback err_type" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="desc">Desc :</label>
                            <textarea name="desc" id="desc" class="form-control" maxlength="200" placeholder="Please Enter Desc"></textarea>
                            <span class="error invalid-feedback err_desc" style="display: hide;"></span>
                        </div>
                        <center>
                            <div id="qr"></div>
                            <span id="qr_label" style="font-weight: bold"></span>
                        </center>
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
@endpush
