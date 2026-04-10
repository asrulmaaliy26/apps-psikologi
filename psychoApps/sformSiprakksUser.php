<?php include( "contentsConAdm.php" );
   $id=uniqid();
   $nim=mysqli_real_escape_string($con, $_POST['nim']);
   $jenis_praktikum="2";
   $tujuan_prak=mysqli_real_escape_string($con, $_POST['tujuan_prak']);
   $sebutan_pimpinan=mysqli_real_escape_string($con, $_POST['sebutan_pimpinan']);   
   $kota_prak=mysqli_real_escape_string($con, $_POST['kota_prak']);
   $jenjang_testee=mysqli_real_escape_string($con, $_POST['jenjang_testee']);
   $matkul=mysqli_real_escape_string($con, $_POST['matkul']);
   $waktu=mysqli_real_escape_string($con, $_POST['waktu']);
   $jam=mysqli_real_escape_string($con, $_POST['jam']);
   $tgl_pengajuan=mysqli_real_escape_string($con, $_POST['tgl_pengajuan']);
   $split = explode('-', $tgl_pengajuan);
   $bln_pengajuan= mysqli_real_escape_string($con, $split['1']);
   $thn_pengajuan= mysqli_real_escape_string($con, $split['2']);
   $wd1=mysqli_real_escape_string($con, $_POST['wd1']);   
   $statusform=mysqli_real_escape_string($con, $_POST['statusform']);

   $testee1=mysqli_real_escape_string($con, $_POST['testee1']);
   $testee2=mysqli_real_escape_string($con, $_POST['testee2']);
   $testee3=mysqli_real_escape_string($con, $_POST['testee3']);
   $testee4=mysqli_real_escape_string($con, $_POST['testee4']);
   $testee5=mysqli_real_escape_string($con, $_POST['testee5']);
   $testee6=mysqli_real_escape_string($con, $_POST['testee6']);
   $testee7=mysqli_real_escape_string($con, $_POST['testee7']);
   $testee8=mysqli_real_escape_string($con, $_POST['testee8']);
   $testee9=mysqli_real_escape_string($con, $_POST['testee9']);
   $testee10=mysqli_real_escape_string($con, $_POST['testee10']);
   $testee11=mysqli_real_escape_string($con, $_POST['testee11']);
   $testee12=mysqli_real_escape_string($con, $_POST['testee12']);
   $testee13=mysqli_real_escape_string($con, $_POST['testee13']);
   $testee14=mysqli_real_escape_string($con, $_POST['testee14']);
   $testee15=mysqli_real_escape_string($con, $_POST['testee15']);
   $testee16=mysqli_real_escape_string($con, $_POST['testee16']);
   $testee17=mysqli_real_escape_string($con, $_POST['testee17']);
   $testee18=mysqli_real_escape_string($con, $_POST['testee18']);
   $testee19=mysqli_real_escape_string($con, $_POST['testee19']);
   $testee20=mysqli_real_escape_string($con, $_POST['testee20']);

   $urutan1="1";
   $urutan2="2";
   $urutan3="3";
   $urutan4="4";
   $urutan5="5";
   $urutan6="6";
   $urutan7="7";
   $urutan8="8";
   $urutan9="9";
   $urutan10="10";
   $urutan11="11";
   $urutan12="12";
   $urutan13="13";
   $urutan14="14";
   $urutan15="15";
   $urutan16="16";
   $urutan17="17";
   $urutan18="18";
   $urutan19="19";
   $urutan20="20";

   mysqli_query($con, "insert into siprak_siswa(id,nim,jenis_praktikum,tujuan_prak,sebutan_pimpinan,kota_prak,jenjang_testee,matkul,waktu,jam,tgl_pengajuan,bln_pengajuan,thn_pengajuan,wd1,statusform)" .
"values('$id','$nim','$jenis_praktikum','$tujuan_prak','$sebutan_pimpinan','$kota_prak','$jenjang_testee','$matkul','$waktu','$jam','$tgl_pengajuan','$bln_pengajuan','$thn_pengajuan','$wd1','$statusform')") or die(mysqli_error($con));

   $qry=mysqli_query($con, "SELECT id FROM siprak_siswa WHERE id='$id'");
   $ambil=mysqli_fetch_assoc($qry);
   $idPrak=$ambil['id'];
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan1','$testee1')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan2','$testee2')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan3','$testee3')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan4','$testee4')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan5','$testee5')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan6','$testee6')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan7','$testee7')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan8','$testee8')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan9','$testee9')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan10','$testee10')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan11','$testee11')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan12','$testee12')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan13','$testee13')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan14','$testee14')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan15','$testee15')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan16','$testee16')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan17','$testee17')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan18','$testee18')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan19','$testee19')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO testee_siprak(id_siprak,urutan,nama_testee)".
   "VALUES('$idPrak','$urutan20','$testee20')")  or die(mysqli_error($con));

   header("location:riwayatSiprakksUser.php?message=notifInput");
   ?>