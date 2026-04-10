<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Simagis</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      table.tgl {
      border-collapse: collapse;
      }
      table.tgl td {
      border:none;
      padding: 2px;
      }
      table.jadwal {
      border: 1px solid black;
      border-collapse:collapse;
      }
      table.jadwal th, td {
      border:1px solid black;
      padding: 6px;
      text-align:left;
      }
      .right {
      float: right;
      width: 420px;
      }
      @media print {
      div.page
      {
      page-break-after: always;
      page-break-inside: avoid;
      }
      }
    </style>
  </head>
  <body style="font-family:Arial, Helvetica, sans-serif; font-size:16px;">
    <?php 
      $jdwl = "select * from mag_jadwal_ujtes WHERE id='$id'";
      $rjdwl = mysqli_query($GLOBALS["___mysqli_ston"],  $jdwl )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
      while($djdwl = mysqli_fetch_assoc( $rjdwl )) {
      
      $qryperiod = "select * from mag_periode_pendaftaran_ujtes WHERE id='$djdwl[id_ujtes]'";
      $rperiod = mysqli_query($GLOBALS["___mysqli_ston"], $qryperiod)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
      $dperiod = mysqli_fetch_assoc($rperiod);
      $thp = $dperiod['tahap'];
      $ta = $dperiod['ta'];
      $kaprodi=$dperiod['kaprodi'];
      
      $qry_nm_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$thp'";
      $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_thp);
      $dthp = mysqli_fetch_assoc($hasil);
      
      $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$ta'";
      $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
      $dnta = mysqli_fetch_assoc($hasil);
      
      $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
      $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
      $dsemester = mysqli_fetch_assoc($h);
      
      $qkaprodi="select * from dt_pegawai WHERE id='$kaprodi'";
      $reskaprodi=mysqli_query($GLOBALS["___mysqli_ston"], $qkaprodi) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
      $dkaprodi=mysqli_fetch_assoc($reskaprodi);
      
      $qjkaprodi="select * from opsi_jabatan WHERE id='$dkaprodi[jabatan]'";
      $resjkaprodi=mysqli_query($GLOBALS["___mysqli_ston"], $qjkaprodi) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
      $djkaprodi=mysqli_fetch_assoc($resjkaprodi);
      
      $qjikaprodi="select * from opsi_jabatan_instansi WHERE id='$dkaprodi[jabatan_instansi]'";
      $resjikaprodi=mysqli_query($GLOBALS["___mysqli_ston"], $qjikaprodi) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
      $djikaprodi=mysqli_fetch_assoc($resjikaprodi);
      
      $qkdkaprodi="select * from dekanat WHERE id='2'";
      $reskdkaprodi=mysqli_query($GLOBALS["___mysqli_ston"], $qkdkaprodi) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
      $dkdkaprodi=mysqli_fetch_assoc($reskdkaprodi);
      
      function bulanIndo($tanggal)
      {
      $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
      'September','Oktober','Nopember','Desember');
      $split = explode('-', $tanggal);
      return $split[0] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[2];
      }'
      <div class="page">';   
         include("kopPotret.php");
         include("extCetakJadwalUjtes1.php");
         include("extCetakJadwalUjtes2.php");
         include("extCetakJadwalUjtes3.php");'
         ';}'      
      </div>';?>
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
         window.print();
         window.close(); 
      });
    </script>
  </body>
</html>