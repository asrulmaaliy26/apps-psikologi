<?php include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_POST['id']);
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
       
   if (empty($tempat_lahir))
   {   
       die("Mohon tempat lahir diisi!");
   }
   
   else
   {
   $myqry="UPDATE dt_mhssw SET tempat_lahir='$tempat_lahir',tanggal_lahir='$tanggal_lahir',alamat_ktp='$alamat_ktp',alamat_malang='$alamat_malang' WHERE nim='$nim' LIMIT 1";
   mysqli_query($con, $myqry) or die(mysqli_error($con));

   $myqry="UPDATE skkb SET keperluan='$keperluan',tgl_pengajuan='$tgl_pengajuan',bln_pengajuan='$bln_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1";
       mysqli_query($con, $myqry) or die(mysqli_error($con));

   header("location:riwayatSkkbUser.php?message=notifEdit");
   }
   ?>