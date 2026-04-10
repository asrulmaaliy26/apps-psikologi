<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);

  if(isset($_POST['submit'])) {
  $id= mysqli_real_escape_string($con, $_POST['id']);
  $kat_pegawai= mysqli_real_escape_string($con, $_POST['kat_pegawai']);
  $tgl_cpns= mysqli_real_escape_string($con, $_POST['tgl_cpns']);
  $tmt= mysqli_real_escape_string($con, $_POST['tmt']);
  $jenis_pegawai= mysqli_real_escape_string($con, $_POST['jenis_pegawai']);
  $pangkat= mysqli_real_escape_string($con, $_POST['pangkat']);
  $jabatan_instansi= mysqli_real_escape_string($con, $_POST['jabatan_instansi']);
  $status= mysqli_real_escape_string($con, $_POST['status']);
  $nama= mysqli_real_escape_string($con, $_POST['nama']);
  $nama_tg= mysqli_real_escape_string($con, $_POST['nama_tg']);
  $tempat_lahir= mysqli_real_escape_string($con, $_POST['tempat_lahir']);
  $tanggal_lahir= mysqli_real_escape_string($con, $_POST['tanggal_lahir']);
  $alamat_ktp= mysqli_real_escape_string($con, $_POST['alamat_ktp']);
  $alamat_rumah= mysqli_real_escape_string($con, $_POST['alamat_rumah']);
  $jenis_kelamin= mysqli_real_escape_string($con, $_POST['jenis_kelamin']);
  $kntk1= mysqli_real_escape_string($con, $_POST['kntk1']);
  $kntk2= mysqli_real_escape_string($con, $_POST['kntk2']);
  $email1= mysqli_real_escape_string($con, $_POST['email1']);
  $email2= mysqli_real_escape_string($con, $_POST['email2']);
  $sma= mysqli_real_escape_string($con, $_POST['sma']);
  $th_sma= mysqli_real_escape_string($con, $_POST['th_sma']);
  $strata1= mysqli_real_escape_string($con, $_POST['strata1']);
  $th_s1= mysqli_real_escape_string($con, $_POST['th_s1']);
  $strata2= mysqli_real_escape_string($con,$_POST['strata2']);
  $th_s2= mysqli_real_escape_string($con, $_POST['th_s2']);
  $strata3= mysqli_real_escape_string($con, $_POST['strata3']);
  $th_s3= mysqli_real_escape_string($con, $_POST['th_s3']);
  $tgl_2a= mysqli_real_escape_string($con, $_POST['tgl_2a']);
  $tgl_2b= mysqli_real_escape_string($con, $_POST['tgl_2b']);
  $tgl_2c= mysqli_real_escape_string($con, $_POST['tgl_2c']);
  $tgl_2d= mysqli_real_escape_string($con, $_POST['tgl_2d']);
  $tgl_3a= mysqli_real_escape_string($con, $_POST['tgl_3a']);
  $tgl_3b= mysqli_real_escape_string($con, $_POST['tgl_3b']);
  $tgl_3c= mysqli_real_escape_string($con, $_POST['tgl_3c']);
  $tgl_3d= mysqli_real_escape_string($con, $_POST['tgl_3d']);
  $tgl_4a= mysqli_real_escape_string($con, $_POST['tgl_4a']);
  $tgl_4b= mysqli_real_escape_string($con, $_POST['tgl_4b']);
  $tgl_4c= mysqli_real_escape_string($con, $_POST['tgl_4c']);
  $tgl_4d= mysqli_real_escape_string($con, $_POST['tgl_4d']);
  $tgl_4e= mysqli_real_escape_string($con, $_POST['tgl_4e']);
  $password= mysqli_real_escape_string($con, $_POST['password']);
  $md5password=md5($password);

  $level= mysqli_real_escape_string($con, $_POST['level']);

  $cekdata="SELECT id FROM dt_pegawai WHERE id='$id'";
  $ada=mysqli_query($con, $cekdata);
  if(mysqli_num_rows($ada)>0)
  { header("location:dtTendik.php?message=notifGagal"); }
  else  {
  $qry = mysqli_query($con, "INSERT INTO dt_pegawai (id,kat_pegawai,tgl_cpns,tmt,jenis_pegawai,pangkat,jabatan_instansi,status,nama,nama_tg,tempat_lahir,tanggal_lahir,alamat_ktp,alamat_rumah,jenis_kelamin,kntk1,kntk2,email1,email2,sma,th_sma,strata1,th_s1,strata2,th_s2,strata3,th_s3,tgl_2a,tgl_2b,tgl_2c,tgl_2d,tgl_3a,tgl_3b,tgl_3c,tgl_3d,tgl_4a,tgl_4b,tgl_4c,tgl_4d,tgl_4e,password) VALUES ('$id','$kat_pegawai','$tgl_cpns','$tmt','$jenis_pegawai','$pangkat','$jabatan_instansi','$status','$nama','$nama_tg','$tempat_lahir','$tanggal_lahir','$alamat_ktp','$alamat_rumah','$jenis_kelamin','$kntk1','$kntk2','$email1','$email2','$sma','$th_sma','$strata1','$th_s1','$strata2','$th_s2','$strata3','$th_s3','$tgl_2a','$tgl_2b','$tgl_2c','$tgl_2d','$tgl_3a','$tgl_3b','$tgl_3c','$tgl_3d','$tgl_4a','$tgl_4b','$tgl_4c','$tgl_4d','$tgl_4e','$md5password')");

  $qry_log = mysqli_query($con, "INSERT INTO dt_all_adm (username,password,level,nm_person,login_terakhir,status) VALUES ('$id','$md5password','$level','$nama','','$status')");
    header("location:dtTendik.php?message=notifInput");
  }
}
mysqli_close($con);
?>