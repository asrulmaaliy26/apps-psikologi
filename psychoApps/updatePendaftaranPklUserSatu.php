<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $nim = mysqli_real_escape_string($con, $_POST['nim']);
  $id_pkl = mysqli_real_escape_string($con, $_POST['id_pkl']);
  $jenis_pkl=mysqli_real_escape_string($con, $_POST['jenis_pkl']);
  $tempat_lahir=mysqli_real_escape_string($con, $_POST['tempat_lahir']);
  $tanggal_lahir=mysqli_real_escape_string($con, $_POST['tanggal_lahir']);
  $jenis_kelamin=mysqli_real_escape_string($con, $_POST['jenis_kelamin']);   
  $alamat_ktp=mysqli_real_escape_string($con, $_POST['alamat_ktp']);
  $alamat_malang=mysqli_real_escape_string($con, $_POST['alamat_malang']);
  $kntk=mysqli_real_escape_string($con, $_POST['kntk']);
  $dosen_wali=mysqli_real_escape_string($con, $_POST['dosen_wali']);
  $sks_diambil=mysqli_real_escape_string($con, $_POST['sks_diambil']);
  $riwayat_penyakit=mysqli_real_escape_string($con, $_POST['riwayat_penyakit']);
  $kontak_lain=mysqli_real_escape_string($con, $_POST['kontak_lain']);
  $tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
  $split = explode('-', $tgl_pengajuan);
  $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
  $val_adm = '1';
  $statusform = '1';

  $myqry1="UPDATE peserta_pkl SET jenis_pkl='$jenis_pkl',sks_diambil='$sks_diambil',riwayat_penyakit='$riwayat_penyakit',kontak_lain='$kontak_lain',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan',val_adm='$val_adm',statusform='$statusform' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry1) or die(mysqli_error($con));

  $myqry2="UPDATE dt_mhssw SET tempat_lahir='$tempat_lahir',tanggal_lahir='$tanggal_lahir',jenis_kelamin='$jenis_kelamin',alamat_ktp='$alamat_ktp',alamat_malang='$alamat_malang',kntk='$kntk',dosen_wali='$dosen_wali' WHERE nim='$nim' LIMIT 1";
  mysqli_query($con, $myqry2) or die(mysqli_error($con));

  header("location:detailRiwayatPendaftaranPklUser.php?id=$id&message=notifEdit");
  ?>