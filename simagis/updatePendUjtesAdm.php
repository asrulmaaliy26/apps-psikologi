<?php
  include("koneksiUser.php");
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $id_ujtes = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_ujtes']);
  $nim = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
  $judul_tesis = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['judul_tesis']);
  $tgl_pendaftaran = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_pendaftaran']);
  $thn_pendaftaran = date('Y');
  $catatan = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['catatan']);
  $file_tesis = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_tesis']);
  $file_turnitin = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_turnitin']);
  $file_transkrip = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_transkrip']);
  $file_jurnal = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_jurnal']);
  $file_contoh_jurnal = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_contoh_jurnal']); 
  $file_kwitansi = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_kwitansi']);
   
  $jenis_berkas = $_FILES['file_tesis']['type'];
  if ($jenis_berkas == "application/pdf") {
  $myquery = "select * from mag_peserta_ujtes WHERE id='$id'";
  $r = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt = mysqli_fetch_assoc( $r );
  $id_ujtes=$dt['id_ujtes'];
  $date=strtotime('now');
  $namafolder = "file_tesis/";
  	$temp = explode(".", $_FILES["file_tesis"]["name"]);
  	$nama_baru = $nim . '-' . $id_ujtes . '_tesis_'.$date. '.' . end($temp);
  	$file_tesis = $namafolder . $nama_baru;
  	move_uploaded_file($_FILES['file_tesis']['tmp_name'], $namafolder . '/' . $nama_baru);
  
      $res = mysqli_query($GLOBALS["___mysqli_ston"], "select file_tesis from mag_peserta_ujtes where id='$id' LIMIT 1");
       $d=mysqli_fetch_assoc($res);
       if (strlen($d['file_tesis'])>3)
       {
        if (file_exists($d['file_tesis'])) unlink($d['file_tesis']);
       }
       mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_peserta_ujtes SET file_tesis='$file_tesis' WHERE id='$id' LIMIT 1");
  } else {
  	header("location:pendaftarUjtesPerPeriode.php?id=$id_ujtes&message=notifGagal");
  }
  
  $j_berkas = $_FILES['file_turnitin']['type'];
  if ($j_berkas == "application/pdf") {
  $myquery2 = "select * from mag_peserta_ujtes WHERE id='$id'";
  $r2 = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery2 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt2 = mysqli_fetch_assoc( $r2 );
  $id_ujtes2=$dt2['id_ujtes'];
  $date2=strtotime('now');
  $nmfold = "file_turnitin_tesis/";
  	$temp_turnitin = explode(".", $_FILES["file_turnitin"]["name"]);
  	$nname = $nim . '-' . $id_ujtes2 . '_turnitin-tesis_'.$date2. '.' . end($temp_turnitin);
  	$file_turnitin = $nmfold . $nname;
  	move_uploaded_file($_FILES['file_turnitin']['tmp_name'], $nmfold . '/' . $nname);
  
      $res2 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_turnitin from mag_peserta_ujtes where id='$id' LIMIT 1");
       $d2=mysqli_fetch_assoc($res2);
       if (strlen($d2['file_turnitin'])>3)
       {
        if (file_exists($d2['file_turnitin'])) unlink($d2['file_turnitin']);
       }
       mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_peserta_ujtes SET file_turnitin='$file_turnitin' WHERE id='$id' LIMIT 1");
  } else {
  	header("location:pendaftarUjtesPerPeriode.php?message=notifGagal");
  }
  
  $j_transkrip = $_FILES['file_transkrip']['type'];
  if ($j_transkrip == "application/pdf") {
  $myquery8 = "select * from mag_peserta_ujtes WHERE id='$id'";
  $r8 = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery8 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt8 = mysqli_fetch_assoc( $r8 );
  $id_ujtes8=$dt8['id_ujtes'];
  $date8=strtotime('now');
  $nf_transkrip = "file_transkrip_tesis/";
    $temp_transkrip = explode(".", $_FILES["file_transkrip"]["name"]);
    $newnametranskrip = $nim . '-' . $id_ujtes8 . '_transkrip-tesis_'.$date8. '.' . end($temp_transkrip);
    $file_transkrip = $nf_transkrip . $newnametranskrip;
    move_uploaded_file($_FILES['file_transkrip']['tmp_name'], $nf_transkrip . '/' . $newnametranskrip);
  
      $res8 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_transkrip from mag_peserta_ujtes where id='$id' LIMIT 1");
       $d8=mysqli_fetch_assoc($res8);
       if (strlen($d8['file_transkrip'])>3)
       {
        if (file_exists($d8['file_transkrip'])) unlink($d8['file_transkrip']);
       }
       mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_peserta_ujtes SET file_transkrip='$file_transkrip' WHERE id='$id' LIMIT 1");
  } else {
    header("location:pendaftarUjtesPerPeriode.php?message=notifGagal");
  }

  $j_jurnal = $_FILES['file_jurnal']['type'];
  if ($j_jurnal == "application/pdf") {
  $myquery3 = "select * from mag_peserta_ujtes WHERE id='$id'";
  $r3 = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery3 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt3 = mysqli_fetch_assoc( $r3 );
  $id_ujtes3=$dt3['id_ujtes'];
  $date3=strtotime('now');
  $nf_jurnal = "file_jurnal_tesis/";
    $temp_jurnal = explode(".", $_FILES["file_jurnal"]["name"]);
    $newnamejurnal = $nim . '-' . $id_ujtes3 . '_jurnal-tesis_'.$date3. '.' . end($temp_jurnal);
    $file_jurnal = $nf_jurnal . $newnamejurnal;
    move_uploaded_file($_FILES['file_jurnal']['tmp_name'], $nf_jurnal . '/' . $newnamejurnal);
  
      $res3 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_jurnal from mag_peserta_ujtes where id='$id' LIMIT 1");
       $d3=mysqli_fetch_assoc($res3);
       if (strlen($d3['file_jurnal'])>3)
       {
        if (file_exists($d3['file_jurnal'])) unlink($d3['file_jurnal']);
       }
       mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_peserta_ujtes SET file_jurnal='$file_jurnal' WHERE id='$id' LIMIT 1");
  } else {
    header("location:pendaftarUjtesPerPeriode.php?message=notifGagal");
  }

  $j_template_jurnal = $_FILES['file_contoh_jurnal']['type'];
  if ($j_template_jurnal == "application/pdf") {
  $myquery4 = "select * from mag_peserta_ujtes WHERE id='$id'";
  $r4 = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery4 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt4 = mysqli_fetch_assoc( $r4 );
  $id_ujtes4=$dt4['id_ujtes'];
  $date4=strtotime('now');
  $nf_template_jurnal = "file_contoh_template_jurnal_tesis/";
    $temp_template_jurnal = explode(".", $_FILES["file_contoh_jurnal"]["name"]);
    $newnametemplatejurnal = $nim . '-' . $id_ujtes4 . '_template_jurnal-tesis_'.$date4. '.' . end($temp_template_jurnal);
    $file_contoh_jurnal = $nf_template_jurnal . $newnametemplatejurnal;
    move_uploaded_file($_FILES['file_contoh_jurnal']['tmp_name'], $nf_template_jurnal . '/' . $newnametemplatejurnal);
  
      $res4 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_contoh_jurnal from mag_peserta_ujtes where id='$id' LIMIT 1");
       $d4=mysqli_fetch_assoc($res4);
       if (strlen($d4['file_contoh_jurnal'])>3)
       {
        if (file_exists($d4['file_contoh_jurnal'])) unlink($d4['file_contoh_jurnal']);
       }
       mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_peserta_ujtes SET file_contoh_jurnal='$file_contoh_jurnal' WHERE id='$id' LIMIT 1");
  } else {
    header("location:pendaftarUjtesPerPeriode.php?message=notifGagal");
  }

  $j_kwitansi = $_FILES['file_kwitansi']['type'];
  if ($j_kwitansi == "application/pdf") {
  $myquery7 = "select * from mag_peserta_ujtes WHERE id='$id'";
  $r7 = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery7 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt7 = mysqli_fetch_assoc( $r7 );
  $id_ujtes7=$dt7['id_ujtes'];
  $date7=strtotime('now');
  $nf_kwitansi = "file_kwitansi_ujian_tesis/";
    $temp_kwitansi = explode(".", $_FILES["file_kwitansi"]["name"]);
    $newnamekwitansi = $nim . '-' . $id_ujtes7 . '_kwitansi-ujtes_'.$date7. '.' . end($temp_kwitansi);
    $file_kwitansi = $nf_kwitansi . $newnamekwitansi;
    move_uploaded_file($_FILES['file_kwitansi']['tmp_name'], $nf_kwitansi . '/' . $newnamekwitansi);
  
      $res7 = mysqli_query($GLOBALS["___mysqli_ston"], "select file_kwitansi from mag_peserta_ujtes where id='$id' LIMIT 1");
       $d7=mysqli_fetch_assoc($res7);
       if (strlen($d7['file_kwitansi'])>3)
       {
        if (file_exists($d7['file_kwitansi'])) unlink($d7['file_kwitansi']);
       }
       mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_peserta_ujtes SET file_kwitansi='$file_kwitansi' WHERE id='$id' LIMIT 1");
  } else {
    header("location:pendaftarUjtesPerPeriode.php?message=notifGagal");
  }

   $myqry="UPDATE mag_peserta_ujtes SET judul_tesis='$judul_tesis',tgl_pendaftaran='$tgl_pendaftaran',thn_pendaftaran='$thn_pendaftaran',catatan='$catatan' WHERE id='$id' LIMIT 1";
  	mysqli_query($GLOBALS["___mysqli_ston"], $myqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  	header("location:pendaftarUjtesPerPeriode.php?id=$id_ujtes&message=notifEdit");
  ?>