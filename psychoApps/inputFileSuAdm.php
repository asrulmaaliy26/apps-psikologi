<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $username = $_SESSION['username'];
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  $queryAdm = "SELECT * FROM dt_all_adm WHERE username='$username'";
  $rAdm = mysqli_query($con, $queryAdm) or die( mysqli_error($con));
  $dAdm = mysqli_fetch_assoc($rAdm);
  $idAdm = $dAdm['username'];
  $tahun = date("Y");
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmTaper.php" );
        ?>
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="mb-0">Kirim File Surat</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small"><a href="rekapKirimSuratUndAdm.php?page=<?php echo $page;?>">Surat Undangan</a></li>
                  <li class="breadcrumb-item active small">Form Upload</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h4 class="card-title">Form Upload</h4>
                  </div>
                  <div class="card-body">
                    <form action="sinputFileSuAdm.php" method="post" enctype="multipart/form-data">
                      <input type="text" class="sr-only" name="executor" value="<?php echo $idAdm;?>" readonly required>
                      <input type="text" class="sr-only" name="page" value="<?php echo $page;?>" readonly required>
                      <input type="text" class="sr-only" name="jenis_surat" value="3" readonly required>
                      <div class="form-group">
                        <label>Keterangan tentang File</label>
                        <textarea id="textarea-custom-one" name="deskripsi" class="form-control form-control-sm" style="height: 300px;" required></textarea>
                      </div>
                      <div class="row">
                        <div class="form-group col-md-6">
                          <label>Upload File</label>
                          <input type="file" name="file_surat" class="form-control form-control-sm" required>
                          <small class="form-text text-muted">File harus pdf.</small>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Tanggal Upload File</label>
                          <div class="input-group date" id="tgl_ymd_one" data-target-input="nearest">
                            <input type="text" name="tgl_upload" class="form-control form-control-sm" data-target="#tgl_ymd_one"  data-toggle="datetimepicker" required/>
                            <div class="input-group-append" data-target="#tgl_ymd_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Catatan</label>
                        <input type="text" name="catatan" class="form-control form-control-sm">
                      </div>
                      <button type="submit" class="btn btn-sm btn-success">Submit</button>
                    </form>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>