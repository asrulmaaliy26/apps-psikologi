<?php 
  include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con, $_GET[ 'page' ] );
  
  $q = "SELECT * FROM mag_periode_pengajuan_dospem WHERE id='$id'";
  $r = mysqli_query($con,  $q )or DIE( mysqli_error($con) );
  $d = mysqli_fetch_assoc( $r );
  
  $q_ta = "SELECT * FROM mag_dt_ta WHERE id='$d[ta]'";
  $r_ta = mysqli_query($con,  $q_ta )or DIE( mysqli_error($con) );
  $d_ta = mysqli_fetch_assoc( $r_ta );
  
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmBakS2.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="m-0">Pengajuan Dosen Pembimbing Tesis</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                  <li class="breadcrumb-item"><a href="magPeriodePptAdm.php?page=<?php echo $page;?>">Periode Pengajuan</a></li>
                  <li class="breadcrumb-item active">Edit</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col connectedSortable">
                <div class="card card-outline card-success">
                  <form action="magUpdatePeriodePptPerIdAdm.php" method="post" enctype="multipart/form-data">
                    <div class="card-header">
                      <h3 class="card-title">Edit</h3>
                    </div>
                    <div class="card-body">
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <input type="text" name="ta" class="sr-only" value="<?php echo $d_ta['id'];?>" required readonly>
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="tahap">Tahap <span class="text-danger">*</span></label>
                          <?php
                          echo "<select name='tahap' class='form-control form-control-sm' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con,  "SELECT * FROM mag_opsi_tahap_ujprop_ujtes ORDER BY tahap ASC" );
                          WHILE ( $w = mysqli_fetch_array( $tampil ) ) {
                            IF ( $d['tahap'] == $w[ 'id' ] ) {
                               echo "<option value='$w[id]' selected>$w[tahap]</option>";
                            } ELSE {
                               echo "<option value='$w[id]'>$w[tahap]</option>";
                            }
                          }
                          echo "</select>";
                          ?>
                        </div>
                        <div class="form-group col-6">
                          <label for="syarat_sks">Syarat SKS <span class="text-danger">*</span></label>
                          <input type="number" min="1" max="100" name="syarat_sks" class="form-control form-control-sm" value="<?php echo $d['syarat_sks'];?>" required/>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="start_datetime">Batas Waktu Awal <span class="text-danger">*</span></label>
                          <div class="input-group date" id="tgl_ymd_jam_one" data-target-input="nearest">
                            <input type="text" name="start_datetime" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_ymd_jam_one" value="<?php echo $d['start_datetime'];?>" required/>
                            <div class="input-group-append" data-target="#tgl_ymd_jam_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-6">
                          <label for="end_datetime">Batas Waktu Akhir <span class="text-danger">*</span></label>
                          <div class="input-group date" id="tgl_ymd_jam_two" data-target-input="nearest">
                            <input type="text" name="end_datetime" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_ymd_jam_two" value="<?php echo $d['end_datetime'];?>" required/>
                            <div class="input-group-append" data-target="#tgl_ymd_jam_two" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-outline-success btn-sm float-left">Update</button>
                      <a href="magPeriodePptAdm.php?page=<?php echo "$page";?>" class="btn btn-outline-secondary btn-sm float-right">Batal</a>
                    </div>
                  </form>
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