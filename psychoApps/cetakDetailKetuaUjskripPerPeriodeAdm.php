<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $id_ujskrip = mysqli_real_escape_string($con,  $_GET[ 'id_ujskrip' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  $page0 = mysqli_real_escape_string($con,  $_GET[ 'page0' ] );
  
  $qpenguji = "SELECT * FROM dt_pegawai WHERE id='$id'";
  $rqpenguji = mysqli_query($con, $qpenguji)or die( mysqli_error($con));
  $dqpenguji = mysqli_fetch_assoc($rqpenguji);

  $qper = "SELECT * FROM peserta_ujskrip WHERE id_ujskrip='$id_ujskrip'";
  $rper = mysqli_query($con, $qper)or die( mysqli_error($con));
  $dper = mysqli_fetch_assoc($rper);
  
  $qidper = "SELECT * FROM pendaftaran_skripsi WHERE id='$id_ujskrip'";
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

  function bulanIndo($tanggal)
  {
   $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
   'September','Oktober','Nopember','Desember');
   $split = explode('-', $tanggal);
   return $split[0] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[2];
  }
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
                <h6 class="m-0">Penguji Ujian Skripsi</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="rekapPengujiUjskripAdm.php?page=<?php echo $page;?>">Penguji Ujian Skripsi</a></li>
                  <li class="breadcrumb-item small"><a class="text-info" href="rekapKetuaUjskripAdm.php?id=<?php echo $id;?>&page=<?php echo $page;?>&page0=<?php echo $page0;?>">Ketua Penguji</a></li>
                  <li class="breadcrumb-item active small">Cetak Ketua Penguji <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Cetak Ketua Penguji <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h4>
                      <span class="badge badge-info float-right"> <?php echo $dqpenguji['nama'];?></span>
                    </div>
                  </div>
                  <div class="card-body p-0">
                   <?php
                      $sql = "SELECT * FROM jadwal_ujskrip WHERE ketua_penguji='$id' AND id_ujskrip='$id_ujskrip' GROUP BY tgl_ujian ORDER BY tgl_ujian ASC";
                      $result = mysqli_query($con, $sql);
                      while($data = mysqli_fetch_array($result)) {
                            
                      $formatTgl=date("d-m-Y", strtotime($data['tgl_ujian']));
                      $day = date('D', strtotime($formatTgl));
                      $dayList = array(
                        'Sun' => 'Minggu',
                        'Mon' => 'Senin',
                        'Tue' => 'Selasa',
                        'Wed' => 'Rabu',
                        'Thu' => 'Kamis',
                        'Fri' => "Jum'at",
                        'Sat' => 'Sabtu'
                      );

                      $qry_ruang = "SELECT * FROM dt_ruang WHERE id='$data[ruang]'";
                      $res_ruang = mysqli_query($con, $qry_ruang);
                      $dt_ruang = mysqli_fetch_assoc($res_ruang);
                      include("tableHariRuangUjskripKetuaCetak.php");
                      include("extConJadUjskripKetuaCetak.php");'
                      ';}?>
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