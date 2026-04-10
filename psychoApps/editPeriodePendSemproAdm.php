<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $qidper = "SELECT * FROM pendaftaran_sempro WHERE id='$id'";
  $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
  $didper = mysqli_fetch_assoc($ridper);
  
  $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
  $hasil = mysqli_query($con, $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
   
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$didper[ta]'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
  
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  
  $qry_grade = "SELECT * FROM grade_sempro WHERE id_sempro='$id'";
  $res_grade = mysqli_query($con, $qry_grade);
  $dt_grade = mysqli_fetch_assoc($res_grade);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php
        include( "navtopAdm.php" );
        include( "navSideBarAdmBakS1.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Pendaftaran Sempro Skripsi <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="pndftrnSemproAdm.php?page=<?php echo $page;?>">Periode Pendaftaran</a></li>
                  <li class="breadcrumb-item active small">Edit Periode</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <form action="updatePeriodePendSemproAdm.php" method="post">
                  <input type="text" name="id" class="sr-only" value="<?php echo $didper['id'];?>" required readonly>
                  <input type="text" name="ta" class="sr-only" value="<?php echo $dnta['id'];?>" required readonly>
                  <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                  <div class="card card-outline card-info">
                    <div class="card-header">
                      <div class="clearfix">
                        <h4 class="card-title float-left">Edit Periode</h4>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label for="tahap">Tahap</label>
                        <select name="tahap" class="form-control form-control-sm" id="tahap" required>
                        <?php
                          $tampil = mysqli_query($con,  "SELECT * FROM opsi_tahap_ujprop_ujskrip ORDER BY tahap ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $didper['tahap'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[tahap]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[tahap]</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="start_datetime">Waktu Awal Pendaftaran</label>
                        <div class="input-group date" id="start_datetime_edit" data-target-input="nearest">
                          <input type="text" name="start_datetime" class="form-control form-control-sm datetimepicker-input" data-target="#start_datetime_edit" value="<?php echo $didper['start_datetime'];?>" required/>
                          <div class="input-group-append" data-target="#start_datetime_edit" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="end_datetime">Waktu Akhir Pendaftaran</label>
                        <div class="input-group date" id="end_datetime_edit" data-target-input="nearest">
                          <input type="text" name="end_datetime" class="form-control form-control-sm datetimepicker-input" data-target="#end_datetime_edit" value="<?php echo $didper['end_datetime'];?>" required/>
                          <div class="input-group-append" data-target="#end_datetime_edit" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="syarat_sks">Syarat SKS yang Harus Ditempuh</label>
                        <input type="number" name="syarat_sks" class="form-control form-control-sm" value="<?php echo $didper['syarat_sks'];?>" required>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="lt">Batas Atas Grade Lulus</label>
                          <input type="number" max="100" step=".0001" name="lt" class="form-control form-control-sm" value="<?php echo $dt_grade['lt'];?>" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="lb">Batas Bawah Grade Lulus</label>
                          <input type="number" step=".0001" name="lb" class="form-control form-control-sm" value="<?php echo $dt_grade['lb'];?>" required>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="lrt">Batas Atas Grade Lulus Revisi</label>
                          <input type="number" step=".0001" name="lrt" class="form-control form-control-sm" value="<?php echo $dt_grade['lrt'];?>" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="lrb">Batas Bawah Grade Lulus Revisi</label>
                          <input type="number" step=".0001" name="lrb" class="form-control form-control-sm" value="<?php echo $dt_grade['lrb'];?>" required>
                        </div>
                      </div>
                      <div class="form-row">                        
                        <div class="form-group col-md-6">
                          <label for="sut">Batas Atas Grade Seminar Ulang</label>
                          <input type="number" step=".0001" name="sut" class="form-control form-control-sm" value="<?php echo $dt_grade['sut'];?>" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="sub">Batas Bawah Grade Seminar Ulang</label>
                          <input type="number" step=".0001" name="sub" class="form-control form-control-sm" value="<?php echo $dt_grade['sub'];?>" required>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <a href="pndftrnSemproAdm.php?page=<?php echo "$page";?>" class="btn btn-outline-warning btn-flat btn-sm float-left" data-dismiss="modal">Batal</a>
                      <button type="submit" class="btn btn-outline-primary btn-flat btn-sm float-right" data-dismiss="modal">Update</button>
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
    <script type="text/javascript">
      $(function () {
        $('#start_datetime_edit').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        icons: {
        time: "fas fa-clock",
        date: "fas fa-calendar-alt",
        up: "fas fa-chevron-up",
        down: "fas fa-chevron-down",
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right'
        }
        });
        });
        $(function () {
        $('#end_datetime_edit').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        icons: {
        time: "fas fa-clock",
        date: "fas fa-calendar-alt",
        up: "fas fa-chevron-up",
        down: "fas fa-chevron-down",
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right'
        }
        });
        });   
    </script>
  </body>
</html>