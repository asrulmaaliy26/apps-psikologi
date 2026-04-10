<?php include("contentsConAdm.php");
  $qryUser = "SELECT * FROM opsi_level_admin WHERE id='6'";
  $rUser = mysqli_query($con, $qryUser);
  $dUser = mysqli_fetch_assoc($rUser);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmKepeg.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <?php
              if (!empty($_GET['message']) && $_GET['message'] == 'notifGagal') {
                  echo '
                  <div class="alert alert-danger d-none" role="alert" id="alert">
                  <span>Impor data gagal! Pastikan jenis filenya!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
                  echo '
                  <div class="alert alert-primary d-none" role="alert" id="alert">
                  <span>Impor data berhasil!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              ?>
            <div class="row mb-2">
              <div class="col-sm-6">
                <h4 class="mb-0">Impor Data</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small"><?php echo $dUser['nm'];?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <form method="post" action="sformImporUserTataPersuratan.php" enctype="multipart/form-data">
                  <div class="card card-outline card-success">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Form Impor</h4>
                      <a href="images/template-impor-user-tata-persuratan.xls" type="button" class="btn btn-outline-success btn-xs float-right" title="Download Template Impor"><i class="fas fa-download"></i> Download Template Impor</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="info-box mb-3">
                        <b>Petunjuk:</b>
                        <ul class="list">
                          <li>Form ini untuk impor user <?php echo $dUser['nm'];?> yang belum terdaftar.</li>
                          <li>File yang akan diimpor hanya berekstensi .xls (Excel 97-2003).</li>
                          <li>Silahkan download template file untuk impor user <?php echo $dUser['nm'];?>, dan silahkan baca di sheet "baca petunjuk" untuk pengisian kolom yang tersedia.</li>
                        </ul>
                      </div>
                        <div class="form-group">
                        <label for="filedata">Pilih File yang Akan Diimpor <span class="text-danger">*</span></label>
                        <input type="file" name="filedata" class="form-control form-control-sm" required>
                      </div>
                  </div>
                  <div class="card-footer clearfix">
                    <button type="submit" class="btn btn-outline-success btn-sm" data-dismiss="modal">Impor</button>
                  </div>
                </div>
              </form>
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