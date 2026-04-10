<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $id_sempro = mysqli_real_escape_string($con,  $_GET[ 'id_sempro' ] );
  $tgl_seminar = mysqli_real_escape_string($con,  $_GET[ 'tgl_seminar' ] );
  
  $qidjdwl = "SELECT * FROM jadwal_sempro WHERE penguji1='$id' AND id_sempro='$id_sempro'";
  $ridjdwl = mysqli_query($con, $qidjdwl)or die( mysqli_error($con));
  $didjdwl = mysqli_fetch_assoc($ridjdwl);

  $qpenguji = "SELECT * FROM dt_pegawai WHERE id='$didjdwl[penguji1]'";
  $rqpenguji = mysqli_query($con, $qpenguji)or die( mysqli_error($con));
  $dqpenguji = mysqli_fetch_assoc($rqpenguji);

  $qidper = "SELECT * FROM pendaftaran_sempro WHERE id='$didjdwl[id_sempro]'";
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

  $qwd1 = "SELECT * FROM dt_pegawai WHERE id='$didper[wd1]'";
  $rwd1 = mysqli_query($con, $qwd1)or die( mysqli_error($con));
  $dwd1 = mysqli_fetch_assoc($rwd1);   
   
  $qkaprodi = "SELECT * FROM dt_pegawai WHERE id='$didper[kajur]'";
  $rkaprodi = mysqli_query($con, $qkaprodi)or die( mysqli_error($con));
  $dkaprodi = mysqli_fetch_assoc($rkaprodi);
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Jadwal Seminar Proposal <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].' '.$dqpenguji['nama_tg'].'';?></title>
    <meta charset="utf-8">
    <style>
      table {
      border-collapse: collapse;
      }
      table, th, td {
      border: 1px solid black;
      }
      th, td {
      padding: 10px;
      }
      .right {
      float: right;
      position:relative;
      width: 260px;
      margin-bottom:20px;
      }
    </style>
  <body>
    <?php
      header("Content-type: application/vnd-ms-excel");
      header('Content-Disposition: attachment; filename=Jadwal Seminar Proposal Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].' '.$dqpenguji['nama_tg'].'.xls');

      $jdwl = "SELECT * FROM jadwal_sempro WHERE penguji1='$id' AND id_sempro='$id_sempro' AND tgl_seminar='$tgl_seminar'";
      $rjdwl = mysqli_query($con,  $jdwl )or die( mysqli_error($con) );
      $djdwl = mysqli_fetch_assoc( $rjdwl );
         
      $qpenguji = "SELECT * FROM dt_pegawai WHERE id='$djdwl[penguji1]'";
      $rqpenguji = mysqli_query($con, $qpenguji)or die( mysqli_error($con));
      $dqpenguji = mysqli_fetch_assoc($rqpenguji);

      $qryperiod = "SELECT * FROM pendaftaran_sempro WHERE id='$djdwl[id_sempro]'";
      $rperiod = mysqli_query($con, $qryperiod)or die( mysqli_error($con));
      $dperiod = mysqli_fetch_assoc($rperiod);
      $thp = $dperiod['tahap'];
      $ta = $dperiod['ta'];
      $kajur=$dperiod['kajur'];
         
      $qry_nm_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$thp'";
      $hasil = mysqli_query($con, $qry_nm_thp);
      $dthp = mysqli_fetch_assoc($hasil);
         
      $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$ta'";
      $hasil = mysqli_query($con, $qry_nm_ta);
      $dnta = mysqli_fetch_assoc($hasil);
     
      $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
      $h = mysqli_query($con, $qry_nm_smt);
      $dsemester = mysqli_fetch_assoc($h);
         
      function bulanIndo($tanggal)
        {
          $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
          $split = explode('-', $tanggal);
            return $split[0] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[2];
         }

      include("extEksporJadwalSempro1Penguji1.php");
      include("extEksporJadwalSempro2Penguji1.php");
      include("extEksporJadwalSempro3Penguji1.php");?>

    <?php include( "jsAdm.php" );?>
    <script type="text/javascript">
      $(document).ready(function() {
         window.close(); 
      });
    </script>
  </body>
</html>