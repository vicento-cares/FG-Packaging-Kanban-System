<!-- Logout Modal -->
<div class="modal fade" id="LogoutModal" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header bg-lightblue">
        <h4 class="modal-title" id="LogoutModalTitle">Logout</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="logoutClose">
          <span class="text-white" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="LogoutModalBody">
        <center>Confirm Logout?</center>
      </div>
      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-danger btn-block" onclick="logout('../../process/auth/sign_out.php')" id="logout">Logout</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->