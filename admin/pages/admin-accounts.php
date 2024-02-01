<?php
include('plugins/header.php');
include('plugins/css/admin-accounts_stylesheet.php');
include('plugins/preloader.php');
include('plugins/navbar.php');
include('plugins/sidebar/admin-accounts_bar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Admin Accounts</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="requested-packaging-materials.php">FG Packaging</a></li>
              <li class="breadcrumb-item"><a href="admin-accounts.php">Account Management</a></li>
              <li class="breadcrumb-item active">Admin</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mb-4">
          <div class="col-sm-6">
            <input type="text" class="form-control" id="i_search" placeholder="Search" maxlength="255">
          </div>
          <div class="col-sm-2">
            <button type="button" class="btn bg-lightblue btn-block" onclick="load_data(3)"><i class="fas fa-search"></i> Search Account</button>
          </div>
          <div class="col-sm-2">
            <button type="button" class="btn bg-lightblue btn-block" onclick="load_data(1)"><i class="fas fa-sync-alt"></i> Refresh Table</button>
          </div>
          <div class="col-sm-2">
            <button type="button" class="btn bg-lightblue btn-block" id="btnAddAdminAccount" data-toggle="modal" data-target="#AddAccountModal"><i class="fas fa-plus-circle"></i> Add Account</button>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="card card-lightblue card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="fas fa-users-cog"></i> Admin Accounts Table</h3>
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
                <div class="d-flex justify-content-sm-start">
                  <label id="counter_view_search"></label>
                </div>
                <div class="table-responsive" style="max-height: 400px; overflow: auto; display:inline-block;">
                  <table id="adminAccountTable" class="table table-head-fixed text-nowrap table-hover">
                    <thead style="text-align: center;">
                      <tr>
                        <th>No.</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Date Updated</th>
                      </tr>
                    </thead>
                    <tbody id="adminAccountData" style="text-align: center;">
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
                <div class="d-flex justify-content-sm-end">
                  <input type="hidden" id="loader_count">
                  <label id="counter_view"></label>
                </div>
                <div class="d-flex justify-content-sm-center">
                  <button type="button" class="btn bg-lightblue" id="load_more_data" style="display:none;" onclick="load_data(2)">Load more</button>
                  <button type="button" class="btn bg-lightblue" id="search_more_data" style="display:none;" onclick="load_data(4)">Load more</button>
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
include('plugins/modals/admin-accounts_add.php');
include('plugins/modals/admin-accounts_details.php');
include('plugins/modals/delete-data_modal.php');
include('plugins/js/admin-accounts_script.php');
?>
