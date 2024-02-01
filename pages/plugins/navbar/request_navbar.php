<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-dark bg-lightblue text-light border-bottom-0">
  <a href="request.php" class="navbar-brand ml-2">
    <img src="../dist/img/fg-pkg-logo.png" alt="FG Packaging Logo" class="brand-image elevation-3 bg-light p-1" style="opacity: .8">
    <span class="brand-text font-weight-light text-light"><b><?=htmlspecialchars($_SESSION['section'])?></b> - <b>FG</b> Packaging E-Kanban</span>
  </a>

  <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse order-3" id="navbarCollapse">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a href="request.php" class="nav-link active"><i class="fas fa-archive"></i> Request Packaging Materials</a>
      </li>
      <li class="nav-item">
        <a href="history-section.php" class="nav-link"><i class="fas fa-history"></i> History</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="modal" data-target="#LogoutModal" style="cursor:pointer;"><i class="fas fa-unlock"></i> Logout</a>
      </li>
    </ul>
  </div>

  <!-- Right navbar links -->
  <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#" id="notif_badge">
        <i class="far fa-bell"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-header" id="notif_title">Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="request.php" class="dropdown-item" id="notif_ongoing">
          <i class="fas fa-spinner mr-2"></i> No new ongoing request
          <span class="float-right text-muted text-sm"></span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="request.php" class="dropdown-item" id="notif_store_out">
          <i class="fas fa-history mr-2"></i> No new stored out requests
          <span class="float-right text-muted text-sm"></span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="request.php" class="dropdown-item dropdown-footer">See All Requests</a>
      </div>
    </li>
    <!-- Account Information Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fas fa-user-alt"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <div class="dropdown-item bg-lightblue">
          <!-- Message Start -->
          <div class="media">
            <img src="../dist/img/user.png" alt="User Avatar" class="img-size-50 mr-3 img-circle">
            <div class="media-body">
              <h3 class="dropdown-item-title"><?=htmlspecialchars($_SESSION['requestor_name'])?></h3>
              <p class="text-sm"><?=htmlspecialchars($_SESSION['requestor'])?></p>
              <p class="text-sm">Active Now</p>
            </div>
          </div>
          <!-- Message End -->
        </div>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
  </ul>
</nav>
<!-- /.navbar -->
