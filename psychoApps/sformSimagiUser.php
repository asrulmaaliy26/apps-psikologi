<?php include( "contentsConAdm.php" );
   $nim=mysqli_real_escape_string($con, $_POST['nim']);
   $jenis_magang="1";
   $lembaga_tujuan_surat=mysqli_real_escape_string($con, $_POST['lembaga_tujuan_surat']);
   $alamat_lengkap_lts=mysqli_real_escape_string($con, $_POST['alamat_lengkap_lts']);
   $nama_obyek=mysqli_real_escape_string($con, $_POST['nama_obyek']);
   $tgl_awal_pelaksanaan=mysqli_real_escape_string($con, $_POST['tgl_awal_pelaksanaan']);
   $tgl_akhir_pelaksanaan=mysqli_real_escape_string($con, $_POST['tgl_akhir_pelaksanaan']);
   $kota_lts=mysqli_real_escape_string($con, $_POST['kota_lts']);
   $sebutan_pimpinan=mysqli_real_escape_string($con, $_POST['sebutan_pimpinan']);
   $tgl_pengajuan=mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
   $split = explode('-', $tgl_pengajuan);
   $bln_pengajuan= mysqli_real_escape_string($con, $split['1']);
   $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
   $wd1=mysqli_real_escape_string($con, $_POST['wd1']);
   $validasi_proposal=mysqli_real_escape_string($con, $_POST['validasi_proposal']);
   $statusform=mysqli_real_escape_string($con, $_POST['statusform']);
   $proposal=mysqli_real_escape_string($con, $_POST['proposal']);

   $namafolder = "file_proposal_magang/";
   $jenis_berkas = $_FILES['proposal']['type'];

   if ($proposal='' || $jenis_berkas != "application/pdf") {
   header("location:riwayatSimagiUser.php?message=notifGagalUpload");} 
   else {
   $temp = explode(".", $_FILES["proposal"]["name"]);
   $nama_baru = $nim . '_proposal_magang' . '.' . end($temp);
   $berkas = $namafolder . $nama_baru;
   move_uploaded_file($_FILES['proposal']['tmp_name'], $namafolder . '/' . $nama_baru);

   mysqli_query($con, "INSERT INTO magang(nim,jenis_magang,lembaga_tujuan_surat,alamat_lengkap_lts,nama_obyek,tgl_awal_pelaksanaan,tgl_akhir_pelaksanaan,kota_lts,sebutan_pimpinan,proposal,tgl_pengajuan,bln_pengajuan,thn_pengajuan,wd1,validasi_proposal,statusform)".
   "values('$nim','$jenis_magang','$lembaga_tujuan_surat','$alamat_lengkap_lts','$nama_obyek','$tgl_awal_pelaksanaan','$tgl_akhir_pelaksanaan','$kota_lts','$sebutan_pimpinan','$berkas','$tgl_pengajuan','$bln_pengajuan','$thn_pengajuan','$wd1','$validasi_proposal','$statusform')")  or die(mysqli_error($con));

   header("location:riwayatSimagiUser.php?message=notifInput");
}
   ?>