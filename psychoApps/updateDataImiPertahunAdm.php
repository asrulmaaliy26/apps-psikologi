<?php include( "contentsConAdm.php" );
   
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $page_a= mysqli_real_escape_string($con, $_POST['page_a']);
   $tahun= mysqli_real_escape_string($con, $_POST['tahun']);
   $page= mysqli_real_escape_string($con, $_POST['page']);
   $no_agenda_surat=mysqli_real_escape_string($con, $_POST['no_agenda_surat']);
   $nim=mysqli_real_escape_string($con, $_POST['nim']);
   $lembaga_tujuan_surat=mysqli_real_escape_string($con, $_POST['lembaga_tujuan_surat']);
   $alamat_lengkap_lts=mysqli_real_escape_string($con, $_POST['alamat_lengkap_lts']);   
   $nama_obyek=mysqli_real_escape_string($con, $_POST['nama_obyek']);
   $kota_lts=mysqli_real_escape_string($con, $_POST['kota_lts']);
   $sebutan_pimpinan=mysqli_real_escape_string($con, $_POST['sebutan_pimpinan']);
   $tgl_awal_pelaksanaan=mysqli_real_escape_string($con, $_POST['tgl_awal_pelaksanaan']);
   $tgl_akhir_pelaksanaan=mysqli_real_escape_string($con, $_POST['tgl_akhir_pelaksanaan']);
   $tgl_dikeluarkan=mysqli_real_escape_string($con, $_POST['tgl_dikeluarkan']);
   $tgl_proses=date('d-m-Y');
   $tembusan=mysqli_real_escape_string($con, $_POST['tembusan']);
   $statusform=mysqli_real_escape_string($con, '2');
   $executor=mysqli_real_escape_string($con, $_POST['executor']);
   
   mysqli_query($con, "UPDATE magang SET no_agenda_surat='$no_agenda_surat',lembaga_tujuan_surat='$lembaga_tujuan_surat',alamat_lengkap_lts='$alamat_lengkap_lts',nama_obyek='$nama_obyek',kota_lts='$kota_lts',sebutan_pimpinan='$sebutan_pimpinan',tgl_awal_pelaksanaan='$tgl_awal_pelaksanaan',tgl_akhir_pelaksanaan='$tgl_akhir_pelaksanaan',tgl_proses='$tgl_proses',tgl_dikeluarkan='$tgl_dikeluarkan',tembusan='$tembusan',statusform='$statusform',executor='$executor' WHERE id='$id' LIMIT 1")  or die(mysqli_error($con)); {  
   header("location:dataImiPertahunAdm.php?page_a=$page_a&tahun=$tahun&page=$page&message=notifEdit");
   }
   ?>