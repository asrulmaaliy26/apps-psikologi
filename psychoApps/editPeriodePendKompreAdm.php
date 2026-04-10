<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $qidper = "SELECT * FROM pendaftaran_kompre WHERE id='$id'";
  $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
  $didper = mysqli_fetch_assoc($ridper);
  
  $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
  $hasil = mysqli_query($con, $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
  
  $qry_jenis_periode = "SELECT * FROM opsi_kategori_periode_kompre WHERE id='$didper[jenis_periode]'";
  $hasil = mysqli_query($con, $qry_jenis_periode);
  $djp = mysqli_fetch_assoc($hasil);
  
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$didper[ta]'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
  
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  
  $qry_grade = "SELECT * FROM grade_kompre WHERE id_kompre='$id'";
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
                <h6 class="m-0">Pendaftaran Ujian Kompre <?php echo 'Tahap '.$dthp['tahap'].' <span class="small text-secondary">'.$djp['nm'].'</span> '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="pndftrnKompreAdm.php?page=<?php echo $page;?>">Periode Pendaftaran</a></li>
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
                <form action="updatePeriodePendKompreAdm.php" method="post">
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
                        <label for="jenis_periode">Kategori Periode</label>
                        <select name="jenis_periode" class="form-control form-control-sm" id="jenis_periode" required>
                        <?php
                          $tampil = mysqli_query($con,  "SELECT * FROM opsi_kategori_periode_kompre ORDER BY nm ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $didper['jenis_periode'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nm]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nm]</option>";
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
                        <div class="form-group col-md-3">
                          <label for="at">Batas Atas Grade A</label>
                          <input type="number" max="100" name="at" class="form-control form-control-sm" value="<?php echo $dt_grade['at'];?>" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="ab">Batas Bawah Grade A</label>
                          <input type="number" name="ab" class="form-control form-control-sm" value="<?php echo $dt_grade['ab'];?>" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="bplust">Batas Atas Grade B+</label>
                          <input type="number" name="bplust" class="form-control form-control-sm" value="<?php echo $dt_grade['bplust'];?>" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="bplusb">Batas Bawah Grade B+</label>
                          <input type="number" name="bplusb" class="form-control form-control-sm" value="<?php echo $dt_grade['bplusb'];?>" required>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label for="bt">Batas Atas Grade B</label>
                          <input type="number" name="bt" class="form-control form-control-sm" value="<?php echo $dt_grade['bt'];?>" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="bb">Batas Bawah Grade B</label>
                          <input type="number" name="bb" class="form-control form-control-sm" value="<?php echo $dt_grade['bb'];?>" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="cplust">Batas Atas Grade C+</label>
                          <input type="number" name="cplust" class="form-control form-control-sm" value="<?php echo $dt_grade['cplust'];?>" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="cplusb">Batas Bawah Grade C+</label>
                          <input type="number" name="cplusb" class="form-control form-control-sm" value="<?php echo $dt_grade['cplusb'];?>" required>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label for="ct">Batas Atas Grade C</label>
                          <input type="number" name="ct" class="form-control form-control-sm" value="<?php echo $dt_grade['ct'];?>" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="cb">Batas Bawah Grade C</label>
                          <input type="number" name="cb" class="form-control form-control-sm" value="<?php echo $dt_grade['cb'];?>" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="dt">Batas Atas Grade D</label>
                          <input type="number" name="dt" class="form-control form-control-sm" value="<?php echo $dt_grade['dt'];?>" required>
                        </div>
                        <div class="form-group col-md-3">
                          <label for="db">Batas Bawah Grade D</label>
                          <input type="number" min="1" name="db" class="form-control form-control-sm" value="<?php echo $dt_grade['db'];?>" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="passing_grade">Passing Grade yang Ditentukan</label>
                        <input type="number" name="passing_grade" class="form-control form-control-sm" value="<?php echo $didper['passing_grade'];?>" required>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input name="status" type="radio" id="customRadioInline1" class="custom-control-input" value="1" <?php if($didper['status'] == '1') echo 'checked';?>>
                        <label class="custom-control-label" for="customRadioInline1">Aktifkan</label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input name="status" type="radio" id="customRadioInline2" class="custom-control-input" value="2" <?php if($didper['status'] == '2') echo 'checked';?>>
                        <label class="custom-control-label" for="customRadioInline2">Non Aktifkan</label>
                      </div>
                    </div>
                    <div class="card-footer">
                      <a href="pndftrnKompreAdm.php?page=<?php echo "$page";?>" class="btn btn-outline-warning btn-flat btn-sm float-left" data-dismiss="modal">Batal</a>
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