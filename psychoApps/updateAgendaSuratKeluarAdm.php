<?php include( "contentsConAdm.php" );
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $page=mysqli_real_escape_string($con, $_POST['page']);
  $no_berkas=mysqli_real_escape_string($con, $_POST['no_berkas']);
  $tujuan=mysqli_real_escape_string($con, addslashes($_POST['tujuan']));
  $tgl_surat=mysqli_real_escape_string($con, $_POST['tgl_surat']);
  $split = explode('-', $tgl_surat);
  $bln_surat= mysqli_real_escape_string($con, $split['1']);
  $tahun= mysqli_real_escape_string($con, $split['2']);
  $jml_berkas=mysqli_real_escape_string($con, $_POST['jml_berkas']);
  $perihal=mysqli_real_escape_string($con, addslashes($_POST['perihal']));
  $ordner=mysqli_real_escape_string($con, $_POST['ordner']);
  $editor=mysqli_real_escape_string($con, $_POST['editor']);
  /*
  $berkas=mysqli_real_escape_string($con, $_POST['berkas']);
  
  $rand = rand();
  $namafolder = "surat_keluar/";
  $jenis_berkas = $_FILES['berkas']['type'];
  if($jenis_berkas == "application/pdf") {
  $temp = explode(".", $_FILES["berkas"]["name"]);
  $nama_baru = $no_berkas . '_' . $tgl_surat . '_surat_keluar' . '_' . $rand . '.' . end($temp);
  $berkas = $namafolder . $nama_baru;
  move_uploaded_file($_FILES['berkas']['tmp_name'], $namafolder . '/' . $nama_baru);
  
  $res = mysqli_query($con, "SELECT berkas FROM surat_keluar WHERE id='$id' LIMIT 1");
  $d=mysqli_fetch_assoc($res);
  if (strlen($d['berkas'])>3)
  {
  if (file_exists($d['berkas'])) unlink($d['berkas']);
  }
  mysqli_query($con, "UPDATE surat_keluar SET berkas='$berkas' WHERE id='$id' LIMIT 1");
  header("location:agendaSuratKeluarAdm.php?message=notifEdit");
  } else {
  header("location:agendaSuratKeluarAdm.php?message=notifGagal");
  */
  $myqry="UPDATE surat_keluar SET no_berkas='$no_berkas',tujuan='$tujuan',tgl_surat='$tgl_surat',bulan='$bln_surat',tahun='$tahun',jml_berkas='$jml_berkas',perihal='$perihal',ordner='$ordner',editor='$editor' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry) or die(mysqli_error($con));
  header("location:agendaSuratKeluarAdm.php?page=$page&message=notifEdit");
  ?>