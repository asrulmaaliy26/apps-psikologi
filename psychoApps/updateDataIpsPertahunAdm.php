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
   $kota_penelitian=mysqli_real_escape_string($con, $_POST['kota_penelitian']);
   $sebutan_pimpinan=mysqli_real_escape_string($con, $_POST['sebutan_pimpinan']);
   $judul_skripsi=mysqli_real_escape_string($con, $_POST['judul_skripsi']);
   $dosen_pembimbing1=mysqli_real_escape_string($con, $_POST['dosen_pembimbing1']);
   $dosen_pembimbing2=mysqli_real_escape_string($con, $_POST['dosen_pembimbing2']);
   $tgl_awal_pelaksanaan=mysqli_real_escape_string($con, $_POST['tgl_awal_pelaksanaan']);
   $tgl_akhir_pelaksanaan=mysqli_real_escape_string($con, $_POST['tgl_akhir_pelaksanaan']);
   $model_pelaksanaan=mysqli_real_escape_string($con, $_POST['model_pelaksanaan']);
   $tgl_dikeluarkan=mysqli_real_escape_string($con, $_POST['tgl_dikeluarkan']);
   $tgl_proses=date('d-m-Y');
   $tembusan=mysqli_real_escape_string($con, $_POST['tembusan']);
   $statusform=mysqli_real_escape_string($con, '2');
   $executor=mysqli_real_escape_string($con, $_POST['executor']);

   mysqli_query($con, "UPDATE sips SET no_agenda_surat='$no_agenda_surat',lembaga_tujuan_surat='$lembaga_tujuan_surat',alamat_lengkap_lts='$alamat_lengkap_lts',nama_obyek='$nama_obyek',kota_penelitian='$kota_penelitian',sebutan_pimpinan='$sebutan_pimpinan',judul_skripsi='$judul_skripsi',dosen_pembimbing1='$dosen_pembimbing1',dosen_pembimbing2='$dosen_pembimbing2',tgl_awal_pelaksanaan='$tgl_awal_pelaksanaan',tgl_akhir_pelaksanaan='$tgl_akhir_pelaksanaan',model_pelaksanaan='$model_pelaksanaan',tgl_proses='$tgl_proses',tgl_dikeluarkan='$tgl_dikeluarkan',tembusan='$tembusan',statusform='$statusform',executor='$executor' WHERE id='$id' LIMIT 1")  or die(mysqli_error($con));

   mysqli_query($con, "UPDATE pengelompokan_dospem_skripsi SET dospem_skripsi1='$dosen_pembimbing1',dospem_skripsi2='$dosen_pembimbing2' WHERE nim='$nim' LIMIT 1")  or die(mysqli_error($con)); {
   header("location:dataIpsPertahunAdm.php?page_a=$page_a&tahun=$tahun&page=$page&message=notifEdit");
   }
   ?>