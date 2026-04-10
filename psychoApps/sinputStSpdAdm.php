<?php include "contentsConAdm.php";
   $id=uniqid();
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $no_agenda_surat=mysqli_real_escape_string($con, $_POST['no_agenda_surat']);
   $perihal=mysqli_real_escape_string($con, $_POST['perihal']);
   $dasar=mysqli_real_escape_string($con, $_POST['dasar']);       
   $awal_berlaku=mysqli_real_escape_string($con, $_POST['awal_berlaku']);   
   $akhir_berlaku=mysqli_real_escape_string($con, $_POST['akhir_berlaku']);   
   $tgl_ditetapkan=mysqli_real_escape_string($con, $_POST['tgl_ditetapkan']);
   $split = explode('-', $tgl_ditetapkan);
   $bulan= mysqli_real_escape_string($con, $split['1']);
   $tahun= mysqli_real_escape_string($con, $split['0']);
   $jenis_st="2";
   $executor= mysqli_real_escape_string($con, $_POST['executor']);
   
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
   
   //* insert st* //
   $sql7 =  "SELECT * FROM dt_pegawai WHERE jabatan_instansi='1'";
   $result7 = mysqli_query($con, $sql7);
   $data7 = mysqli_fetch_array($result7);                         
   $dekan=mysqli_real_escape_string($con, $data7['id']);
   
   mysqli_query($con, "INSERT INTO st(id,no_agenda_surat,perihal,dasar,awal_berlaku,akhir_berlaku,tgl_ditetapkan,jenis_st,dekan,bulan,tahun,executor)" .
   "VALUES('$id','$no_agenda_surat','$perihal','$dasar','$awal_berlaku','$akhir_berlaku','$tgl_ditetapkan','$jenis_st','$dekan','$bulan','$tahun','$executor')") or die(mysqli_error($con)); 
      
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$id','$urutan1','$nama1','$jabatan1')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$id','$urutan2','$nama2','$jabatan2')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$id','$urutan3','$nama3','$jabatan3')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$id','$urutan4','$nama4','$jabatan4')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$id','$urutan5','$nama5','$jabatan5')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$id','$urutan6','$nama6','$jabatan6')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$id','$urutan7','$nama7','$jabatan7')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$id','$urutan8','$nama8','$jabatan8')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$id','$urutan9','$nama9','$jabatan9')")  or die(mysqli_error($con));

   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$id','$urutan56','$nama56','$jabatan56')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$id','$urutan57','$nama57','$jabatan57')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$id','$urutan58','$nama58','$jabatan58')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$id','$urutan59','$nama59','$jabatan59')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$id','$urutan60','$nama60','$jabatan60')")  or die(mysqli_error($con));
   mysqli_query($con, "INSERT INTO personil_st(id_st,urutan,nama,jabatan_st)".
   "VALUES('$id','$urutan61','$nama61','$jabatan61')")  or die(mysqli_error($con));
   
   $sql1 =  "SELECT * FROM personil_st WHERE id_st='$id' AND urutan='1'";
   $result1 = mysqli_query($con, $sql1);
   $data1 = mysqli_fetch_array($result1);                         
   $d1=$data1['nama'];
   $s1 =  "SELECT * FROM dt_pegawai WHERE id='$d1'";
   $r1 = mysqli_query($con, $s1);
   $dt1 = mysqli_fetch_array($r1);                         
   $mydata1=$dt1['jabatan_instansi'];
   
   $sql2 =  "SELECT * FROM personil_st WHERE id_st='$id' AND urutan='2'";
   $result2 = mysqli_query($con, $sql2);
   $data2 = mysqli_fetch_array($result2);                         
   $d2=$data2['nama'];
   $s2 =  "SELECT * FROM dt_pegawai WHERE id='$d2'";
   $r2 = mysqli_query($con, $s2);
   $dt2 = mysqli_fetch_array($r2);                         
   $mydata2=$dt2['jabatan_instansi'];
   
   $sql3 =  "SELECT * FROM personil_st WHERE id_st='$id' AND urutan='3'";
   $result3 = mysqli_query($con, $sql3);
   $data3 = mysqli_fetch_array($result3);                         
   $d3=$data3['nama'];
   $s3 =  "SELECT * FROM dt_pegawai WHERE id='$d3'";
   $r3 = mysqli_query($con, $s3);
   $dt3 = mysqli_fetch_array($r3);                         
   $mydata3=$dt3['jabatan_instansi'];
   
   $sql4 =  "SELECT * FROM personil_st WHERE id_st='$id' AND urutan='4'";
   $result4 = mysqli_query($con, $sql4);
   $data4 = mysqli_fetch_array($result4);                         
   $d4=$data4['nama'];
   $s4 =  "SELECT * FROM dt_pegawai WHERE id='$d4'";
   $r4 = mysqli_query($con, $s4);
   $dt4 = mysqli_fetch_array($r4);                         
   $mydata4=$dt4['jabatan_instansi'];
   
   $sql5 =  "SELECT * FROM personil_st WHERE id_st='$id' AND urutan='5'";
   $result5 = mysqli_query($con, $sql5);
   $data5 = mysqli_fetch_array($result5);                         
   $d5=$data5['nama'];
   $s5 =  "SELECT * FROM dt_pegawai WHERE id='$d5'";
   $r5 = mysqli_query($con, $s5);
   $dt5 = mysqli_fetch_array($r5);                         
   $mydata5=$dt5['jabatan_instansi'];
   
   $sql6 =  "SELECT * FROM personil_st WHERE id_st='$id' AND urutan='6'";
   $result6 = mysqli_query($con, $sql6);
   $data6 = mysqli_fetch_array($result6);                         
   $d6=$data6['nama'];
   $s6 =  "SELECT * FROM dt_pegawai WHERE id='$d6'";
   $r6 = mysqli_query($con, $s6);
   $dt6 = mysqli_fetch_array($r6);                         
   $mydata6=$dt6['jabatan_instansi'];

   $sql7 =  "SELECT * FROM personil_st WHERE id_st='$id' AND urutan='7'";
   $result7 = mysqli_query($con, $sql7);
   $data7 = mysqli_fetch_array($result7);                         
   $d7=$data7['nama'];
   $s7 =  "SELECT * FROM dt_pegawai WHERE id='$d7'";
   $r7 = mysqli_query($con, $s7);
   $dt7 = mysqli_fetch_array($r7);                         
   $mydata7=$dt7['jabatan_instansi'];

   $sql8 =  "SELECT * FROM personil_st WHERE id_st='$id' AND urutan='8'";
   $result8 = mysqli_query($con, $sql8);
   $data8 = mysqli_fetch_array($result8);                         
   $d8=$data8['nama'];
   $s8 =  "SELECT * FROM dt_pegawai WHERE id='$d8'";
   $r8 = mysqli_query($con, $s8);
   $dt8 = mysqli_fetch_array($r8);                         
   $mydata8=$dt8['jabatan_instansi'];

   $sql9 =  "SELECT * FROM personil_st WHERE id_st='$id' AND urutan='9'";
   $result9 = mysqli_query($con, $sql9);
   $data9 = mysqli_fetch_array($result9);                         
   $d9=$data9['nama'];
   $s9 =  "SELECT * FROM dt_pegawai WHERE id='$d9'";
   $r9 = mysqli_query($con, $s9);
   $dt9 = mysqli_fetch_array($r9);                         
   $mydata9=$dt9['jabatan_instansi'];
   
   $qry="UPDATE personil_st SET jabatan_st='$mydata1' WHERE id_st='$id' AND urutan='1' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   
   $qry="UPDATE personil_st SET jabatan_st='$mydata2' WHERE id_st='$id' AND urutan='2' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   
   $qry="UPDATE personil_st SET jabatan_st='$mydata3' WHERE id_st='$id' AND urutan='3' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   
   $qry="UPDATE personil_st SET jabatan_st='$mydata4' WHERE id_st='$id' AND urutan='4' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   
   $qry="UPDATE personil_st SET jabatan_st='$mydata5' WHERE id_st='$id' AND urutan='5' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));
   
   $qry="UPDATE personil_st SET jabatan_st='$mydata6' WHERE id_st='$id' AND urutan='6' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));

   $qry="UPDATE personil_st SET jabatan_st='$mydata7' WHERE id_st='$id' AND urutan='7' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));

   $qry="UPDATE personil_st SET jabatan_st='$mydata8' WHERE id_st='$id' AND urutan='8' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));

   $qry="UPDATE personil_st SET jabatan_st='$mydata9' WHERE id_st='$id' AND urutan='9' LIMIT 1";
   mysqli_query($con, $qry) or die(mysqli_error($con));

   header("location:rekapSuratTugasAdm.php?page=$page&message=notifInput");
   ?>