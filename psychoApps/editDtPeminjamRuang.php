<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $q_pr = "SELECT * FROM dt_peminjam_ruang WHERE id='$id'";
  $r_pr = mysqli_query($con, $q_pr)or die( mysqli_error($con));
  $d_pr = mysqli_fetch_assoc($r_pr);
  ?>
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
                <h4 class="mb-0">Data Peminjaman Ruang</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="dtPinjamRuang.php?page=<?php echo $page;?>">Data Peminjam Ruang</a></li>
                  <li class="breadcrumb-item active small">Edit Data Peminjam Ruang</li>
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
                    <div class="clearfix">
                      <h4 class="card-title float-left">Edit Data Peminjam Ruang</h4>
                      <span class="float-right"><strong><?php echo $d_pr['nm'];?></strong></span>
                    </div>
                  </div>
                  <div class="card-body">
                    <form action="updateDtPeminjamRuang.php" method="post" enctype="multipart/form-data">
                    <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                    <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                    <label for="nm">Nama Peminjam</label>
                    <div class="form-group">
                      <input name="nm" class="form-control form-control-sm" value="<?php echo $d_pr['nm']?>" required>
                    </div>
                    <label for="alasan_pinjam">Alasan Peminjaman</label>
                    <div class="form-group">
                      <input name="alasan_pinjam" class="form-control form-control-sm" value="<?php echo $d_pr['alasan_pinjam']?>" required>
                    </div>
                    <div class="form-group">
                      <label for="tgl_awal_pinjam">Tanggal Mulai Peminjaman</label>
                      <div class="input-group date" id="tgl_ymd_one" data-target-input="nearest">
                        <input type="text" name="tgl_awal_pinjam" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_ymd_one" value="<?php echo $d_pr['tgl_awal_pinjam']?>" required/>
                        <div class="input-group-append" data-target="#tgl_ymd_one" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="tgl_akhir_pinjam">Tanggal Akhir Peminjaman</label>
                      <div class="input-group date" id="tgl_ymd_two" data-target-input="nearest">
                        <input type="text" name="tgl_akhir_pinjam" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_ymd_two" value="<?php echo $d_pr['tgl_akhir_pinjam']?>" required/>
                        <div class="input-group-append" data-target="#tgl_ymd_two" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button type="submit" class="btn btn-outline-primary btn-sm float-left">Update</button>
                    <a href="dtPinjamRuang.php?page=<?php echo "$page";?>" class="btn btn-outline-secondary btn-sm float-right">Batal</a>
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