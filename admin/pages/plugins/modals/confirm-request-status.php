<!-- Data Info Modal -->
<div class="modal fade" id="ConfirmOngoingRequestModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Confirm Mark As Ongoing</h4>
        <button type="button" class="close" data-dismiss="modal" data-toggle="modal" data-target="#PendingRequestDetailsFgModal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-sm-12">
              <p>Are you sure you want to mark as ongoing all selected requests?</p>
              <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="mark_as_ongoing_request_arr()">Yes</button>
        <button type="button" class="btn bg-lightblue" data-dismiss="modal" data-toggle="modal" data-target="#PendingRequestDetailsFgModal">No</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Data Info Modal -->
<div class="modal fade" id="ConfirmStoreOutRequestModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Confirm Store Out</h4>
        <button type="button" class="close" data-dismiss="modal" data-toggle="modal" data-target="#OngoingRequestDetailsFgModal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-sm-12">
              <p>Are you sure you want to store out all selected requests?</p>
              <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="store_out_requested_arr()">Yes</button>
        <button type="button" class="btn bg-lightblue" data-dismiss="modal" data-toggle="modal" data-target="#OngoingRequestDetailsFgModal">No</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->