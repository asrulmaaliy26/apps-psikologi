<?php include( "koneksiAdm.php" );
  $id=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id']);
  $id_sempro=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_sempro']);
  $tgl_seminar=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_seminar']);
  $jam_mulai=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['jam_mulai']);   
  $jam_selesai=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['jam_selesai']);
  $penguji1=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['penguji1']);
  $penguji2=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['penguji2']);
  $penguji3=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['penguji3']);
  $penguji4=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['penguji4']);
  $ruang=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['ruang']);
  $cek ="2";

  $plusKonversi = date('Y-m-d', strtotime($tgl_seminar. ' + 30 days'));

  $myqry="UPDATE mag_jadwal_sempro SET tgl_seminar='$tgl_seminar',jam_mulai='$jam_mulai',jam_selesai='$jam_selesai',penguji1='$penguji1',penguji2='$penguji2',penguji3='$penguji3',penguji4='$penguji4',ruang='$ruang',batas_revisi='$plusKonversi' WHERE id_pendaftaran='$id' LIMIT 1";
  mysqli_query($GLOBALS["___mysqli_ston"], $myqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  $qry="UPDATE mag_peserta_sempro SET id_jdwl='$id',cek='$cek' WHERE id='$id' LIMIT 1";
  mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));

  header("location:pendaftarSemproPerPeriode.php?id=$id_sempro&message=notifEdit");
  ?>