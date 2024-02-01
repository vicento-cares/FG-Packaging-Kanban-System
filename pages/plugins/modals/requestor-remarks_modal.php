<!-- Data Info Modal -->
<div class="modal fade" id="RequestRemarksDetailsSectionModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Remarks Details</h4>
        <button type="button" class="close" data-dismiss="modal" data-toggle="modal" data-target="" aria-label="Close" id="btnRequestRemarksDetailsSectionModalClose1">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="requestor_remarks_id">
        <input type="hidden" id="remarks_id">
        <input type="hidden" id="remarks_request_id">
        <input type="hidden" id="remarks_kanban">
        <input type="hidden" id="remarks_kanban_no">
        <input type="hidden" id="remarks_serial_no">
        <input type="hidden" id="remarks_scan_date_time">
        <form>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Request ID : </label>
                <span id="remarks_request_id_shown"></span>
              </div>
              <!-- text input -->
              <div class="form-group">
                <label>Requestor/PIC Fullname : </label>
                <span id="remarks_requestor_name"></span>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Requestor Remarks Date & Time : </label>
                <span id="remarks_requestor_date_time"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Requestor Remarks</label>
                <textarea id="i_requestor_remarks" class="form-control" style="resize: none;" rows="3" maxlength="255" placeholder="Type your remarks here" onkeyup="count_requestor_remarks_char()" required></textarea>
                <span id="i_requestor_remarks_count"></span>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lightblue" data-dismiss="modal" data-toggle="modal" data-target="" id="btnRequestRemarksDetailsSectionModalClose2">Close</button>
        <button type="button" class="btn btn-success" id="btnAddRemarks" onclick="save_requestor_remarks()" style="display:none;" disabled>Add Remarks</button>
        <button type="button" class="btn btn-success" id="btnSaveRemarks" onclick="update_requestor_remarks()" style="display:none;" disabled>Save Remarks</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->