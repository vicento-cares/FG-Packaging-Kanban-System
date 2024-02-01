<!-- Data Info Modal -->
<div class="modal fade" id="AddSectionModal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Add New Section</h4>
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
                <label>Section</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="i_section" maxlength="255" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>IP</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="i_ip" maxlength="45" required>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lightblue" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-success" onclick="save_data()">Add Section</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->