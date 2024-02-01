<!-- Data Info Modal -->
<div class="modal fade" id="RequestModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Request Packaging Materials</h4>
        <button type="button" class="close" id="btnCloseScannedKanban" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="i_id">
        <input type="hidden" id="verified_id_no">
        <input type="hidden" id="verified_requestor_name">
        <input type="hidden" id="verified_requestor">
        <input type="hidden" id="i_request_id">
        <div class="row">
          <div class="col-sm-12">
            <!-- text input -->
            <div class="form-group">
              <label id="scan_kanban">Scan Kanban</label>
              <input type="text" class="form-control" id="i_kanban" maxlength="255" required autofocus>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <!-- text input -->
            <div class="form-group">
              <label>Current Request ID : </label>
              <span id="current_request_id_shown"></span>
            </div>
          </div>
          <div class="col-sm-6">
            <!-- text input -->
            <div class="form-group">
              <label>Current No. of Kanban : </label>
              <span id="current_total_kanban"></span>
            </div>
          </div>
        </div>
        <div id="accordion">
          <div class="card">
            <div class="card-header">
              <h4 class="card-title w-100">
                <a class="d-block w-100 text-dark" data-toggle="collapse" href="#collapseOne">
                  Request Legend
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="collapse" data-parent="#accordion">
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-3 col-lg-3 p-1 table-primary"><center>Has Remarks</center></div>
                  <div class="col-sm-3 col-lg-3 p-1 table-danger"><center>Qty Change Needed</center></div>
                  <div class="col-sm-3 col-lg-3 p-1 table-warning"><center>Qty Changed</center></div>
                  <div class="col-sm-3 col-lg-3 p-1 table-success"><center>Qty Changed With Remarks</center></div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="table-responsive" style="max-height: 175px; overflow: auto; display:inline-block;">
          <table id="scannedKanbanTable" class="table table-sm table-head-fixed text-nowrap table-hover">
            <thead style="text-align: center;">
              <tr>
                <th>No.</th>
                <th>Line No.</th>
                <th>Item No.</th>
                <th>Item Name</th>
                <th>Qty</th>
                <th>Remarks</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="scannedKanbanData" style="text-align: center;"></tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lightblue" id="btnRequestScannedKanban" onclick="update_scanned()" disabled>Request</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->