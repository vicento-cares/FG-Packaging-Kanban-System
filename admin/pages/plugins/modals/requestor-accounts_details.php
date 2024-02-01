<!-- Data Info Modal -->
<div class="modal fade" id="RAccountInfoModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Requestor Account Details</h4>
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
                <label>ID Number</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_id_no" maxlength="255" required>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Section</label><label style="color: red;">*</label>
                <select class="form-control" id="u_section" style="width: 100%;" disabled>
                  <option disabled selected value="">Select Section</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Name</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_name" maxlength="255" required>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Line No</label><label style="color: red;">*</label>
                <input list="u_lines" class="form-control" id="u_line_no" maxlength="255" onchange="get_route_details('update')" required>
                <datalist id="u_lines"></datalist>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Car Model</label><label style="color: red;">*</label>
                <select class="form-control" id="u_car_model" style="width: 100%;" disabled>
                  <option disabled selected value="">Select Car Model</option>
                </select>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Factory Area</label><label style="color: red;">*</label>
                <select class="form-control" id="u_factory_area" style="width: 100%;" disabled>
                  <option disabled selected value="">Select Factory Area</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Requestor</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_requestor" maxlength="255" required>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lightblue" onclick="update_id_no()">Update ID No.</button>
        <button type="button" class="btn btn-success" onclick="update_data()">Update Account</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteDataModal">Delete Account</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->