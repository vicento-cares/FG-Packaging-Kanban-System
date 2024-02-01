<?php
include('plugins/header.php');
include('plugins/css/kanban-printing_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/kanban-printing_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Kanban Printing</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="requested-packaging-materials.php">FG Packaging</a></li>
              <li class="breadcrumb-item"><a href="kanban-printing.php">Kanban Masterlist</a></li>
              <li class="breadcrumb-item active">Kanban Printing</li>
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
                <h3 class="card-title"><i class="fas fa-qrcode"></i> Registered Kanban Table</h3>
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
                    <select class="form-control" id="i_print_category" style="width: 100%;" onchange="printing_category()">
                      <option disabled selected value="">Select Category</option>
                      <option value="By Batch">By Batch</option>
                      <option value="By Line No.">By Line No.</option>
                      <option value="By Latest Upload">By Latest Upload</option>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <select class="form-control" id="i_section_batch" style="width: 100%; display:none;" onchange="load_kanban(1)"></select>
                    <select class="form-control" id="i_section_line" style="width: 100%; display:none;" onchange="load_kanban(1)"></select>
                    <select class="form-control" id="i_section" style="width: 100%; display:none;" onchange="load_kanban(1)"></select>
                  </div>
                  <div class="col-sm-2">
                    <select class="form-control" id="i_batch" style="width: 100%; display:none;" onchange="load_kanban(1)"></select>
                    <select class="form-control" id="i_line" style="width: 100%; display:none;" onchange="load_kanban(1)"></select>
                  </div>
                  <div class="col-sm-3">
                    <button type="button" class="btn bg-lightblue btn-block" id="btnPrintSelKbnByCat" onclick="print_selected_kanban_by_category()" disabled><i class="fas fa-print"></i> Print Selected Kanban</button>
                  </div>
                  <div class="col-sm-3">
                    <button type="button" class="btn bg-lightblue btn-block" id="btnPrintKbnByCat" onclick="print_kanban_by_category()" disabled><i class="fas fa-print"></i> Print All Kanban</button>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="kanbanRegTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th><input type="checkbox" name="check_all_kanban" id="check_all_kanban" onclick="select_all_kanban_func()"></th>
                        <th>No.</th>
                        <th>Line No.</th>
                        <th>Area</th>
                        <th>Item Name</th>
                        <th>Qty</th>
                        <th>Section</th>
                        <th>Date Updated</th>
                      </tr>
                    </thead>
                    <tbody id="kanbanRegData" style="text-align: center;"></tbody>
                  </table>
                </div>
                <div class="d-flex justify-content-sm-end">
                  <input type="hidden" id="loader_count">
                  <label id="counter_view"></label>
                </div>
                <div class="d-flex justify-content-sm-center">
                  <button type="button" class="btn bg-lightblue" id="search_more_data" style="display:none;" onclick="load_kanban(2)">Load more</button>
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
            <div class="card card-lightblue card-outline collapsed-card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-history"></i> Store Out Request History Table</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
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
                    <input type="datetime-local" class="form-control" id="i_store_out_date_from">
                  </div>
                  <div class="col-sm-3">
                    <label>Store Out Date To</label>
                    <input type="datetime-local" class="form-control" id="i_store_out_date_to">
                  </div>
                  <div class="col-sm-2">
                    <label>Section</label>
                    <select class="form-control" id="store_out_history_section" style="width: 100%;" onchange="get_store_out_request_history_printing(1)">
                      <option selected value="All">All Section</option>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <label>Line No.</label>
                    <input list="i_store_out_lines" class="form-control" id="i_store_out_line_no" maxlength="255">
                    <datalist id="i_store_out_lines"></datalist>
                  </div>
                  <div class="col-sm-2">
                    <label>Item No.</label>
                    <input type="text" class="form-control" id="i_store_out_item_no" maxlength="10">
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-3">
                    <label>Item Name</label>
                    <input list="i_store_out_items" class="form-control" id="i_store_out_item_name" maxlength="100">
                    <datalist id="i_store_out_items"></datalist>
                  </div>
                  <div class="col-sm-3">
                    <label>Search</label>
                    <button type="button" class="btn bg-lightblue btn-block" onclick="get_store_out_request_history_printing(1)"><i class="fas fa-search"></i> Search History</button>
                  </div>
                  <div class="col-sm-3">
                    <label>Print</label>
                    <button type="button" class="btn bg-lightblue btn-block" id="btnPrintSelStoreOutRequestKbnHistory" onclick="print_selected_store_out_request_history()" disabled><i class="fas fa-print"></i> Print Selected Kanban</button>
                  </div>
                  <div class="col-sm-3">
                    <label>Print</label>
                    <button type="button" class="btn bg-lightblue btn-block" id="btnPrintStoreOutRequestKbnHistory" onclick="print_store_out_request_history()" disabled><i class="fas fa-print"></i> Print All Kanban</button>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search2"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="storeOutRequestHistoryTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th><input type="checkbox" name="check_all_kanban_history" id="check_all_kanban_history" onclick="select_all_kanban_history_func()"></th>
                        <th>No.</th>
                        <th>Request ID</th>
                        <th>Line No.</th>
                        <th>Area</th>
                        <th>Item No.</th>
                        <th>Item Name</th>
                        <th>Kbn No.</th>
                        <th>Qty</th>
                        <th>Section</th>
                        <th>Route No.</th>
                        <th>Truck No.</th>
                        <th>Scan Date & Time</th>
                        <th>Request Date & Time</th>
                        <th>Store Out Date & Time</th>
                      </tr>
                    </thead>
                    <tbody id="storeOutRequestHistoryData" style="text-align: center;"></tbody>
                  </table>
                </div>
                <div class="d-flex justify-content-sm-end">
                  <input type="hidden" id="loader_count2">
                  <label id="counter_view2"></label>
                </div>
                <div class="d-flex justify-content-sm-center">
                  <button type="button" class="btn bg-lightblue" id="search_more_data2" style="display:none;" onclick="get_store_out_request_history_printing(2)">Load more</button>
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
include('plugins/modals/kanban-printing_modal.php');
include('plugins/js/kanban-printing_script.php');
?>
