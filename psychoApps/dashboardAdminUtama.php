<?php include("contentsConAdm.php"); ?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php
    include("navtopAdm.php");
    include("navSideBarAdminUtama.php");
    ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard Admin Utama</h1>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <section class="col-md-6 connectedSortable">
              <div class="card card-outline card-info">
                <div class="card-header">
                  <h3 class="card-title">Akses Layanan & Pengaduan</h3>
                </div>
                <div class="card-body">
                  <p>Selamat datang di panel Admin Utama. Gunakan menu di bawah untuk mengelola jabatan dan layanan pengaduan.</p>
                  <div class="row">
                    <div class="col-lg-4 col-6">
                      <div class="small-box bg-info">
                        <div class="inner">
                          <h3>Data</h3>
                          <p>Daftar Jabatan</p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-list-ul"></i>
                        </div>
                        <a href="kelolaJabatanAdm.php" class="small-box-footer">Kelola <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                    <div class="col-lg-4 col-6">
                      <div class="small-box bg-success">
                        <div class="inner">
                          <h3>User</h3>
                          <p>Tentukan Pejabat</p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-user-tag"></i>
                        </div>
                        <a href="kelolaPejabatAdm.php" class="small-box-footer">Atur Jabatan <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                    <div class="col-lg-4 col-6">
                      <div class="small-box bg-warning">
                        <div class="inner">
                          <h3>Link</h3>
                          <p>Layanan Pengaduan</p>
                        </div>
                        <div class="icon">
                          <i class="fas fa-headset"></i>
                        </div>
                        <a href="https://docs.google.com/spreadsheets/d/1Rpct62WQy3AFAT5cNIgyP2iaIgFYxGVNPibLIB_RYpg/edit?usp=sharing" target="_blank" class="small-box-footer">Buka <i class="fas fa-arrow-circle-right"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </section>
    </div>
  </div>
  <?php include("footerAdm.php"); ?>
  <?php include("jsAdm.php"); ?>
</body>

</html>