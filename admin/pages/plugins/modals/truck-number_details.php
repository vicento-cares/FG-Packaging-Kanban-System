<!-- Data Info Modal -->
<div class="modal fade" id="TruckInfoModal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Truck Number Details</h4>
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
                <label>Truck Number</label>
                <input type="number" class="form-control" id="u_truck_no" min="1" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Time From</label>
                <input type="text" class="form-control" id="u_time_from" maxlength="255" disabled>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <!-- text input -->
              <div class="form-group">
                <label>Time To</label>
                <input type="text" class="form-control" id="u_time_to" maxlength="255" disabled>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lightblue" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success" onclick="update_data()" style="display: none;">Update Truck</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#deleteDataModal" style="display: none;">Delete Truck</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->