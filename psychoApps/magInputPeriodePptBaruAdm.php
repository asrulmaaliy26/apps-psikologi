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
    $id = mysqli_real_escape_string($con, $_REQUEST['tahap'].''.$_REQUEST['ta']);
    $tahap = mysqli_real_escape_string($con, $_REQUEST['tahap']);
    $ta = mysqli_real_escape_string($con, $_REQUEST['ta']);
    $syarat_sks = mysqli_real_escape_string($con, $_REQUEST['syarat_sks']);
    $start_datetime = mysqli_real_escape_string($con, $_REQUEST['start_datetime']);
    $end_datetime = mysqli_real_escape_string($con, $_REQUEST['end_datetime']);
    $status = mysqli_real_escape_string($con, $_REQUEST['status']);
    $wd1 = mysqli_real_escape_string($con, $_REQUEST['wd1']);
    $kaprodi = mysqli_real_escape_string($con, $_REQUEST['kaprodi']);
  
    $cekdata="SELECT id FROM mag_periode_pengajuan_dospem WHERE id='$id'";
    $ada=mysqli_query($con, $cekdata) or die(mysqli_error($con));
  
    $cekta="SELECT status FROM mag_dt_ta WHERE status='1'";
    $aktif=mysqli_query($con, $cekta) or die(mysqli_error($con));
  
    if(mysqli_num_rows($ada)>0)
     { header("location:magPeriodePptAdm.php?message=notifSama"); }
    elseif(mysqli_num_rows($aktif)==0)
     { header("location:magPeriodePptAdm.php?message=notifTa"); }
    else {
     if($_POST['status']==1) {
     mysqli_query($con, "UPDATE mag_periode_pengajuan_dospem SET status='2' WHERE status='1' LIMIT 1")  or die(mysqli_error($con));
     $myqry=mysqli_query($con, "INSERT INTO mag_periode_pengajuan_dospem(id,tahap,ta,start_datetime,end_datetime,syarat_sks,status,wd1,kaprodi) VALUES ('$id','$tahap','$ta','$start_datetime','$end_datetime','$syarat_sks','$status','$wd1','$kaprodi')");
     header("location:magPeriodePptAdm.php?page=$page&message=notifInput");}
     if($_POST['status']==2) {
     $myqry=mysqli_query($con, "INSERT INTO mag_periode_pengajuan_dospem(id,tahap,ta,start_datetime,end_datetime,syarat_sks,status,wd1,kaprodi) VALUES ('$id','$tahap','$ta','$start_datetime','$end_datetime','$syarat_sks','$status','$wd1','$kaprodi')");
     header("location:magPeriodePptAdm.php?page=$page&message=notifInput");}
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
                <h4 class="m-0">Pengajuan Dosen Pembimbing Tesis</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                  <li class="breadcrumb-item"><a href="magPeriodePptAdm.php?page=<?php echo $page;?>">Periode Pengajuan</a></li>
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
                  <form action="magInputPeriodePptBaruAdm.php" method="post" enctype="multipart/form-data">
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
                          <label for="tahap">Tahap <span class="text-danger">*</span></label>
                          <?php echo "<select name='tahap' class='form-control form-control-sm' required/>";
                            echo "<option value=''>-Pilih-</option>";
                            $tampil=mysqli_query($con, "SELECT * FROM mag_opsi_tahap_ujprop_ujtes ORDER BY tahap ASC");
                            while($w=mysqli_fetch_array($tampil)){
                              echo "<option value='$w[id]'>$w[tahap]</option>";
                            }
                            echo "</select>";
                             ?>
                        </div>
                        <div class="form-group col-6">
                          <label for="syarat_sks">Syarat SKS <span class="text-danger">*</span></label>
                          <input type="number" min="1" max="100" name="syarat_sks" class="form-control form-control-sm" required/>
                        </div>
                      </div>
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