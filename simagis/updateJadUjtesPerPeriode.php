<?php include( "koneksiAdm.php" );
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $id_ujtes=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_ujtes']);
  $tgl_ujian=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_ujian']);
  $jam_mulai=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['jam_mulai']);   
  $jam_selesai=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['jam_selesai']);
  $penguji1=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['penguji1']);
  $penguji2=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['penguji2']);
  $penguji3=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['penguji3']);
  $penguji4=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['penguji4']);
  $ruang=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['ruang']);
  $cek ="2";
  
  $plusKonversi = date('Y-m-d', strtotime($tgl_ujian. ' + 30 days'));
  
  $myqry="UPDATE mag_jadwal_ujtes SET tgl_ujian='$tgl_ujian',jam_mulai='$jam_mulai',jam_selesai='$jam_selesai',penguji1='$penguji1',penguji2='$penguji2',penguji3='$penguji3',penguji4='$penguji4',ruang='$ruang',batas_revisi='$plusKonversi' WHERE id_pendaftaran='$id' LIMIT 1";
  mysqli_query($GLOBALS["___mysqli_ston"], $myqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  $qry="UPDATE mag_peserta_ujtes SET id_jdwl='$id',cek='$cek' WHERE id='$id' LIMIT 1";
  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  header("location:pendaftarUjtesPerPeriode.php?id=$id_ujtes&message=notifEdit");
  ?>