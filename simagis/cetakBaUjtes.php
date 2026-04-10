<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  
  $myquery = "select * from mag_peserta_ujtes WHERE id='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt = mysqli_fetch_assoc( $res );
  
  $jdwl = "select * from mag_jadwal_ujtes WHERE id='$dt[id_jdwl]'";
  $rjdwl = mysqli_query($GLOBALS["___mysqli_ston"],  $jdwl )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $djdwl = mysqli_fetch_assoc( $rjdwl );
  
  $qry = "select * from mag_dt_mhssw_pasca WHERE nim='$dt[nim]'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qry )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dataku = mysqli_fetch_assoc( $resp );
  
  $qjl = "select * from nama_jurusan_lembaga";
  $resjl = mysqli_query($GLOBALS["___mysqli_ston"],  $qjl )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $djl = mysqli_fetch_assoc( $resjl );
  $nm_jurusan_lembaga = $djl['nm'];
  
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
  
  $qry_moment = "SELECT * FROM mag_periode_pendaftaran_ujtes WHERE id='$dt[id_ujtes]'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_ujtes=$data['id'];
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
      table.induk {
      border-collapse: collapse;
      font-size:14px;
      border:1px solid #333333;
      }
      table.induk td {
      border:none;
      }
      table.induk td {
      padding: 4px 2px 4px 2px;
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
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>Berita Acara Ujian Tesis<br />
        <?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']; ?></strong>
      </p>
      <div style="margin-bottom:20px;">
        <table width="100%" class="induk">
          <tr>
            <td width="2%">A.</td>
            <td colspan="2">IDENTITAS MAHASISWA</td>
            <td width="2%" style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td width="2%">C.</td>
            <td colspan="5">PENELITIAN</td>
            <td width="6%">&nbsp;</td>
            <td width="2%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="2%">1.</td>
            <td width="45%">Nama Lengkap:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="2%">1.</td>
            <td colspan="4">Isi Tesis</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dataku[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">a. Pentingnya Masalah</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>2.</td>
            <td>NIM.:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">b. Metode/Pendekatan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dataku[nim]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">c. Sistematika Pembahasan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>3.</td>
            <td>Jurusan:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">d. Analisa</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$nm_jurusan_lembaga";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">e. Kepustakaan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>B.</td>
            <td colspan="2">INFORMASI TESIS</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>2.</td>
            <td colspan="4">Pelaksanaan Ujian</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>1.</td>
            <td>Judul:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">a. Penguasaan Materi Pembahasan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td rowspan="5"><?php echo $dt['judul_tesis']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_tesis']);?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">b. Sikap/Penampilan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">c. Konsultasi</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>3.</td>
            <td colspan="4">Organisasi Penulisan</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">a. Teknik Pengetikan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">b. Format/Tata Letak</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>2.</td>
            <td>Dosen Pembimbing: </td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">c. Kerapian/Kebersihan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dp2[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>D.</td>
            <td colspan="5">HASIL YUDISIUM</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>3.</td>
            <td>Susunan Dosen Penguji:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>1.</td>
            <td width="3%" style="border:1px solid #333333;">No.</td>
            <td width="10%" style="border:1px solid #333333;">Bobot</td>
            <td width="12%" style="border:1px solid #333333;">Nilai Huruf</td>
            <td width="12%" style="border:1px solid #333333;">Nilai Angka</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Sekretaris:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">1.</td>
            <td style="border:1px solid #333333;">85 - 100</td>
            <td style="border:1px solid #333333;">A</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dp2[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">2.</td>
            <td style="border:1px solid #333333;">75 - 84</td>
            <td style="border:1px solid #333333;">B+</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Ketua:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">3.</td>
            <td style="border:1px solid #333333;">70 - 74</td>
            <td style="border:1px solid #333333;">B</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dp1[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">4.</td>
            <td style="border:1px solid #333333;">65 - 69</td>
            <td style="border:1px solid #333333;">C+</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Penguji Utama:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">5.</td>
            <td style="border:1px solid #333333;">60 - 64</td>
            <td style="border:1px solid #333333;">C</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dp3[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">6.</td>
            <td style="border:1px solid #333333;">< 60</td>
            <td style="border:1px solid #333333;">D</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>4.</td>
            <td>Hari, Tanggal:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">7.</td>
            <td style="border:1px solid #333333;">< 50</td>
            <td style="border:1px solid #333333;">Tidak Lulus</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $dayList[$day].', '.bulanIndo($djdwl['tgl_ujian']);?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>2.</td>
            <td colspan="4">Catatan</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>5.</td>
            <td>Pukul:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $djdwl['jam_mulai'].' - '.$djdwl['jam_selesai'];?> WIB.</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>6.</td>
            <td>Ruang:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$druang[nm]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>7.</td>
            <td>Tandatangan Mahasiswa:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>____________________</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </div>
      <br />
      <br />
      <div class="right">
        Malang, <?php echo bulanIndo($djdwl['tgl_ujian']);?> <br />
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
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>Berita Acara Ujian Tesis<br />
        <?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']; ?></strong>
      </p>
      <div style="margin-bottom:20px;">
        <table width="100%" class="induk">
          <tr>
            <td width="2%">A.</td>
            <td colspan="2">IDENTITAS MAHASISWA</td>
            <td width="2%" style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td width="2%">C.</td>
            <td colspan="5">PENELITIAN</td>
            <td width="6%">&nbsp;</td>
            <td width="2%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="2%">1.</td>
            <td width="45%">Nama Lengkap:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="2%">1.</td>
            <td colspan="4">Isi Tesis</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dataku[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">a. Pentingnya Masalah</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>2.</td>
            <td>NIM.:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">b. Metode/Pendekatan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dataku[nim]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">c. Sistematika Pembahasan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>3.</td>
            <td>Jurusan:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">d. Analisa</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$nm_jurusan_lembaga";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">e. Kepustakaan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>B.</td>
            <td colspan="2">INFORMASI TESIS</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>2.</td>
            <td colspan="4">Pelaksanaan Ujian</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>1.</td>
            <td>Judul:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">a. Penguasaan Materi Pembahasan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td rowspan="5"><?php echo $dt['judul_tesis']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_tesis']);?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">b. Sikap/Penampilan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">c. Konsultasi</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>3.</td>
            <td colspan="4">Organisasi Penulisan</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">a. Teknik Pengetikan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">b. Format/Tata Letak</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>2.</td>
            <td>Dosen Pembimbing: </td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">c. Kerapian/Kebersihan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dp2[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>D.</td>
            <td colspan="5">HASIL YUDISIUM</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>3.</td>
            <td>Susunan Dosen Penguji:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>1.</td>
            <td width="3%" style="border:1px solid #333333;">No.</td>
            <td width="10%" style="border:1px solid #333333;">Bobot</td>
            <td width="12%" style="border:1px solid #333333;">Nilai Huruf</td>
            <td width="12%" style="border:1px solid #333333;">Nilai Angka</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Sekretaris:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">1.</td>
            <td style="border:1px solid #333333;">85 - 100</td>
            <td style="border:1px solid #333333;">A</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dp2[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">2.</td>
            <td style="border:1px solid #333333;">75 - 84</td>
            <td style="border:1px solid #333333;">B+</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Ketua:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">3.</td>
            <td style="border:1px solid #333333;">70 - 74</td>
            <td style="border:1px solid #333333;">B</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dp1[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">4.</td>
            <td style="border:1px solid #333333;">65 - 69</td>
            <td style="border:1px solid #333333;">C+</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Penguji Utama:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">5.</td>
            <td style="border:1px solid #333333;">60 - 64</td>
            <td style="border:1px solid #333333;">C</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dp3[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">6.</td>
            <td style="border:1px solid #333333;">< 60</td>
            <td style="border:1px solid #333333;">D</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>4.</td>
            <td>Hari, Tanggal:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">7.</td>
            <td style="border:1px solid #333333;">< 50</td>
            <td style="border:1px solid #333333;">Tidak Lulus</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $dayList[$day].', '.bulanIndo($djdwl['tgl_ujian']);?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>2.</td>
            <td colspan="4">Catatan</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>5.</td>
            <td>Pukul:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $djdwl['jam_mulai'].' - '.$djdwl['jam_selesai'];?> WIB.</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>6.</td>
            <td>Ruang:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$druang[nm]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>7.</td>
            <td>Tandatangan Mahasiswa:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>____________________</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </div>
      <br />
      <br />
      <div class="right">
        Malang, <?php echo bulanIndo($djdwl['tgl_ujian']);?> <br />
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
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>Berita Acara Ujian Tesis<br />
        <?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']; ?></strong>
      </p>
      <div style="margin-bottom:20px;">
        <table width="100%" class="induk">
          <tr>
            <td width="2%">A.</td>
            <td colspan="2">IDENTITAS MAHASISWA</td>
            <td width="2%" style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td width="2%">C.</td>
            <td colspan="5">PENELITIAN</td>
            <td width="6%">&nbsp;</td>
            <td width="2%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="2%">1.</td>
            <td width="45%">Nama Lengkap:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="2%">1.</td>
            <td colspan="4">Isi Tesis</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dataku[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">a. Pentingnya Masalah</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>2.</td>
            <td>NIM.:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">b. Metode/Pendekatan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dataku[nim]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">c. Sistematika Pembahasan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>3.</td>
            <td>Jurusan:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">d. Analisa</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$nm_jurusan_lembaga";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">e. Kepustakaan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>B.</td>
            <td colspan="2">INFORMASI TESIS</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>2.</td>
            <td colspan="4">Pelaksanaan Ujian</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>1.</td>
            <td>Judul:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">a. Penguasaan Materi Pembahasan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td rowspan="5"><?php echo $dt['judul_tesis']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_tesis']);?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">b. Sikap/Penampilan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">c. Konsultasi</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>3.</td>
            <td colspan="4">Organisasi Penulisan</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">a. Teknik Pengetikan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">b. Format/Tata Letak</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>2.</td>
            <td>Dosen Pembimbing: </td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">c. Kerapian/Kebersihan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dp2[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>D.</td>
            <td colspan="5">HASIL YUDISIUM</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>3.</td>
            <td>Susunan Dosen Penguji:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>1.</td>
            <td width="3%" style="border:1px solid #333333;">No.</td>
            <td width="10%" style="border:1px solid #333333;">Bobot</td>
            <td width="12%" style="border:1px solid #333333;">Nilai Huruf</td>
            <td width="12%" style="border:1px solid #333333;">Nilai Angka</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Sekretaris:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">1.</td>
            <td style="border:1px solid #333333;">85 - 100</td>
            <td style="border:1px solid #333333;">A</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dp2[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">2.</td>
            <td style="border:1px solid #333333;">75 - 84</td>
            <td style="border:1px solid #333333;">B+</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Ketua:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">3.</td>
            <td style="border:1px solid #333333;">70 - 74</td>
            <td style="border:1px solid #333333;">B</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dp1[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">4.</td>
            <td style="border:1px solid #333333;">65 - 69</td>
            <td style="border:1px solid #333333;">C+</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Penguji Utama:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">5.</td>
            <td style="border:1px solid #333333;">60 - 64</td>
            <td style="border:1px solid #333333;">C</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dp3[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">6.</td>
            <td style="border:1px solid #333333;">< 60</td>
            <td style="border:1px solid #333333;">D</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>4.</td>
            <td>Hari, Tanggal:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">7.</td>
            <td style="border:1px solid #333333;">< 50</td>
            <td style="border:1px solid #333333;">Tidak Lulus</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $dayList[$day].', '.bulanIndo($djdwl['tgl_ujian']);?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>2.</td>
            <td colspan="4">Catatan</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>5.</td>
            <td>Pukul:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $djdwl['jam_mulai'].' - '.$djdwl['jam_selesai'];?> WIB.</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>6.</td>
            <td>Ruang:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$druang[nm]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>7.</td>
            <td>Tandatangan Mahasiswa:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>____________________</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </div>
      <br />
      <br />
      <div class="right">
        Malang, <?php echo bulanIndo($djdwl['tgl_ujian']);?> <br />
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
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><strong>Berita Acara Ujian Tesis<br />
        <?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']; ?></strong>
      </p>
      <div style="margin-bottom:20px;">
        <table width="100%" class="induk">
          <tr>
            <td width="2%">A.</td>
            <td colspan="2">IDENTITAS MAHASISWA</td>
            <td width="2%" style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td width="2%">C.</td>
            <td colspan="5">PENELITIAN</td>
            <td width="6%">&nbsp;</td>
            <td width="2%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td width="2%">1.</td>
            <td width="45%">Nama Lengkap:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="2%">1.</td>
            <td colspan="4">Isi Tesis</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dataku[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">a. Pentingnya Masalah</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>2.</td>
            <td>NIM.:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">b. Metode/Pendekatan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dataku[nim]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">c. Sistematika Pembahasan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>3.</td>
            <td>Jurusan:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">d. Analisa</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$nm_jurusan_lembaga";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">e. Kepustakaan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>B.</td>
            <td colspan="2">INFORMASI TESIS</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>2.</td>
            <td colspan="4">Pelaksanaan Ujian</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>1.</td>
            <td>Judul:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">a. Penguasaan Materi Pembahasan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td rowspan="5"><?php echo $dt['judul_tesis']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_tesis']);?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">b. Sikap/Penampilan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">c. Konsultasi</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>3.</td>
            <td colspan="4">Organisasi Penulisan</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">a. Teknik Pengetikan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">b. Format/Tata Letak</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>2.</td>
            <td>Dosen Pembimbing: </td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4">c. Kerapian/Kebersihan</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dp2[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>D.</td>
            <td colspan="5">HASIL YUDISIUM</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>3.</td>
            <td>Susunan Dosen Penguji:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>1.</td>
            <td width="3%" style="border:1px solid #333333;">No.</td>
            <td width="10%" style="border:1px solid #333333;">Bobot</td>
            <td width="12%" style="border:1px solid #333333;">Nilai Huruf</td>
            <td width="12%" style="border:1px solid #333333;">Nilai Angka</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Sekretaris:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">1.</td>
            <td style="border:1px solid #333333;">85 - 100</td>
            <td style="border:1px solid #333333;">A</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dp2[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">2.</td>
            <td style="border:1px solid #333333;">75 - 84</td>
            <td style="border:1px solid #333333;">B+</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Ketua:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">3.</td>
            <td style="border:1px solid #333333;">70 - 74</td>
            <td style="border:1px solid #333333;">B</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dp1[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">4.</td>
            <td style="border:1px solid #333333;">65 - 69</td>
            <td style="border:1px solid #333333;">C+</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>Penguji Utama:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">5.</td>
            <td style="border:1px solid #333333;">60 - 64</td>
            <td style="border:1px solid #333333;">C</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$dp3[nama]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">6.</td>
            <td style="border:1px solid #333333;">< 60</td>
            <td style="border:1px solid #333333;">D</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>4.</td>
            <td>Hari, Tanggal:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border:1px solid #333333;">7.</td>
            <td style="border:1px solid #333333;">< 50</td>
            <td style="border:1px solid #333333;">Tidak Lulus</td>
            <td style="border:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $dayList[$day].', '.bulanIndo($djdwl['tgl_ujian']);?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>2.</td>
            <td colspan="4">Catatan</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>5.</td>
            <td>Pukul:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $djdwl['jam_mulai'].' - '.$djdwl['jam_selesai'];?> WIB.</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>6.</td>
            <td>Ruang:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td style="border-bottom:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo "$druang[nm]";?></td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>7.</td>
            <td>Tandatangan Mahasiswa:</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>____________________</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="border-left:1px solid #333333; border-right:1px solid #333333;">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </div>
      <br />
      <br />
      <div class="right">
        Malang, <?php echo bulanIndo($djdwl['tgl_ujian']);?> <br />
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