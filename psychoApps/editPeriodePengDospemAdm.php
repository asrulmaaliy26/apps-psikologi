<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $myquery = "SELECT * FROM pengajuan_dospem WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );
  
  $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$dataku[tahap]'";
  $hasil = mysqli_query($con, $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
  
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$dataku[ta]'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
  
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
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
                <h6 class="m-0">Pengajuan Dospem Skripsi <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="pngjnDospemAdm.php?page=<?php echo $page;?>">Periode Pengajuan</a></li>
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
                <form action="updatePeriodePengDospemAdm.php" method="post">
                  <input type="text" name="id" class="sr-only" value="<?php echo $dataku['id'];?>" required readonly>
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
                            if ( $dataku['tahap'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[tahap]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[tahap]</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="start_datetime">Waktu Awal Pengajuan</label>
                        <div class="input-group date" id="start_datetime_edit" data-target-input="nearest">
                          <input type="text" name="start_datetime" class="form-control form-control-sm datetimepicker-input" data-target="#start_datetime_edit" value="<?php echo $dataku['start_datetime'];?>" required/>
                          <div class="input-group-append" data-target="#start_datetime_edit" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="end_datetime">Waktu Akhir Pengajuan</label>
                        <div class="input-group date" id="end_datetime_edit" data-target-input="nearest">
                          <input type="text" name="end_datetime" class="form-control form-control-sm datetimepicker-input" data-target="#end_datetime_edit" value="<?php echo $dataku['end_datetime'];?>" required/>
                          <div class="input-group-append" data-target="#end_datetime_edit" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="syarat_sks">Syarat SKS yang Harus Ditempuh</label>
                        <input type="number" name="syarat_sks" class="form-control form-control-sm" value="<?php echo $dataku['syarat_sks'];?>" required>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input name="status" type="radio" id="customRadioInline1" class="custom-control-input" value="1" <?php if($dataku['status'] == '1') echo 'checked';?>>
                        <label class="custom-control-label" for="customRadioInline1">Aktifkan</label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input name="status" type="radio" id="customRadioInline2" class="custom-control-input" value="2" <?php if($dataku['status'] == '2') echo 'checked';?>>
                        <label class="custom-control-label" for="customRadioInline2">Non Aktifkan</label>
                      </div>
                    </div>
                    <div class="card-footer">
                      <a href="pngjnDospemAdm.php?page=<?php echo "$page";?>" class="btn btn-outline-warning btn-flat btn-sm float-left" data-dismiss="modal">Batal</a>
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