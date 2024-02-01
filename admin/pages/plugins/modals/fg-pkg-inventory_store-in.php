<!-- Data Info Modal -->
<div class="modal fade" id="FgPkgInvStoreInModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">FG Packaging Inventory Store In</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-sm-8">
              <label>Item Name</label><label style="color: red;">*</label>
              <select class="form-control" id="si_item_name" style="width: 100%;" required>
                <option disabled selected value="">Select Item Name</option>
              </select>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Supplier Name</label><label style="color: red;">*</label>
                <select class="form-control" id="si_supplier_name" style="width: 100%;" required>
                  <option disabled selected value="">Select Supplier</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Invoice No.</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="si_invoice_no" maxlength="255" required>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>PO No.</label>
                <input type="text" class="form-control" id="si_po_no" maxlength="255">
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>DR No.</label><label style="color: red;">*</label>
                <input type="text" class="form-control" id="si_dr_no" maxlength="255" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Quantity</label><label style="color: red;">*</label>
                <input type="number" class="form-control" id="si_quantity" min="1" required>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Storage Area</label><label style="color: red;">*</label>
                <select class="form-control" id="si_storage_area" style="width: 100%;" required>
                  <option disabled selected value="">Select Area</option>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Delivery Date & Time</label>
                <input type="datetime-local" class="form-control" id="si_delivery_date_time">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-4">
              <!-- text input -->
              <div class="form-group">
                <label>Reason</label>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="Urgent" id="si_reason">
                  <label class="form-check-label" for="si_reason">
                    Urgent
                  </label>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lightblue" onclick="store_in()">Store In</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->