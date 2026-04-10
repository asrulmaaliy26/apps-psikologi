<?php include( "contentsConAdm.php" );
   
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $page_a= mysqli_real_escape_string($con, $_POST['page_a']);
   $tahun= mysqli_real_escape_string($con, $_POST['tahun']);
   $page= mysqli_real_escape_string($con, $_POST['page']);
   $no_agenda_surat=mysqli_real_escape_string($con, $_POST['no_agenda_surat']);
   $nama_testee=mysqli_real_escape_string($con, $_POST['nama_testee']);
   $nim_testee=mysqli_real_escape_string($con, $_POST['nim_testee']);
   $matkul_testee=mysqli_real_escape_string($con, $_POST['matkul_testee']);
   $dosen_testee=mysqli_real_escape_string($con, $_POST['dosen_testee']);
   $matkul=mysqli_real_escape_string($con, $_POST['matkul']);
   $waktu=mysqli_real_escape_string($con, $_POST['waktu']);
   $jam=mysqli_real_escape_string($con, $_POST['jam']);
   $tgl_dikeluarkan=mysqli_real_escape_string($con, $_POST['tgl_dikeluarkan']);
   $tgl_proses=date('d-m-Y');
   $tembusan=mysqli_real_escape_string($con, $_POST['tembusan']);
   $statusform=mysqli_real_escape_string($con, '2');
   $executor=mysqli_real_escape_string($con, $_POST['executor']);   

   $myqry="UPDATE siprak_mahasiswa SET no_agenda_surat='$no_agenda_surat',nama_testee='$nama_testee',nim_testee='$nim_testee',matkul_testee='$matkul_testee',dosen_testee='$dosen_testee',matkul='$matkul',waktu='$waktu',jam='$jam',tgl_proses='$tgl_proses',tgl_dikeluarkan='$tgl_dikeluarkan',tembusan='$tembusan',statusform='$statusform',executor='$executor' WHERE id='$id' LIMIT 1";
       mysqli_query($con, $myqry) or die(mysqli_error($con)); {
   header("location:dataIpitmPertahunAdm.php?page_a=$page_a&tahun=$tahun&page=$page&message=notifEdit");
   }
   ?>