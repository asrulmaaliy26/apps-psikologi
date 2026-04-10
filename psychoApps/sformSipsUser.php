<?php include( "contentsConAdm.php" );
   $nim=mysqli_real_escape_string($con, $_POST['nim']);
   $lembaga_tujuan_surat=mysqli_real_escape_string($con, $_POST['lembaga_tujuan_surat']);
   $alamat_lengkap_lts=mysqli_real_escape_string($con, $_POST['alamat_lengkap_lts']);
   $nama_obyek=mysqli_real_escape_string($con, $_POST['nama_obyek']);
   $tgl_awal_pelaksanaan=mysqli_real_escape_string($con, $_POST['tgl_awal_pelaksanaan']);
   $tgl_akhir_pelaksanaan=mysqli_real_escape_string($con, $_POST['tgl_akhir_pelaksanaan']);
   $model_pelaksanaan=mysqli_real_escape_string($con, $_POST['model_pelaksanaan']);
   $kota_penelitian=mysqli_real_escape_string($con, $_POST['kota_penelitian']);
   $sebutan_pimpinan=mysqli_real_escape_string($con, $_POST['sebutan_pimpinan']);
   $judul_skripsi=mysqli_real_escape_string($con, $_POST['judul_skripsi']);
   $dosen_pembimbing1=mysqli_real_escape_string($con, $_POST['dosen_pembimbing1']);
   $dosen_pembimbing2=mysqli_real_escape_string($con, $_POST['dosen_pembimbing2']);
   $tgl_pengajuan=mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
   $split = explode('-', $tgl_pengajuan);
   $bln_pengajuan= mysqli_real_escape_string($con, $split['1']);
   $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
   $wd1=mysqli_real_escape_string($con, $_POST['wd1']);
   $statusform=mysqli_real_escape_string($con, $_POST['statusform']);
   
   mysqli_query($con, "INSERT INTO sips(nim,lembaga_tujuan_surat,alamat_lengkap_lts,nama_obyek,tgl_awal_pelaksanaan,tgl_akhir_pelaksanaan,model_pelaksanaan,kota_penelitian,sebutan_pimpinan,judul_skripsi,dosen_pembimbing1,dosen_pembimbing2,tgl_pengajuan,bln_pengajuan,thn_pengajuan,wd1,statusform)".
   "values('$nim','$lembaga_tujuan_surat','$alamat_lengkap_lts','$nama_obyek','$tgl_awal_pelaksanaan','$tgl_akhir_pelaksanaan','$model_pelaksanaan','$kota_penelitian','$sebutan_pimpinan','$judul_skripsi','$dosen_pembimbing1','$dosen_pembimbing2','$tgl_pengajuan','$bln_pengajuan','$thn_pengajuan','$wd1','$statusform')")  or die(mysqli_error($con));
   
   $q="UPDATE pengelompokan_dospem_skripsi SET dospem_skripsi1='$dosen_pembimbing1',dospem_skripsi2='$dosen_pembimbing2' WHERE nim='$nim' LIMIT 1";
       mysqli_query($con, $q) or die(mysqli_error($con));

   header("location:riwayatSipsUser.php?message=notifInput");
   ?>