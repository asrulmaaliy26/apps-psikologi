<?php 
  include( "contentsConAdm.php" );
  $page = mysqli_real_escape_string($con, $_GET[ 'page' ] );
  
  $qta = "SELECT * FROM mag_dt_ta WHERE status='1'";
  $rta = mysqli_query($con, $qta)or die( mysqli_error($con));
  $dta = mysqli_fetch_assoc($rta);   
   
  $qwd1 = "SELECT * FROM dt_pegawai WHERE jabatan_instansi = '2'";
  $rwd1 = mysqli_query($con, $qwd1)or die( mysqli_error($con));
  $dwd1 = mysqli_fetch_assoc($rwd1);   
   
  $qkaprodi = "SELECT * FROM dt_pegawai WHERE jabatan_instansi = '36'";
  $rkaprodi = mysqli_query($con, $qkaprodi)or die( mysqli_error($con));
  $dkaprodi = mysqli_fetch_assoc($rkaprodi);
  
   if(isset($_POST['new']) && $_POST['new']==1)
   {
    $page = mysqli_real_escape_string($con, $_REQUEST['page']);
    $ta = mysqli_real_escape_string($con, $_REQUEST['ta']);
    $start_datetime = mysqli_real_escape_string($con, $_REQUEST['start_datetime']);
    $end_datetime = mysqli_real_escape_string($con, $_REQUEST['end_datetime']);
    $status = mysqli_real_escape_string($con, $_REQUEST['status']);
    $wd1 = mysqli_real_escape_string($con, $_REQUEST['wd1']);
    $kaprodi = mysqli_real_escape_string($con, $_REQUEST['kaprodi']);
  
    $cekdata="SELECT id FROM mag_periode_pengajuan_ac WHERE ta='$ta'";
    $ada=mysqli_query($con, $cekdata) or die(mysqli_error($con));
  
    $cekta="SELECT status FROM mag_dt_ta WHERE status='1'";
    $aktif=mysqli_query($con, $cekta) or die(mysqli_error($con));
  
    if(mysqli_num_rows($ada)>0)
     { header("location:magPeriodePacAdm.php?message=notifSama"); }
    elseif(mysqli_num_rows($aktif)==0)
     { header("location:magPeriodePacAdm.php?message=notifTa"); }
    else {
     if($_POST['status']==1) {
     mysqli_query($con, "UPDATE mag_periode_pengajuan_ac SET status='2' WHERE status='1' LIMIT 1")  or die(mysqli_error($con));
     $myqry=mysqli_query($con, "INSERT INTO mag_periode_pengajuan_ac(ta,start_datetime,end_datetime,status,wd1,kaprodi) VALUES ('$ta','$start_datetime','$end_datetime','$status','$wd1','$kaprodi')");
     header("location:magPeriodePacAdm.php?page=$page&message=notifInput");}
     if($_POST['status']==2) {
     $myqry=mysqli_query($con, "INSERT INTO mag_periode_pengajuan_ac(ta,start_datetime,end_datetime,status,wd1,kaprodi) VALUES ('$ta','$start_datetime','$end_datetime','$status','$wd1','$kaprodi')");
     header("location:magPeriodePacAdm.php?page=$page&message=notifInput");}
    }
   }
   mysqli_close($con);
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
                  <li class="breadcrumb-item active">Input</li>
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
                  <form action="magInputPeriodePacBaruAdm.php" method="post" enctype="multipart/form-data">
                    <div class="card-header">
                      <h3 class="card-title">Input</h3>
                    </div>
                    <div class="card-body">
                      <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                      <input type="text" name="wd1" class="sr-only" value="<?php echo $dwd1['id'];?>" required readonly>
                      <input type="text" name="kaprodi" class="sr-only" value="<?php echo $dkaprodi['id'];?>" required readonly>
                      <input type="text" name="ta" class="sr-only" value="<?php echo $dta['id'];?>" required readonly>
                      <input type="hidden" name="new" value="1" required readonly class="sr-only" />
                      <div class="row">
                        <div class="form-group col-6">
                          <label for="start_datetime">Batas Waktu Awal <span class="text-danger">*</span></label>
                          <div class="input-group date" id="tgl_ymd_jam_one" data-target-input="nearest">
                            <input type="text" name="start_datetime" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_ymd_jam_one" required/>
                            <div class="input-group-append" data-target="#tgl_ymd_jam_one" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-6">
                          <label for="end_datetime">Batas Waktu Akhir <span class="text-danger">*</span></label>
                          <div class="input-group date" id="tgl_ymd_jam_two" data-target-input="nearest">
                            <input type="text" name="end_datetime" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_ymd_jam_two" required/>
                            <div class="input-group-append" data-target="#tgl_ymd_jam_two" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input name="status" type="radio" id="customRadioInline1" class="custom-control-input" value="1" checked>
                        <label class="custom-control-label" for="customRadioInline1">Aktifkan Periode</label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input name="status" type="radio" id="customRadioInline2" class="custom-control-input" value="2">
                        <label class="custom-control-label" for="customRadioInline2">Non Aktifkan Periode</label>
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" name="submit" class="btn btn-outline-success btn-sm float-left">Submit</button>
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