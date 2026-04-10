<?php include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_POST['id']);
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
   $tgl_pengajuan=mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
   $split = explode('-', $tgl_pengajuan);
   $bln_pengajuan= mysqli_real_escape_string($con, $split['1']);
   $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
       
   if (empty($nama_obyek))
   {   
       die("Mohon nama obyek diisi!");
   }
   
   else
   {
   $myqry="UPDATE sips SET lembaga_tujuan_surat='$lembaga_tujuan_surat',alamat_lengkap_lts='$alamat_lengkap_lts',nama_obyek='$nama_obyek',kota_penelitian='$kota_penelitian',sebutan_pimpinan='$sebutan_pimpinan',judul_skripsi='$judul_skripsi',dosen_pembimbing1='$dosen_pembimbing1',dosen_pembimbing2='$dosen_pembimbing2',tgl_awal_pelaksanaan='$tgl_awal_pelaksanaan',tgl_akhir_pelaksanaan='$tgl_akhir_pelaksanaan',model_pelaksanaan='$model_pelaksanaan',tgl_pengajuan='$tgl_pengajuan',bln_pengajuan='$bln_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1";
       mysqli_query($con, $myqry) or die(mysqli_error($con));

   $q="UPDATE pengelompokan_dospem_skripsi SET dospem_skripsi1='$dosen_pembimbing1',dospem_skripsi2='$dosen_pembimbing2' WHERE nim='$nim' LIMIT 1";
       mysqli_query($con, $q) or die(mysqli_error($con));

       header("location:riwayatSipsUser.php?message=notifEdit");
   }
   ?>