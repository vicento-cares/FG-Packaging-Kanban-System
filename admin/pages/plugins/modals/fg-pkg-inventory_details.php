<!-- Data Info Modal -->
<div class="modal fade" id="FgPkgInvInfoModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">FG Packaging Inventory Details</h4>
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
                <label>Item Name</label>
                <input type="text" class="form-control" id="u_item_name" maxlength="100" disabled>
              </div>
            </div>
          </div>
          <div class="row">
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
                <label>Quantity</label>
                <input type="number" class="form-control" id="u_quantity" min="1" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Storage Area</label>
                <input type="text" class="form-control" id="u_storage_area" disabled>
              </div>
            </div>
            <div class="col-sm-3">
              <!-- text input -->
              <div class="form-group">
                <label>Safety Stock</label>
                <input type="number" class="form-control" id="u_safety_stock" min="1">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lightblue" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="update_safety_stock()">Update Safety Stock</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->