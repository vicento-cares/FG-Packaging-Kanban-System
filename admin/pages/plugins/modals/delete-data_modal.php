<!-- Delete Data Modal -->
<div class="modal fade" id="deleteDataModal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title">Delete</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-sm-12">
              <p>Are you sure you want to delete this Record?</p>
              <p class="text-warning"><small>This action cannot be undone.</small></p>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn bg-lightblue" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" onclick="delete_data()">Delete</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->