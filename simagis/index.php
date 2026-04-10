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
      <div class="col-md-5 col-sm-12 col-xs-12" style="float:none; margin:auto; margin-top:20px;">
        <h3 class="page-header text-center">LOGIN USER SIMAGIS</h3>
        <div class="panel panel-default">
          <div class="panel-body">
            <form class="form" role="form" method="post" action="logUser.php?op=in" name="login">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                  <input type="text" name="username" class="form-control" id="username" placeholder="Username">
                </div>
              </div>
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                  <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                </div>
              </div>
              <hr>
              <button type="submit" class="btn btn-block btn-primary">Login</button>
              </a>
              <div style="margin-top: 15px; text-align: center;">
                <a href="../docs.php" class="text-muted"><span class="glyphicon glyphicon-book"></span> Baca Dokumentasi Sistem</a>
              </div>
            </form>
          </div>
        </div>
        <?php
        if (!empty($_GET['message']) && $_GET['message'] == 'notifLogin') {
          echo '<div class="alert alert-danger custom-alert text-center" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Username atau password salah!</div>';
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