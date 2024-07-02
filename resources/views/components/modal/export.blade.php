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
