<?php
include('plugins/header.php');
include('plugins/css/fg-pkg-inventory-history_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/fg-pkg-inventory-history_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Inventory History</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="requested-packaging-materials.php">FG Packaging</a></li>
              <li class="breadcrumb-item"><a href="fg-pkg-inventory-history.php">Inventory Management</a></li>
              <li class="breadcrumb-item active">Inventory History</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-12">
            <div class="card card-lightblue card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-boxes"></i> <i class="fas fa-plus-circle"></i> Store In History Table</h3>
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
                    <label>Store In Date From</label>
                    <input type="datetime-local" class="form-control" id="store_in_date_from">
                  </div>
                  <div class="col-sm-2">
                    <label>Store In Date To</label>
                    <input type="datetime-local" class="form-control" id="store_in_date_to">
                  </div>
                  <div class="col-sm-2">
                    <label>Storage Area</label>
                    <select class="form-control" id="si_storage_area" style="width: 100%;" onchange="get_si_inventory_history(1)">
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <label>Item No.</label>
                    <input type="text" class="form-control" id="si_item_no" maxlength="10">
                  </div>
                  <div class="col-sm-4">
                    <label>Item Name</label>
                    <input list="si_items" class="form-control" id="si_item_name" maxlength="100">
                    <datalist id="si_items"></datalist>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-2 offset-sm-8">
                    <button type="button" class="btn bg-lightblue btn-block" onclick="get_si_inventory_history(1)"><i class="fas fa-search"></i> Search</button>
                  </div>
                  <div class="col-sm-2">
                    <button type="button" class="btn bg-lightblue btn-block" id="btnExportSiInvHistoryCsv" onclick="export_si_inventory_history()" disabled><i class="fas fa-file-download"></i> Export CSV</button>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="siInvHistoryTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>Store In Date & Time</th>
                        <th>Item No.</th>
                        <th>Item Name</th>
                        <th>Inventory Received</th>
                        <th>RIR ID</th>
                        <th>Invoice No.</th>
                        <th>PO No.</th>
                        <th>DR No.</th>
                        <th>Supplier Name</th>
                        <th>Storage Area</th>
                        <th>Reason</th>
                        <th>Delivery Date & Time</th>
                        <th>Inventory On Hand</th>
                        <th>Inventory After</th>
                      </tr>
                    </thead>
                    <tbody id="siInvHistoryData" style="text-align: center;"></tbody>
                  </table>
                </div>
                <div class="d-flex justify-content-sm-end">
                  <input type="hidden" id="loader_count">
                  <label id="counter_view"></label>
                </div>
                <div class="d-flex justify-content-sm-center">
                  <button type="button" class="btn bg-lightblue" id="search_more_data" style="display:none;" onclick="get_si_inventory_history(2)">Load more</button>
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
                <h3 class="card-title"><i class="fas fa-boxes"></i> <i class="fas fa-minus-circle"></i> Store Out History Table</h3>
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
                    <label>Store Out Date From</label>
                    <input type="datetime-local" class="form-control" id="store_out_date_from">
                  </div>
                  <div class="col-sm-3">
                    <label>Store Out Date To</label>
                    <input type="datetime-local" class="form-control" id="store_out_date_to">
                  </div>
                  <div class="col-sm-2">
                    <label>Storage Area</label>
                    <select class="form-control" id="so_storage_area" style="width: 100%;" onchange="get_so_inventory_history(1)">
                    </select>
                  </div>
                  <div class="col-sm-4">
                    <label>Remarks</label>
                    <select class="form-control" id="so_remarks" style="width: 100%;" onchange="get_so_inventory_history(1)">
                      <option selected value="All">All Remarks</option>
                      <option value="Without Remarks">Without Remarks</option>
                      <option value="With Remarks">With Remarks</option>
                    </select>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-3">
                    <label>Item No.</label>
                    <input type="text" class="form-control" id="so_item_no" maxlength="10">
                  </div>
                  <div class="col-sm-5">
                    <label>Item Name</label>
                    <input list="so_items" class="form-control" id="so_item_name" maxlength="100">
                    <datalist id="so_items"></datalist>
                  </div>
                  <div class="col-sm-2">
                    <label>Search</label>
                    <button type="button" class="btn bg-lightblue btn-block" onclick="get_so_inventory_history(1)"><i class="fas fa-search"></i> Search</button>
                  </div>
                  <div class="col-sm-2">
                    <label>Export</label>
                    <button type="button" class="btn bg-lightblue btn-block" id="btnExportSoInvHistoryCsv" onclick="export_so_inventory_history()" disabled><i class="fas fa-file-download"></i> Export CSV</button>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search2"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="soInvHistoryTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>Store Out Date & Time</th>
                        <th>Item No.</th>
                        <th>Item Name</th>
                        <th>Inventory Out</th>
                        <th>Request ID</th>
                        <th>Storage Area</th>
                        <th>Remarks</th>
                        <th>Inventory On Hand</th>
                        <th>Inventory After</th>
                      </tr>
                    </thead>
                    <tbody id="soInvHistoryData" style="text-align: center;"></tbody>
                  </table>
                </div>
                <div class="d-flex justify-content-sm-end">
                  <input type="hidden" id="loader_count2">
                  <label id="counter_view2"></label>
                </div>
                <div class="d-flex justify-content-sm-center">
                  <button type="button" class="btn bg-lightblue" id="search_more_data2" style="display:none;" onclick="get_so_inventory_history(2)">Load more</button>
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
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<?php
include('plugins/footer.php');
include('plugins/modals/logout_modal.php');
include('plugins/modals/store-in-po-no_details.php');
include('plugins/js/fg-pkg-inventory-history_script.php');
?>
