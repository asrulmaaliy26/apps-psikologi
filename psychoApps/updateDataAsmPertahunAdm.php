<?php include( "contentsConAdm.php" );
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $page_a=mysqli_real_escape_string($con, $_POST['page_a']);
  $tahun=mysqli_real_escape_string($con, $_POST['tahun']);
  $page=mysqli_real_escape_string($con, $_POST['page']);
  $tgl_terima=mysqli_real_escape_string($con, $_POST['tgl_terima']);
  $no_berkas=mysqli_real_escape_string($con, $_POST['no_berkas']);
  $pengirim=mysqli_real_escape_string($con, addslashes($_POST['pengirim']));
  $tgl_surat=mysqli_real_escape_string($con, $_POST['tgl_surat']);
  $split = explode('-', $tgl_surat);
  $bln_surat= mysqli_real_escape_string($con, $split['1']);
  $tahun= mysqli_real_escape_string($con, $split['2']);
  $no_surat=mysqli_real_escape_string($con, $_POST['no_surat']);
  $jml_berkas=mysqli_real_escape_string($con, $_POST['jml_berkas']);
  $perihal=mysqli_real_escape_string($con, addslashes($_POST['perihal']));
  $ordner=mysqli_real_escape_string($con, $_POST['ordner']);
  $editor=mysqli_real_escape_string($con, $_POST['editor']);
  /*
  $berkas=mysqli_real_escape_string($con, $_POST['berkas']);
  
  $rand = rand();
  $namafolder = "surat_masuk/";
  $jenis_berkas = $_FILES['berkas']['type'];
  if($jenis_berkas == "application/pdf") {
  $temp = explode(".", $_FILES["berkas"]["name"]);
  $nama_baru = $no_berkas . '_' . $tgl_surat . '_surat_masuk' . '_' . $rand . '.' . end($temp);
  $berkas = $namafolder . $nama_baru;
  move_uploaded_file($_FILES['berkas']['tmp_name'], $namafolder . '/' . $nama_baru);
  
  $res = mysqli_query($con, "SELECT berkas FROM surat_masuk WHERE id='$id' LIMIT 1");
  $d=mysqli_fetch_assoc($res);
  if (strlen($d['berkas'])>3)
  {
  if (file_exists($d['berkas'])) unlink($d['berkas']);
  }
  mysqli_query($con, "UPDATE surat_masuk SET berkas='$berkas' WHERE id='$id' LIMIT 1");
  header("location:dataAsmPertahunAdm.php?message=notifEdit");
  } else {
  header("location:dataAsmPertahunAdm.php?message=notifGagal");
  */
  $myqry="UPDATE surat_masuk SET tgl_terima='$tgl_terima',no_berkas='$no_berkas',pengirim='$pengirim',tgl_surat='$tgl_surat',bulan='$bln_surat',tahun='$tahun',no_surat='$no_surat',jml_berkas='$jml_berkas',perihal='$perihal',ordner='$ordner',editor='$editor' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry) or die(mysqli_error($con));
  header("location:dataAsmPertahunAdm.php?page_a=$page_a&tahun=$tahun&page=$page&message=notifEdit");
  ?>