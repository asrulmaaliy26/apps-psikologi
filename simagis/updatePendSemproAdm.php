<?php
  include("koneksiAdm.php");
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $id_sempro = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_sempro']);
  $nim = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
  $judul_prop = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['judul_prop']);
  $tgl_pendaftaran = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_pendaftaran']);
  $thn_pendaftaran = date('Y');
  $catatan = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['catatan']);
  $file_prop = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_prop']);
  $file_turnitin = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_turnitin']);
  $file_toefl = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_toefl']);
  $file_transkrip = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_transkrip']);
  $file_audien = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_audien']);
  $file_diseminasi = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_diseminasi']);
  $file_publikasi = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_publikasi']);
  $file_kwitansi = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_kwitansi']);
   
  $jenis_berkas = $_FILES['file_prop']['type'];
  if ($jenis_berkas == "application/pdf") {
  $myquery = "select * from mag_peserta_sempro WHERE id='$id'";
  $r = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt = mysqli_fetch_assoc( $r );
  $id_sempro=$dt['id_sempro'];
  $date=strtotime('now');
  $namafolder = "file_proposal/";
    $temp = explode(".", $_FILES["file_prop"]["name"]);
    $nama_baru = $nim . '-' . $id_sempro . '_proposal_'.$date. '.' . end($temp);
    $file_prop = $namafolder . $nama_baru;
    move_uploaded_file($_FILES['file_prop']['tmp_name'], $namafolder . '/' . $nama_baru);
  
      $res = mysqli_query($GLOBALS["___mysqli_ston"], "select file_prop from mag_peserta_sempro where id='$id' LIMIT 1");
       $d=mysqli_fetch_assoc($res);
       if (strlen($d['file_prop'])>3)
       {
        if (file_exists($d['file_prop'])) unlink($d['file_prop']);
       }
       mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_peserta_sempro SET file_prop='$file_prop' WHERE id='$id' LIMIT 1");
  } else {
    header("location:pendaftarSemproPerPeriode.php?message=notifGagal");
  }
    
  $j_berkas = $_FILES['file_turnitin']['type'];
  if ($j_berkas == "application/pdf") {
  $myquery2 = "select * from mag_peserta_sempro WHERE id='$id'";
  $r2 = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery2 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt2 = mysqli_fetch_assoc( $r2 );
  $id_sempro2=$dt2['id_sempro'];
  $date2=strtotime('now');
  $nmfold = "file_turnitin_sempro/";
    $temp_turnitin = explode(".", $_FILES["file_turnitin"]["name"]);
    $nname = $nim . '-' . $id_sempro2 . '_turnitin-sempro_'.$date2. '.' . end($temp_turnitin);
    $file_turnitin = $nmfold . $nname;
    move_uploaded_file($_FILES['file_turnitin']['tmp_name'], $nmfold . '/' . $nname);
  
      $res2 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_turnitin from mag_peserta_sempro where id='$id' LIMIT 1");
       $d2=mysqli_fetch_assoc($res2);
       if (strlen($d2['file_turnitin'])>3)
       {
        if (file_exists($d2['file_turnitin'])) unlink($d2['file_turnitin']);
       }
       mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_peserta_sempro SET file_turnitin='$file_turnitin' WHERE id='$id' LIMIT 1");
  } else {
    header("location:pendaftarSemproPerPeriode.php?message=notifGagal");
  }
  
  $jns_berkas = $_FILES['file_toefl']['type'];
  if ($jns_berkas == "application/pdf") {
  $myquery3 = "select * from mag_peserta_sempro WHERE id='$id'";
  $r3 = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery3 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt3 = mysqli_fetch_assoc( $r3 );
  $id_sempro3=$dt3['id_sempro'];
  $date3=strtotime('now');
  $nmfolder = "file_toefl_sempro/";
    $temp_toefl = explode(".", $_FILES["file_toefl"]["name"]);
    $newname = $nim . '-' . $id_sempro3 . '_toefl-sempro_'.$date3. '.' . end($temp_toefl);
    $file_toefl = $nmfolder . $newname;
    move_uploaded_file($_FILES['file_toefl']['tmp_name'], $nmfolder . '/' . $newname);
  
      $res3 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_toefl from mag_peserta_sempro where id='$id' LIMIT 1");
       $d3=mysqli_fetch_assoc($res3);
       if (strlen($d3['file_toefl'])>3)
       {
        if (file_exists($d3['file_toefl'])) unlink($d3['file_toefl']);
       }
       mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_peserta_sempro SET file_toefl='$file_toefl' WHERE id='$id' LIMIT 1");
  } else {
    header("location:pendaftarSemproPerPeriode.php?message=notifGagal");
  }

  $j_transkrip = $_FILES['file_transkrip']['type'];
  if ($j_transkrip == "application/pdf") {
  $myquery8 = "select * from mag_peserta_sempro WHERE id='$id'";
  $r8 = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery8 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt8 = mysqli_fetch_assoc( $r8 );
  $id_sempro8=$dt8['id_sempro'];
  $date8=strtotime('now');
  $nf_transkrip = "file_transkrip_sempro/";
    $temp_transkrip = explode(".", $_FILES["file_transkrip"]["name"]);
    $newnametranskrip = $nim . '-' . $id_sempro8 . '_transkrip-sempro_'.$date8. '.' . end($temp_transkrip);
    $file_transkrip = $nf_transkrip . $newnametranskrip;
    move_uploaded_file($_FILES['file_transkrip']['tmp_name'], $nf_transkrip . '/' . $newnametranskrip);
  
      $res8 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_transkrip from mag_peserta_sempro where id='$id' LIMIT 1");
       $d8=mysqli_fetch_assoc($res8);
       if (strlen($d8['file_transkrip'])>3)
       {
        if (file_exists($d8['file_transkrip'])) unlink($d8['file_transkrip']);
       }
       mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_peserta_sempro SET file_transkrip='$file_transkrip' WHERE id='$id' LIMIT 1");
  } else {
    header("location:pendaftarSemproPerPeriode.php?message=notifGagal");
  }

  $j_audien = $_FILES['file_audien']['type'];
  if ($j_audien == "application/pdf") {
  $myquery4 = "select * from mag_peserta_sempro WHERE id='$id'";
  $r4 = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery4 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt4 = mysqli_fetch_assoc( $r4 );
  $id_sempro4=$dt4['id_sempro'];
  $date4=strtotime('now');
  $nf_audien = "file_audien_sempro/";
    $temp_audien = explode(".", $_FILES["file_audien"]["name"]);
    $newnameaudien = $nim . '-' . $id_sempro4 . '_audien-sempro_'.$date4. '.' . end($temp_audien);
    $file_audien = $nf_audien . $newnameaudien;
    move_uploaded_file($_FILES['file_audien']['tmp_name'], $nf_audien . '/' . $newnameaudien);
  
      $res4 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_audien from mag_peserta_sempro where id='$id' LIMIT 1");
       $d4=mysqli_fetch_assoc($res4);
       if (strlen($d4['file_audien'])>3)
       {
        if (file_exists($d4['file_audien'])) unlink($d4['file_audien']);
       }
       mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_peserta_sempro SET file_audien='$file_audien' WHERE id='$id' LIMIT 1");
  } else {
    header("location:pendaftarSemproPerPeriode.php?message=notifGagal");
  }

  $j_diseminasi = $_FILES['file_diseminasi']['type'];
  if ($j_diseminasi == "application/pdf") {
  $myquery5 = "select * from mag_peserta_sempro WHERE id='$id'";
  $r5 = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery5 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt5 = mysqli_fetch_assoc( $r5 );
  $id_sempro5=$dt5['id_sempro'];
  $date5=strtotime('now');
  $nf_diseminasi = "file_diseminasi_sempro/";
    $temp_diseminasi = explode(".", $_FILES["file_diseminasi"]["name"]);
    $newnamediseminasi = $nim . '-' . $id_sempro5 . '_diseminasi-sempro_'.$date5. '.' . end($temp_diseminasi);
    $file_diseminasi = $nf_diseminasi . $newnamediseminasi;
    move_uploaded_file($_FILES['file_diseminasi']['tmp_name'], $nf_diseminasi . '/' . $newnamediseminasi);
  
      $res5 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_diseminasi from mag_peserta_sempro where id='$id' LIMIT 1");
       $d5=mysqli_fetch_assoc($res5);
       if (strlen($d5['file_diseminasi'])>3)
       {
        if (file_exists($d5['file_diseminasi'])) unlink($d5['file_diseminasi']);
       }
       mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_peserta_sempro SET file_diseminasi='$file_diseminasi' WHERE id='$id' LIMIT 1");
  } else {
    header("location:pendaftarSemproPerPeriode.php?message=notifGagal");
  }

  $j_publikasi = $_FILES['file_publikasi']['type'];
  if ($j_publikasi == "application/pdf") {
  $myquery6 = "select * from mag_peserta_sempro WHERE id='$id'";
  $r6 = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery6 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt6 = mysqli_fetch_assoc( $r6 );
  $id_sempro6=$dt6['id_sempro'];
  $date6=strtotime('now');
  $nf_publikasi = "file_publikasi_sempro/";
    $temp_publikasi = explode(".", $_FILES["file_publikasi"]["name"]);
    $newnamepublikasi = $nim . '-' . $id_sempro6 . '_publikasi-sempro_'.$date6. '.' . end($temp_publikasi);
    $file_publikasi = $nf_publikasi . $newnamepublikasi;
    move_uploaded_file($_FILES['file_publikasi']['tmp_name'], $nf_publikasi . '/' . $newnamepublikasi);
  
      $res6 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_publikasi from mag_peserta_sempro where id='$id' LIMIT 1");
       $d6=mysqli_fetch_assoc($res6);
       if (strlen($d6['file_publikasi'])>3)
       {
        if (file_exists($d6['file_publikasi'])) unlink($d6['file_publikasi']);
       }
       mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_peserta_sempro SET file_publikasi='$file_publikasi' WHERE id='$id' LIMIT 1");
  } else {
    header("location:pendaftarSemproPerPeriode.php?message=notifGagal");
  }

  $j_kwitansi = $_FILES['file_kwitansi']['type'];
  if ($j_kwitansi == "application/pdf") {
  $myquery7 = "select * from mag_peserta_sempro WHERE id='$id'";
  $r7 = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery7 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt7 = mysqli_fetch_assoc( $r7 );
  $id_sempro7=$dt7['id_sempro'];
  $date7=strtotime('now');
  $nf_kwitansi = "file_kwitansi_sempro/";
    $temp_kwitansi = explode(".", $_FILES["file_kwitansi"]["name"]);
    $newnamekwitansi = $nim . '-' . $id_sempro7 . '_kwitansi-sempro_'.$date7. '.' . end($temp_kwitansi);
    $file_kwitansi = $nf_kwitansi . $newnamekwitansi;
    move_uploaded_file($_FILES['file_kwitansi']['tmp_name'], $nf_kwitansi . '/' . $newnamekwitansi);
  
      $res7 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_kwitansi from mag_peserta_sempro where id='$id' LIMIT 1");
       $d7=mysqli_fetch_assoc($res7);
       if (strlen($d7['file_kwitansi'])>3)
       {
        if (file_exists($d7['file_kwitansi'])) unlink($d7['file_kwitansi']);
       }
       mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_peserta_sempro SET file_kwitansi='$file_kwitansi' WHERE id='$id' LIMIT 1");
  } else {
    header("location:pendaftarSemproPerPeriode.php?message=notifGagal");
  }
  
  $myqry="UPDATE mag_peserta_sempro SET judul_prop='$judul_prop',tgl_pendaftaran='$tgl_pendaftaran',thn_pendaftaran='$thn_pendaftaran',catatan='$catatan' WHERE id='$id' LIMIT 1";
  mysqli_query($GLOBALS["___mysqli_ston"], $myqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  header("location:pendaftarSemproPerPeriode.php?id=$id_sempro&message=notifEdit");
  ?>