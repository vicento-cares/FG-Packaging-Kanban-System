<!-- Data Info Modal -->
<div class="modal fade" id="FgPkgInvTransferModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">FG Packaging Inventory Transfer</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-sm-8">
              <label>Item Name</label><label style="color: red;">*</label>
              <select class="form-control" id="so_item_name" style="width: 100%;" required>
                <option disabled selected value="">Select Item Name</option>
              </select>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Quantity</label><label style="color: red;">*</label>
                <input type="number" class="form-control" id="so_quantity" min="1" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>From Storage Area</label><label style="color: red;">*</label>
                <select class="form-control" id="so_storage_area" style="width: 100%;" required>
                  <option disabled selected value="">Select Area</option>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group" id="so_to_storage_area_input">
                <label>To Storage Area</label><label style="color: red;">*</label>
                <select class="form-control" id="so_to_storage_area" style="width: 100%;" required>
                  <option disabled selected value="">Select Area</option>
                </select>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lightblue" onclick="transfer()">Transfer</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->