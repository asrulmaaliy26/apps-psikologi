<?php include( "contentsConAdm.php" );
   $id=mysqli_real_escape_string($con, $_POST['id']);
   $page=mysqli_real_escape_string($con, $_POST['page']);
   $no_agenda_surat=mysqli_real_escape_string($con, $_POST['no_agenda_surat']);
   $penerima=mysqli_real_escape_string($con, $_POST['penerima']);
   $maksud_spd=mysqli_real_escape_string($con, $_POST['maksud_spd']);
   $tempat_berangkat=mysqli_real_escape_string($con, $_POST['tempat_berangkat']);       
   $tempat_tujuan=mysqli_real_escape_string($con, $_POST['tempat_tujuan']);
   $tempat_tujuan2=mysqli_real_escape_string($con, $_POST['tempat_tujuan2']);
   $tempat_tujuan3=mysqli_real_escape_string($con, $_POST['tempat_tujuan3']);   
   $tanggal_berangkat=mysqli_real_escape_string($con, $_POST['tanggal_berangkat']);
   $tanggal_kembali=mysqli_real_escape_string($con, $_POST['tanggal_kembali']);
   $durasi_spd=mysqli_real_escape_string($con, $_POST['durasi_spd']);
   $tgl_ditetapkan=mysqli_real_escape_string($con, $_POST['tgl_ditetapkan']);
   $tahun=date('Y');
   $editor=mysqli_real_escape_string($con, $_POST['editor']);

   $sql1 =  "SELECT * FROM dt_pegawai WHERE id='$penerima'";
   $result1 = mysqli_query($con, $sql1);
   $data1 = mysqli_fetch_array($result1);
   $jabatan_instansi_penerima=mysqli_real_escape_string($con, $data1['jabatan_instansi']);
   $pangkat=mysqli_real_escape_string($con, $data1['pangkat']);
   
   $sql2 =  "SELECT * FROM ppk";
   $result2 = mysqli_query($con, $sql2);
   $data2 = mysqli_fetch_array($result2);                         
   $ppk=mysqli_real_escape_string($con, $data2['nm']);
   $jabatan_ppk=mysqli_real_escape_string($con, $data2['jabatan_instansi']);
   
   $sql3 =  "SELECT * FROM dt_pegawai WHERE jabatan_instansi='1'";
   $result3 = mysqli_query($con, $sql3);
   $data3 = mysqli_fetch_array($result3);                         
   $dekan=mysqli_real_escape_string($con, $data3['id']);
   
   $myqry="UPDATE spd SET no_agenda_surat='$no_agenda_surat',penerima='$penerima',pangkat='$pangkat',jabatan_instansi_penerima='$jabatan_instansi_penerima',maksud_spd='$maksud_spd',tempat_berangkat='$tempat_berangkat',tempat_tujuan='$tempat_tujuan',tempat_tujuan2='$tempat_tujuan2',tempat_tujuan3='$tempat_tujuan3',tanggal_berangkat='$tanggal_berangkat',tanggal_kembali='$tanggal_kembali',durasi_spd='$durasi_spd',ppk='$ppk',jabatan_ppk='$jabatan_ppk',dekan='$dekan',tgl_ditetapkan='$tgl_ditetapkan',editor='$editor' WHERE id='$id' LIMIT 1";
   mysqli_query($con, $myqry) or die(mysqli_error($con));
   
   header("location:rekapSpdAdm.php?page=$page&message=notifEdit");
   ?>