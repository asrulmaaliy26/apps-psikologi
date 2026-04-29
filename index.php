<?php include("psychoApps/conExt.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PsychoApps | Login</title>
  <link rel="icon" href="assets/logo psikologi .png" type="image/png">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap">
  <link rel="stylesheet" href="vendor/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="vendor/dist/css/adminlte.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style type="text/css">
    body.login-page {
      background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
      background-size: 400% 400%;
      animation: gradient 15s ease infinite;
      font-family: 'Inter', sans-serif;
      height: 100vh;
    }

    @keyframes gradient {
      0% {
        background-position: 0% 50%;
      }

      50% {
        background-position: 100% 50%;
      }

      100% {
        background-position: 0% 50%;
      }
    }

    .login-box {
      width: 400px;
    }

    .card {
      border-radius: 15px;
      border: none;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.9);
    }

    .login-logo {
      margin-bottom: 20px;
    }

    .logo-container {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      gap: 30px;
      background: rgba(255, 255, 255, 0.2);
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 10px;
      margin-top: 50px;
    }

    .logo-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 150px;
    }

    .logo-item img {
      height: 60px;
      width: auto;
      filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
      margin-bottom: 8px;
    }

    .logo-item small {
      color: #fff;
      font-size: 10px;
      line-height: 1.2;
      font-weight: 600;
      text-align: center;
      text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
    }

    .login-logo span {
      color: #fff;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 2px;
      font-size: 24px;
      display: block;
      margin-top: 10px;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .login-card-body {
      border-radius: 15px;
      padding: 30px;
    }

    .btn-primary {
      background-color: #1a2a6c;
      border: none;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #0d1535;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .form-control {
      border-radius: 8px;
      border: 1px solid #ddd;
    }

    .input-group-text {
      border-radius: 0 8px 8px 0;
      background-color: #f8f9fa;
      border: 1px solid #ddd;
      border-left: none;
    }

    .alert {
      position: fixed;
      top: 20px;
      left: 50%;
      transform: translateX(-50%);
      z-index: 9999;
      width: 90%;
      max-width: 400px;
      border-radius: 10px;
    }

    .login-container {
      width: 100%;
      max-width: 900px;
      margin: 20px;
    }

    .card {
      border-radius: 20px;
      border: none;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
      backdrop-filter: blur(15px);
      background: rgba(255, 255, 255, 0.92);
      overflow: hidden;
    }

    .login-logo {
      margin-bottom: 30px;
    }

    .logo-container {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 30px;
      background: rgba(255, 255, 255, 0.15);
      padding: 30px;
      border-radius: 15px;
      margin-bottom: 20px;
      backdrop-filter: blur(5px);
    }

    .side-logo {
      height: 80px;
      width: auto;
      filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.2));
    }

    .logo-text {
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .logo-text h2 {
      color: #fff;
      font-size: 20px;
      font-weight: 800;
      margin: 0;
      letter-spacing: 2px;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    .logo-text h3 {
      color: #fff;
      font-size: 14px;
      font-weight: 600;
      margin: 5px 0 0 0;
      letter-spacing: 1px;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    .login-logo span {
      display: none;
      /* Hide the old PsychoApps text as it's now in the header */
    }

    .login-card-body {
      /* padding: 0; */
    }

    .left-pane {
      background: rgba(0, 0, 0, 0.02);
      padding: 40px;
      border-right: 1px solid rgba(0, 0, 0, 0.05);
    }

    .right-pane {
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .level-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 12px;
    }

    .level-card {
      background: #fff;
      border: 2px solid #f0f0f0;
      border-radius: 12px;
      padding: 12px 8px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      min-height: 100px;
    }

    .card-icon {
      width: 45px;
      height: 45px;
      background: #f8f9fa;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 10px;
      transition: all 0.3s ease;
    }

    .level-card i {
      font-size: 20px;
      color: #1a2a6c;
    }

    .level-card span {
      font-size: 9px;
      font-weight: 700;
      color: #444;
      line-height: 1.2;
      text-transform: uppercase;
    }

    .level-card:hover {
      background: #fff;
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      border-color: #1a2a6c;
    }

    .level-card:hover .card-icon {
      background: #eef2ff;
      transform: scale(1.1);
    }

    .level-card.selected {
      border-color: #b21f1f;
      background: #fff;
      box-shadow: 0 10px 25px rgba(178, 31, 31, 0.2);
    }

    .level-card.selected .card-icon {
      background: #fff5f5;
    }

    .level-card.selected i {
      color: #b21f1f;
    }

    .level-category h6 {
      font-size: 11px;
      letter-spacing: 1px;
      color: #888;
      border-left: 3px solid #1a2a6c;
      padding-left: 10px;
    }

    .btn-primary {
      background: linear-gradient(to right, #1a2a6c, #2a4a9c);
      border: none;
      font-weight: 700;
      height: 50px;
      border-radius: 10px;
      margin-top: 10px;
      letter-spacing: 1px;
    }

    .form-control {
      height: 50px;
      border-radius: 10px;
      padding-left: 15px;
    }

    @media (max-width: 768px) {
      .level-grid {
        grid-template-columns: repeat(2, 1fr);
      }

      .left-pane {
        border-right: none;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      }

      @keyframes blink {
        0% {
          opacity: 1;
        }

        50% {
          opacity: 0.4;
          transform: scale(1.05);
        }

        100% {
          opacity: 1;
        }
      }

      .blink-text {
        animation: blink 2s infinite ease-in-out;
        display: inline-block;
        color: #1a2a6c !important;
        font-weight: 700 !important;
      }
  </style>
</head>
<?php
if (!empty($_GET['message']) && $_GET['message'] == 'notifLogin') {
  echo "
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
          icon: 'error',
          title: 'Login Gagal',
          text: 'Sesuaikan level, username dan password.',
          confirmButtonColor: '#1a2a6c',
          timer: 3000,
          timerProgressBar: true
        });
      });
    </script>";
}
?>

<body class="hold-transition login-page">
  <div class="login-container">
    <div class="login-logo text-center">
      <div class="logo-container">
        <img src="assets/logo psikologi .png" alt="Logo Psikologi" class="side-logo">
        <div class="logo-text">
          <h2>FAKULTAS PSIKOLOGI</h2>
          <h3>UIN MAULANA MALIK IBRAHIM MALANG</h3>
        </div>
        <img src="assets/Logo-UIN-Malang-Format-AI-CDR-PNG-SVG-PSD-EPS.png" alt="Logo UIN Malang" class="side-logo">
      </div>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <div class="row">
          <div class="col-md-7 left-pane">
            <h5 class="mb-4 font-weight-bold text-primary"><i class="fas fa-layer-group mr-2"></i> Pilih Level Akses</h5>

            <div class="level-category mb-4">
              <h6 class="text-muted font-weight-bold mb-3">DOSEN & MAHASISWA</h6>
              <div class="level-grid">
                <?php
                $q = mysqli_query($con, "SELECT * FROM opsi_level_admin WHERE id IN (1,2,3,11) ORDER BY FIELD(id, 1,2,3,11)");
                while ($c = mysqli_fetch_array($q)) {
                  $icon = "fa-user-cog";
                  $nm = strtolower($c['nm']);
                  if (strpos($nm, 'dosen') !== false) $icon = "fa-chalkboard-teacher";
                  elseif (strpos($nm, 'mahasiswa') !== false) $icon = "fa-user-graduate";
                  elseif (strpos($nm, 'karyawan') !== false) $icon = "fa-user-tie";

                  echo "
                  <div class='level-card' data-id='$c[id]' onclick='selectLevel(this, \"$c[id]\")'>
                    <div class='card-icon'><i class='fas $icon'></i></div>
                    <span>$c[nm]</span>
                  </div>";
                }
                ?>
              </div>
            </div>

            <div class="level-category">
              <h6 class="text-muted font-weight-bold mb-3">ADMINISTRATOR</h6>
              <div class="level-grid">
                <?php
                $q = mysqli_query($con, "SELECT * FROM opsi_level_admin WHERE id NOT IN (1,2,3,11) ORDER BY id ASC");
                while ($c = mysqli_fetch_array($q)) {
                  $icon = "fa-user-shield";
                  echo "
                  <div class='level-card' data-id='$c[id]' onclick='selectLevel(this, \"$c[id]\")'>
                    <div class='card-icon'><i class='fas $icon'></i></div>
                    <span>$c[nm]</span>
                  </div>";
                }
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-5 right-pane">
            <div class="text-center mb-4">
              <h5 class="font-weight-bold text-dark">Login Akun</h5>
              <p class="text-muted small">Masukkan kredensial Anda</p>
            </div>
            <form action="psychoApps/logAllAdm.php?op=in" method="post" id="login-form">
              <input type="hidden" name="level" id="level-input" required>

              <div class="input-group mb-4">
                <input type="text" name="username" class="form-control" placeholder="Username" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-4">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row mb-4">
                <div class="col-12">
                  <div class="icheck-primary">
                    <input type="checkbox" id="remember">
                    <label for="remember">
                      Tetap masuk
                    </label>
                  </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-block">MASUK KE SISTEM</button>

              <div class="mt-4 text-center">
                <a href="docs.php" class="blink-text small"><i class="fas fa-book-open mr-1"></i> Dokumentasi Sistem</a>
              </div>
            </form>
          </div>
        </div>
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

    function selectLevel(element, id) {
      // Remove selected class from all cards
      $('.level-card').removeClass('selected');
      // Add selected class to the clicked card
      $(element).addClass('selected');
      // Set the hidden input value
      $('#level-input').val(id);
    }

    // $('#login-form').submit(function(e) {
    //   if (!$('#level-input').val()) {
    //     e.preventDefault();
    //     Swal.fire({
    //       icon: 'warning',
    //       title: 'Perhatian',
    //       text: 'Silakan pilih level terlebih dahulu!',
    //       confirmButtonColor: '#1a2a6c'
    //     });
    //   }
    // });
  </script>
</body>

</html>