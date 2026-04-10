<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $qidjdwl = "SELECT * FROM jadwal_ujskrip WHERE id='$id'";
  $ridjdwl = mysqli_query($con, $qidjdwl)or die( mysqli_error($con));
  $didjdwl = mysqli_fetch_assoc($ridjdwl);

  $qidper = "SELECT * FROM pendaftaran_skripsi WHERE id='$didjdwl[id_ujskrip]'";
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
      <title>Jadwal Ujian Skripsi <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></title>
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
         width: 320px;
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
         $jdwl = "SELECT * FROM jadwal_ujskrip WHERE id='$id'";
         $rjdwl = mysqli_query($con,  $jdwl )or die( mysqli_error($con) );
         while($djdwl = mysqli_fetch_assoc( $rjdwl )) {
         
         $qryperiod = "SELECT * FROM pendaftaran_skripsi WHERE id='$djdwl[id_ujskrip]'";
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
         $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
         'September','Oktober','Nopember','Desember');
         $split = explode('-', $tanggal);
         return $split[0] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[2];
         }'
         <div class="page">';   
            include("kopPotretUser.php");
            include("extCetakJadwalUjskrip1User.php");
            include("extCetakJadwalUjskrip2User.php");
            include("extCetakJadwalUjskrip3User.php");'
            ';}'      
         </div>';?>
      <?php include( "jsAdm.php" );?>
      <script type="text/javascript">
         $(document).ready(function() {
            window.print();
            window.close(); 
         });
      </script>
   </body>
</html>