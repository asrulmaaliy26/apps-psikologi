<?php include( "contentsConAdm.php" );

   $id=mysqli_real_escape_string($con, $_POST['id']);
   $page_a= mysqli_real_escape_string($con, $_POST['page_a']);
   $tahun= mysqli_real_escape_string($con, $_POST['tahun']);
   $page= mysqli_real_escape_string($con, $_POST['page']);
   $no_agenda_surat=mysqli_real_escape_string($con, $_POST['no_agenda_surat']);
   $nim=mysqli_real_escape_string($con, $_POST['nim']);
   $alamat_malang=mysqli_real_escape_string($con, $_POST['alamat_malang']);
   $keperluan=mysqli_real_escape_string($con, $_POST['keperluan']);
   $tgl_awal_berlaku=mysqli_real_escape_string($con, $_POST['tgl_awal_berlaku']);
   $tgl_akhir_berlaku=mysqli_real_escape_string($con, $_POST['tgl_akhir_berlaku']);
   $tgl_dikeluarkan=mysqli_real_escape_string($con, $_POST['tgl_dikeluarkan']);
   $tgl_proses=date('d-m-Y');
   $tembusan=mysqli_real_escape_string($con, $_POST['tembusan']);
   $statusform=mysqli_real_escape_string($con, '2');
   $executor=mysqli_real_escape_string($con, $_POST['executor']);
  	   
   $myqry="UPDATE skkb SET no_agenda_surat='$no_agenda_surat',keperluan='$keperluan',tgl_awal_berlaku='$tgl_awal_berlaku',tgl_akhir_berlaku='$tgl_akhir_berlaku',tgl_proses='$tgl_proses',tgl_dikeluarkan='$tgl_dikeluarkan',tembusan='$tembusan',statusform='$statusform',executor='$executor' WHERE id='$id' LIMIT 1";
       mysqli_query($con, $myqry) or die(mysqli_error($con)); {
   header("location:dataKkbPertahunAdm.php?page_a=$page_a&tahun=$tahun&page=$page&message=notifEdit");
   }
   ?>