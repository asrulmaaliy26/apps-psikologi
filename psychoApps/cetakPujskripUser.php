<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $nim = $_SESSION[ 'nim' ];
  $myquery = "SELECT * FROM peserta_ujskrip WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $res );
   
  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$dt[nim]'";
  $dmhssw = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $dmhssw );
   
  $qfak= "SELECT * FROM nm_fakultas WHERE id='$dataku[fakultas_pertama_daftar]'";
  $resfak = mysqli_query($con,  $qfak )or die( mysqli_error($con) );
  $dfak = mysqli_fetch_assoc( $resfak );
   
  $qjur= "SELECT * FROM nm_jurusan WHERE id='$dataku[jurusan_pertama_daftar]'";
  $resjur = mysqli_query($con,  $qjur )or die( mysqli_error($con) );
  $djur = mysqli_fetch_assoc( $resjur );
   
  $qjl = "SELECT * FROM nama_jurusan_lembaga";
  $resjl = mysqli_query($con,  $qjl )or die( mysqli_error($con) );
  $djl = mysqli_fetch_assoc( $resjl );
  $nm_jurusan_lembaga = $djl['nm'];
   
  $qnl = "SELECT * FROM nama_lembaga";
  $resnl = mysqli_query($con,  $qnl )or die( mysqli_error($con) );
  $dnl = mysqli_fetch_assoc( $resnl );
  $nm_lembaga = $dnl['nm'];
   
  $qnli = "SELECT * FROM nama_lembaga_induk";
  $resnli = mysqli_query($con,  $qnli )or die( mysqli_error($con) );
  $dnli = mysqli_fetch_assoc( $resnli );
  $nm_lembaga_induk = $dnli['nm'];
   
  $qdw= "SELECT * FROM dt_pegawai WHERE id='$dataku[dosen_wali]'";
  $resdw = mysqli_query($con,  $qdw )or die( mysqli_error($con) );
  $ddw = mysqli_fetch_assoc( $resdw );
   
  $qdk= "SELECT * FROM dt_kota WHERE id='$dataku[tempat_lahir]'";
  $resdk = mysqli_query($con,  $qdk )or die( mysqli_error($con) );
  $ddk = mysqli_fetch_assoc( $resdk );
   
  $qjk= "SELECT * FROM jns_kelamin WHERE id='$dataku[jenis_kelamin]'";
  $resjk = mysqli_query($con,  $qjk )or die( mysqli_error($con) );
  $djk = mysqli_fetch_assoc( $resjk );
   
  $qpa= "SELECT * FROM jns_pkrjn WHERE id='$dataku[pekerjaan_ayah]'";
  $respa = mysqli_query($con,  $qpa )or die( mysqli_error($con) );
  $dpa = mysqli_fetch_assoc( $respa );
   
  $qpi= "SELECT * FROM jns_pkrjn WHERE id='$dataku[pekerjaan_ibu]'";
  $respi = mysqli_query($con,  $qpi )or die( mysqli_error($con) );
  $dpi = mysqli_fetch_assoc( $respi );
   
  $qpemb1 = "SELECT * FROM dt_pegawai WHERE id='$dt[pembimbing1]'";
  $resp = mysqli_query($con,  $qpemb1 )or die( mysqli_error($con) );
  $dpemb1 = mysqli_fetch_assoc( $resp );
      
  $qpemb2 = "SELECT * FROM dt_pegawai WHERE id='$dt[pembimbing2]'";
  $resp = mysqli_query($con,  $qpemb2 )or die( mysqli_error($con) );
  $dpemb2 = mysqli_fetch_assoc( $resp );
   
  $qry_moment = "SELECT * FROM pendaftaran_skripsi WHERE id='$dt[id_ujskrip]'";
  $hasil = mysqli_query($con, $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_ujskrip=$data['id'];
  $thp=$data['tahap'];
  $ta=$data['ta'];
   
  $qry_nm_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$thp'";
  $hasil = mysqli_query($con, $qry_nm_thp);
  $dthp = mysqli_fetch_assoc($hasil);
   
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$ta'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);

  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
   
  $jdwl = "SELECT * FROM jadwal_ujskrip WHERE id='$dt[id_jdwl]'";
  $rjdwl = mysqli_query($con,  $jdwl )or die( mysqli_error($con) );
  $djdwl = mysqli_fetch_assoc( $rjdwl );
   
  $qruang = "SELECT * FROM dt_ruang WHERE id='$djdwl[ruang]'";
  $resp = mysqli_query($con,  $qruang )or die( mysqli_error($con) );
  $druang = mysqli_fetch_assoc( $resp );
   
  $tanggal=date("d-m-Y", strtotime($djdwl['tgl_ujian']));
  $day = date('D', strtotime($tanggal));
  $dayList = array(
  'Sun' => 'Minggu',
  'Mon' => 'Senin',
  'Tue' => 'Selasa',
  'Wed' => 'Rabu',
   
  'Thu' => 'Kamis',
  'Fri' => "Jum'at",
  'Sat' => 'Sabtu'
   );
   
   function bulanIndo($tanggal)
   {
   $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
   'September','Oktober','Nopember','Desember');
   $split = explode('-', $tanggal);
   return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
   }   
   
   function bulanIndo2($tanggal2)
   {
   $bulan2 = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
   'September','Oktober','Nopember','Desember');
   $split2 = explode('-', $tanggal2);
   return $split2[0] . ' ' . $bulan2[ (int)$split2[1] ] . ' ' . $split2[2];
   } 
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Pendaftaran Ujian Skripsi</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      table.biodata {
         border-collapse: collapse;
         text-transform:uppercase;
         }
         table.biodata tr, td {
         vertical-align: top;
         }
         table.biodata td {
         border:none;
         padding: 2px;
         }
         table.a {
         border-collapse: collapse;
         text-transform:uppercase;
         }
         table.a tr, td {
         vertical-align: top;
         }
         table.a td {
         border:none;
         padding: 4px;
         }
         table.a-1 {
         border-collapse: collapse;
         text-transform:uppercase;
         }
         table.a-1 tr, td {
         vertical-align: top;
         }
         table.a-1 td {
         border:none;
         padding: 3px;
         }
         table.a-2 {
         border-collapse: collapse;
         text-transform:uppercase;
         }
         table.a-2 tr, td {
         vertical-align: top;
         }
         table.a-2 td {
         border:none;
         padding: 3px;
         }
         table.a-3 {
         border-collapse: collapse;
         text-transform:uppercase;
         }
         table.a-3 tr, td {
         vertical-align: top;
         }
         table.a-3 td {
         border:none;
         padding: 3px;
         }
         table.a-4 {
         border-collapse: collapse;
         text-transform:uppercase;
         }
         table.a-4 tr, td {
         vertical-align: top;
         }
         table.a-4 td {
         border:none;
         padding: 3px;
         }
         table.a-4-1 {
         border: 1px solid #000000;
         border-collapse: collapse;
         }
         table.a-4-1 tr, td {
         vertical-align: top;
         }
         table.a-4-1 td {
         border:none;
         padding: 3px;
         }
         table.a-4-2 {
         border-collapse: collapse;
         }
         table.a-4-2 tr, td {
         vertical-align: top;
         }
         table.a-4-2 td {
         border:none;
         padding: 3px;
         }
         table.foto {
         border: 1px solid #000000;
         width: 100%;
         height: 170px;
         text-align: left;
         border-collapse: collapse;
         }
         table.foto td, table.foto th {
         border: 1px solid #000000;
         padding: 2px 2px 2px 2px;
         }
         table.ket {
         width: 100%;
         text-align: left;
         border-collapse: collapse;
         }
         .right-photo {
         float: right;
         position: absolute;
         top: 180px;
         right: 40px;
         }
         .right-ttd {
         float: right;
         width: 280px;
         text-transform:uppercase;
         }     
         .border-format {
         border: 1px solid rgba(0,0,0,0.5);
         border-radius: 4px;
         padding:4px;
         width:22%;
         float:left;
         }
         .border-reg {
         border: 1px solid rgba(0,0,0,0.5);
         border-radius: 4px;
         padding:4px;
         width:26%;
         float:right;
         }
         @media print {
         body {margin-top: 10mm; margin-bottom: 20mm;
         margin-left: 10mm; margin-right: 10mm}
         div.page
         {
         page-break-after: always;
         page-break-inside: avoid;
         }
         }
    </style>
  </head>
  <body style="font-family:Arial, Helvetica, sans-serif; font-size:1em;">
    <div class="page">
         <?php
            include( "kopPotretAUser.php" );
            ?>
         <div class="border-reg"><code>Reg. <?php echo "$dt[id_reg]"?></code></div>
         <br />     
         <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>BIODATA PESERTA UJIAN SKRIPSI <br />
            <?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' '.$dnta['ta']; ?></strong>
         </p>
         <div class="right-photo">
            <?php if(empty($dataku['photo'])) { if($dataku['jenis_kelamin']=="1") { echo '<img src="images/cewek.png"  width="84rem" height="94rem" />';} else { echo '<img src="images/cowok.png" width="84rem" height="94rem" />';}} else { echo '<img src="'.$dataku['photo'].'" width="84rem" height="94rem" />';}?>
         </div>
         <div>
            <p style="margin-bottom:2px;"><strong>DATA AKADEMIK</strong></p>
            <table width="100%" class="biodata">
               <tr>
                  <td width="36%">NIM</td>
                  <td width="2%" align="center">:</td>
                  <td width="62%"><?php if(empty($dataku['nim'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nim]";}?></td>
               </tr>
               <tr>
                  <td>Nama Lengkap</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['nama'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama]";}?></td>
               </tr>
               <tr>
                  <td>Angkatan</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['angkatan'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[angkatan]";}?></td>
               </tr>
               <tr>
                  <td>Fakultas Pertama Daftar</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['fakultas_pertama_daftar'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dfak[nm]";}?></td>
               </tr>
               <tr>
                  <td>Jurusan Pertama Daftar</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['jurusan_pertama_daftar'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$djur[nm]";}?></td>
               </tr>
               <tr>
                  <td>Asal SMA/MA</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['asal_sekolah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[asal_sekolah]";}?></td>
               </tr>
               <tr>
                  <td>Riwayat Pendidikan Terakhir</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['pend_terakhir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[pend_terakhir]";}?></td>
               </tr>
               <tr>
                  <td>Dosen Wali</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['dosen_wali'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$ddw[nama]";}?></td>
               </tr>
               <tr>
                  <td>Dosen Pembimbing Skripsi</td>
                  <td align="center">:</td>
                  <td><?php echo "$dpemb1[nama]";?></td>
               </tr>
               <tr>
                  <td>Judul Skripsi *)</td>
                  <td align="center">:</td>
                  <td><?php echo $dt['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_skripsi']);?></td>
               </tr>
            </table>
            <p style="margin-bottom:2px;"><strong>DATA PRIBADI</strong></p>
            <table width="100%" class="biodata">
               <tr>
                  <td width="36%">Tempat, Tanggal Lahir</td>
                  <td width="2%" align="center">:</td>
                  <td width="62%"><?php if(empty($dataku['tempat_lahir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$ddk[nm_kota]";}?>, <?php if(empty($dataku['tanggal_lahir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo bulanIndo($dataku['tanggal_lahir']);}?></td>
               </tr>
               <tr>
                  <td>Alamat Asal</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['alamat_ktp'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[alamat_ktp]";}?></td>
               </tr>
               <tr>
                  <td>Alamat di Malang</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['alamat_malang'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[alamat_malang]";}?></td>
               </tr>
               <tr>
                  <td>Jenis Kelamin</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['jenis_kelamin'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$djk[nm]";}?></td>
               </tr>
               <tr>
                  <td>Kontak HP</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['kntk'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[kntk]";}?></td>
               </tr>
               <tr>
                  <td>email</td>
                  <td align="center">:</td>
                  <td style="text-transform:lowercase"><?php if(empty($dataku['imel'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[imel]";}?></td>
               </tr>
               <tr>
                  <td>facebook</td>
                  <td align="center">:</td>
                  <td style="text-transform:none;"><?php echo "$dataku[facebook]";?></td>
               </tr>
               <tr>
                  <td>twitter</td>
                  <td align="center">:</td>
                  <td style="text-transform:none;"><?php echo "$dataku[twitter]";?></td>
               </tr>
               <tr>
                  <td>instagram</td>
                  <td align="center">:</td>
                  <td style="text-transform:none;"><?php echo "$dataku[instagram]";?></td>
               </tr>
               <tr>
                  <td>blog/Website</td>
                  <td align="center">:</td>
                  <td style="text-transform:none;"><?php echo "$dataku[web]";?></td>
               </tr>
            </table>
            <p style="margin-bottom:2px;"><strong>DATA ORANGTUA</strong></p>
            <table width="100%" class="biodata">
               <tr>
                  <td width="36%">Nama Ayah</td>
                  <td width="2%" align="center">:</td>
                  <td width="62%"><?php if(empty($dataku['nama_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama_ayah]";}?></td>
               </tr>
               <tr>
                  <td>Pekerjaan Ayah</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['pekerjaan_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dpa[nm]";}?></td>
               </tr>
               <tr>
                  <td>Alamat Ayah</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['alamat_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[alamat_ayah]";}?></td>
               </tr>
               <tr>
                  <td>Kontak/HP Ayah</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['telepon_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[telepon_ayah]";}?></td>
               </tr>
               <tr>
                  <td>Nama Ibu</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['nama_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama_ibu]";}?></td>
               </tr>
               <tr>
                  <td>Pekerjaan Ibu</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['pekerjaan_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dpi[nm]";}?></td>
               </tr>
               <tr>
                  <td>Alamat Ibu</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['alamat_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[alamat_ibu]";}?></td>
               </tr>
               <tr>
                  <td>Kontak/HP Ibu</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['telepon_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[telepon_ibu]";}?></td>
               </tr>
            </table>
         </div>
         <br />
         <br />
         <div class="right-ttd">
            Malang, <?php echo bulanIndo2($dt['tgl_pengajuan']);?>
            <br />
            <br />
            <br />
            <br />
            <br />
            <?php echo "$dataku[nama]";?>
            <br />
            NIM. <?php echo "$dataku[nim]";?>
         </div>
      </div>
      <br />
      <div class="page" style="padding-top: 18px;">
         <?php
            include( "kopPotretAUser.php" );
            ?>
         <div class="border-reg"><code>Reg. <?php echo "$dt[id_reg]"?></code></div>
         <div class="border-format"><code>FORMAT MODEL: A</code></div>
         <br />
         <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>IDENTITAS PESERTA UJIAN SKRIPSI <br />
            <?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' '.$dnta['ta']; ?></strong>
         </p>
         <div>
            <table width="100%" class="a">
               <tr>
                  <td width="36%">Nama Lengkap</td>
                  <td width="2%" align="center">:</td>
                  <td width="62%"><?php echo "$dataku[nama]";?></td>
               </tr>
               <tr>
                  <td>NIM</td>
                  <td align="center">:</td>
                  <td><?php echo "$dataku[nim]";?></td>
               </tr>
               <tr>
                  <td>Fakultas/Jurusan</td>
                  <td align="center">:</td>
                  <td><?php echo "$nm_lembaga".'/'."$nm_jurusan_lembaga";?></td>
               </tr>
               <tr>
                  <td>No.Telp/HP</td>
                  <td align="center">:</td>
                  <td><?php echo "$dataku[kntk]";?></td>
               </tr>
               <tr>
                  <td>Judul Skripsi *)</td>
                  <td align="center">:</td>
                  <td><?php echo $dt['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_skripsi']);?></td>
               </tr>
               <tr>
                  <td>Dosen Pembimbing Skripsi</td>
                  <td align="center">:</td>
                  <td><?php echo "$dpemb1[nama]";?></td>
               </tr>
               <tr>
                  <td>Tanggal Ujian Skripsi</td>
                  <td align="center">:</td>
                  <td><?php if(empty($djdwl['tgl_ujian'])) { echo "";} else { echo $dayList[$day].', '.bulanIndo2($djdwl['tgl_ujian']);}?></td>
               </tr>
               <tr>
                  <td>Pukul Ujian Skripsi</td>
                  <td align="center">:</td>
                  <td><?php if(empty($djdwl['jam_mulai']) && empty($djdwl['jam_selesai'])) { echo "";} else { echo $djdwl['jam_mulai'].' - '.$djdwl['jam_selesai'].' WIB.';}?></td>
               </tr>
               <tr>
                  <td>Ruang Ujian Skripsi</td>
                  <td align="center">:</td>
                  <td><?php echo "$druang[nm]";?></td>
               </tr>
            </table>
         </div>
         <br />
         <br />
         <div class="right-ttd">
            Malang, <?php echo bulanIndo2($dt['tgl_pengajuan']);?>
            <br />
            <br />
            <br />
            <br />
            <br />
            <?php echo "$dataku[nama]";?>
            <br />
            NIM. <?php echo "$dataku[nim]";?>
         </div>
      </div>
      <br />
      <div class="page" style="padding-top: 18px;">
         <?php
            include( "kopPotretAUser.php" );
            ?>
         <div class="border-reg"><code>Reg. <?php echo "$dt[id_reg]"?></code></div>
         <div class="border-format"><code>FORMAT MODEL: A-1</code></div>
         <br />
         <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>IDENTITAS PESERTA UJIAN SKRIPSI <br />
            <?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' '.$dnta['ta']; ?></strong>
         </p>
         <div>
            <table width="100%" class="a-1">
               <tr>
                  <td width="36%">Nama Lengkap</td>
                  <td width="2%" align="center">:</td>
                  <td width="62%"><?php if(empty($dataku['nama'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama]";}?></td>
               </tr>
               <tr>
                  <td >NIM</td>
                  <td>:</td>
                  <td><?php if(empty($dataku['nim'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nim]";}?></td>
               </tr>
               <tr>
                  <td>Jenis Kelamin</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['jenis_kelamin'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$djk[nm]";}?></td>
               </tr>
               <tr>
                  <td>Tempat, Tanggal Lahir</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['tempat_lahir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$ddk[nm_kota]";}?>, <?php if(empty($dataku['tanggal_lahir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo bulanIndo($dataku['tanggal_lahir']);}?></td>
               </tr>
               <tr>
                  <td>Angkatan</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['angkatan'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[angkatan]";}?></td>
               </tr>
               <tr>
                  <td>Fakultas Pertama Daftar</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['fakultas_pertama_daftar'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dfak[nm]";}?></td>
               </tr>
               <tr>
                  <td>Jurusan Pertama Daftar</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['jurusan_pertama_daftar'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$djur[nm]";}?></td>
               </tr>
               <tr>
                  <td>Riwayat Pendidikan Terakhir</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['pend_terakhir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[pend_terakhir]";}?></td>
               </tr>
               <tr>
                  <td>Judul Skripsi *)</td>
                  <td align="center">:</td>
                  <td><?php echo $dt['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_skripsi']);?></td>
               </tr>
               <tr>
                  <td>Dosen Pembimbing Skripsi</td>
                  <td align="center">:</td>
                  <td><?php echo "$dpemb1[nama]";?></td>
               </tr>
               <tr>
                  <td>Alamat di Malang</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['alamat_malang'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[alamat_malang]";}?></td>
               </tr>
               <tr>
                  <td>No.Telp/HP</td>
                  <td align="center">:</td>
                  <td><?php echo "$dataku[kntk]";?></td>
               </tr>
               <tr>
                  <td>email</td>
                  <td align="center">:</td>
                  <td style="text-transform:lowercase"><?php if(empty($dataku['imel'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[imel]";}?></td>
               </tr>
               <tr>
                  <td>Nama Ayah</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['nama_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama_ayah]";}?></td>
               </tr>
               <tr>
                  <td>Pekerjaan Ayah</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['pekerjaan_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dpa[nm]";}?></td>
               </tr>
               <tr>
                  <td>Alamat Ayah</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['alamat_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[alamat_ayah]";}?></td>
               </tr>
               <tr>
                  <td>Kontak/HP Ayah</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['telepon_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[telepon_ayah]";}?></td>
               </tr>
               <tr>
                  <td>Nama Ibu</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['nama_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama_ibu]";}?></td>
               </tr>
               <tr>
                  <td>Pekerjaan Ibu</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['pekerjaan_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dpi[nm]";}?></td>
               </tr>
               <tr>
                  <td>Alamat Ibu</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['alamat_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[alamat_ibu]";}?></td>
               </tr>
               <tr>
                  <td>Kontak/HP Ibu</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['telepon_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[telepon_ibu]";}?></td>
               </tr>
            </table>
         </div>
         <br />
         <br />
         <div class="right-ttd" style="margin-bottom:20px;">
            Malang, <?php echo bulanIndo2($dt['tgl_pengajuan']);?>
            <br />
            <br />
            <br />
            <br />
            <br />
            <?php echo "$dataku[nama]";?>
            <br />
            NIM. <?php echo "$dataku[nim]";?>
         </div>
         <div>
            <table class="foto">
               <tbody>
                  <tr>
                     <td><small>Tempel 6 lembar foto ukuran 3x4 di sini.</small></td>
                  </tr>
               </tbody>
            </table>
         </div>
         <span><small> *) Apabila di saat ujian ada perubahan judul, segera hubungi staf BAK Fakultas Psikologi paling lambat 3 (tiga) hari pasca ujian.</small></span>
      </div>
      <br />
      <div class="page" style="padding-top: 18px;">
         <?php
            include( "kopPotretAUser.php" );
            ?>
         <div class="border-reg"><code>Reg. <?php echo "$dt[id_reg]"?></code></div>
         <div class="border-format"><code>FORMAT MODEL: A-2</code></div>
         <br />
         <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>BLANGKO PENDAFTARAN UJIAN SKRIPSI <br />
            <?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' '.$dnta['ta']; ?></strong>
         </p>
         <div>
            <table width="100%" class="a-2">
               <tr>
                  <td width="36%">Nama Lengkap</td>
                  <td width="2%" align="center">:</td>
                  <td width="62%"><?php if(empty($dataku['nama'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama]";}?></td>
               </tr>
               <tr>
                  <td>NIM</td>
                  <td>:</td>
                  <td><?php if(empty($dataku['nim'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nim]";}?></td>
               </tr>
               <tr>
                  <td>Fakultas/Jurusan</td>
                  <td align="center">:</td>
                  <td><?php echo "$nm_lembaga".'/'."$nm_jurusan_lembaga";?></td>
               </tr>
               <tr>
                  <td>Tempat, Tanggal Lahir</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['tempat_lahir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$ddk[nm_kota]";}?>, <?php if(empty($dataku['tanggal_lahir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo bulanIndo($dataku['tanggal_lahir']);}?></td>
               </tr>
               <tr>
                  <td>Riwayat Pendidikan Terakhir</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['pend_terakhir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[pend_terakhir]";}?></td>
               </tr>
               <tr>
                  <td>Alamat di Malang</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['alamat_malang'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[alamat_malang]";}?></td>
               </tr>
               <tr>
                  <td>No.Telp/HP</td>
                  <td align="center">:</td>
                  <td><?php echo "$dataku[kntk]";?></td>
               </tr>
               <tr>
                  <td>email</td>
                  <td align="center">:</td>
                  <td style="text-transform:lowercase"><?php if(empty($dataku['imel'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[imel]";}?></td>
               </tr>
               <tr>
                  <td>Nama Ayah</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['nama_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama_ayah]";}?></td>
               </tr>
               <tr>
                  <td>Alamat Ayah</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['alamat_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[alamat_ayah]";}?></td>
               </tr>
               <tr>
                  <td>Kontak/HP Ayah</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['telepon_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[telepon_ayah]";}?></td>
               </tr>
               <tr>
                  <td>Nama Ibu</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['nama_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama_ibu]";}?></td>
               </tr>
               <tr>
                  <td>Alamat Ibu</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['alamat_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[alamat_ibu]";}?></td>
               </tr>
               <tr>
                  <td>Kontak/HP Ibu</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['telepon_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[telepon_ibu]";}?></td>
               </tr>
               <tr>
                  <td>Judul Skripsi</td>
                  <td align="center">:</td>
                  <td><?php echo $dt['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_skripsi']);?></td>
               </tr>
               <tr>
                  <td>&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td>&nbsp;</td>
               </tr>
               <tr>
                  <td colspan="3" style="text-transform:none;">
                     Dengan ini mendaftarkan diri menempuh ujian skripsi dengan menyerahkan syarat-syarat sebagai berikut:
                     <ol style="list-style-type: square;">
                        <li>4 (empat) eksemplar naskah skripsi yang telah ditandatangani asli oleh dosen pembimbing skripsi.</li>
                        <li>2 (dua) lembar fotokopi ijazah SMA/MA yang diligalisir.</li>
                        <li>1 (satu) lembar kwitansi SPP terakhir.</li>
                        <li>Lembar Transkrip Nilai terakhir.</li>
                        <li>Berkas: Biodata, Format A, A-1, A-2, A-3 dan A-4.</li>
                        <li>File foto resmi dan berwarna dengan
                           <?php if($dataku['jenis_kelamin']==1) {echo "memakai almamater dan berjilbab";} else { echo "memakai almamater dan berdasi";}?>.
                        </li>
                        <li>Fotokopi sertifikat TOEFL/TOAFL.</li>
                     </ol>
                  </td>
               </tr>
            </table>
         </div>
         <br />
         <br />
         <div class="right-ttd" style="margin-bottom:20px;">
            Malang, <?php echo bulanIndo2($dt['tgl_pengajuan']);?>
            <br />
            <br />
            <br />
            <br />
            <br />
            <?php echo "$dataku[nama]";?>
            <br />
            NIM. <?php echo "$dataku[nim]";?>
         </div>
         <div>
            <table class="foto">
               <tbody>
                  <tr>
                     <td><small>Tempel 5 lembar foto ukuran 3x4 di sini.</small></td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <br />
      <div class="page" style="padding-top: 18px;">
         <?php
            include( "kopPotretAUser.php" );
            ?>
         <div class="border-reg"><code>Reg. <?php echo "$dt[id_reg]"?></code></div>
         <div class="border-format"><code>FORMAT MODEL: A-3</code></div>
         <br />
         <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>IDENTITAS PESERTA UJIAN SKRIPSI <br />
            <?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' '.$dnta['ta']; ?></strong>
         </p>
         <div>
            <table width="100%" class="a-3">
               <tr>
                  <td width="36%">Nama Lengkap</td>
                  <td width="2%" align="center">:</td>
                  <td width="62%"><?php if(empty($dataku['nama'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama]";}?></td>
               </tr>
               <tr>
                  <td>NIM</td>
                  <td>:</td>
                  <td><?php if(empty($dataku['nim'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nim]";}?></td>
               </tr>
               <tr>
                  <td>Jenis Kelamin</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['jenis_kelamin'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$djk[nm]";}?></td>
               </tr>
               <tr>
                  <td>Tempat, Tanggal Lahir</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['tempat_lahir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$ddk[nm_kota]";}?>, <?php if(empty($dataku['tanggal_lahir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo bulanIndo($dataku['tanggal_lahir']);}?></td>
               </tr>
               <tr>
                  <td>Angkatan</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['angkatan'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[angkatan]";}?></td>
               </tr>
               <tr>
                  <td>Fakultas/Jurusan Pertama Daftar</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['fakultas_pertama_daftar'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dfak[nm]";}?>/<?php if(empty($dataku['jurusan_pertama_daftar'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$djur[nm]";}?></td>
               </tr>
               <tr>
                  <td>No.Telp/HP</td>
                  <td align="center">:</td>
                  <td><?php echo "$dataku[kntk]";?></td>
               </tr>
               <tr>
                  <td>email</td>
                  <td align="center">:</td>
                  <td style="text-transform:lowercase"><?php if(empty($dataku['imel'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[imel]";}?></td>
               </tr>
               <tr>
                  <td>Alamat di Malang</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['alamat_malang'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[alamat_malang]";}?></td>
               </tr>
               <tr>
                  <td>Riwayat Pendidikan Terakhir</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['pend_terakhir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[pend_terakhir]";}?></td>
               </tr>
               <tr>
                  <td>Nama Ayah</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['nama_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama_ayah]";}?></td>
               </tr>
               <tr>
                  <td>Alamat Ayah</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['alamat_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[alamat_ayah]";}?></td>
               </tr>
               <tr>
                  <td>Kontak/HP Ayah</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['telepon_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[telepon_ayah]";}?></td>
               </tr>
               <tr>
                  <td>Nama Ibu</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['nama_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama_ibu]";}?></td>
               </tr>
               <tr>
                  <td>Alamat Ibu</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['alamat_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[alamat_ibu]";}?></td>
               </tr>
               <tr>
                  <td>Kontak/HP Ibu</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['telepon_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[telepon_ibu]";}?></td>
               </tr>
               <tr>
                  <td colspan="3">
                     <hr>
                  </td>
               </tr>
               <tr>
                  <td>Tanggal Ujian Skripsi</td>
                  <td align="center">:</td>
                  <td><?php if(empty($djdwl['tgl_ujian'])) { echo "________________________________________*)";} else { echo $dayList[$day].', '.bulanIndo2($djdwl['tgl_ujian']);}?></td>
               </tr>
               <tr>
                  <td>Tanggal Selesai Revisi</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dt['tgl_revisi'])) { echo "________________________________________*)";} else { echo $dayList[$day].', '.bulanIndo2($dt['tgl_revisi']);}?></td>
               </tr>
               <tr>
                  <td>Tanggal Lulus</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['thn_lls_s1'])) { echo "________________________________________*)";} else { echo $dayList[$day].', '.bulanIndo2($dataku['thn_lls_s1']);}?></td>
               </tr>
               <tr>
                  <td>No. Register Ijazah</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['reg_ijazah'])) { echo "________________________________________*)";} else { echo $dataku['reg_ijazah'];}?></td>
               </tr>
               <tr>
                  <td>No. Ijazah</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['no_ijazah'])) { echo "________________________________________*)";} else { echo $dataku['no_ijazah'];}?></td>
               </tr>
               <tr>
                  <td>Judul Skripsi</td>
                  <td align="center">:</td>
                  <td><?php echo $dt['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_skripsi']);?></td>
               </tr>
               <tr>
                  <td>Dosen Pembimbing Skripsi</td>
                  <td align="center">:</td>
                  <td><?php echo "$dpemb1[nama]";?></td>
               </tr>
            </table>
         </div>
         <br />
         <br />
         <div class="right-ttd" style="margin-bottom:20px;">
            Malang, <?php echo bulanIndo2($dt['tgl_pengajuan']);?>
            <br />
            <br />
            <br />
            <br />
            <br />
            <?php echo "$dataku[nama]";?>
            <br />
            NIM. <?php echo "$dataku[nim]";?>
         </div>
         <div>
            <table class="ket">
               <tbody>
                  <tr>
                     <td>
                        <small>
                           Keterangan:
                           <ol style="list-style-type: decimal;">
                              <li>Nama lengkap harus diisi sesuai dengan nama yang tertera di ijazah SD/SLTP/SMA/MA/Akte Kelahiran.</li>
                              <li>Apabila di saat ujian ada perubahan judul, segera hubungi staf BAK Fakultas Psikologi paling lambat 3 (tiga) hari pasca ujian.</li>
                              <li>*) Diisi oleh admin.</li>
                           </ol>
                        </small>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
      <br />
      <div class="page" style="padding-top: 18px;">
         <?php
            include( "kopPotretAUser.php" );
            ?>
         <div class="border-reg"><code>Reg. <?php echo "$dt[id_reg]"?></code></div>
         <div class="border-format"><code>FORMAT MODEL: A-4</code></div>
         <br />
         <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>BLANGKO ISIAN UNTUK PENULISAN IJAZAH</strong></p>
         <div>
            <table width="100%" class="a-4">
               <tr>
                  <td width="30%">Nama Lengkap</td>
                  <td width="2%" align="center">:</td>
                  <td width="68%"><?php if(empty($dataku['nama'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama]";}?></td>
               </tr>
               <tr>
                  <td>NIM</td>
                  <td>:</td>
                  <td><?php if(empty($dataku['nim'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nim]";}?></td>
               </tr>
               <tr>
                  <td>Tempat, Tanggal Lahir</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['tempat_lahir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$ddk[nm_kota]";}?>, <?php if(empty($dataku['tanggal_lahir'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo bulanIndo($dataku['tanggal_lahir']);}?></td>
               </tr>
               <tr>
                  <td>Angkatan</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['angkatan'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[angkatan]";}?></td>
               </tr>
               <tr>
                  <td>Fakultas/Jurusan</td>
                  <td align="center">:</td>
                  <td><?php echo "$nm_lembaga".'/'."$nm_jurusan_lembaga";?></td>
               </tr>
               <tr>
                  <td>Asal SMA/MA</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['asal_sekolah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[asal_sekolah]";}?></td>
               </tr>
               <tr>
                  <td>Judul Skripsi</td>
                  <td align="center">:</td>
                  <td><?php echo $dt['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_skripsi']);?></td>
               </tr>
               <tr>
                  <td>No.Telp/HP</td>
                  <td align="center">:</td>
                  <td><?php echo "$dataku[kntk]";?></td>
               </tr>
               <tr>
                  <td>email</td>
                  <td align="center">:</td>
                  <td style="text-transform:lowercase"><?php if(empty($dataku['imel'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[imel]";}?></td>
               </tr>
               <tr>
                  <td>Nama Ayah</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['nama_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama_ayah]";}?></td>
               </tr>
               <tr>
                  <td>Kontak/HP Ayah</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['telepon_ayah'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[telepon_ayah]";}?></td>
               </tr>
               <tr>
                  <td>Nama Ibu</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['nama_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[nama_ibu]";}?></td>
               </tr>
               <tr>
                  <td>Kontak/HP Ibu</td>
                  <td align="center">:</td>
                  <td><?php if(empty($dataku['telepon_ibu'])) { echo "<font class='text-danger'>Belum diisi</font>";} else { echo "$dataku[telepon_ibu]";}?></td>
               </tr>
            </table>
         </div>
         <br />
         <br />
         <div class="right-ttd" style="margin-bottom:20px;">
            Malang, <?php echo bulanIndo2($dt['tgl_pengajuan']);?>
            <br />
            <br />
            <br />
            <br />
            <br />
            <?php echo "$dataku[nama]";?>
            <br />
            NIM. <?php echo "$dataku[nim]";?>
         </div>
         <div style="margin:0 auto; width:76%;">
            <table width="100%" class="a-4-1">
               <tr>
                  <td width="4%">1.</td>
                  <td width="96%">Data di atas telah diteliti dan data selanjutnya diisi oleh admin.</td>
               </tr>
               <tr>
                  <td>2.</td>
                  <td>Admin bertanggungjawab atas kebenaran data yang tertera pada ijazah.</td>
               </tr>
            </table>
         </div>
         <br />   
         <div>
            <table width="100%" class="a-4-2">
               <tr>
                  <td width="30%">Nomor Ijazah</td>
                  <td width="2%" align="center">:</td>
                  <td colspan="4" style="border-bottom:1px solid #666666;"><?php if(empty($dataku['no_ijazah'])) { echo "";} else { echo $dataku['no_ijazah'];}?></td>
               </tr>
               <tr>
                  <td>Jumlah SKS/SKS*N</td>
                  <td align="center">:</td>
                  <td colspan="4" style="border-bottom:1px solid #666666; text-align:center;">/</td>
               </tr>
               <tr>
                  <td>IPK/Yudisium</td>
                  <td align="center">:</td>
                  <td colspan="4" style="border-bottom:1px solid #666666;"></td>
               </tr>
               <tr>
                  <td>Wisuda ke/Semester</td>
                  <td align="center">:</td>
                  <td colspan="3" style="border-bottom:1px solid #666666; text-align:center;">/</td>
                  <td width="14%" style="border-bottom:1px solid #666666;">20&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/20</td>
               </tr>
               <tr>
                  <td>Persyaratan Administrasi</td>
                  <td align="center">:</td>
                  <td width="12%">&#9744; Lengkap</td>
                  <td width="12%">&#9744; Kurang:</td>
                  <td colspan="2" style="border-bottom:1px solid #666666;">&nbsp;</td>
               </tr>
               <tr style="display:none;">
                  <td>&nbsp;</td>
                  <td align="center">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td width="30%">&nbsp;</td>
                  <td>&nbsp;</td>
               </tr>
            </table>
         </div>
         <br />
         <br />
         <div class="right-ttd" style="margin-bottom:20px;">
            Malang, _____ - _____ - ________<br />
            Admin,
            <br />
            <br />
            <br />
            <br />
            <br />
            ______________________________
         </div>
      </div>
    <?php include( "jsAdm.php" );?>
    <script type="text/javascript">
      $(document).ready(function() {
         window.print();
         window.close(); 
      });
    </script>
  </body>
</html>