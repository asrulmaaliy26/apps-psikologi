<?php include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $anggota1=mysqli_real_escape_string($con, $_POST['anggota1']);
   $anggota2=mysqli_real_escape_string($con, $_POST['anggota2']);
   $anggota3=mysqli_real_escape_string($con, $_POST['anggota3']);
   $anggota4=mysqli_real_escape_string($con, $_POST['anggota4']);
   $anggota5=mysqli_real_escape_string($con, $_POST['anggota5']);
   $anggota6=mysqli_real_escape_string($con, $_POST['anggota6']);
   $anggota7=mysqli_real_escape_string($con, $_POST['anggota7']);
   $anggota8=mysqli_real_escape_string($con, $_POST['anggota8']);
   $lembaga_tujuan_surat=mysqli_real_escape_string($con, $_POST['lembaga_tujuan_surat']);
   $alamat_lengkap_lts=mysqli_real_escape_string($con, $_POST['alamat_lengkap_lts']);
   $nama_obyek=mysqli_real_escape_string($con, $_POST['nama_obyek']);
   $kota_lts=mysqli_real_escape_string($con, $_POST['kota_lts']);
   $sebutan_pimpinan=mysqli_real_escape_string($con, $_POST['sebutan_pimpinan']);
   $tgl_awal_pelaksanaan=mysqli_real_escape_string($con, $_POST['tgl_awal_pelaksanaan']);
   $tgl_akhir_pelaksanaan=mysqli_real_escape_string($con, $_POST['tgl_akhir_pelaksanaan']);
   $tgl_pengajuan=mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
   $split = explode('-', $tgl_pengajuan);
   $bln_pengajuan= mysqli_real_escape_string($con, $split['1']);
   $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
   $proposal=mysqli_real_escape_string($con, $_POST['proposal']);
   $validasi_proposal=mysqli_real_escape_string($con, $_POST['validasi_proposal']);
   $statusform=mysqli_real_escape_string($con, $_POST['statusform']);

   $namafolder = "file_proposal_magang/";
   $jenis_berkas = $_FILES['proposal']['type'];

   if ($jenis_berkas != "application/pdf") {
   header("location:riwayatSimagkUser.php?message=notifGagalUpload");} 
   else {
   $temp = explode(".", $_FILES["proposal"]["name"]);
   $nama_baru = $anggota1 . '_proposal_magang' . '_' . uniqid() . '.' . end($temp);
   $berkas = $namafolder . $nama_baru;
   move_uploaded_file($_FILES['proposal']['tmp_name'], $namafolder . '/' . $nama_baru);

   $res = mysqli_query($con, "SELECT proposal FROM magang WHERE id='$id' LIMIT 1");
   $d=mysqli_fetch_assoc($res);
   if (strlen($d['proposal'])>3)
    {
      if (file_exists($d['proposal'])) unlink($d['proposal']);
    }
   mysqli_query($con, "UPDATE magang SET proposal='$berkas' WHERE id='$id' LIMIT 1");
   }
   $myqry="UPDATE magang SET lembaga_tujuan_surat='$lembaga_tujuan_surat',alamat_lengkap_lts='$alamat_lengkap_lts',nama_obyek='$nama_obyek',kota_lts='$kota_lts',sebutan_pimpinan='$sebutan_pimpinan',tgl_awal_pelaksanaan='$tgl_awal_pelaksanaan',tgl_akhir_pelaksanaan='$tgl_akhir_pelaksanaan',tgl_pengajuan='$tgl_pengajuan',bln_pengajuan='$bln_pengajuan',thn_pengajuan='$thn_pengajuan',validasi_proposal='$validasi_proposal',statusform='$statusform' WHERE id='$id' LIMIT 1";
   mysqli_query($con, $myqry) or die(mysqli_error($con));

   $sql="UPDATE anggota_magang SET nim_anggota = '$anggota2' WHERE id_magang = '$id' AND urutan='2'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE anggota_magang SET nim_anggota = '$anggota3' WHERE id_magang = '$id' AND urutan='3'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE anggota_magang SET nim_anggota = '$anggota4' WHERE id_magang = '$id' AND urutan='4'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE anggota_magang SET nim_anggota = '$anggota5' WHERE id_magang = '$id' AND urutan='5'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE anggota_magang SET nim_anggota = '$anggota6' WHERE id_magang = '$id' AND urutan='6'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE anggota_magang SET nim_anggota = '$anggota7' WHERE id_magang = '$id' AND urutan='7'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE anggota_magang SET nim_anggota = '$anggota8' WHERE id_magang = '$id' AND urutan='8'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));

   header("location:riwayatSimagkUser.php?message=notifEdit");
   ?>