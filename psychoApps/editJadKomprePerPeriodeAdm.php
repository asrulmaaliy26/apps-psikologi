<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $id_kompre = mysqli_real_escape_string($con,  $_GET[ 'id_kompre' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $qidper = "SELECT * FROM pendaftaran_kompre WHERE id='$id_kompre'";
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
  
  $qjadwal = "SELECT * FROM jadwal_kompre WHERE id='$id'";
  $rjadwal = mysqli_query($con, $qjadwal)or die( mysqli_error($con));
  $djadwal = mysqli_fetch_assoc($rjadwal);
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
                <li class="breadcrumb-item small"><a class="text-info" href="jadKomprePerPeriodeAdm.php?id=<?php echo $id_kompre;?>&page=<?php echo $page;?>">Jadwal Ujian</a></li>
                <li class="breadcrumb-item active small">Edit Jadwal</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <form action="updateJadKomprePerPeriodeAdm.php" method="post">
                   <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                   <input type="text" name="id_kompre" class="sr-only" value="<?php echo $id_kompre;?>" required readonly>
                   <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                  <div class="card card-outline card-info">
                    <div class="card-header">
                      <div class="clearfix">
                        <h4 class="card-title float-left">Edit Jadwal</h4>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label for="pengawas1">Pengawas I</label>
                        <select name="pengawas1" class="form-control form-control-sm" id="pengawas1" required>
                        <?php
                          $tampil = mysqli_query($con,  "SELECT * FROM dt_pengawas_kompre ORDER BY nm ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $djadwal['pengawas1'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nm]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nm]</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="pengawas2">Pengawas II</label>
                        <select name="pengawas2" class="form-control form-control-sm" id="pengawas2" required>
                        <?php
                          $tampil = mysqli_query($con,  "SELECT * FROM dt_pengawas_kompre ORDER BY nm ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $djadwal['pengawas2'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nm]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nm]</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="ruang">Ruang</label>
                        <select name="ruang" class="form-control form-control-sm" id="ruang" required>
                        <?php
                          $tampil = mysqli_query($con,  "SELECT * FROM dt_ruang ORDER BY nm ASC" );
                          while ( $w = mysqli_fetch_array( $tampil ) ) {
                            if ( $djadwal['ruang'] == $w[ 'id' ] ) {
                              echo "<option value='$w[id]' selected>$w[nm]</option>";
                            } else {
                              echo "<option value='$w[id]'>$w[nm]</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="tgl_kompre">Tanggal Kompre</label>
                        <div class="input-group date" id="tgl_kompre" data-target-input="nearest">
                          <input type="text" name="tgl_kompre" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_kompre" value="<?php echo $djadwal['tgl_kompre'];?>" required/>
                          <div class="input-group-append" data-target="#tgl_kompre" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="jam_mulai">Jam Mulai</label>
                        <div class="input-group date" id="jam_mulai" data-target-input="nearest">
                          <input type="text" name="jam_mulai" class="form-control form-control-sm datetimepicker-input" data-target="#jam_mulai" value="<?php echo $djadwal['jam_mulai'];?>" required/>
                          <div class="input-group-append" data-target="#jam_mulai" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-clock"></i></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="jam_selesai">Jam Selesai</label>
                        <div class="input-group date" id="jam_selesai" data-target-input="nearest">
                          <input type="text" name="jam_selesai" class="form-control form-control-sm datetimepicker-input" data-target="#jam_selesai" value="<?php echo $djadwal['jam_selesai'];?>" required/>
                          <div class="input-group-append" data-target="#jam_selesai" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fas fa-clock"></i></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <a href="jadKomprePerPeriodeAdm.php?id=<?php echo $id_kompre;?>&page=<?php echo $page;?>" class="btn btn-outline-warning btn-flat btn-sm float-left" data-dismiss="modal">Batal</a>
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
        $('#tgl_kompre').datetimepicker({
        format: 'YYYY-MM-DD',
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
        $('#jam_mulai').datetimepicker({
        format: 'HH:mm',
        icons: {
        time: "fas fa-clock",
        up: "fas fa-chevron-up",
        down: "fas fa-chevron-down"
        }
        });
        });

      $(function () {
        $('#jam_selesai').datetimepicker({
        format: 'HH:mm',
        icons: {
        time: "fas fa-clock",
        up: "fas fa-chevron-up",
        down: "fas fa-chevron-down"
        }
        });
        });
    </script>
  </body>
</html>