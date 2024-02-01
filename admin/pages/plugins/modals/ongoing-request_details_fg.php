<!-- Data Info Modal -->
<div class="modal fade" id="OngoingRequestDetailsFgModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Ongoing Request Details</h4>
        <button type="button" class="close" data-dismiss="modal" onclick="uncheck_all_ongoing()" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="ongoing_request_id">
        <div class="row">
          <div class="col-sm-12">
            <label><i class="fas fa-user-tag"></i> Requestor/PIC Fullname : </label>
            <span id="ongoing_requestor_name"></span>
          </div>
        </div>
        <div class="table-responsive" style="max-height: 200px; overflow: auto; display:inline-block;">
          <table id="ongoingRequestedDetailsTable" class="table table-sm table-head-fixed text-nowrap table-hover">
            <thead style="text-align: center;">
              <tr>
                <th><input type="checkbox" name="check_all_ongoing" id="check_all_ongoing" onclick="select_all_ongoing_func()"></th>
                <th>Line No.</th>
                <th>Storage Area</th>
                <th>Item No.</th>
                <th>Item Name</th>
                <th>Kbn No.</th>
                <th>Qty</th>
                <th>Remarks</th>
                <th>Scan Date & Time</th>
                <th>Request Date & Time</th>
              </tr>
            </thead>
            <tbody id="ongoingRequestedDetailsData" style="text-align: center;"></tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lightblue" data-dismiss="modal" onclick="uncheck_all_ongoing()">Close</button>
        <button type="button" class="btn bg-lightblue" data-dismiss="modal" id="btnPrintOngoing" onclick="print_ongoing()" disabled>Print</button>
        <button type="button" class="btn btn-success" id="btnStoreOutRequested" data-dismiss="modal" data-toggle="modal" data-target="#ConfirmStoreOutRequestModal" disabled>Store Out Requested</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->