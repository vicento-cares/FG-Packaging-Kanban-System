<?php
include('plugins/header.php');
include('plugins/css/request-search_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/request-search_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> Request Search</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="requested-packaging-materials.php">FG Packaging</a></li>
              <li class="breadcrumb-item"><a href="request-search.php">Request Management</a></li>
              <li class="breadcrumb-item active">Request Search</li>
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
                <h3 class="card-title"><i class="fas fa-archive"></i> Request Table</h3>
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
                    <label>Request Date From</label>
                    <input type="datetime-local" class="form-control" id="i_request_date_from">
                  </div>
                  <div class="col-sm-3">
                    <label>Request Date To</label>
                    <input type="datetime-local" class="form-control" id="i_request_date_to">
                  </div>
                  <div class="col-sm-2">
                    <label>Section</label>
                    <select class="form-control" id="i_request_section" style="width: 100%;" onchange="get_request_searched(1)">
                      <option selected value="All">All Section</option>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <label>Request Status</label>
                    <select class="form-control" id="i_request_status" style="width: 100%;" onchange="get_request_searched(1)">
                      <option selected value="Pending">Pending</option>
                      <option value="Ongoing">Ongoing</option>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <label>Line No.</label>
                    <input list="i_request_lines" class="form-control" id="i_request_line_no" maxlength="255">
                    <datalist id="i_request_lines"></datalist>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-3">
                    <label>Item No.</label>
                    <input type="text" class="form-control" id="i_request_item_no" maxlength="10">
                  </div>
                  <div class="col-sm-5">
                    <label>Item Name</label>
                    <input list="i_request_items" class="form-control" id="i_request_item_name" maxlength="100">
                    <datalist id="i_request_items"></datalist>
                  </div>
                  <div class="col-sm-2">
                    <label>Search</label>
                    <button type="button" class="btn bg-lightblue btn-block" onclick="get_request_searched(1)"><i class="fas fa-search"></i> Search Request</button>
                  </div>
                  <div class="col-sm-2">
                    <label>Export</label>
                    <button type="button" class="btn bg-lightblue btn-block" id="btnExportRequestSearchCsv" onclick="export_request_searched()" disabled><i class="fas fa-file-download"></i> Export CSV</button>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="requestSearchTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>Request ID</th>
                        <th>Line No.</th>
                        <th>Storage Area</th>
                        <th>Item No.</th>
                        <th>Item Name</th>
                        <th>Kbn No.</th>
                        <th>Qty</th>
                        <th>Section</th>
                        <th>Scan Date & Time</th>
                        <th>Request Date & Time</th>
                      </tr>
                    </thead>
                    <tbody id="requestSearchData" style="text-align: center;"></tbody>
                  </table>
                </div>
                <div class="d-flex justify-content-sm-end">
                  <input type="hidden" id="loader_count">
                  <label id="counter_view"></label>
                </div>
                <div class="d-flex justify-content-sm-center">
                  <button type="button" class="btn bg-lightblue" id="search_more_data" style="display:none;" onclick="get_request_searched(2)">Load more</button>
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
include('plugins/js/request-search_script.php');
?>
