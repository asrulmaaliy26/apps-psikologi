<?php include( "contentsConAdm.php" );

   $id=mysqli_real_escape_string($con, $_POST['id']);
   $page= mysqli_real_escape_string($con, $_POST['page']);
   $date= mysqli_real_escape_string($con, $_POST['date']);
   $anggota1=mysqli_real_escape_string($con, $_POST['anggota1']);
   $anggota2=mysqli_real_escape_string($con, $_POST['anggota2']);
   $anggota3=mysqli_real_escape_string($con, $_POST['anggota3']);
   $anggota4=mysqli_real_escape_string($con, $_POST['anggota4']);
   $anggota5=mysqli_real_escape_string($con, $_POST['anggota5']);
   $anggota6=mysqli_real_escape_string($con, $_POST['anggota6']);
   $anggota7=mysqli_real_escape_string($con, $_POST['anggota7']);
   $anggota8=mysqli_real_escape_string($con, $_POST['anggota8']);
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

   mysqli_query($con, "UPDATE magang SET no_agenda_surat='$no_agenda_surat',lembaga_tujuan_surat='$lembaga_tujuan_surat',alamat_lengkap_lts='$alamat_lengkap_lts',nama_obyek='$nama_obyek',kota_lts='$kota_lts',sebutan_pimpinan='$sebutan_pimpinan',tgl_awal_pelaksanaan='$tgl_awal_pelaksanaan',tgl_akhir_pelaksanaan='$tgl_akhir_pelaksanaan',tgl_proses='$tgl_proses',tgl_dikeluarkan='$tgl_dikeluarkan',tembusan='$tembusan',statusform='$statusform',executor='$executor' WHERE id='$id' LIMIT 1")  or die(mysqli_error($con));

   $sql="UPDATE anggota_magang SET nim_anggota = '$anggota2' WHERE id_magang = '$id' AND urutan='2'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE anggota_magang SET nim_anggota = '$anggota3' WHERE id_magang = '$id' AND urutan='3'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE anggota_magang SET nim_anggota = '$anggota4' WHERE id_magang = '$id' AND urutan='4'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE anggota_magang SET nim_anggota = '$anggota5' WHERE id_magang = '$id' AND urutan='5'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE anggota_magang SET nim_anggota = '$anggota6' WHERE id_magang = '$id' AND urutan='6'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE anggota_magang SET nim_anggota = '$anggota7' WHERE id_magang = '$id' AND urutan='7'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));
   $sql="UPDATE anggota_magang SET nim_anggota = '$anggota8' WHERE id_magang = '$id' AND urutan='8'";
   $result = mysqli_query($con, $sql) or die(mysqli_error($con));

   header("location:rekapSimagKelompokAdm.php?date=$date&page=$page&message=notifEdit");
   ?>