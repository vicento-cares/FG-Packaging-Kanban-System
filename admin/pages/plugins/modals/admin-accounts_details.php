<!-- Data Info Modal -->
<div class="modal fade" id="AccountInfoModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Admin Account Details</h4>
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
                <label>Username</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_username" maxlength="255" required>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Name</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_name" maxlength="255" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Password</label><label style="color: red;">*</label>
                <input type="password" class="form-control" id="u_password" maxlength="255" required>
              </div>
            </div>
            <div class="col-sm-6">
              <!-- text input -->
              <div class="form-group">
                <label>Role</label><label style="color: red;">*</label>
                <select class="form-control" id="u_role" style="width: 100%;" required>
                  <option disabled selected value="">Select Role</option>
                  <option value="Admin">Admin</option>
                  <option value="FG">FG</option>
                </select>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lightblue" onclick="update_username()">Change Username</button>
        <button type="button" class="btn bg-lightblue" onclick="update_password()">Change Password</button>
        <button type="button" class="btn btn-success" onclick="update_data()">Update Account</button>
        <button type="button" class="btn btn-danger" id="btnDeleteAdminAccount" data-dismiss="modal" data-toggle="modal" data-target="#deleteDataModal">Delete Account</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->