<?php include("psychoApps/conExt.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PsychoApps</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="vendor/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="vendor/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="vendor/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="vendor/plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="vendor/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="vendor/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="vendor/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="vendor/plugins/summernote/summernote-bs4.min.css">
  <link href="vendor/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <style type="text/css">
    div.alert {
      position: absolute;
      top: 90px;
      left: 50px;
      right: 50px;
      z-index: 1;
    }
  </style>
</head>
<?php
if (!empty($_GET['message']) && $_GET['message'] == 'notifLogin') {
  echo '
                  <div class="alert alert-danger d-none text-center" role="alert" id="alert">
                  <span>Login gagal! Sesuaikan level, username dan password.</span></div>
                  ';
}
?>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <span>PsychoApps</span>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Masukkan level, username dan password</p>
        <form action="psychoApps/logAllAdm.php?op=in" method="post">
          <div class="input-group mb-3">
            <select name="level" class="form-control" placeholder="Pilih level" required>
              <option value="">-Pilih Level-</option>
              <?php
              $q = mysqli_query($con, "SELECT * FROM opsi_level_admin ORDER BY id ASC");
              while ($c = mysqli_fetch_array($q)) {
                echo "<option value='$c[id]'>$c[nm]</option>";
              }
              ?>
            </select>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-layer-group"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-12 text-center">
              <a href="docs.php" class="text-secondary"><i class="fas fa-book"></i> Baca Dokumentasi Sistem</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="vendor/plugins/jquery/jquery.min.js"></script>
  <script src="vendor/plugins/jquery-ui/jquery-ui.min.js"></script>
  <script src="vendor/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/plugins/chart.js/Chart.min.js"></script>
  <script src="vendor/plugins/sparklines/sparkline.js"></script>
  <script src="vendor/plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="vendor/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <script src="vendor/plugins/jquery-knob/jquery.knob.min.js"></script>
  <script src="vendor/plugins/moment/moment.min.js"></script>
  <script src="vendor/plugins/daterangepicker/daterangepicker.js"></script>
  <script src="vendor/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <script src="vendor/plugins/summernote/summernote-bs4.min.js"></script>
  <script src="vendor/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="vendor/dist/js/adminlte.js"></script>
  <script src="vendor/dist/js/pages/dashboard.js"></script>
  <script type="text/javascript" src="tinymce/tinymce.min.js"></script>
  <script>
    $('#alert').removeClass('d-none');
    setTimeout(() => {
      $('.alert').alert('close');
    }, 3000);
  </script>
</body>

</html>