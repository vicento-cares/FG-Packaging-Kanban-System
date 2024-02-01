<!-- Data Info Modal -->
<div class="modal fade" id="KanbanInfoModal">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Kanban Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="u_id">
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Item Name</label><label style="color: red;">*</label>
                <select class="form-control" id="u_item_name" style="width: 100%;" onchange="get_item_details('update')" required>
                  <option disabled selected value="">Select Item Name</option>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Item No</label>
                <input type="text" class="form-control" id="u_item_no" maxlength="10" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Batch No.</label>
                <input type="text" class="form-control" id="u_batch_no" maxlength="255" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Dimension</label>
                <input type="text" class="form-control" id="u_dimension" maxlength="100" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Size</label>
                <input type="text" class="form-control" id="u_size" maxlength="8" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Color</label>
                <input type="text" class="form-control" id="u_color" maxlength="24" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Quantity</label><label style="color: red;">*</label>
                <input type="number" class="form-control" id="u_quantity" min="1" required>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Storage Area</label><label style="color: red;">*</label>
                <select class="form-control" id="u_storage_area" style="width: 100%;" required>
                  <option disabled selected value="">Select Area</option>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Section</label><label style="color: red;">*</label>
                <select class="form-control" id="u_section" style="width: 100%;" disabled>
                  <option disabled selected value="">Select Section</option>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Line No.</label><label style="color: red;">*</label>
                <input list="u_lines" class="form-control" id="u_line_no" maxlength="255" onchange="get_route_details('update')" required>
                <datalist id="u_lines"></datalist>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Latest Kanban No.</label>
                <input type="number" class="form-control" id="u_kanban_no" min="1" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Request Limit</label><label style="color: red;">*</label>
                <input type="number" class="form-control" id="u_req_limit" min="1" required>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Request Limit Qty Left</label>
                <input type="number" class="form-control" id="u_req_limit_qty" min="1" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Request Limit Start Time</label><label style="color: red;">*</label>
                <input type="time" class="form-control" id="u_req_limit_time">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lightblue" data-dismiss="modal" onclick="print_single_kanban()">Print Kanban</button>
        <button type="button" class="btn btn-success" onclick="update_data()">Update Kanban</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteDataModal">Delete Kanban</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->