<!-- Data Info Modal -->
<div class="modal fade" id="PendingRequestDetailsSectionModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Pending Request Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <label><i class="fas fa-user-tag"></i> Requestor/PIC Fullname : </label>
            <span id="pending_requestor_name"></span>
          </div>
        </div>
        <div class="table-responsive" style="max-height: 200px; overflow: auto; display:inline-block;">
          <table id="pendingRequestDetailsTable" class="table table-sm table-head-fixed text-nowrap table-hover">
            <thead style="text-align: center;">
              <tr>
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
            <tbody id="pendingRequestDetailsData" style="text-align: center;"></tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lightblue" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->