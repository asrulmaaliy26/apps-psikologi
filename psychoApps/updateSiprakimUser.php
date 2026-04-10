<?php include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $nama_testee=mysqli_real_escape_string($con, $_POST['nama_testee']);
   $nim_testee=mysqli_real_escape_string($con, $_POST['nim_testee']);
   $matkul_testee=mysqli_real_escape_string($con, $_POST['matkul_testee']);
   $dosen_testee=mysqli_real_escape_string($con, $_POST['dosen_testee']);
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
   $myqry="UPDATE siprak_mahasiswa SET nama_testee='$nama_testee',nim_testee='$nim_testee',matkul_testee='$matkul_testee',dosen_testee='$dosen_testee',matkul='$matkul',waktu='$waktu',jam='$jam',tgl_pengajuan='$tgl_pengajuan',bln_pengajuan='$bln_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1";
       mysqli_query($con, $myqry) or die(mysqli_error($con));

       header("location:riwayatSiprakimUser.php?message=notifEdit");
   }
   ?>