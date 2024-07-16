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
                            <label class="control-label" for="part_number">Part Number :</label>
                            <select name="part_number" id="part_number" class="custom-select select2" style="width: 100%;"
                                required>
                                <option value="">Select Part Number</option>
                                @foreach ($pns as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            <span class="error invalid-feedback err_part_number" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Name Project :</label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Please Enter Name Project" required>
                            <span class="error invalid-feedback err_name" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="target">Target :</label>
                            <input type="text" name="target" class="form-control mask_angka" id="target"
                                placeholder="Please Enter Target" min="0" required>
                            <span class="error invalid-feedback err_target" style="display: hide;"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="modal_form_delete" class="btn btn-danger"><i class="fas fa-trash mr-1"
                                data-toggle="tooltip" title="Delete"></i>Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"
                                data-toggle="tooltip" title="Close"></i>Close</button>
                        <button type="submit" id="modal_form_submit" class="btn btn-primary"><i
                                class="fas fa-paper-plane mr-1" data-toggle="tooltip" title="Save"></i>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('components.modal.export')
@endpush
