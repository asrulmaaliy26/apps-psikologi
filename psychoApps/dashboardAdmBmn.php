<?php include( "contentsConAdm.php" );?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
    <?php 
      include( "navtopAdm.php" );
      include( "navSideBarAdmBmn.php" );
      ?> 
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h4 class="mb-0">Dashboard</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Dashboard</li>
                </ol>
              </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-3 col-6">
              <div class="small-box bg-info">
                <div class="inner">
                  <?php
                  $q1 = mysqli_query($con, "SELECT COUNT(id) as total FROM dt_inventaris_barang");
                  $d1 = mysqli_fetch_assoc($q1);
                  ?>
                  <h3><?php echo $d1['total']; ?></h3>
                  <p>Total Barang</p>
                </div>
                <div class="icon">
                  <i class="fas fa-box"></i>
                </div>
                <a href="dtBarang.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-warning">
                <div class="inner">
                  <?php
                  $q2 = mysqli_query($con, "SELECT COUNT(id) as total FROM dt_inventaris_barang WHERE status_peminjaman='2'");
                  $d2 = mysqli_fetch_assoc($q2);
                  ?>
                  <h3><?php echo $d2['total']; ?></h3>
                  <p>Barang Dipinjam</p>
                </div>
                <div class="icon">
                  <i class="fas fa-hand-holding"></i>
                </div>
                <a href="dtBarangDipinjam.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-danger">
                <div class="inner">
                  <?php
                  $q3 = mysqli_query($con, "SELECT COUNT(id) as total FROM dt_pengajuan_penghapusan_bmn WHERE status='Diajukan'");
                  $d3 = mysqli_fetch_assoc($q3);
                  ?>
                  <h3><?php echo $d3['total']; ?></h3>
                  <p>Penghapusan (Pending)</p>
                </div>
                <div class="icon">
                  <i class="fas fa-trash-alt"></i>
                </div>
                <a href="rekapPenghapusanBmnAdm.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-success">
                <div class="inner">
                  <?php
                  $q4 = mysqli_query($con, "SELECT COUNT(id) as total FROM dt_pengajuan_penghapusan_bmn WHERE status='Selesai'");
                  $d4 = mysqli_fetch_assoc($q4);
                  ?>
                  <h3><?php echo $d4['total']; ?></h3>
                  <p>Penghapusan (Selesai)</p>
                </div>
                <div class="icon">
                  <i class="fas fa-check-circle"></i>
                </div>
                <a href="rekapPenghapusanBmnAdm.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>