@push('modal')
    <div class="modal animated fade fadeInDown" id="modal_form" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
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
                    <div class="modal-body pb-0">
                        <div class="form-group">
                            <label class="form-label">Shift :</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="shift" value="day" class="selectgroup-input" checked>
                                    <span class="selectgroup-button">Day</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="shift" value="night" class="selectgroup-input">
                                    <span class="selectgroup-button">Night</span>
                                </label>
                            </div>
                            <span class="error invalid-feedback err_shift" style="display: hide;"></span>
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
                            <label class="form-label">Type :</label>
                            <div class="selectgroup w-100">
                                <label class="selectgroup-item">
                                    <input type="radio" name="type" value="schedule" class="selectgroup-input" checked>
                                    <span class="selectgroup-button">Schedule</span>
                                </label>
                                <label class="selectgroup-item">
                                    <input type="radio" name="type" value="unschedule" class="selectgroup-input">
                                    <span class="selectgroup-button">Unschedule</span>
                                </label>
                            </div>
                            <span class="error invalid-feedback err_type" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="date">Date :</label>
                            <input type="text" name="date" class="form-control datepicker" id="date"
                                placeholder="Please Enter date" required readonly>
                            <span class="error invalid-feedback err_date" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="start">Start :</label>
                            <input type="text" name="start" class="form-control datetimepicker" id="start"
                                placeholder="Please Enter Start" required readonly>
                            <span class="error invalid-feedback err_start" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="finish">Finish :</label>
                            <input type="text" name="finish" class="form-control datetimepicker" id="finish"
                                placeholder="Please Enter Finish" required readonly>
                            <span class="error invalid-feedback err_finish" style="display: hide;"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="fas fa-times mr-1" data-toggle="tooltip" title="Close"></i>Close</button>
                        <button type="submit" id="modal_form_submit" class="btn btn-primary"><i
                                class="fas fa-paper-plane mr-1" data-toggle="tooltip" title="Save"></i>Save</button>

                        <button type="button" id="btn_item_add" class="btn btn-primary" style="display: none"><i
                                class="fas fa-plus mr-1" data-toggle="tooltip" title="Add Item"></i>Add
                            Item</button>
                        <div class="table-responsive" id="div_item" style="display: none">
                            <table class="table table-hover" id="table_item" style="width: 100%;cursor: pointer;">
                                <thead>
                                    <tr>
                                        <th>Desc</th>
                                        <th>Action</th>
                                        <th>Component</th>
                                        <th>Part Number</th>
                                        <th>Part Name</th>
                                        <th>Part Qty</th>
                                        <th>Man Power</th>
                                        <th style="width: 50px">#</th>
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
                    <h5 class="modal-title" id="modal_form_item_title">Add Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" data-toggle="tooltip" title="Close">&times;</span>
                    </button>
                </div>
                <form id="form_item" class="form-vertical" action="{{ route('api.dmcr_items.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="dmcr" id="dmcr_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label" for="desc">Desc :</label>
                            <textarea name="desc" id="desc" class="form-control" maxlength="200" placeholder="Please Enter Desc"
                                required></textarea>
                            <span class="error invalid-feedback err_desc" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="action">Action :</label>
                            <textarea name="action" id="action" class="form-control" maxlength="200" placeholder="Please Enter Action"
                                required></textarea>
                            <span class="error invalid-feedback err_action" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="component">Component :</label>
                            <select name="component" id="component" class="custom-select select2" style="width: 100%;"
                                required>
                            </select>
                            <span class="error invalid-feedback err_component" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="part_number">Part Number :</label>
                            <input type="text" name="part_number" class="form-control" id="part_number"
                                placeholder="Please Enter Part Number" maxlength="200">
                            <span class="error invalid-feedback err_part_number" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="part_name">Part Name :</label>
                            <textarea name="part_name" id="part_name" class="form-control" maxlength="200"
                                placeholder="Please Enter Part Name"></textarea>
                            <span class="error invalid-feedback err_part_name" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="part_qty">Part Qty :</label>
                            <input type="text" name="part_qty" class="form-control mask_angka" id="part_qty"
                                placeholder="Please Enter Part Qty" min="0">
                            <span class="error invalid-feedback err_part_qty" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="users">Man Powers :</label>
                            <select name="users[]" id="users" class="form-control" style="width: 100%;" required>
                                {{-- @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach --}}
                            </select>
                            <span class="error invalid-feedback err_users" style="display: hide;"></span>
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

    @include('components.modal.export')
@endpush
