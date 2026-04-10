<?php 
  include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con, $_GET[ 'page' ] );
  
  $q = "SELECT * FROM mag_periode_pengajuan_ac WHERE id='$id'";
  $r = mysqli_query($con,  $q )or DIE( mysqli_error($con) );
  $d = mysqli_fetch_assoc( $r );
  
  $q_ta = "SELECT * FROM mag_dt_ta WHERE id='$d[id]'";
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
                <h4 class="m-0">Pengajuan Academic Coach</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                  <li class="breadcrumb-item"><a href="magPeriodePacAdm.php?page=<?php echo $page;?>">Periode Pengajuan</a></li>
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
                  <form action="magUpdatePeriodePacPerIdAdm.php" method="post" enctype="multipart/form-data">
                    <div class="card-header">
                      <h3 class="card-title">Edit</h3>
                    </div>
                    <div class="card-body">
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
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
                      <a href="magPeriodePacAdm.php?page=<?php echo "$page";?>" class="btn btn-outline-secondary btn-sm float-right">Batal</a>
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