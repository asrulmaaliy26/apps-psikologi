<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $qper = "SELECT * FROM peserta_sempro WHERE id='$id'";
  $rper = mysqli_query($con, $qper)or die( mysqli_error($con));
  $dper = mysqli_fetch_assoc($rper);
  
  $qry = "SELECT * FROM dt_mhssw WHERE nim='$dper[nim]'";
  $resp = mysqli_query($con,  $qry )or die( mysqli_error($con) );
  $data = mysqli_fetch_assoc( $resp );
  
  $qidper = "SELECT * FROM pendaftaran_sempro WHERE id='$dper[id_sempro]'";
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
  
  $qjdwl = "SELECT * FROM jadwal_sempro WHERE id_pendaftaran='$id'";
  $res = mysqli_query($con,  $qjdwl )or die( mysqli_error($con) );
  $djdwl = mysqli_fetch_assoc( $res );
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
                <h6 class="m-0">Input Jadwal Seminar Proposal <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="inputJdwlSemproAdm.php?page=<?php echo $page;?>">Input Jadwal Seminar Proposal</a></li>
                  <li class="breadcrumb-item small"><a class="text-info" href="inputJadSemproPerPeriodeAdm.php?id=<?php echo $dper['id_sempro'];?>&page=<?php echo $page;?>">Input Jadwal Per Pendaftar</a></li>
                  <li class="breadcrumb-item active small">Form Input Jadwal</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <form action="updateJadSemproAdm.php" method="post">
                  <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                  <input type="text" name="id_sempro" class="sr-only" value="<?php echo $didper['id'];?>" required readonly>
                  <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                  <div class="card card-outline card-info">
                    <div class="card-header">
                      <div class="clearfix">
                        <h4 class="card-title float-left">Input Jadwal</h4>
                        <span class="badge badge-info float-right"> <?php echo $data['nama'].' / '.$data['nim'];?></span>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-4">
                          <div class="form-group">
                            <label for="tgl_seminar">Tanggal Seminar</label>
                            <div class="input-group date" id="tgl_seminar" data-target-input="nearest">
                              <input type="text" name="tgl_seminar" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_seminar" value="<?php echo $djdwl['tgl_seminar'];?>" required/>
                              <div class="input-group-append" data-target="#tgl_seminar" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-4">
                          <div class="form-group">
                            <label for="penguji1">Narasumber 1</label>
                            <select name="penguji1" class="form-control form-control-sm" id="penguji1" required>
                            <?php
                              $tampil = mysqli_query($con,  "SELECT * FROM dt_pegawai WHERE jenis_pegawai = '1' ORDER BY nama_tg ASC" );
                              while ( $w = mysqli_fetch_array( $tampil ) ) {
                                if ( $djdwl['penguji1'] == $w[ 'id' ] ) {
                                  echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                                } else {
                                  echo "<option value='$w[id]'>$w[nama_tg]</option>";
                                }
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-4">
                          <div class="form-group">
                            <label for="jam_mulai">Jam Mulai</label>
                            <div class="input-group date" id="jam_mulai" data-target-input="nearest">
                              <input type="text" name="jam_mulai" class="form-control form-control-sm datetimepicker-input" data-target="#jam_mulai" value="<?php echo $djdwl['jam_mulai'];?>" required/>
                              <div class="input-group-append" data-target="#jam_mulai" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fas fa-clock"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-4">
                          <div class="form-group">
                            <label for="ruang">Ruang</label>
                            <select name="ruang" class="form-control form-control-sm" id="ruang" required>
                            <?php
                              $tampil = mysqli_query($con,  "SELECT * FROM dt_ruang ORDER BY nm ASC" );
                              while ( $w = mysqli_fetch_array( $tampil ) ) {
                                if ( $djdwl['ruang'] == $w[ 'id' ] ) {
                                  echo "<option value='$w[id]' selected>$w[nm]</option>";
                                } else {
                                  echo "<option value='$w[id]'>$w[nm]</option>";
                                }
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-4">
                          <div class="form-group">
                            <label for="penguji2">Narasumber 2</label>
                            <select name="penguji2" class="form-control form-control-sm" id="penguji2" required>
                            <?php
                              $tampil = mysqli_query($con,  "SELECT * FROM dt_pegawai WHERE jenis_pegawai = '1' ORDER BY nama_tg ASC" );
                              while ( $w = mysqli_fetch_array( $tampil ) ) {
                                if ( $djdwl['penguji2'] == $w[ 'id' ] ) {
                                  echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
                                } else {
                                  echo "<option value='$w[id]'>$w[nama_tg]</option>";
                                }
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="col-4">
                          <div class="form-group">
                            <label for="jam_selesai">Jam Selesai</label>
                            <div class="input-group date" id="jam_selesai" data-target-input="nearest">
                              <input type="text" name="jam_selesai" class="form-control form-control-sm datetimepicker-input" data-target="#jam_selesai" value="<?php echo $djdwl['jam_selesai'];?>" required/>
                              <div class="input-group-append" data-target="#jam_selesai" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fas fa-clock"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <a href="inputJadSemproPerPeriodeAdm.php?id=<?php echo $dper['id_sempro'];?>&page=<?php echo $page;?>" class="btn btn-outline-warning btn-flat btn-sm float-left" data-dismiss="modal">Batal</a>
                      <button type="submit" class="btn btn-outline-primary btn-flat btn-sm float-right" data-dismiss="modal">Submit</button>
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
        $('#tgl_seminar').datetimepicker({
        format: 'DD-MM-YYYY',
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