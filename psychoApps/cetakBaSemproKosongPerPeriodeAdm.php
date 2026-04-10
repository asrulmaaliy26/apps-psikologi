<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $myquery = "SELECT * FROM peserta_sempro WHERE id='$id'";
   $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
   $dt = mysqli_fetch_assoc( $res );
   
   $jdwl = "SELECT * FROM jadwal_sempro WHERE id='$dt[id_jdwl]'";
   $rjdwl = mysqli_query($con,  $jdwl )or die( mysqli_error($con) );
   $djdwl = mysqli_fetch_assoc( $rjdwl );
   
   $qry = "SELECT * FROM dt_mhssw WHERE nim='$dt[nim]'";
   $resp = mysqli_query($con,  $qry )or die( mysqli_error($con) );
   $dataku = mysqli_fetch_assoc( $resp );
   
   $qpemb1 = "SELECT * FROM dt_pegawai WHERE id='$djdwl[penguji1]'";
   $resp = mysqli_query($con,  $qpemb1 )or die( mysqli_error($con) );
   $dp1 = mysqli_fetch_assoc( $resp );
      
   $qpemb2 = "SELECT * FROM dt_pegawai WHERE id='$djdwl[penguji2]'";
   $resp = mysqli_query($con,  $qpemb2 )or die( mysqli_error($con) );
   $dp2 = mysqli_fetch_assoc( $resp );
   
   $qry_moment = "SELECT * FROM pendaftaran_sempro WHERE id='$dt[id_sempro]'";
   $hasil = mysqli_query($con, $qry_moment);
   $data = mysqli_fetch_assoc($hasil);
   $id_sempro=$data['id'];
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
  
   $qruang = "SELECT * FROM dt_ruang WHERE id='$djdwl[ruang]'";
   $resp = mysqli_query($con,  $qruang )or die( mysqli_error($con) );
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
    <title>PsychoApps</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
    <style>
      table {}
      table.info td {
      border-collapse: collapse;
      vertical-align: top;
      font-size:16px;
      }
      div.ttd-peserta {
      position: absolute;
      top: 155px;
      right: 10px;
      width: 130px;
      height: 130px;
      border: 1px solid black;
      font-size: 10px;
      text-align: center;
      }
      .tg {border-collapse:collapse;border-spacing:0; width: 100%;}
      .tg td{border-color:black;border-style:solid;border-width:1px;font-size:15px;
      overflow:hidden;padding:3px 3px;word-break:normal;}
      .tg th{border-color:black;border-style:solid;border-width:1px;font-size:15px;
      font-weight:normal;overflow:hidden;padding:3px 3px;word-break:normal;}
      .tg .tg-9wq8{background-color:#efefef;font-weight:bold;border-color:inherit;text-align:center;vertical-align:middle;}
      .tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:middle;}
      .tg_a {border-collapse:collapse;border-spacing:0; width: 100%;}
      .tg_a td{border-color:black;border-style:solid;border-width:1px;font-size:15px;
      overflow:hidden;padding:3px 3px;word-break:normal;}
      .tg_a th{border-color:black;border-style:solid;border-width:1px;font-size:15px;
      font-weight:normal;overflow:hidden;padding:3px 3px;word-break:normal;}
      .tg_a .tg_a-b3sw{background-color:#efefef;font-weight:bold;border-color:inherit;text-align:center;vertical-align:middle}
      .tg_a .tg_a-0lax{font-weight:normal;border-color:inherit;text-align:left;vertical-align:middle}
      
      .catatan {
      border-style: 1px solid black; width: 100%; border-collapse: collapse;
      }
      .catatan td {
      padding: 4px 4px;
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
  <body style="font-family:'Arial Narrow',Arial, Helvetica, sans-serif;">
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><b>KOMPONEN PENILAIAN SEMINAR PROPOSAL SKRIPSI</b>
      </p>
      <div class="ttd-peserta">Tanda Tangan <br/>Peserta Seminar</div>
      <table class="info" width="78%">
        <tbody>
          <tr>
            <td colspan="3" width="22%">Nama Mahasiswa</td>
            <td width="2%">:</td>
            <td colspan="4" width="54%"><?php echo strtoupper($dataku['nama']);?></td>
          </tr>
          <tr>
            <td colspan="3">NIM</td>
            <td>:</td>
            <td colspan="4"><?php echo $dataku['nim'];?></td>
          </tr>
          <tr>
            <td colspan="3">Judul Proposal Skripsi</td>
            <td>:</td>
            <td colspan="4"><?php echo strtoupper($dt['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_prop']));?></td>
          </tr>
          <tr>
            <td colspan="3">Narasumber 1</td>
            <td>:</td>
            <td colspan="4"><?php echo strtoupper($dp1['nama']);?></td>
          </tr>
          <tr>
            <td colspan="3">Narasumber 2</td>
            <td>:</td>
            <td colspan="4"><?php echo strtoupper($dp2['nama']);?></td>
          </tr>
        </tbody>
      </table>
      <br />
      <table class="tg">
        <thead>
          <tr>
            <th class="tg-9wq8" rowspan="2" style="width:2%;">NO</th>
            <th class="tg-9wq8" colspan="2" rowspan="2">KOMPONEN</th>
            <th class="tg-9wq8" rowspan="2" style="width:6%;">SKALA</th>
            <th class="tg-9wq8" colspan="2">NILAI</th>
          </tr>
          <tr>
            <th class="tg-9wq8" style="width:15%;">NARASUMBER 1</th>
            <th class="tg-9wq8" style="width:15%;">NARASUMBER 2</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="tg-0pky" style="text-align:center;">1</td>
            <td class="tg-0pky" colspan="2" style="text-align:left;">Kejelasan, ketepatan dan relevansi judul penelitian dengan keilmuan Prodi</td>
            <td class="tg-0pky" style="text-align:center;">0 - 5</td>
            <td class="tg-0pky"></td>
            <td class="tg-0pky"></td>
          </tr>
          <tr>
            <td class="tg-0pky" style="text-align:center;">2</td>
            <td class="tg-0pky" colspan="2" style="text-align:left;">Permasalahan yang diteliti merepresentasi isu aktual</td>
            <td class="tg-0pky" style="text-align:center;">0 - 5</td>
            <td class="tg-0pky"></td>
            <td class="tg-0pky"></td>
          </tr>
          <tr>
            <td class="tg-0pky" style="text-align:center;">3</td>
            <td class="tg-0pky" colspan="2" style="text-align:left;">Kejelasan Rumusan Masalah</td>
            <td class="tg-0pky" style="text-align:center;">0 - 10</td>
            <td class="tg-0pky"></td>
            <td class="tg-0pky"></td>
          </tr>
          <tr>
            <td class="tg-0pky" style="text-align:center;">4</td>
            <td class="tg-0pky" colspan="2" style="text-align:left;">Keterkaitan judul penelitian dengan Teori, Metodologi & Hasil yang diharapkan</td>
            <td class="tg-0pky" style="text-align:center;">0 - 15</td>
            <td class="tg-0pky"></td>
            <td class="tg-0pky"></td>
          </tr>
          <tr>
            <td class="tg-0pky" style="text-align:center;">5</td>
            <td class="tg-0pky" colspan="2" style="text-align:left;">Orisinalitas dan keterbaruan penelitian (bukan pengulangan)</td>
            <td class="tg-0pky" style="text-align:center;">0 - 10</td>
            <td class="tg-0pky"></td>
            <td class="tg-0pky"></td>
          </tr>
          <tr>
            <td class="tg-0pky" style="text-align:center;">6</td>
            <td class="tg-0pky" colspan="2" style="text-align:left;">Permasalahan didukung dengan data aktual</td>
            <td class="tg-0pky" style="text-align:center;">0 - 10</td>
            <td class="tg-0pky"></td>
            <td class="tg-0pky"></td>
          </tr>
          <tr>
            <td class="tg-0pky" style="text-align:center;">7</td>
            <td class="tg-0pky" colspan="2" style="text-align:left;">Ketepatan Instrumen Penelitian</td>
            <td class="tg-0pky" style="text-align:center;">0 - 5</td>
            <td class="tg-0pky"></td>
            <td class="tg-0pky"></td>
          </tr>
          <tr>
            <td class="tg-0pky" rowspan="2" style="text-align:center;">8</td>
            <td class="tg-0pky" style="text-align:center; width:2%; border-right-style:none;">a.</td>
            <td class="tg-0pky" style="width:60%; border-left-style:none;">Kejelasan Setiap Siklus (Khusus Penelitian Pengembangan)</td>
            <td class="tg-0pky" style="text-align:center;">0 - 15</td>
            <td class="tg-0pky"></td>
            <td class="tg-0pky"></td>
          </tr>
          <tr>
            <td class="tg-0pky" style="text-align:center; border-right-style:none;">b.</td>
            <td class="tg-0pky" style="text-align:left; border-left-style:none;">Sumber Data Informan (Khusus Penelitian Kualitatif)</td>
            <td class="tg-0pky" style="text-align:center;">0 - 15</td>
            <td class="tg-0pky"></td>
            <td class="tg-0pky"></td>
          </tr>
          <tr>
            <td class="tg-0pky" style="text-align:center;">9</td>
            <td class="tg-0pky" colspan="2" style="text-align:left;">Ketepatan Instrumen Penelitian</td>
            <td class="tg-0pky" style="text-align:center;">0 - 10</td>
            <td class="tg-0pky"></td>
            <td class="tg-0pky"></td>
          </tr>
          <tr>
            <td class="tg-0pky" style="text-align:center;">10</td>
            <td class="tg-0pky" colspan="2" style="text-align:left;">Penguasaan dan Kemampuan menjelaskan Proposal Skripsi</td>
            <td class="tg-0pky" style="text-align:center;">0 - 15</td>
            <td class="tg-0pky"></td>
            <td class="tg-0pky"></td>
          </tr>
          <tr>
            <td class="tg-0pky" colspan="5" style="text-align:center; font-weight:bold;">TOTAL NILAI</td>
            <td class="tg-0pky"></td>
          </tr>
          <tr>
            <td class="tg-0pky" colspan="5" style="text-align:center; font-weight:bold;">REKOMENDASI</td>
            <td class="tg-0pky"></td>
          </tr>
        </tbody>
      </table>
      <span><strong>Catatan</strong>: Untuk poin 8 dipilih salah satu sesuai dengan jenis penelitian yang dilakukan mahasiswa</span>
      <br/><br/>
      <span><strong>KRITERIA PENILAIAN PROPOSAL</span>
      <table class="tg_a">
        <thead>
          <tr>
            <th class="tg_a-b3sw" colspan="2">SKALA PENILAIAN</th>
            <th class="tg_a-b3sw">KETENTUAN PENILAIAN</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="tg_a-0lax" style="width: 4%; text-align: center;">1</td>
            <td class="tg_a-0lax" style="width: 56%;">85 - 100 = A</td>
            <td class="tg_a-0lax" style="width: 40%;">Layak dengan Revisi</td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="text-align: center;">2</td>
            <td class="tg_a-0lax">75 - 84 = B+</td>
            <td class="tg_a-0lax">Layak dengan Revisi</td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="text-align: center;">3</td>
            <td class="tg_a-0lax">70 - 74 = B</td>
            <td class="tg_a-0lax">Layak dengan Revisi</td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="text-align: center;">4</td>
            <td class="tg_a-0lax">65 - 69 = C+</td>
            <td class="tg_a-0lax">Layak dengan Revisi</td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="text-align: center;">5</td>
            <td class="tg_a-0lax">60 - 64 = C</td>
            <td class="tg_a-0lax">Layak dengan Revisi</td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="text-align: center;">6</td>
            <td class="tg_a-0lax">50 - 59 = D</td>
            <td class="tg_a-0lax">Tidak Layak, Revisi Total</td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="text-align: center;">7</td>
            <td class="tg_a-0lax">0 - 50 = E</td>
            <td class="tg_a-0lax">Tidak Layak, Revisi Total & Mengulang Seminar</td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;">Malang, <?php echo bulanIndo($djdwl['tgl_seminar']);?></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" colspan="2" style="border:none;">Narasumber 1</td>
            <td class="tg_a-0lax" style="border:none;">Narasumber 2</td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" colspan="2" style="border:none;"><?php echo $dp1['nama'];?></td>
            <td class="tg_a-0lax" style="border:none;"><?php echo $dp2['nama'];?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <br/>
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><b>REKOMENDASI PERBAIKAN PROPOSAL SKRIPSI</b>
      </p>
      <table class="info" width="100%" style="font-weight:normal;">
        <tbody>
          <tr>
            <td colspan="3" width="22%">Nama Mahasiswa</td>
            <td width="2%">:</td>
            <td colspan="4" width="76%"><?php echo strtoupper($dataku['nama']);?></td>
          </tr>
          <tr>
            <td colspan="3">NIM</td>
            <td>:</td>
            <td colspan="4"><?php echo $dataku['nim'];?></td>
          </tr>
          <tr>
            <td colspan="3">Judul Proposal Skripsi</td>
            <td>:</td>
            <td colspan="4"><?php echo strtoupper($dt['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_prop']));?></td>
          </tr>
          <tr>
            <td colspan="3">Narasumber 1</td>
            <td>:</td>
            <td colspan="4"><?php echo strtoupper($dp1['nama']);?></td>
          </tr>
          <tr>
            <td colspan="3">Narasumber 2</td>
            <td>:</td>
            <td colspan="4"><?php echo strtoupper($dp2['nama']);?></td>
          </tr>
        </tbody>
      </table>
      <br />
      <table class="catatan">
        <tbody>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
        </tbody>
      </table>
      <table class="tg_a">
        <tbody>
        <tr>
            <td class="tg_a-0lax" colspan="2" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;">Narasumber 1</td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none; width: 4%;"></td>
            <td class="tg_a-0lax" style="border:none; width: 50%;"></td>
            <td class="tg_a-0lax" style="border:none; width: 46%;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" colspan="2" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"><?php echo $dp1['nama'];?></td>
          </tr>
      </table>
    </div>
    <br/>
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><b>REKOMENDASI PERBAIKAN PROPOSAL SKRIPSI</b>
      </p>
      <table class="info" width="100%" style="font-weight:normal;">
        <tbody>
          <tr>
            <td colspan="3" width="22%">Nama Mahasiswa</td>
            <td width="2%">:</td>
            <td colspan="4" width="76%"><?php echo strtoupper($dataku['nama']);?></td>
          </tr>
          <tr>
            <td colspan="3">NIM</td>
            <td>:</td>
            <td colspan="4"><?php echo $dataku['nim'];?></td>
          </tr>
          <tr>
            <td colspan="3">Judul Proposal Skripsi</td>
            <td>:</td>
            <td colspan="4"><?php echo strtoupper($dt['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_prop']));?></td>
          </tr>
          <tr>
            <td colspan="3">Narasumber 1</td>
            <td>:</td>
            <td colspan="4"><?php echo strtoupper($dp1['nama']);?></td>
          </tr>
          <tr>
            <td colspan="3">Narasumber 2</td>
            <td>:</td>
            <td colspan="4"><?php echo strtoupper($dp2['nama']);?></td>
          </tr>
        </tbody>
      </table>
      <br />
      <table class="catatan">
        <tbody>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;----------------------------------------------------------------------------------------------------------------------------------------------------------------&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
          <tr>
            <td style="text-align: center; width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
          </tr>
        </tbody>
      </table>
      <table class="tg_a">
        <tbody>
        <tr>
            <td class="tg_a-0lax" colspan="2" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;">Narasumber 2</td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none; width: 4%;"></td>
            <td class="tg_a-0lax" style="border:none; width: 50%;"></td>
            <td class="tg_a-0lax" style="border:none; width: 46%;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"></td>
          </tr>
          <tr>
            <td class="tg_a-0lax" colspan="2" style="border:none;"></td>
            <td class="tg_a-0lax" style="border:none;"><?php echo $dp2['nama'];?></td>
          </tr>
      </table>
    </div>
  </body>
  <?php include( "jsAdm.php" );?>
  <script type="text/javascript">
    $(document).ready(function() {
       window.print();
       window.close(); 
    });
  </script>