<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_POST['id']);
  $nim = mysqli_real_escape_string($con, $_POST['nim']);
  $id_periode = mysqli_real_escape_string($con, $_POST['id_periode']);
  $digit_ipk1 = mysqli_real_escape_string($con, $_POST['digit_ipk1']);
  $digit_ipk2 = mysqli_real_escape_string($con, $_POST['digit_ipk2']);
  $ipk = $digit_ipk1.','.$digit_ipk2;
  $sks_ditempuh = mysqli_real_escape_string($con, $_POST['sks_ditempuh']);
  $judul_skripsi = mysqli_real_escape_string($con, $_POST['judul_skripsi']);
  $jenis_skripsi = mysqli_real_escape_string($con, $_POST['jenis_skripsi']);
  $bidang_skripsi = mysqli_real_escape_string($con, $_POST['bidang_skripsi']);
  $metode_riset = mysqli_real_escape_string($con, $_POST['metode_riset']);
  $var_1 = mysqli_real_escape_string($con, $_POST['var_1']);
  $var_2 = mysqli_real_escape_string($con, $_POST['var_2']);
  $var_3 = mysqli_real_escape_string($con, $_POST['var_3']);
  $tgl_pengajuan = mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
  $split = explode('-', $tgl_pengajuan);
  $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);

  $myquery = "SELECT * FROM pengelompokan_dospem_skripsi WHERE id='$id'";
  $r = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $r );
  
  if($dt['cekjudul'] == 4) {
    $myqry1="UPDATE pengelompokan_dospem_skripsi SET ipk='$ipk',digit_ipk1='$digit_ipk1',digit_ipk2='$digit_ipk2',sks_ditempuh='$sks_ditempuh',judul_skripsi='$judul_skripsi',jenis_skripsi='$jenis_skripsi',bidang_skripsi='$bidang_skripsi',metode_riset='$metode_riset',var_1='$var_1',var_2='$var_2',var_3='$var_3',var_4='$var_4',cekjudul='1',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry1) or die(mysqli_error($con));
  header("location:riwayatPengajuanDospemUser.php?message=notifEdit");}
  else {
    $myqry1="UPDATE pengelompokan_dospem_skripsi SET ipk='$ipk',digit_ipk1='$digit_ipk1',digit_ipk2='$digit_ipk2',sks_ditempuh='$sks_ditempuh',judul_skripsi='$judul_skripsi',jenis_skripsi='$jenis_skripsi',bidang_skripsi='$bidang_skripsi',metode_riset='$metode_riset',var_1='$var_1',var_2='$var_2',var_3='$var_3',var_4='$var_4',tgl_pengajuan='$tgl_pengajuan',thn_pengajuan='$thn_pengajuan' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry1) or die(mysqli_error($con));
  header("location:riwayatPengajuanDospemUser.php?message=notifEdit");
  }
  ?>