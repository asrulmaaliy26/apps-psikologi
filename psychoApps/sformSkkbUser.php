<?php include( "contentsConAdm.php" );
   $nim=mysqli_real_escape_string($con, $_POST['nim']);
   $tempat_lahir=mysqli_real_escape_string($con, $_POST['tempat_lahir']);
   $tanggal_lahir=mysqli_real_escape_string($con, $_POST['tanggal_lahir']);   
   $alamat_ktp=mysqli_real_escape_string($con, $_POST['alamat_ktp']);
   $alamat_malang=mysqli_real_escape_string($con, $_POST['alamat_malang']);
   $keperluan=mysqli_real_escape_string($con, $_POST['keperluan']);
   $tgl_pengajuan=mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
   $split = explode('-', $tgl_pengajuan);
   $bln_pengajuan= mysqli_real_escape_string($con, $split['1']);
   $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
   $wd1=mysqli_real_escape_string($con, $_POST['wd1']);
   $statusform=mysqli_real_escape_string($con, $_POST['statusform']);
   
   $query=mysqli_query($con, "INSERT INTO skkb(nim,keperluan,tgl_pengajuan,bln_pengajuan,thn_pengajuan,wd1,statusform)".
   "VALUES('$nim','$keperluan','$tgl_pengajuan','$bln_pengajuan','$thn_pengajuan','$wd1','$statusform')")  or die(mysqli_error($con));

   $sql="UPDATE dt_mhssw SET tempat_lahir='$tempat_lahir',tanggal_lahir='$tanggal_lahir',alamat_ktp='$alamat_ktp',alamat_malang='$alamat_malang' WHERE nim='$nim' LIMIT 1";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));

   header("location:riwayatSkkbUser.php?message=notifInput");
   ?>