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
                            <label class="control-label" for="name">Name :</label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Please Enter Name" maxlength="100" required>
                            <span class="error invalid-feedback err_name" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="email">Email :</label>
                            <input type="email" name="email" class="form-control" id="email"
                                placeholder="Please Enter Email" maxlength="100" required>
                            <span class="error invalid-feedback err_email" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="nrp">NRP :</label>
                            <input type="text" name="nrp" class="form-control" id="nrp"
                                placeholder="Please Enter NRP" maxlength="100">
                            <span class="error invalid-feedback err_nrp" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password">Password :</label>
                            <input type="text" name="password" class="form-control" id="password"
                                placeholder="Please Enter Password" minlength="5" required>
                            <small id="modal_form_password_help" class="form-text text-muted" style="display: none">
                                Kosongkan jika tidak ingin mengganti password.
                            </small>
                            <span class="error invalid-feedback err_password" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="pool">Pool :</label>
                            <select name="pool" id="pool" class="form-control select2" style="width: 100%;"
                                required>
                            </select>
                            <span class="error invalid-feedback err_pool" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Role :</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="role" value="user" class="selectgroup-input" checked>
                                    <span class="selectgroup-button">User</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="role" value="admin" class="selectgroup-input">
                                    <span class="selectgroup-button">Admin</span>
                                </label>
                            </div>
                            <span class="error invalid-feedback err_role" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="custom-switch mt-2 pl-0">
                                <input type="checkbox" name="is_active" id="is_active" class="custom-switch-input">
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Active (Can Login)</span>
                            </label>
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
@endpush
