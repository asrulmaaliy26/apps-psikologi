<?php
include("koneksiExt.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "headExt.php"; ?>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-5 col-sm-12 col-xs-12" style="float:none; margin:auto; margin-top:40px;">
        <div class="text-center" style="margin-bottom: 20px;">
          <div style="display: flex; justify-content: center; align-items: center; gap: 20px; background: rgba(255,255,255,0.9); padding: 20px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <img src="../assets/logo psikologi .png" style="height: 60px; width: auto;" alt="Logo Psikologi">
            <div style="text-align: center;">
              <h4 style="color: #1a2a6c; font-weight: 800; margin: 0; letter-spacing: 1px; font-size: 16px;">FAKULTAS PSIKOLOGI</h4>
              <h5 style="color: #555; font-weight: 600; margin: 5px 0 0 0; font-size: 11px;">UIN MAULANA MALIK IBRAHIM MALANG</h5>
            </div>
            <img src="../assets/Logo-UIN-Malang-Format-AI-CDR-PNG-SVG-PSD-EPS.png" style="height: 60px; width: auto;" alt="Logo UIN Malang">
          </div>
          <h3 style="color: #1a2a6c; font-weight: 700; margin-top: 15px;">LOGIN USER SIMAGIS</h3>
        </div>
        <div class="panel panel-default" style="border-radius: 10px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
          <div class="panel-body" style="padding: 30px;">
            <form class="form" role="form" method="post" action="logUser.php?op=in" name="login">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon" style="background: #f8f9fa; border-right: none;"><span class="glyphicon glyphicon-user"></span></span>
                  <input type="text" name="username" class="form-control" id="username" placeholder="Username" style="height: 45px; border-left: none;">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon" style="background: #f8f9fa; border-right: none;"><span class="glyphicon glyphicon-lock"></span></span>
                  <input type="password" name="password" class="form-control" id="password" placeholder="Password" style="height: 45px; border-left: none;">
                </div>
              </div>
              <div style="margin-top: 20px;">
                <button type="submit" class="btn btn-block btn-primary" style="height: 45px; font-weight: 600; background: #1a2a6c; border: none; border-radius: 5px;">Login</button>
              </div>
              <div style="margin-top: 20px; text-align: center;">
                <a href="../docs.php" class="blink-text small" style="text-decoration: none;"><span class="glyphicon glyphicon-book"></span> Baca Dokumentasi Sistem</a>
              </div>
            </form>
          </div>
        </div>
        <?php
        if (!empty($_GET['message']) && $_GET['message'] == 'notifLogin') {
          echo "
            <script>
              document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Login Gagal',
                  text: 'Username atau password salah!',
                  confirmButtonColor: '#1a2a6c',
                  timer: 3000,
                  timerProgressBar: true
                });
              });
            </script>";
        }
        ?>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="panel panel-info" style="box-shadow:none; border:0px;">
          <div class="panel-heading">
            <h3 class="panel-title text-center">Pengumuman</h3>
          </div>
          <table class="table table-condensed table-striped">
            <tbody>
              <?php
              $qp = "select * from mag_upload_pengumuman ORDER BY id ASC";
              $rp = mysqli_query($GLOBALS["___mysqli_ston"], $qp) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              while ($dp = mysqli_fetch_assoc($rp)) {
              ?>
                <tr>
                  <td>
                    <button type="button" style="padding:0px;" class="btn btn-link" title='Baca...' data-toggle='modal' data-target='#modalDetail' data-whatever='<?php echo $dp['id'] ?>'><?php echo $dp['judul']; ?></button> <br />
                    <span class="text-muted small">Posted on: <?php echo $dp['tbt']; ?></span>
                  </td>
                </tr>
              <?php }; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="panel panel-info" style="box-shadow:none; border:0px;">
          <div class="panel-heading">
            <h3 class="panel-title text-center">Download</h3>
          </div>
          <table class="table table-condensed table-striped">
            <tbody>
              <?php
              $qb = "SELECT * FROM mag_upload_berkas ORDER BY id DESC";
              $rb = mysqli_query($GLOBALS["___mysqli_ston"], $qb) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              while ($db = mysqli_fetch_assoc($rb)) {

                $qk = "SELECT * FROM kategori_upload_berkas WHERE id='$db[kategori]'";
                $rk = mysqli_query($GLOBALS["___mysqli_ston"], $qk) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                $dk = mysqli_fetch_assoc($rk);
              ?>
                <tr>
                  <td>
                    <a href="<?php echo $db['berkas']; ?>" target="_blank"><?php echo $db['deskripsi']; ?></a> <br />
                    <span class="text-muted small">Kategori: <?php echo $dk['nm']; ?>, Posted on: <?php echo $db['tbt']; ?></span>
                  </td>
                </tr>
              <?php }; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="panel panel-info" style="box-shadow:none; border:0px;">
          <div class="panel-heading">
            <h3 class="panel-title text-center">Standard Operasional Procedur (SOP)</h3>
          </div>
          <table class="table table-condensed table-striped">
            <tbody>
              <tr>
                <td>
                  <span class="glyphicon glyphicon-edit text-primary"></span> <button type="button" style="padding:0px;" class="btn btn-link" title='Baca...' data-toggle='modal' data-target='#modalPprp'>SOP Pengajuan Peminatan Rumpun Psikologi</button>
                </td>
              </tr>
              <tr>
                <td>
                  <span class="glyphicon glyphicon-edit text-primary"></span> <button type="button" style="padding:0px;" class="btn btn-link" title='Baca...' data-toggle='modal' data-target='#modalPac'>SOP Pengajuan Academic Coach</button>
                </td>
              </tr>
              <tr>
                <td>
                  <span class="glyphicon glyphicon-edit text-primary"></span> <button type="button" style="padding:0px;" class="btn btn-link" title='Baca...' data-toggle='modal' data-target='#modalPpt'>SOP Pengajuan Pembimbing Tesis</button>
                </td>
              </tr>
              <tr>
                <td>
                  <span class="glyphicon glyphicon-edit text-primary"></span> <button type="button" style="padding:0px;" class="btn btn-link" title='Baca...' data-toggle='modal' data-target='#modalPspt'>SOP Pendaftaran Seminar Proposal Tesis</button>
                </td>
              </tr>
              <tr>
                <td>
                  <span class="glyphicon glyphicon-edit text-primary"></span> <button type="button" style="padding:0px;" class="btn btn-link" title='Baca...' data-toggle='modal' data-target='#modalPut'>SOP Pendaftaran Ujian Tesis</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="panel panel-info" style="box-shadow:none; border:0px;">
          <div class="panel-heading">
            <h3 class="panel-title text-center">Kontak Layanan</h3>
          </div>
          <table class="table table-condensed table-striped">
            <tbody>
              <?php
              $qkl = "select * from mag_kontak_layanan ORDER BY id ASC";
              $rkl = mysqli_query($GLOBALS["___mysqli_ston"], $qkl) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              while ($dkl = mysqli_fetch_assoc($rkl)) {
              ?>
                <tr>
                  <?php if (empty($dkl['hp'])) {
                    echo
                    '<td>
                  <span class="glyphicon glyphicon-user"></span> ' . $dkl['nm'] . '<br />
                  <span class="glyphicon glyphicon-envelope"></span> ' . $dkl['email'] . ' <br />
                  <b>Spesifikasi Layanan:</b> <br />
                  ' . nl2br($dkl['deskripsi_layanan']) . '
                  </td>';
                  } else if (empty($dkl['email'])) {
                    echo
                    '<td>
                  <span class="glyphicon glyphicon-user"></span> ' . $dkl['nm'] . '<br />
                  <span class="glyphicon glyphicon-phone-alt"></span> ' . $dkl['hp'] . ' <br />
                  <b>Spesifikasi Layanan:</b> <br />
                  ' . nl2br($dkl['deskripsi_layanan']) . '
                  </td>';
                  } else {
                    echo
                    '<td>
                  <span class="glyphicon glyphicon-user"></span> ' . $dkl['nm'] . '<br />
                  <span class="glyphicon glyphicon-phone-alt"></span> ' . $dkl['hp'] . ' <br />
                  <span class="glyphicon glyphicon-envelope"></span> ' . $dkl['email'] . ' <br />
                  <b>Spesifikasi Layanan:</b> <br />
                  ' . nl2br($dkl['deskripsi_layanan']) . '
                  </td>';
                  }
                  ?>
                </tr>
              <?php }; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" tabindex="-1" role="dialog" id="modalPengumuman" aria-labelledby="labelModalPengumuman" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="modalPengumuman">Pengumuman</h4>
        </div>
        <div class="modal-body">
          <div class="isiModalPengumuman"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" tabindex="-1" role="dialog" id="modalDownload" aria-labelledby="labelModalDownload" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="modalDownload">Download</h4>
        </div>
        <div class="modal-body">
          <div class="isiModalDownload"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" tabindex="-1" role="dialog" id="modalPprp" aria-labelledby="labelModalPprp" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="modalPprp">SOP Pengajuan Peminatan Rumpun Psikologi</h4>
        </div>
        <div class="modal-body">
          <div class="panel panel-default">
            <div class="panel-body">
              <?php
              $qpprp = "select * from mag_sop_pprp LIMIT 1";
              $rpprp = mysqli_query($GLOBALS["___mysqli_ston"], $qpprp) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $dpprp = mysqli_fetch_assoc($rpprp);
              echo $dpprp['isi']; ?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" tabindex="-1" role="dialog" id="modalPac" aria-labelledby="labelModalPac" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="modalPac">SOP Pengajuan Academic Coach</h4>
        </div>
        <div class="modal-body">
          <div class="panel panel-default">
            <div class="panel-body">
              <?php
              $qpac = "select * from mag_sop_pac LIMIT 1";
              $rpac = mysqli_query($GLOBALS["___mysqli_ston"], $qpac) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $dpac = mysqli_fetch_assoc($rpac);
              echo $dpac['isi']; ?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" tabindex="-1" role="dialog" id="modalPpt" aria-labelledby="labelModalPpt" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="modalPpt">SOP Pengajuan Pembimbing Tesis</h4>
        </div>
        <div class="modal-body">
          <div class="panel panel-default">
            <div class="panel-body">
              <?php
              $qppt = "select * from mag_sop_ppt LIMIT 1";
              $rppt = mysqli_query($GLOBALS["___mysqli_ston"], $qppt) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $dppt = mysqli_fetch_assoc($rppt);
              echo $dppt['isi']; ?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" tabindex="-1" role="dialog" id="modalPspt" aria-labelledby="labelModalPspt" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="modalPspt">SOP Pendaftaran Seminar Proposal Tesis</h4>
        </div>
        <div class="modal-body">
          <div class="panel panel-default">
            <div class="panel-body">
              <?php
              $qpspt = "select * from mag_sop_pspt LIMIT 1";
              $rpspt = mysqli_query($GLOBALS["___mysqli_ston"], $qpspt) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $dpspt = mysqli_fetch_assoc($rpspt);
              echo $dpspt['isi']; ?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" tabindex="-1" role="dialog" id="modalPut" aria-labelledby="labelModalPut" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="modalPut">SOP Pendaftaran Ujian Tesis</h4>
        </div>
        <div class="modal-body">
          <div class="panel panel-default">
            <div class="panel-body">
              <?php
              $qput = "select * from mag_sop_put LIMIT 1";
              $rput = mysqli_query($GLOBALS["___mysqli_ston"], $qput) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
              $dput = mysqli_fetch_assoc($rput);
              echo $dput['isi']; ?>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <?php include("footerExt.php"); ?>
  <?php include "jsSourceExt.php"; ?>
  <script>
    window.setTimeout(function() {
      $(".custom-alert").fadeOut(500, function() {
        $(this).remove();
      });
    }, 3000);

    $('#modalPengumuman').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
        type: "GET",
        url: "detailPengumumanUser.php",
        data: dataString,
        cache: false,
        success: function(data) {
          console.log(data);
          modal.find('.isiModalDetail').html(data);
        },
        error: function(err) {
          console.log(err);
        }
      });
    });

    $('#modalDownload').on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
        type: "GET",
        url: "detailDownloadUser.php",
        data: dataString,
        cache: false,
        success: function(data) {
          console.log(data);
          modal.find('.isiModalDownload').html(data);
        },
        error: function(err) {
          console.log(err);
        }
      });
    });
  </script>
</body>

</html>