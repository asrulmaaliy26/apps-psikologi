<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  
  $myquery = "select * from mag_peserta_sempro WHERE id='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt = mysqli_fetch_assoc( $res );
  
  $jdwl = "select * from mag_jadwal_sempro WHERE id='$dt[id_jdwl]'";
  $rjdwl = mysqli_query($GLOBALS["___mysqli_ston"],  $jdwl )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $djdwl = mysqli_fetch_assoc( $rjdwl );
  
  $qry = "select * from mag_dt_mhssw_pasca WHERE nim='$dt[nim]'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qry )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dataku = mysqli_fetch_assoc( $resp );
  
  $qp1 = "select * from dt_pegawai WHERE id='$djdwl[penguji1]'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qp1 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dp1 = mysqli_fetch_assoc( $resp );
     
  $qp2 = "select * from dt_pegawai WHERE id='$djdwl[penguji2]'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qp2 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dp2 = mysqli_fetch_assoc( $resp );
  
  $qp3 = "select * from dt_pegawai WHERE id='$djdwl[penguji3]'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qp3 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dp3 = mysqli_fetch_assoc( $resp );
  
  $qp4 = "select * from dt_pegawai WHERE id='$djdwl[penguji4]'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qp4 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dp4 = mysqli_fetch_assoc( $resp );
  
  $qry_moment = "SELECT * FROM mag_periode_pendaftaran_sempro WHERE id='$dt[id_sempro]'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_sempro=$data['id'];
  $thp=$data['tahap'];
  $ta=$data['ta'];
  
  $qry_nm_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$thp'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_thp);
  $dthp = mysqli_fetch_assoc($hasil);
    
  $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$ta'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
  
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  
  $qruang = "select * from dt_ruang WHERE id='$djdwl[ruang]'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qruang )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $druang = mysqli_fetch_assoc( $resp );
  
  $tanggal=date("d-m-Y", strtotime($djdwl['tgl_seminar']));
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
  return $split[0] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[2];
  }   
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Simagis</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      table.info {
      border-collapse: collapse;
      }
      table.info td {
      border:none;
      }
      table.info td {
      padding: 4px;
      }
      table.catatan {
      border: 1px solid black;
      padding: 4px 30px 30px 30px;
      }
      table.catatan td {
      border-bottom:1px solid black;
      padding: 12px;
      }
      table.nilai {
      border-collapse:collapse;
      border: 1px solid black;
      }
      table.nilai td {
      padding: 4px;
      border: 1px solid black;
      }
      .right {
      float: right;
      width: 320px;
      }
      @media print {
      div.page
      {
      page-break-after: always;
      page-break-inside: avoid;
      }
      }      
    </style>
  </head>
  <body style="font-family:Arial, Helvetica, sans-serif; font-size:16px;">
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <br />
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>Berita Acara Seminar Proposal Tesis<br />
        <?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']; ?></strong>
      </p>
      <div style="margin-bottom:20px;">
        <table width="100%" class="info">
          <tr>
            <td width="32%">Nama Lengkap</td>
            <td width="2%" align="center">:</td>
            <td width="66%"><?php echo "$dataku[nama]";?></td>
          </tr>
          <tr>
            <td>NIM</td>
            <td align="center">:</td>
            <td><?php echo "$dataku[nim]";?></td>
          </tr>
          <tr>
            <td valign="top">Judul Proposal Tesis</td>
            <td align="center" valign="top">:</td>
            <td valign="top"><?php echo $dt['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_prop']);?></td>
          </tr>
          <tr>
            <td>Penguji Utama</td>
            <td align="center">:</td>
            <td><?php echo "$dp3[nama]";?></td>
          </tr>
          <tr>
            <td>Ketua Penguji</td>
            <td align="center">:</td>
            <td><?php echo "$dp4[nama]";?></td>
          </tr>
          <tr>
            <td>Pembimbing I</td>
            <td align="center">:</td>
            <td><?php echo "$dp1[nama]";?></td>
          </tr>
          <tr>
            <td>Pembimbing II</td>
            <td align="center">:</td>
            <td><?php echo "$dp2[nama]";?></td>
          </tr>
          <tr>
            <td>Hari, Tanggal</td>
            <td align="center">:</td>
            <td><?php echo $dayList[$day].', '.bulanIndo($djdwl['tgl_seminar']);?></td>
          </tr>
          <tr>
            <td>Pukul</td>
            <td align="center">:</td>
            <td><?php echo $djdwl['jam_mulai'].' - '.$djdwl['jam_selesai'];?> WIB.</td>
          </tr>
          <tr>
            <td>Ruang Seminar</td>
            <td align="center">:</td>
            <td><?php echo "$druang[nm]";?></td>
          </tr>
        </table>
      </div>
      <div style="margin-bottom:20px;">
        <table width="100%" class="catatan">
          <tr>
            <td style="padding:0 0 0 0; border-bottom:none;">Catatan Penguji :</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
      </div>
      <div>
        <table width="90%" class="nilai" style="table-layout:auto; margin: 0 auto;">
          <tr>
            <td style="padding:0 0 0 30px; border-bottom:none;"  width="50%">Nilai :</td>
            <td width="2%">No.</td>
            <td width="24%">Rentang Nilai</td>
            <td width="24%">Predikat Nilai</td>
          </tr>
          <tr>
            <td style="border-top:none; border-bottom:none;">&nbsp;</td>
            <td>1.</td>
            <td>80 - 100</td>
            <td>Lanjut</td>
          </tr>
          <tr>
            <td style="border-top:none; border-bottom:none;">&nbsp;</td>
            <td>2.</td>
            <td>60 - 79</td>
            <td>Lanjut (Revisi)</td>
          </tr>
          <tr>
            <td style="border-top:none; border-bottom:none;">&nbsp;</td>
            <td>3.</td>
            <td>40 - 59</td>
            <td>Seminar Ulang</td>
          </tr>
        </table>
      </div>
      <br />
      <br />
      <div class="right">
        Malang, <?php echo bulanIndo($djdwl['tgl_seminar']);?> <br />
        Penguji Utama,
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <?php echo "$dp3[nama]";?> <br />
        <?php if($dp3['kat_pegawai']==1) { echo "NIP. "."$dp3[id]";} else { echo "NIPT. "."$dp3[id]";}?>
      </div>
    </div>
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <br />
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>Berita Acara Seminar Proposal Tesis<br />
        <?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']; ?></strong>
      </p>
      <div style="margin-bottom:20px;">
        <table width="100%" class="info">
          <tr>
            <td width="32%">Nama Lengkap</td>
            <td width="2%" align="center">:</td>
            <td width="66%"><?php echo "$dataku[nama]";?></td>
          </tr>
          <tr>
            <td>NIM</td>
            <td align="center">:</td>
            <td><?php echo "$dataku[nim]";?></td>
          </tr>
          <tr>
            <td valign="top">Judul Proposal Skripsi</td>
            <td align="center" valign="top">:</td>
            <td valign="top"><?php echo $dt['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_prop']);?></td>
          </tr>
          <tr>
            <td>Penguji Utama</td>
            <td align="center">:</td>
            <td><?php echo "$dp3[nama]";?></td>
          </tr>
          <tr>
            <td>Ketua Penguji</td>
            <td align="center">:</td>
            <td><?php echo "$dp4[nama]";?></td>
          </tr>
          <tr>
            <td>Pembimbing I</td>
            <td align="center">:</td>
            <td><?php echo "$dp1[nama]";?></td>
          </tr>
          <tr>
            <td>Pembimbing II</td>
            <td align="center">:</td>
            <td><?php echo "$dp2[nama]";?></td>
          </tr>
          <tr>
            <td>Hari, Tanggal</td>
            <td align="center">:</td>
            <td><?php echo $dayList[$day].', '.bulanIndo($djdwl['tgl_seminar']);?></td>
          </tr>
          <tr>
            <td>Pukul</td>
            <td align="center">:</td>
            <td><?php echo $djdwl['jam_mulai'].' - '.$djdwl['jam_selesai'];?> WIB.</td>
          </tr>
          <tr>
            <td>Ruang Seminar</td>
            <td align="center">:</td>
            <td><?php echo "$druang[nm]";?></td>
          </tr>
        </table>
      </div>
      <div style="margin-bottom:20px;">
        <table width="100%" class="catatan">
          <tr>
            <td style="padding:0 0 0 0; border-bottom:none;">Catatan Penguji :</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
      </div>
      <div>
        <table width="90%" class="nilai" style="table-layout:auto; margin: 0 auto;">
          <tr>
            <td style="padding:0 0 0 30px; border-bottom:none;"  width="50%">Nilai :</td>
            <td width="2%">No.</td>
            <td width="24%">Rentang Nilai</td>
            <td width="24%">Predikat Nilai</td>
          </tr>
          <tr>
            <td style="border-top:none; border-bottom:none;">&nbsp;</td>
            <td>1.</td>
            <td>80 - 100</td>
            <td>Lanjut</td>
          </tr>
          <tr>
            <td style="border-top:none; border-bottom:none;">&nbsp;</td>
            <td>2.</td>
            <td>60 - 79</td>
            <td>Lanjut (Revisi)</td>
          </tr>
          <tr>
            <td style="border-top:none; border-bottom:none;">&nbsp;</td>
            <td>3.</td>
            <td>40 - 59</td>
            <td>Seminar Ulang</td>
          </tr>
        </table>
      </div>
      <br />
      <br />
      <div class="right">
        Malang, <?php echo bulanIndo($djdwl['tgl_seminar']);?> <br />
        Ketua Penguji,
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <?php echo "$dp4[nama]";?> <br />
        <?php if($dp4['kat_pegawai']==1) { echo "NIP. "."$dp4[id]";} else { echo "NIPT. "."$dp4[id]";}?>
      </div>
    </div>
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <br />
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>Berita Acara Seminar Proposal Tesis<br />
        <?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']; ?></strong>
      </p>
      <div style="margin-bottom:20px;">
        <table width="100%" class="info">
          <tr>
            <td width="32%">Nama Lengkap</td>
            <td width="2%" align="center">:</td>
            <td width="66%"><?php echo "$dataku[nama]";?></td>
          </tr>
          <tr>
            <td>NIM</td>
            <td align="center">:</td>
            <td><?php echo "$dataku[nim]";?></td>
          </tr>
          <tr>
            <td valign="top">Judul Proposal Skripsi</td>
            <td align="center" valign="top">:</td>
            <td valign="top"><?php echo $dt['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_prop']);?></td>
          </tr>
          <tr>
            <td>Penguji Utama</td>
            <td align="center">:</td>
            <td><?php echo "$dp3[nama]";?></td>
          </tr>
          <tr>
            <td>Ketua Penguji</td>
            <td align="center">:</td>
            <td><?php echo "$dp4[nama]";?></td>
          </tr>
          <tr>
            <td>Pembimbing I</td>
            <td align="center">:</td>
            <td><?php echo "$dp1[nama]";?></td>
          </tr>
          <tr>
            <td>Pembimbing II</td>
            <td align="center">:</td>
            <td><?php echo "$dp2[nama]";?></td>
          </tr>
          <tr>
            <td>Hari, Tanggal</td>
            <td align="center">:</td>
            <td><?php echo $dayList[$day].', '.bulanIndo($djdwl['tgl_seminar']);?></td>
          </tr>
          <tr>
            <td>Pukul</td>
            <td align="center">:</td>
            <td><?php echo $djdwl['jam_mulai'].' - '.$djdwl['jam_selesai'];?> WIB.</td>
          </tr>
          <tr>
            <td>Ruang Seminar</td>
            <td align="center">:</td>
            <td><?php echo "$druang[nm]";?></td>
          </tr>
        </table>
      </div>
      <div style="margin-bottom:20px;">
        <table width="100%" class="catatan">
          <tr>
            <td style="padding:0 0 0 0; border-bottom:none;">Catatan Penguji :</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
      </div>
      <div>
        <table width="90%" class="nilai" style="table-layout:auto; margin: 0 auto;">
          <tr>
            <td style="padding:0 0 0 30px; border-bottom:none;"  width="50%">Nilai :</td>
            <td width="2%">No.</td>
            <td width="24%">Rentang Nilai</td>
            <td width="24%">Predikat Nilai</td>
          </tr>
          <tr>
            <td style="border-top:none; border-bottom:none;">&nbsp;</td>
            <td>1.</td>
            <td>80 - 100</td>
            <td>Lanjut</td>
          </tr>
          <tr>
            <td style="border-top:none; border-bottom:none;">&nbsp;</td>
            <td>2.</td>
            <td>60 - 79</td>
            <td>Lanjut (Revisi)</td>
          </tr>
          <tr>
            <td style="border-top:none; border-bottom:none;">&nbsp;</td>
            <td>3.</td>
            <td>40 - 59</td>
            <td>Seminar Ulang</td>
          </tr>
        </table>
      </div>
      <br />
      <br />
      <div class="right">
        Malang, <?php echo bulanIndo($djdwl['tgl_seminar']);?> <br />
        Pembimbing I,
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <?php echo "$dp1[nama]";?> <br />
        <?php if($dp1['kat_pegawai']==1) { echo "NIP. "."$dp1[id]";} else { echo "NIPT. "."$dp1[id]";}?>
      </div>
    </div>
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <br />
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>Berita Acara Seminar Proposal Tesis<br />
        <?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']; ?></strong>
      </p>
      <div style="margin-bottom:20px;">
        <table width="100%" class="info">
          <tr>
            <td width="32%">Nama Lengkap</td>
            <td width="2%" align="center">:</td>
            <td width="66%"><?php echo "$dataku[nama]";?></td>
          </tr>
          <tr>
            <td>NIM</td>
            <td align="center">:</td>
            <td><?php echo "$dataku[nim]";?></td>
          </tr>
          <tr>
            <td valign="top">Judul Proposal Skripsi</td>
            <td align="center" valign="top">:</td>
            <td valign="top"><?php echo $dt['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_prop']);?></td>
          </tr>
          <tr>
            <td>Penguji Utama</td>
            <td align="center">:</td>
            <td><?php echo "$dp3[nama]";?></td>
          </tr>
          <tr>
            <td>Ketua Penguji</td>
            <td align="center">:</td>
            <td><?php echo "$dp4[nama]";?></td>
          </tr>
          <tr>
            <td>Pembimbing I</td>
            <td align="center">:</td>
            <td><?php echo "$dp1[nama]";?></td>
          </tr>
          <tr>
            <td>Pembimbing II</td>
            <td align="center">:</td>
            <td><?php echo "$dp2[nama]";?></td>
          </tr>
          <tr>
            <td>Hari, Tanggal</td>
            <td align="center">:</td>
            <td><?php echo $dayList[$day].', '.bulanIndo($djdwl['tgl_seminar']);?></td>
          </tr>
          <tr>
            <td>Pukul</td>
            <td align="center">:</td>
            <td><?php echo $djdwl['jam_mulai'].' - '.$djdwl['jam_selesai'];?> WIB.</td>
          </tr>
          <tr>
            <td>Ruang Seminar</td>
            <td align="center">:</td>
            <td><?php echo "$druang[nm]";?></td>
          </tr>
        </table>
      </div>
      <div style="margin-bottom:20px;">
        <table width="100%" class="catatan">
          <tr>
            <td style="padding:0 0 0 0; border-bottom:none;">Catatan Penguji :</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
      </div>
      <div>
        <table width="90%" class="nilai" style="table-layout:auto; margin: 0 auto;">
          <tr>
            <td style="padding:0 0 0 30px; border-bottom:none;"  width="50%">Nilai :</td>
            <td width="2%">No.</td>
            <td width="24%">Rentang Nilai</td>
            <td width="24%">Predikat Nilai</td>
          </tr>
          <tr>
            <td style="border-top:none; border-bottom:none;">&nbsp;</td>
            <td>1.</td>
            <td>80 - 100</td>
            <td>Lanjut</td>
          </tr>
          <tr>
            <td style="border-top:none; border-bottom:none;">&nbsp;</td>
            <td>2.</td>
            <td>60 - 79</td>
            <td>Lanjut (Revisi)</td>
          </tr>
          <tr>
            <td style="border-top:none; border-bottom:none;">&nbsp;</td>
            <td>3.</td>
            <td>40 - 59</td>
            <td>Seminar Ulang</td>
          </tr>
        </table>
      </div>
      <br />
      <br />
      <div class="right">
        Malang, <?php echo bulanIndo($djdwl['tgl_seminar']);?> <br />
        Pembimbing II,
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <?php echo "$dp2[nama]";?> <br />
        <?php if($dp2['kat_pegawai']==1) { echo "NIP. "."$dp2[id]";} else { echo "NIPT. "."$dp2[id]";}?>
      </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
         window.print();
         window.close(); 
      });
    </script>
  </body>
</html>