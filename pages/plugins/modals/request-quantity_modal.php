<!-- Data Info Modal -->
<div class="modal fade" id="RequestQtyDetailsSectionModal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Quantity Details</h4>
        <button type="button" class="close" data-dismiss="modal" data-toggle="modal" data-target="#RequestModal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="i_request_quantity_id">
        <input type="hidden" id="i_request_id_2">
        <div class="row">
          <div class="col-sm-12">
            <!-- text input -->
            <div class="form-group">
              <label>Quantity on Kanban : </label>
              <span id="i_request_quantity_max"></span>
            </div>
          </div>
        </div>
        <div class="row" id="i_req_limit_qty_row">
          <div class="col-sm-12">
            <!-- text input -->
            <div class="form-group">
              <label>Remaining Quantity : </label>
              <span id="i_request_limit_quantity"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <!-- text input -->
            <div class="form-group">
              <label>Quantity</label><label style="color: red;">*</label>
              <input type="number" class="form-control" id="i_request_quantity" min="1" required>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lightblue" data-dismiss="modal" data-toggle="modal" data-target="#RequestModal">Close</button>
        <button type="button" class="btn bg-lightblue" id="btnSaveRequestQty" onclick="update_request_quantity()">Save</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->