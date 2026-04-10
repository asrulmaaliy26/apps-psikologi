<?php
  include("koneksiUser.php");
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $nim = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
  $judul_prop = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['judul_prop']);
  $file_prop = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_prop']);
  $file_form_revisi = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_form_revisi']);
  $tgl_upload = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_upload']);
  $thn_upload = date('Y');
  
  $jenis_berkas = $_FILES['file_prop']['type'];
    if ($jenis_berkas == "application/pdf") {
    $myquery = "select * from mag_revisi_sempro WHERE id='$id'";
    $r = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
    $dt = mysqli_fetch_assoc( $r );
    $id_sempro=$dt['id_sempro'];
    $date=strtotime('now');
    $namafolder = "file_revisi_proposal/";
      $temp = explode(".", $_FILES["file_prop"]["name"]);
      $nama_baru = $nim . '-' . $id_sempro . '_revisi-proposal_'.$date. '.' . end($temp);
      $file_prop = $namafolder . $nama_baru;
      move_uploaded_file($_FILES['file_prop']['tmp_name'], $namafolder . '/' . $nama_baru);
    
        $res = mysqli_query($GLOBALS["___mysqli_ston"], "select file_prop from mag_revisi_sempro where id='$id' LIMIT 1");
         $d=mysqli_fetch_assoc($res);
         if (strlen($d['file_prop'])>3)
         {
          if (file_exists($d['file_prop'])) unlink($d['file_prop']);
         }
         mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_revisi_sempro SET file_prop='$file_prop' WHERE id='$id' LIMIT 1");
    } else {
      header("location:formRevisiSempro.php?message=notifGagal");
    }
  
    $j_berkas = $_FILES['file_form_revisi']['type'];
    if ($j_berkas == "application/pdf") {
    $myquery2 = "select * from mag_revisi_sempro WHERE id='$id'";
    $r2 = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery2 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
    $dt2 = mysqli_fetch_assoc( $r2 );
    $id_sempro2=$dt2['id_sempro'];
    $date2=strtotime('now');
    $nmfold = "file_form_revisi_sempro/";
      $temp_form_revisi = explode(".", $_FILES["file_form_revisi"]["name"]);
      $nname = $nim . '-' . $id_sempro2 . '_form-revisi-sempro_'.$date2. '.' . end($temp_form_revisi);
      $file_form_revisi = $nmfold . $nname;
      move_uploaded_file($_FILES['file_form_revisi']['tmp_name'], $nmfold . '/' . $nname);
    
        $res2 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_form_revisi from mag_revisi_sempro where id='$id' LIMIT 1");
         $d2=mysqli_fetch_assoc($res2);
         if (strlen($d2['file_form_revisi'])>3)
         {
          if (file_exists($d2['file_form_revisi'])) unlink($d2['file_form_revisi']);
         }
         mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_revisi_sempro SET file_form_revisi='$file_form_revisi' WHERE id='$id' LIMIT 1");
    } else {
      header("location:formRevisiSempro.php?message=notifGagal");
    }
  
  $myqry="UPDATE mag_revisi_sempro SET judul_prop='$judul_prop',tgl_upload='$tgl_upload',thn_upload='$thn_upload' WHERE id='$id' LIMIT 1";
    mysqli_query($GLOBALS["___mysqli_ston"], $myqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    header("location:formRevisiSempro.php?message=notifEdit");
  ?>