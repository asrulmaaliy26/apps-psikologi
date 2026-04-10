<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $qper = "SELECT * FROM peserta_ujskrip WHERE id='$id'";
  $rper = mysqli_query($con, $qper)or die( mysqli_error($con));
  $dper = mysqli_fetch_assoc($rper);
  $id_ujskrip = $dper['id_ujskrip'];

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
        include( "navSideBarUserS1.php" );
        ?> 
      <div class="content-wrapper">
        <?php include( "alertUser.php" );?>
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-4">
                <h1 class="m-0 float-left">Pendaftaran</h1>
              </div>
              <div class="col-sm-8">
                <ol class="mt-2 breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Ujian Skripsi</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm">
                <div class="card card-success card-outline card-outline-tabs">
                  <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link" href="prePendaftaranUjianSkripsiUser.php" role="tab" aria-selected="true">Form</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="riwayatPendaftaranUjianSkripsiUser.php" role="tab" aria-selected="true">Riwayat</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link active" href="jadwalUjskripUser.php?id=<?php echo $id;?>" role="tab" aria-selected="true">Jadwal</a>
                        </li>
                    </ul>
                  </div>
                  <div class="card-body pl-0 pr-0 pb-0">
                   <?php
                      $sql = "SELECT * FROM jadwal_ujskrip WHERE id_ujskrip='$id_ujskrip' GROUP BY tgl_ujian ORDER BY tgl_ujian ASC";
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
                      include("tableHariRuangUjskripUser.php");
                      include("extConJadUjskripUser.php");'
               ';}?>
               </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>