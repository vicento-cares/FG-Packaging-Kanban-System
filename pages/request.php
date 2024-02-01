<?php
include('plugins/request_header.php');
include('plugins/css/request_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar/request_navbar.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="row mb-2 ml-1 mr-1">
        <div class="col-sm-6">
          <h1 class="m-0"> Request Packaging Materials</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="request.php">FG Packaging</a></li>
            <li class="breadcrumb-item"><a href="request.php">Requestor</a></li>
            <li class="breadcrumb-item active">Request</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="row mb-4 ml-1 mr-1">
        <div class="col-sm-2 offset-sm-10">
          <button type="button" class="btn bg-lightblue btn-block" data-toggle="modal" data-target="#RequestModal"><i class="fas fa-plus-circle"></i> Request Packaging Materials</button>
        </div>
      </div>
      <div class="row ml-1 mr-1">
        <div class="col-sm-12">
          <div class="card card-lightblue card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-archive"></i> Pending Requested Packaging Materials</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                  <i class="fas fa-expand"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row mb-2">
                <div class="col-sm-2">
                  <span id="counter_view_search"></span>
                </div>
                <div class="col-sm-2">
                  <span id="counter_view_search_req"></span>
                </div>
              </div>
              <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                <table id="pendingRequestTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                  <thead style="text-align: center;">
                    <tr>
                      <th>No.</th>
                      <th>Request ID</th>
                      <th>Request Date & Time</th>
                      <th>No. of Kanban</th>
                      <th>Requested By</th>
                    </tr>
                  </thead>
                  <tbody id="pendingRequestData" style="text-align: center;">
                    <tr>
                      <td colspan="5" style="text-align:center;">
                        <div class="spinner-border text-dark" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row ml-1 mr-1">
        <div class="col-sm-12">
          <div class="card card-lightblue card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-spinner"></i> Ongoing Requested Packaging Materials</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                  <i class="fas fa-expand"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row mb-2">
                <div class="col-sm-2">
                  <span id="counter_view_search2"></span>
                </div>
                <div class="col-sm-2">
                  <span id="counter_view_search_req2"></span>
                </div>
              </div>
              <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                <table id="ongoingRequestTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                  <thead style="text-align: center;">
                    <tr>
                      <th>No.</th>
                      <th>Request ID</th>
                      <th>Request Date & Time</th>
                      <th>No. of Kanban</th>
                      <th>Requested By</th>
                    </tr>
                  </thead>
                  <tbody id="ongoingRequestData" style="text-align: center;">
                    <tr>
                      <td colspan="5" style="text-align:center;">
                        <div class="spinner-border text-dark" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row ml-1 mr-1">
        <div class="col-sm-12">
          <div class="card card-lightblue card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-history"></i> Stored Out Requested Packaging Materials</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                  <i class="fas fa-expand"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                <table id="soRequestTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                  <thead style="text-align: center;">
                    <tr>
                      <th>No.</th>
                      <th>Request ID</th>
                      <th>Request Date & Time</th>
                      <th>No. of Kanban</th>
                      <th>Requested By</th>
                    </tr>
                  </thead>
                  <tbody id="soRequestData" style="text-align: center;">
                    <tr>
                      <td colspan="5" style="text-align:center;">
                        <div class="spinner-border text-dark" role="status">
                          <span class="sr-only">Loading...</span>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include('plugins/footer.php');
include('plugins/modals/logout_modal.php');
include('plugins/modals/pending-request_details_section.php');
include('plugins/modals/ongoing-request_details_section.php');
include('plugins/modals/so-request_details_section.php');
include('plugins/modals/request_modal.php');
include('plugins/modals/request-quantity_modal.php');
include('plugins/modals/requestor-remarks_modal.php');
include('plugins/js/request_script.php');
?>
