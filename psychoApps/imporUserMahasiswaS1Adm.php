<?php include("contentsConAdm.php");
  $qryUser = "SELECT * FROM opsi_level_admin WHERE id='2'";
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
        include( "navSideBarAdminUtama.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <?php
              if (!empty($_GET['message']) && $_GET['message'] == 'notifGagal') {
                  echo '
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <span>Impor akun gagal! Pastikan jenis filenya!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
                  echo '
                  <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <span>Impor akun berhasil!</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  </div>
                  ';}
              ?>
            <div class="row mb-2">
              <div class="col-sm-6">
                <h4 class="mb-0">Impor Akun Akses (Login)</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">User <?php echo $dUser['nm'];?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <form method="post" action="sformImporUserMahasiswaS1Adm.php" enctype="multipart/form-data">
                  <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Form Impor Akun S1</h4>
                      <a href="images/template-impor-user-mahasiswa-s1.xls" type="button" class="btn btn-outline-info btn-xs float-right" title="Download Template Impor"><i class="fas fa-download"></i> Download Template Akun S1</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="info-box mb-3">
                        <div class="info-box-content">
                          <b>Petunjuk:</b>
                          <ul class="list">
                            <li>Form ini untuk impor kredensial login (username/password) <?php echo $dUser['nm'];?>.</li>
                            <li>File yang akan diimpor hanya berekstensi .xls (Excel 97-2003).</li>
                            <li>Pastikan kolom level diisi dengan angka 2 untuk S1.</li>
                          </ul>
                        </div>
                      </div>
                        <div class="form-group">
                        <label for="filedata">Pilih File Akun (.xls) <span class="text-danger">*</span></label>
                        <input type="file" name="filedata" class="form-control form-control-sm" required>
                      </div>
                  </div>
                  <div class="card-footer clearfix">
                    <button type="submit" class="btn btn-info btn-sm">Mulai Impor Akun</button>
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
