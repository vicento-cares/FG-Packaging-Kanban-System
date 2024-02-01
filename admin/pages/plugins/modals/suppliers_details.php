<!-- Data Info Modal -->
<div class="modal fade" id="SuppliersInfoModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Supplier Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="u_id">
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Supplier Name</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_supplier_name" maxlength="255" required>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-success" onclick="update_data()">Update Supplier</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteDataModal">Delete Supplier</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->