<!-- Data Info Modal -->
<div class="modal fade" id="AddKanbanModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Add New Kanban</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="i_id">
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Item Name</label><label style="color: red;">*</label>
                <select class="form-control" id="i_item_name" style="width: 100%;" onchange="get_item_details('insert')" required>
                  <option disabled selected value="">Select Item Name</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Dimension</label>
                <input type="text" class="form-control" id="i_dimension" maxlength="100" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Size</label>
                <input type="text" class="form-control" id="i_size" maxlength="8" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Color</label>
                <input type="text" class="form-control" id="i_color" maxlength="24" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Quantity</label><label style="color: red;">*</label>
                <input type="number" class="form-control" id="i_quantity" min="1" required>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Storage Area</label><label style="color: red;">*</label>
                <select class="form-control" id="i_storage_area" style="width: 100%;" required>
                  <option disabled selected value="">Select Area</option>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Section</label><label style="color: red;">*</label>
                <select class="form-control" id="i_section" style="width: 100%;" disabled>
                  <option disabled selected value="">Select Section</option>
                </select>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Line No.</label><label style="color: red;">*</label>
                <input list="i_lines" class="form-control" id="i_line_no" maxlength="255" onchange="get_route_details('insert')" required>
                <datalist id="i_lines"></datalist>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Request Limit</label><label style="color: red;">*</label>
                <input type="number" class="form-control" id="i_req_limit" min="1" required>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lightblue" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="save_data()">Add Kanban</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->