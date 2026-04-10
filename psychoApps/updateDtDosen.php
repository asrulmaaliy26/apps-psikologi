<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);

  if(isset($_POST['submit'])) {
  $page= mysqli_real_escape_string($con, $_POST['page']);
  $id= mysqli_real_escape_string($con, $_POST['id']);
  $kat_pegawai= mysqli_real_escape_string($con, $_POST['kat_pegawai']);
  $tgl_cpns= mysqli_real_escape_string($con, $_POST['tgl_cpns']);
  $tmt= mysqli_real_escape_string($con, $_POST['tmt']);
  $pangkat= mysqli_real_escape_string($con, $_POST['pangkat']);
  $jabatan= mysqli_real_escape_string($con, $_POST['jabatan']);
  $jabatan_instansi= mysqli_real_escape_string($con, $_POST['jabatan_instansi']);
  $kepakaran_minor= mysqli_real_escape_string($con, $_POST['kepakaran_minor']);
  $kepakaran_mayor= mysqli_real_escape_string($con, $_POST['kepakaran_mayor']);
  $trend_riset= mysqli_real_escape_string($con, $_POST['trend_riset']);
  $profil_riset_terkini= mysqli_real_escape_string($con,$_POST['profil_riset_terkini']);
  $mengajar_pasca= mysqli_real_escape_string($con, $_POST['mengajar_pasca']);
  $menguji_sempro_tesis= mysqli_real_escape_string($con, $_POST['menguji_sempro_tesis']);
  $menguji_ujian_tesis= mysqli_real_escape_string($con, $_POST['menguji_ujian_tesis']);
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
  $strata1= mysqli_real_escape_string($con, $_POST['strata1']);
  $th_s1= mysqli_real_escape_string($con, $_POST['th_s1']);
  $strata2= mysqli_real_escape_string($con,$_POST['strata2']);
  $th_s2= mysqli_real_escape_string($con, $_POST['th_s2']);
  $strata3= mysqli_real_escape_string($con, $_POST['strata3']);
  $th_s3= mysqli_real_escape_string($con, $_POST['th_s3']);
  $guru_bsr= mysqli_real_escape_string($con, $_POST['guru_bsr']);
  $th_gb= mysqli_real_escape_string($con, $_POST['th_gb']);  
  $tgl_3a= mysqli_real_escape_string($con, $_POST['tgl_3a']);
  $tgl_3b= mysqli_real_escape_string($con, $_POST['tgl_3b']);
  $tgl_3c= mysqli_real_escape_string($con, $_POST['tgl_3c']);
  $tgl_3d= mysqli_real_escape_string($con, $_POST['tgl_3d']);
  $tgl_4a= mysqli_real_escape_string($con, $_POST['tgl_4a']);
  $tgl_4b= mysqli_real_escape_string($con, $_POST['tgl_4b']);
  $tgl_4c= mysqli_real_escape_string($con, $_POST['tgl_4c']);
  $tgl_4d= mysqli_real_escape_string($con, $_POST['tgl_4d']);
  $tgl_4e= mysqli_real_escape_string($con, $_POST['tgl_4e']);

  $qry = mysqli_query($con, "UPDATE dt_pegawai SET kat_pegawai='$kat_pegawai',tgl_cpns='$tgl_cpns',tmt='$tmt',pangkat='$pangkat',jabatan='$jabatan',jabatan_instansi='$jabatan_instansi',kepakaran_minor='$kepakaran_minor',kepakaran_mayor='$kepakaran_mayor',trend_riset='$trend_riset',profil_riset_terkini='$profil_riset_terkini',mengajar_pasca='$mengajar_pasca',menguji_sempro_tesis='$menguji_sempro_tesis',menguji_ujian_tesis='$menguji_ujian_tesis',status='$status',nama='$nama',nama_tg='$nama_tg',tempat_lahir='$tempat_lahir',tanggal_lahir='$tanggal_lahir',alamat_ktp='$alamat_ktp',alamat_rumah='$alamat_rumah',jenis_kelamin='$jenis_kelamin',kntk1='$kntk1',kntk2='$kntk2',email1='$email1',email2='$email2',strata1='$strata1',th_s1='$th_s1',strata2='$strata2',th_s2='$th_s2',strata3='$strata3',th_s3='$th_s3',guru_bsr='$guru_bsr',th_gb='$th_gb',tgl_3a='$tgl_3a',tgl_3b='$tgl_3b',tgl_3c='$tgl_3c',tgl_3d='$tgl_3d',tgl_4a='$tgl_4a',tgl_4b='$tgl_4b',tgl_4c='$tgl_4c',tgl_4d='$tgl_4d',tgl_4e='$tgl_4e' WHERE id='$id'");

  $qry_log = mysqli_query($con, "UPDATE dt_all_adm SET nm_person='$nama',status='$status' WHERE username='$id'");
  header("location:dtDosen.php?message=notifEdit&page=$page");
  }
mysqli_close($con);
  ?>