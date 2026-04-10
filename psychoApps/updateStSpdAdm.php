<?php include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $no_agenda_surat=mysqli_real_escape_string($con, $_POST['no_agenda_surat']);
   $perihal=mysqli_real_escape_string($con, $_POST['perihal']);
   $dasar=mysqli_real_escape_string($con, $_POST['dasar']);       
   $awal_berlaku=mysqli_real_escape_string($con, $_POST['awal_berlaku']);   
   $akhir_berlaku=mysqli_real_escape_string($con, $_POST['akhir_berlaku']);
   $tgl_ditetapkan=mysqli_real_escape_string($con, $_POST['tgl_ditetapkan']);
   $editor=mysqli_real_escape_string($con, $_POST['editor']);
   
   //* update st * //
   $myqry="UPDATE st SET no_agenda_surat='$no_agenda_surat',perihal='$perihal',dasar='$dasar',awal_berlaku='$awal_berlaku',akhir_berlaku='$akhir_berlaku',tgl_ditetapkan='$tgl_ditetapkan',editor='$editor' WHERE id='$id' LIMIT 1";
   mysqli_query($con, $myqry) or die(mysqli_error($con));
   
   //* personil * //
       
   $nama1=mysqli_real_escape_string($con, $_POST['nama1']);
   $nama2=mysqli_real_escape_string($con, $_POST['nama2']);
   $nama3=mysqli_real_escape_string($con, $_POST['nama3']);
   $nama4=mysqli_real_escape_string($con, $_POST['nama4']);
   $nama5=mysqli_real_escape_string($con, $_POST['nama5']);
   $nama6=mysqli_real_escape_string($con, $_POST['nama6']);
   $nama7=mysqli_real_escape_string($con, $_POST['nama7']);
   $nama8=mysqli_real_escape_string($con, $_POST['nama8']);
   $nama9=mysqli_real_escape_string($con, $_POST['nama9']);

   $nama56=mysqli_real_escape_string($con, $_POST['nama56']);
   $nama57=mysqli_real_escape_string($con, $_POST['nama57']);
   $nama58=mysqli_real_escape_string($con, $_POST['nama58']);
   $nama59=mysqli_real_escape_string($con, $_POST['nama59']);
   $nama60=mysqli_real_escape_string($con, $_POST['nama60']);
   $nama61=mysqli_real_escape_string($con, $_POST['nama61']);
   
   $s1 =  "SELECT * FROM dt_pegawai WHERE id='".$_POST['nama1']."'";
   $r1 = mysqli_query($con, $s1);
   $dt1 = mysqli_fetch_array($r1);                         
   $mydata1=$dt1['jabatan_instansi'];
   
   $s2 =  "SELECT * FROM dt_pegawai WHERE id='".$_POST['nama2']."'";
   $r2 = mysqli_query($con, $s2);
   $dt2 = mysqli_fetch_array($r2);                         
   $mydata2=$dt2['jabatan_instansi'];
   
   $s3 =  "SELECT * FROM dt_pegawai WHERE id='".$_POST['nama3']."'";
   $r3 = mysqli_query($con, $s3);
   $dt3 = mysqli_fetch_array($r3);                         
   $mydata3=$dt3['jabatan_instansi'];
   
   $s4 =  "SELECT * FROM dt_pegawai WHERE id='".$_POST['nama4']."'";
   $r4 = mysqli_query($con, $s4);
   $dt4 = mysqli_fetch_array($r4);                         
   $mydata4=$dt4['jabatan_instansi'];
   
   $s5 =  "SELECT * FROM dt_pegawai WHERE id='".$_POST['nama5']."'";
   $r5 = mysqli_query($con, $s5);
   $dt5 = mysqli_fetch_array($r5);                         
   $mydata5=$dt5['jabatan_instansi'];
   
   $s6 =  "SELECT * FROM dt_pegawai WHERE id='".$_POST['nama6']."'";
   $r6 = mysqli_query($con, $s6);
   $dt6 = mysqli_fetch_array($r6);                         
   $mydata6=$dt6['jabatan_instansi'];
   
   $s7 =  "SELECT * FROM dt_pegawai WHERE id='".$_POST['nama7']."'";
   $r7 = mysqli_query($con, $s7);
   $dt7 = mysqli_fetch_array($r7);                         
   $mydata7=$dt7['jabatan_instansi'];
   
   $s8 =  "SELECT * FROM dt_pegawai WHERE id='".$_POST['nama8']."'";
   $r8 = mysqli_query($con, $s8);
   $dt8 = mysqli_fetch_array($r8);                         
   $mydata8=$dt8['jabatan_instansi'];
   
   $s9 =  "SELECT * FROM dt_pegawai WHERE id='".$_POST['nama9']."'";
   $r9 = mysqli_query($con, $s9);
   $dt9 = mysqli_fetch_array($r9);                         
   $mydata9=$dt9['jabatan_instansi'];

   $jabatan56=mysqli_real_escape_string($con, $_POST['jabatan56']);
   $jabatan57=mysqli_real_escape_string($con, $_POST['jabatan57']);
   $jabatan58=mysqli_real_escape_string($con, $_POST['jabatan58']);
   $jabatan59=mysqli_real_escape_string($con, $_POST['jabatan59']);
   $jabatan60=mysqli_real_escape_string($con, $_POST['jabatan60']);
   $jabatan61=mysqli_real_escape_string($con, $_POST['jabatan61']);
   
   $urutan1="1";
   $urutan2="2";
   $urutan3="3";
   $urutan4="4";
   $urutan5="5";
   $urutan6="6";
   $urutan7="7";
   $urutan8="8";
   $urutan9="9";

   $urutan56="56";
   $urutan57="57";
   $urutan58="58";
   $urutan59="59";
   $urutan60="60";
   $urutan61="61";

   //* update personil * //
   $qry="UPDATE personil_st SET nama='$nama1',jabatan_st='$mydata1' WHERE id_st='$id' AND urutan='1' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   $qry="UPDATE personil_st SET nama='$nama2',jabatan_st='$mydata2' WHERE id_st='$id' AND urutan='2' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   $qry="UPDATE personil_st SET nama='$nama3',jabatan_st='$mydata3' WHERE id_st='$id' AND urutan='3' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   $qry="UPDATE personil_st SET nama='$nama4',jabatan_st='$mydata4' WHERE id_st='$id' AND urutan='4' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   $qry="UPDATE personil_st SET nama='$nama5',jabatan_st='$mydata5' WHERE id_st='$id' AND urutan='5' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   $qry="UPDATE personil_st SET nama='$nama6',jabatan_st='$mydata6' WHERE id_st='$id' AND urutan='6' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   $qry="UPDATE personil_st SET nama='$nama7',jabatan_st='$mydata7' WHERE id_st='$id' AND urutan='7' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   $qry="UPDATE personil_st SET nama='$nama8',jabatan_st='$mydata8' WHERE id_st='$id' AND urutan='8' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   $qry="UPDATE personil_st SET nama='$nama9',jabatan_st='$mydata9' WHERE id_st='$id' AND urutan='9' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   
   $qry="UPDATE personil_st SET nama='$nama56',jabatan_st='$jabatan56' WHERE id_st='$id' AND urutan='56' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   $qry="UPDATE personil_st SET nama='$nama57',jabatan_st='$jabatan57' WHERE id_st='$id' AND urutan='57' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   $qry="UPDATE personil_st SET nama='$nama58',jabatan_st='$jabatan58' WHERE id_st='$id' AND urutan='58' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   $qry="UPDATE personil_st SET nama='$nama59',jabatan_st='$jabatan59' WHERE id_st='$id' AND urutan='59' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   $qry="UPDATE personil_st SET nama='$nama60',jabatan_st='$jabatan60' WHERE id_st='$id' AND urutan='60' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   $qry="UPDATE personil_st SET nama='$nama61',jabatan_st='$jabatan61' WHERE id_st='$id' AND urutan='61' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   
   header("location:rekapSuratTugasAdm.php?page=$page&message=notifEdit");
   ?>