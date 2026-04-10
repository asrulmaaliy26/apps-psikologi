<?php include( "contentsConAdm.php" );
   $id=uniqid();
   $nim=mysqli_real_escape_string($con, $_POST['nim']);
   $jenis_praktikum="1";
   $tujuan_prak=mysqli_real_escape_string($con, $_POST['tujuan_prak']);
   $sebutan_pimpinan=mysqli_real_escape_string($con, $_POST['sebutan_pimpinan']);
   $kota_prak=mysqli_real_escape_string($con, $_POST['kota_prak']);
   $jenjang_testee=mysqli_real_escape_string($con, $_POST['jenjang_testee']);
   $nama_testee=mysqli_real_escape_string($con, $_POST['nama_testee']);
   $matkul=mysqli_real_escape_string($con, $_POST['matkul']);
   $waktu=mysqli_real_escape_string($con, $_POST['waktu']);
   $jam=mysqli_real_escape_string($con, $_POST['jam']);
   $tgl_pengajuan=mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
   $split = explode('-', $tgl_pengajuan);
   $bln_pengajuan= mysqli_real_escape_string($con, $split['1']);
   $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
   $wd1=mysqli_real_escape_string($con, $_POST['wd1']);   
   $statusform=mysqli_real_escape_string($con, $_POST['statusform']);

  mysqli_query($con, "INSERT INTO siprak_siswa(id,nim,jenis_praktikum,tujuan_prak,sebutan_pimpinan,kota_prak,jenjang_testee,nama_testee,matkul,waktu,jam,tgl_pengajuan,bln_pengajuan,thn_pengajuan,wd1,statusform)" .
   "values('$id','$nim','$jenis_praktikum','$tujuan_prak','$sebutan_pimpinan','$kota_prak','$jenjang_testee','$nama_testee','$matkul','$waktu','$jam','$tgl_pengajuan','$bln_pengajuan','$thn_pengajuan','$wd1','$statusform')") or die(mysqli_error($con));

   header("location:riwayatSiprakisUser.php?message=notifInput");
   ?>