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
   $anggota9=mysqli_real_escape_string($con, $_POST['anggota9']);
   $anggota10=mysqli_real_escape_string($con, $_POST['anggota10']);
   $anggota11=mysqli_real_escape_string($con, $_POST['anggota11']);
   $anggota12=mysqli_real_escape_string($con, $_POST['anggota12']);
   $lembaga_tujuan_surat=mysqli_real_escape_string($con, $_POST['lembaga_tujuan_surat']);
   $alamat_lengkap_lts=mysqli_real_escape_string($con, $_POST['alamat_lengkap_lts']);
   $sebutan_pimpinan=mysqli_real_escape_string($con, $_POST['sebutan_pimpinan']);
   $kota_lts=mysqli_real_escape_string($con, $_POST['kota_lts']);
   $jenis_pkl=mysqli_real_escape_string($con, $_POST['jenis_pkl']);
   $tgl_pengajuan=mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
   $split = explode('-', $tgl_pengajuan);
   $bln_pengajuan= mysqli_real_escape_string($con, $split['1']);
   $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
       
   if (empty($lembaga_tujuan_surat))
   {   
       die("Mohon Lembaga tujuan surat diisi!");
   }
   
   else
   {
   $myqry="UPDATE sitp SET lembaga_tujuan_surat='$lembaga_tujuan_surat',alamat_lengkap_lts='$alamat_lengkap_lts',kota_lts='$kota_lts',sebutan_pimpinan='$sebutan_pimpinan',jenis_pkl='$jenis_pkl',tgl_pengajuan='$tgl_pengajuan',bln_pengajuan='$bln_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1";
   mysqli_query($con, $myqry) or die(mysqli_error($con));

   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota1' WHERE id_sitp = '$id' AND urutan='1'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota2' WHERE id_sitp = '$id' AND urutan='2'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota3' WHERE id_sitp = '$id' AND urutan='3'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota4' WHERE id_sitp = '$id' AND urutan='4'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota5' WHERE id_sitp = '$id' AND urutan='5'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota6' WHERE id_sitp = '$id' AND urutan='6'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota7' WHERE id_sitp = '$id' AND urutan='7'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota8' WHERE id_sitp = '$id' AND urutan='8'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota9' WHERE id_sitp = '$id' AND urutan='9'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota10' WHERE id_sitp = '$id' AND urutan='10'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota11' WHERE id_sitp = '$id' AND urutan='11'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE draf_anggota_pkl SET nim_anggota = '$anggota12' WHERE id_sitp = '$id' AND urutan='12'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));

   header("location:riwayatSitpUser.php?message=notifEdit");
   }
   ?>