<!-- Data Info Modal -->
<div class="modal fade" id="PackagingMaterialsInfoModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Packaging Material Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="u_id">
          <div class="row">
            <div class="col-sm-8">
              <!-- text input -->
              <div class="form-group">
                <label>Item Name</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_item_name" maxlength="100" required>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Item No.</label>
                <input type="text" class="form-control" id="u_item_no" maxlength="10" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Dimension</label>
                <input type="text" class="form-control" id="u_dimension" maxlength="100">
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Size</label>
                <input type="text" class="form-control" id="u_size" maxlength="8">
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Color</label>
                <input type="text" class="form-control" id="u_color" maxlength="24">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Pcs / Bundle</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="u_pcs_bundle" maxlength="12" required>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Req Quantity</label><label style="color: red;">*</label>
                <select class="form-control" id="u_req_quantity" style="width: 100%;" required>
                  <option disabled selected value="">Select Req Qty</option>
                  <option value="per Pcs">per Pcs</option>
                  <option value="per bag">per bag</option>
                  <option value="per kilo">per kilo</option>
                  <option value="per box">per box</option>
                  <option value="per pad">per Pad</option>
                </select>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-success" onclick="update_data()">Update Item</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteDataModal">Delete Item</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->