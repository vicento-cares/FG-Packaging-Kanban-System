<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-lightblue elevation-4">
  <?php include 'brand_logo.php';?>

  <!-- Sidebar -->
  <div class="sidebar">
    <?php include 'user_panel.php';?>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item menu-close">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>
              Account Management
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="admin-accounts.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Admin</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="requestor-accounts.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Requestors</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-header">Inventory Management</li>
        <li class="nav-item">
          <a href="fg-pkg-inventory.php" class="nav-link active">
            <i class="nav-icon fas fa-boxes"></i>
            <p>
              FG Packaging Inventory
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="fg-pkg-inventory-history.php" class="nav-link">
            <i class="nav-icon fas fa-history"></i>
            <p>
              Inventory History
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="packaging-materials.php" class="nav-link">
            <i class="nav-icon fas fa-dolly-flatbed"></i>
            <p>
              Packaging Materials
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="suppliers.php" class="nav-link">
            <i class="nav-icon fas fa-truck-moving"></i>
            <p>
              Suppliers
            </p>
          </a>
        </li>
        <li class="nav-item" style="display: none;">
          <a href="storage-area.php" class="nav-link">
            <i class="nav-icon fas fa-warehouse"></i>
            <p>
              Storage Area
            </p>
          </a>
        </li>
        <li class="nav-header">Kanban Masterlist</li>
        <li class="nav-item">
          <a href="kanban-registration.php" class="nav-link">
            <i class="nav-icon fas fa-qrcode"></i>
            <p>
              Kanban Registration
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="kanban-printing.php" class="nav-link">
            <i class="nav-icon fas fa-print"></i>
            <p>
              Kanban Printing
            </p>
          </a>
        </li>
        <li class="nav-header">Request Management</li>
        <li class="nav-item">
          <a href="kanban-history.php" class="nav-link">
            <i class="nav-icon fas fa-history"></i>
            <p>
              Kanban History
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="requested-packaging-materials.php" class="nav-link">
            <i class="nav-icon fas fa-archive"></i>
            <p>
              Requested Packaging Materials
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="request-search.php" class="nav-link">
            <i class="nav-icon fas fa-search"></i>
            <p>
              Request Search
            </p>
          </a>
        </li>
        <li class="nav-header">Miscellaneous</li>
        <li class="nav-item">
          <a href="section.php" class="nav-link">
            <i class="nav-icon fas fa-map-marker-alt"></i>
            <p>
              Section
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="route-number.php" class="nav-link">
            <i class="nav-icon fas fa-route"></i>
            <p>
              Route Number
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="truck-number.php" class="nav-link">
            <i class="nav-icon fas fa-truck"></i>
            <p>
              Truck Number
            </p>
          </a>
        </li>
        <?php include 'logout.php';?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>