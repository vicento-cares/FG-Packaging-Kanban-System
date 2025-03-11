<?php 
session_set_cookie_params(0, "/fg_packaging_debug");
session_name("fg-pkg-debug");
session_start();

if (isset($_SESSION['username'])) {
  header('location:pages/requested-packaging-materials.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="FG Packaging System" />
  <meta name="keywords" content="FG, Packaging, Kanban, Request" />

  <title>FG Packaging | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="preload" href="../dist/css/font.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <!-- Font Awesome -->
  <link rel="preload" href="../plugins/fontawesome-free/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <!-- Theme style -->
  <link rel="preload" href="../dist/css/adminlte.min.css" as="style" onload="this.rel='stylesheet'">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">

  <style type="text/css">
    /* CUSTOM FOCUS CSS */
    .login-card-body .input-group .form-control:focus ~ .input-group-prepend .input-group-text,
    .login-card-body .input-group .form-control:focus ~ .input-group-append .input-group-text,
    .register-card-body .input-group .form-control:focus ~ .input-group-prepend .input-group-text,
    .register-card-body .input-group .form-control:focus ~ .input-group-append .input-group-text {
      border-color: #99c5de;
    }
    .login-card-body .input-group .form-control.is-invalid ~ .input-group-append .input-group-text,
    .register-card-body .input-group .form-control.is-invalid ~ .input-group-append .input-group-text {
      border-color: #dc3545;
    }
    .login-page {
      background: linear-gradient(to bottom, #307095, #3c8dbc, #8bbdda, #e9ecef);
    }
    /* CUSTOM SWEETALERT COLOR */
    .swal-button {
      background: #3c8dbc;
    }
    .swal-button:not([disabled]):hover {
      background-color: #307095;
    }
  </style>

  <noscript>
    <link rel="stylesheet" href="../dist/css/font.min.css">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  </noscript>

  <link rel="icon" type="image/x-icon" href="../dist/img/fg-pkg-logo.ico">
</head>
<body class="hold-transition login-page accent-lightblue">
  <div class="login-box">
    <div class="login-logo">
      <img class="elevation-3 bg-light p-1 mb-2" src="../dist/img/fg-pkg-logo.png" alt="AdminLTELogo" height="60" width="60">
      <h2 class="text-light"><b>FG</b> Packaging System</h2>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg"><b>Admin-FG Login</b><br>Log in to start your session</p>
        <form id="quickForm" action="javascript:void(0)">
          <div class="form-group">
            <div class="input-group">
              <input type="text" name="username" class="form-control" id="username" placeholder="Username" maxlength="255">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user-alt"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="password" name="password" class="form-control" id="password" placeholder="Password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <button type="submit" class="btn bg-lightblue btn-block" id="login">Login</button>
            </div>
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script defer src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- jquery-validation -->
  <script defer src="../plugins/jquery-validation/jquery.validate.min.js"></script>
  <script defer src="../plugins/jquery-validation/additional-methods.min.js"></script>
  <!-- SweetAlert --->
  <script defer src="../plugins/sweetalert/dist/sweetalert.min.js"></script>
  <!-- Script -->
  <script defer src="../dist/js/src/cookie.js"></script>
  <script defer src="../dist/js/admin/pages/index.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>
  
  <noscript>
    <br>
    <span>We are facing <strong>Script</strong> issues. Kindly enable <strong>JavaScript</strong>!!!</span>
    <br>
    <span>Call IT Personnel Immediately!!! They will fix it right away.</span>
  </noscript>

</body>
</html>