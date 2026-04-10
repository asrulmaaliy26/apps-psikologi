<?php include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $tujuan_prak=mysqli_real_escape_string($con, $_POST['tujuan_prak']);
   $kota_prak=mysqli_real_escape_string($con, $_POST['kota_prak']);
   $sebutan_pimpinan=mysqli_real_escape_string($con, $_POST['sebutan_pimpinan']);   
   $jenjang_testee=mysqli_real_escape_string($con, $_POST['jenjang_testee']);
   $nama_testee=mysqli_real_escape_string($con, $_POST['nama_testee']);
   $matkul=mysqli_real_escape_string($con, $_POST['matkul']);
   $waktu=mysqli_real_escape_string($con, $_POST['waktu']);
   $jam=mysqli_real_escape_string($con, $_POST['jam']);
   $tgl_pengajuan=mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
   $split = explode('-', $tgl_pengajuan);
   $bln_pengajuan= mysqli_real_escape_string($con, $split['1']);
   $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
    
   if (empty($nama_testee))
   {   
       die("Mohon nama testee diisi!");
   }
   
   else 
   {
   $myqry="UPDATE siprak_siswa SET tujuan_prak='$tujuan_prak',sebutan_pimpinan='$sebutan_pimpinan',kota_prak='$kota_prak',jenjang_testee='$jenjang_testee',nama_testee='$nama_testee',matkul='$matkul',waktu='$waktu',jam='$jam',tgl_pengajuan='$tgl_pengajuan',bln_pengajuan='$bln_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1";
       mysqli_query($con, $myqry) or die(mysqli_error($con));

       header("location:riwayatSiprakisUser.php?message=notifEdit");
   }
   ?>