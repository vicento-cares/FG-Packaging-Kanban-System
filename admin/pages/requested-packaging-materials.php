<?php
include('plugins/header.php');
include('plugins/css/requested-packaging-materials_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/requested-packaging-materials_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> Requested Packaging Materials</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="requested-packaging-materials.php">FG Packaging</a></li>
              <li class="breadcrumb-item"><a href="requested-packaging-materials.php">Request Management</a></li>
              <li class="breadcrumb-item active">Requested Packaging Materials</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
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
                  <div class="col-sm-3">
                    <select class="form-control" id="pending_section" style="width: 100%;" onchange="display_pending_on_fg()">
                      <option selected value="All">All Sections</option>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <span id="counter_view_search"></span>
                  </div>
                  <div class="col-sm-2">
                    <span id="counter_view_search_req"></span>
                  </div>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="pendingRequestedTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>Request ID</th>
                        <th>Section</th>
                        <th>Request Date & Time</th>
                        <th>No. of Kanban</th>
                        <th>Requested By</th>
                      </tr>
                    </thead>
                    <tbody id="pendingRequestedData" style="text-align: center;">
                      <tr>
                        <td colspan="6" style="text-align:center;">
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
        <div class="row">
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
                  <div class="col-sm-3">
                    <select class="form-control" id="ongoing_section" style="width: 100%;" onchange="display_ongoing_on_fg()">
                      <option selected value="All">All Sections</option>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <span id="counter_view_search2"></span>
                  </div>
                  <div class="col-sm-2">
                    <span id="counter_view_search_req2"></span>
                  </div>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="ongoingRequestedTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>Request ID</th>
                        <th>Section</th>
                        <th>Request Date & Time</th>
                        <th>No. of Kanban</th>
                        <th>Requested By</th>
                      </tr>
                    </thead>
                    <tbody id="ongoingRequestedData" style="text-align: center;">
                      <tr>
                        <td colspan="6" style="text-align:center;">
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
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include('plugins/footer.php');
include('plugins/modals/logout_modal.php');
include('plugins/modals/confirm-request-status.php');
include('plugins/modals/pending-request_details_fg.php');
include('plugins/modals/ongoing-request_details_fg.php');
include('plugins/modals/requestor-remarks_view.php');
include('plugins/modals/kanban-printing_modal.php');
include('plugins/js/requested-packaging-materials_script.php');
?>
