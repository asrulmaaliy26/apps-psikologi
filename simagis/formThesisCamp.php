<?php
  include("koneksiUser.php");
  $nim = $_SESSION['nim'];
  
  $myquery = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
  $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  $qry_moment = "SELECT * FROM mag_periode_thesis_camp WHERE status='1'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_tc=$data['id'];
  $ta=$data['ta'];
  
  $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$ta'";
  $hasil_ta = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil_ta);
  
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  
  // Semester Calculation
  $current_year = (int)$dnta['ta'];
  $current_smt_type = (int)$dnta['semester']; // 1: Ganjil, 2: Genap
  $entry_year = (int)$dataku['angkatan'];
  $entry_smt = (int)$dataku['smt_daftar']; // 1: Ganjil, 2: Genap
  
  $smt_calculated = ($current_year - $entry_year) * 2 + $current_smt_type - ($entry_smt - 1);
  
  $DATE_NOW=date("Y-m-d H:i:s");
  $START_DATE=$data['start_datetime']; 
  $END_DATE=$data['end_datetime'];
  ?>
<html lang="en">
  <head>
    <?php include 'headUser.php';?>
  </head>
  <body>
    <?php include "navPendUser.php";?>
    <div class="container">
      <div class="row">
        <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
                 echo '<div class="alert alert-success custom-alert" role="alert">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Submit berhasil...</div>';}
                 ?>
        <h3 class="text-center text-info">Thesis Camp</h3>
        <?php         
          if(!$id_tc || $DATE_NOW < $START_DATE) {echo 
          "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-danger text-center'>Maaf... <br />Pendaftaran Thesis Camp <br />
          Semester ".$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Belum Dibuka!</strong></p>
          </div>";
          include "includeRekapThesisCampUser.php";
          }
          else if($DATE_NOW > $END_DATE) {echo 
          "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-danger text-center'>Maaf... <br />Pendaftaran Thesis Camp <br />
          Semester ".$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Telah Ditutup!</strong></p>
          </div>";
          include "includeRekapThesisCampUser.php";
          }
          
          else {
          $qry_cek_daftar = "SELECT COUNT(id) AS jum FROM mag_peserta_thesis_camp WHERE id_periode_thesis_camp='$id_tc' AND nim='$nim'";
          $res_cek = mysqli_query($GLOBALS["___mysqli_ston"], $qry_cek_daftar);
          $dcek = mysqli_fetch_assoc($res_cek);
          $jum=$dcek['jum'];
          
          if($jum>0) { 
            include "includeRekapThesisCampUser.php";
          } else {
            include "includeFormThesisCamp.php";
          }
          }
          ?>    
      </div>
    </div>
    <?php include "footerUser.php";?>
    <?php include "jsSourceUser.php";?>
  </body>
</html>
