<!-- Data Info Modal -->
<div class="modal fade" id="AreaInfoModal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Storage Area Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="u_id">
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Storage Area</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_storage_area" maxlength="12" required>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="update_data()">Update Area</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteDataModal">Delete Area</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->