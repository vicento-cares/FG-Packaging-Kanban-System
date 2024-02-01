<?php
include('plugins/header.php');
include('plugins/css/fg-pkg-inventory_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/fg-pkg-inventory_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>FG Packaging Inventory</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="requested-packaging-materials.php">FG Packaging</a></li>
              <li class="breadcrumb-item"><a href="fg-pkg-inventory.php">Inventory Management</a></li>
              <li class="breadcrumb-item active">FG Packaging Inventory</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mb-4">
          <div class="col-sm-2 offset-sm-10">
            <button type="button" class="btn bg-lightblue btn-block" data-toggle="modal" data-target="#FgPkgInvStoreInModal"><i class="fas fa-plus-circle"></i> Store In</button>
          </div>
          <div class="col-sm-2" style="display: none;">
            <button type="button" class="btn bg-lightblue btn-block" data-toggle="modal" data-target="#FgPkgInvTransferModal"><i class="fas fa-dolly-flatbed"></i> Transfer</button>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="card card-lightblue card-outline collapsed-card">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-lightbulb"></i> FG Packaging Inventory Table Legend</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-sm-4 col-lg-3 p-3 table-danger">Out of Stock</div>
                  <div class="col-sm-4 col-lg-3 p-3 table-warning">Will Run Out of Stock</div>
                  <div class="col-sm-4 col-lg-3 p-3">Available</div>
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
                <h3 class="card-title"><i class="fas fa-boxes"></i> FG Packaging Inventory Table</h3>
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
                    <label>Storage Area</label>
                    <select class="form-control" id="inv_storage_area" style="width: 100%;" onchange="get_inventory(1)">
                    </select>
                  </div>
                  <div class="col-sm-3">
                    <label>Item No.</label>
                    <input type="text" class="form-control" id="inv_item_no" maxlength="10">
                  </div>
                  <div class="col-sm-6">
                    <label>Item Name</label>
                    <input list="inv_items" class="form-control" id="inv_item_name" maxlength="100">
                    <datalist id="inv_items"></datalist>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-sm-2 offset-sm-6">
                    <button type="button" class="btn bg-lightblue btn-block" onclick="get_inventory(1)"><i class="fas fa-search"></i> Search</button>
                  </div>
                  <div class="col-sm-2">
                    <button type="button" class="btn bg-lightblue btn-block" id="btnRefreshFgPkgInv" onclick="get_inventory(3)"><i class="fas fa-sync-alt"></i> Refresh Table</button>
                  </div>
                  <div class="col-sm-2">
                    <button type="button" class="btn bg-lightblue btn-block" id="btnExportFgPkgInvCsv" onclick="export_fg_pkg_inv()" disabled><i class="fas fa-file-download"></i> Export CSV</button>
                  </div>
                </div>
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="fgPkgInvTable" class="table table-sm table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>Item No.</th>
                        <th>Item Name</th>
                        <th>Qty</th>
                        <th>Safety Stock</th>
                        <th>Storage Area</th>
                      </tr>
                    </thead>
                    <tbody id="fgPkgInvData" style="text-align: center;">
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
                <div class="d-flex justify-content-sm-end">
                  <input type="hidden" id="loader_count">
                  <label id="counter_view"></label>
                </div>
                <div class="d-flex justify-content-sm-center">
                  <button type="button" class="btn bg-lightblue" id="search_more_data" style="display:none;" onclick="get_inventory(2)">Load more</button>
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
include('plugins/modals/fg-pkg-inventory_store-in.php');
include('plugins/modals/fg-pkg-inventory_transfer.php');
include('plugins/modals/fg-pkg-inventory_details.php');
include('plugins/js/fg-pkg-inventory_script.php');
?>
