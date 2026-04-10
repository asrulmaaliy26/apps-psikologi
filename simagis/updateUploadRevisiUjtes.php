<?php
  include("koneksiUser.php");
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $nim = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
  $judul_tesis = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['judul_tesis']);
  $variable_x1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['variable_x1']);
  $variable_x2 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['variable_x2']);
  $variable_x3 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['variable_x3']);
  $variable_y1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['variable_y1']);
  $variable_y2 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['variable_y2']);
  $variable_y3 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['variable_y3']);
  $co_variable_1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['co_variable_1']);
  $co_variable_2 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['co_variable_2']);
  $co_variable_3 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['co_variable_3']);
  $mediator = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['mediator']);
  $moderator = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['moderator']);
  $jns_penel = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['jns_penel']);
  $jns_alat_ukur = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['jns_alat_ukur']);
  $keyword_1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['keyword_1']);
  $keyword_2 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['keyword_2']);
  $keyword_3 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['keyword_3']);
  $keyword_4 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['keyword_4']);
  $link_pub = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['link_pub']);
  $file_tesis = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_tesis']);
  $file_form_revisi = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_form_revisi']);
  $tgl_upload = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_upload']);
  $thn_upload = date('Y');
  
  $jenis_berkas = $_FILES['file_tesis']['type'];
    if ($jenis_berkas == "application/pdf") {
    $myquery = "select * from mag_revisi_tesis WHERE id='$id'";
    $r = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
    $dt = mysqli_fetch_assoc( $r );
    $id_ujtes=$dt['id_ujtes'];
    $date=strtotime('now');
    $namafolder = "file_revisi_tesis/";
      $temp = explode(".", $_FILES["file_tesis"]["name"]);
      $nama_baru = $nim . '-' . $id_ujtes . '_revisi-tesis_'.$date. '.' . end($temp);
      $file_tesis = $namafolder . $nama_baru;
      move_uploaded_file($_FILES['file_tesis']['tmp_name'], $namafolder . '/' . $nama_baru);
    
        $res = mysqli_query($GLOBALS["___mysqli_ston"], "select file_tesis from mag_revisi_tesis where id='$id' LIMIT 1");
         $d=mysqli_fetch_assoc($res);
         if (strlen($d['file_tesis'])>3)
         {
          if (file_exists($d['file_tesis'])) unlink($d['file_tesis']);
         }
         mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_revisi_tesis SET file_tesis='$file_tesis' WHERE id='$id' LIMIT 1");
    } else {
      header("location:formRevisiTesis.php?message=notifGagal");
    }
  
    $j_berkas = $_FILES['file_form_revisi']['type'];
    if ($j_berkas == "application/pdf") {
    $myquery2 = "select * from mag_revisi_tesis WHERE id='$id'";
    $r2 = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery2 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
    $dt2 = mysqli_fetch_assoc( $r2 );
    $id_ujtes2=$dt2['id_ujtes'];
    $date2=strtotime('now');
    $nmfold = "file_form_revisi_tesis/";
      $temp_form_revisi = explode(".", $_FILES["file_form_revisi"]["name"]);
      $nname = $nim . '-' . $id_ujtes2 . '_form-revisi-tesis_'.$date2. '.' . end($temp_form_revisi);
      $file_form_revisi = $nmfold . $nname;
      move_uploaded_file($_FILES['file_form_revisi']['tmp_name'], $nmfold . '/' . $nname);
    
        $res2 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_form_revisi from mag_revisi_tesis where id='$id' LIMIT 1");
         $d2=mysqli_fetch_assoc($res2);
         if (strlen($d2['file_form_revisi'])>3)
         {
          if (file_exists($d2['file_form_revisi'])) unlink($d2['file_form_revisi']);
         }
         mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_revisi_tesis SET file_form_revisi='$file_form_revisi' WHERE id='$id' LIMIT 1");
    } else {
      header("location:formRevisiTesis.php?message=notifGagal");
    }
  
  $myqry="UPDATE mag_revisi_tesis SET judul_tesis='$judul_tesis',variable_x1='$variable_x1',variable_x2='$variable_x2',variable_x3='$variable_x3',variable_y1='$variable_y1',variable_y2='$variable_y2',variable_y3='$variable_y3',co_variable_1='$co_variable_1',co_variable_2='$co_variable_2',co_variable_3='$co_variable_3',mediator='$mediator',moderator='$moderator',jns_penel='$jns_penel',jns_alat_ukur='$jns_alat_ukur',keyword_1='$keyword_1',keyword_2='$keyword_2',keyword_3='$keyword_3',keyword_4='$keyword_4',link_pub='$link_pub',tgl_upload='$tgl_upload',thn_upload='$thn_upload' WHERE id='$id' LIMIT 1";
    mysqli_query($GLOBALS["___mysqli_ston"], $myqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    header("location:formRevisiTesis.php?message=notifEdit");
  ?>