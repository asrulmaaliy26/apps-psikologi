<?php
  if(!isset($_SESSION)) { 
      session_start(); 
  }
  if (isset($_SESSION['nim']) && $_SESSION['nim'] != "") {
      include("koneksiUser.php");
      $nim = $_SESSION['nim'];
      $myquery = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
      $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
      $dataku = mysqli_fetch_assoc($dmhssw);
  } else {
      include("koneksiAdm.php");
      $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
      $myquery = "select * from mag_dt_admin_bak WHERE username='$username'";
      $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
      $dataku = mysqli_fetch_assoc($dmhssw);
  }
?>
<html lang="en">

<head>
  <?php
  if (isset($_SESSION['nim']) && $_SESSION['nim'] != "") {
    include 'headUser.php';
  } else {
    include 'headAdm.php';
  }
  ?>
</head>

<body>
  <?php
  if (isset($_SESSION['nim']) && $_SESSION['nim'] != "") {
    include "navDashUser.php";
  } else {
    include "navDashAdm.php";
  }
  ?>x
  <div class="container">
    <div class="row">
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
                    <button type="button" style="padding:0px;" class="btn btn-link" title='Baca...' data-toggle='modal' data-target='#modalPengumuman' data-whatever='<?php echo $dp['id'] ?>'><?php echo $dp['judul']; ?></button> <br />
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

  <?php include "footerUser.php"; ?>
  <?php include "jsSourceUser.php"; ?>
  <script>
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
          modal.find('.isiModalPengumuman').html(data);
        },
        error: function(err) {
          console.log(err);
        }
      });
    });
  </script>
</body>

</html>