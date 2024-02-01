<!-- Data Info Modal -->
<div class="modal fade" id="AddRouteModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Add New Route</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="i_id">
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Route Number</label><label style="color: red;">*</label>
                <input type="number" class="form-control" id="i_route_no" min="1" max="5" required>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Section</label><label style="color: red;">*</label>
                <select class="form-control" id="i_section" style="width: 100%;" required>
                  <option disabled selected value="">Select Section</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Car Model</label><label style="color: red;">*</label>
                <select class="form-control" id="i_car_model" style="width: 100%;" required>
                  <option disabled selected value="">Select Car Model</option>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Line No.</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="i_line_no" maxlength="255" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Factory Area</label><label style="color: red;">*</label>
                <select class="form-control" id="i_factory_area" style="width: 100%;" required>
                  <option disabled selected value="">Select Factory Area</option>
                </select>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lightblue" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="save_data()">Add Route</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->