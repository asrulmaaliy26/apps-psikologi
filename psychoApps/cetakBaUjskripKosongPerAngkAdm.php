<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
   $myquery = "SELECT * FROM peserta_ujskrip WHERE id='$id'";
   $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
   $dt = mysqli_fetch_assoc( $res );
   
   $jdwl = "SELECT * FROM jadwal_ujskrip WHERE id='$dt[id_jdwl]'";
   $rjdwl = mysqli_query($con,  $jdwl )or die( mysqli_error($con) );
   $djdwl = mysqli_fetch_assoc( $rjdwl );
   
   $qry = "SELECT * FROM dt_mhssw WHERE nim='$dt[nim]'";
   $resp = mysqli_query($con,  $qry )or die( mysqli_error($con) );
   $dataku = mysqli_fetch_assoc( $resp );
   
   $qpemb1 = "SELECT * FROM dt_pegawai JOIN pengelompokan_dospem_skripsi ON dt_pegawai.id=pengelompokan_dospem_skripsi.dospem_skripsi1 WHERE pengelompokan_dospem_skripsi.nim='$dt[nim]'";
   $resp = mysqli_query($con,  $qpemb1 )or die( mysqli_error($con) );
   $dp1 = mysqli_fetch_assoc( $resp );
  
   $qpemb2 = "SELECT * FROM dt_pegawai JOIN pengelompokan_dospem_skripsi ON dt_pegawai.id=pengelompokan_dospem_skripsi.dospem_skripsi2 WHERE pengelompokan_dospem_skripsi.nim='$dt[nim]'";
   $resp = mysqli_query($con,  $qpemb2 )or die( mysqli_error($con) );
   $dp2 = mysqli_fetch_assoc( $resp );
  
   $qPengUtama = "SELECT * FROM dt_pegawai WHERE id='$djdwl[penguji_utama]'";
   $rPengUtama = mysqli_query($con,  $qPengUtama )or die( mysqli_error($con) );
   $dPengUtama = mysqli_fetch_assoc( $rPengUtama );
      
   $qPengKetua = "SELECT * FROM dt_pegawai WHERE id='$djdwl[ketua_penguji]'";
   $rPengKetua = mysqli_query($con,  $qPengKetua )or die( mysqli_error($con) );
   $dPengKetua = mysqli_fetch_assoc( $rPengKetua );
   
   $qPengSekretaris = "SELECT * FROM dt_pegawai WHERE id='$djdwl[sekretaris_penguji]'";
   $rPengSekretaris = mysqli_query($con,  $qPengSekretaris )or die( mysqli_error($con) );
   $dPengSekretaris = mysqli_fetch_assoc( $rPengSekretaris );
  
   $qry_moment = "SELECT * FROM pendaftaran_skripsi WHERE id='$dt[id_ujskrip]'";
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
    <title>PsychoApps</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      .infodepan { width: 100%; }
      .infodepan td {
      border-collapse: collapse;
      vertical-align: top;
      font-size:20px;
      }
      .info { width: 100%; }
      .info td {
      border-collapse: collapse;
      vertical-align: top;
      font-size:16px;
      }
      .rerata { 
      width: 100%;
      border-collapse: collapse;
      }
      .rerata td {
      vertical-align: middle;
      }
      .ttdPenguji {
      width: 100%;
      border-collapse: collapse;
      }
      .ttdPenguji td {
      vertical-align: middle;
      text-align: left;
      }
      .konversiNilai {
      width: 40%;
      border-collapse: collapse;
      }
      .konversiNilai td {
      text-align:center;vertical-align: middle;border-color:black;border-style:solid;border-width:1px;font-size:15px;
      overflow:hidden;padding:2px 2px 2px 2px;word-break:normal;
      }
      .konversiNilai th {
      text-align:center;vertical-align: middle;border-color:black;border-style:solid;border-width:1px;font-size:15px;
      font-weight:bold;overflow:hidden;padding:3px 3px;word-break:normal;
      }
      .tg  {border-collapse:collapse;border-spacing:0; width: 100%;}
      .tg td{border-color:black;border-style:solid;border-width:1px;font-size:15px;
      overflow:hidden;padding:3px 3px 8px 8px;word-break:normal;}
      .tg th{border-color:black;border-style:solid;border-width:1px;font-size:15px;
      font-weight:bold;overflow:hidden;padding:3px 3px;word-break:normal;}
      .tg .tg-0lax{text-align:left;vertical-align:middle;}
      .tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:middle;}
      .tg1  {border-collapse:collapse;border-spacing:0;}
      .tg1 td{border-color:black;border-style:solid;border-width:1px;font-size:15px;
      overflow:hidden;padding:3px 3px 8px 8px;word-break:normal;}
      .tg1 th{border-color:black;border-style:solid;border-width:1px;font-size:15px;
      font-weight:bold;overflow:hidden;padding:3px 3px 8px 8px;word-break:normal;}
      .tg1 .tg1-lboi{border-color:inherit;text-align:left;vertical-align:middle;}
      .tg1 .tg1-9wq8{border-color:inherit;text-align:center;vertical-align:middle;}
      .tg1 .tg1-uzvj{border-color:inherit;font-weight:bold;text-align:center;vertical-align:middle;}
      .catatan {
      border: 1.5px solid black; width: 100%; border-collapse: collapse;
      }
      .catatan td {
      padding: 4px 4px;
      }
      .keterangan {
      width: 100%; border-collapse: collapse;
      }
      .keterangan td {
      padding: 5px 5px 5px 5px;
      }
      .right {
      float: right;
      width: 340px;
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
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><b>BERITA ACARA PENILAIAN UJIAN SKRIPSI</b>
      </p>
      <table class="infodepan">
        <tbody>
          <tr>
            <td width="22%">Nama Mahasiswa</td>
            <td width="2%">:</td>
            <td width="76%"><?php echo strtoupper($dataku['nama']);?></td>
          </tr>
          <tr>
            <td>NIM</td>
            <td>:</td>
            <td><?php echo $dataku['nim'];?></td>
          </tr>
          <tr>
            <td>Jurusan</td>
            <td>:</td>
            <td>PSIKOLOGI</td>
          </tr>
          <tr>
            <td>Hari Tanggal Ujian</td>
            <td>:</td>
            <td><?php echo strtoupper($dayList[$day]).' '.strtoupper(bulanIndo($djdwl['tgl_ujian']));?></td>
          </tr>
          <tr>
            <td>Ruang Ujian</td>
            <td>:</td>
            <td><?php echo strtoupper($druang['nm']);?></td>
          </tr>
          <tr>
            <td>Judul Skripsi</td>
            <td>:</td>
            <td><?php echo strtoupper($dt['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dt['judul_skripsi']));?></td>
          </tr>
          <tr>
            <td>Pembimbing</td>
            <td>:</td>
            <td><?php if(empty($dp2['dospem_skripsi2'])) { echo strtoupper($dp1['nama']);} else { echo '1. ' .strtoupper($dp1['nama']). '<br/>'.'2. ' .strtoupper($dp2['nama']);}?></td>
          </tr>
          <tr>
            <td>Penguji Utama</td>
            <td>:</td>
            <td><?php echo strtoupper($dPengUtama['nama']);?></td>
          </tr>
          <tr>
            <td>Ketua Penguji</td>
            <td>:</td>
            <td><?php echo strtoupper($dPengKetua['nama']);?></td>
          </tr>
          <tr>
            <td>Sekretaris Penguji</td>
            <td>:</td>
            <td><?php echo strtoupper($dPengSekretaris['nama']);?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <br />
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <p style="text-align:center; font-size:16px; text-transform:uppercase;"><b>REKAP PENILAIAN UJIAN SKRIPSI</b>
      </p>
      <?php include "infoPesertaUjskrip.php";?>
      <table class="tg">
        <thead>
          <tr>
            <th class="tg-0lax" style="width:4%; border-left: none; border-right: none; border-top:none;"></th>
            <th class="tg-0pky" style="width:50%; border-left: none; border-right: none; border-top:none;"></th>
            <th class="tg-0pky" style="width:28%; border-left: none; border-right: none; border-top:none;"></th>
            <th class="tg-0pky" style="width:18%; border-left: none; border-right: none; border-top:none;"></th>
          </tr>
          <tr>
            <th class="tg-0lax" style="text-align: center;">NO</th>
            <th class="tg-0pky" style="text-align: center;" colspan="2">NILAI PENGUJI</th>
            <th class="tg-0pky" style="text-align: center;">NILAI (X)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="tg-0lax" style="text-align: center;">1.</td>
            <td class="tg-0pky" colspan="2">Penguji Utama</td>
            <td class="tg-0pky"></td>
          </tr>
          <tr>
            <td class="tg-0lax" style="text-align: center;">2.</td>
            <td class="tg-0pky" colspan="2">Ketua Penguji</td>
            <td class="tg-0pky"></td>
          </tr>
          <tr>
            <td class="tg-0lax" style="text-align: center;">3.</td>
            <td class="tg-0pky" colspan="2">Sekretaris Penguji</td>
            <td class="tg-0pky"></td>
          </tr>
          <tr>
            <td class="tg-0lax" colspan="3"><strong>Total Nilai</strong></td>
            <td class="tg-0pky"></td>
          </tr>
          <tr>
            <td colspan="2" style="text-align:center; padding:0px;">
              <table class="rerata">
                <tr>
                  <td style="border:none;"><img src="images/rerata.jpg" style="width: 50%;height: auto;"></td>
                </tr>
              </table>
            </td>
            <td colspan="" style="text-align:center; padding:0px;">
              <table class="rerata">
                <tr>
                  <td style="border:none;"><img src="images/mx.jpg" style="width: 40%;height: auto;"></td>
                </tr>
              </table>
            </td>
            <td class="tg-0pky"></td>
          </tr>
          <tr>
            <td class="tg-0lax" colspan="2" style="padding:30px;">Tanda Tangan Mhs:</td>
            <td class="tg-0pky" colspan="2" style="padding:30px;">Keputusan Sidang: <strong><i>Lulus / Tidak Lulus</i></strong></td>
          </tr>
        </tbody>
      </table>
      <p style="text-align:right;">Malang, <?php echo bulanIndo($djdwl['tgl_ujian']);?></p>
      <table class="ttdPenguji">
        <tr>
          <td style="width:33.3%"><strong>Penguji Utama,</strong></td>
          <td style="width:33.3%"><strong>Ketua Penguji,</strong></td>
          <td style="width:33.3%"><strong>Sekretaris Penguji,</strong></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td style="vertical-align:top;"><strong><?php echo $dPengUtama['nama'];?></strong></td>
          <td style="vertical-align:top;"><strong><?php echo $dPengKetua['nama'];?></strong></td>
          <td style="vertical-align:top;"><strong><?php echo $dPengSekretaris['nama'];?></strong></td>
        </tr>
      </table>
      <br/>
      <span><strong>Keterangan Konversi Nilai</strong></span>
      <table class="konversiNilai">
        <thead>
          <th style="width:3%;">No.</th>
          <th style="width:14%;">Nilai</th>
          <th style="width:7%;">Huruf</th>
          <th style="width:16%;">Keterangan</th>
        </thead>
        <tbody>
          <tr>
            <td>1.</td>
            <td>85 - 100</td>
            <td>A</td>
            <td>Lulus</td>
          </tr>
          <tr>
            <td>2.</td>
            <td>75 - 84</td>
            <td>B+</td>
            <td>Lulus</td>
          </tr>
          <tr>
            <td>3.</td>
            <td>70 - 74</td>
            <td>B</td>
            <td>Lulus</td>
          </tr>
          <tr>
            <td>4.</td>
            <td>65 - 69</td>
            <td>C+</td>
            <td>Lulus</td>
          </tr>
          <tr>
            <td>5.</td>
            <td>60 - 64</td>
            <td>C</td>
            <td>Lulus</td>
          </tr>
          <tr>
            <td>6.</td>
            <td>55 - 59</td>
            <td>D</td>
            <td>Tidak Lulus</td>
          </tr>
          <tr>
            <td>7.</td>
            <td>< 50</td>
            <td>E</td>
            <td>Tidak Lulus</td>
          </tr>
        </tbody>
      </table>
    </div>
    <br />
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <p style="text-align:center; font-size:16px; text-transform:uppercase;"><b>PENILAIAN SIDANG UJIAN SKRIPSI</b>
      </p>
      <?php include "infoPesertaUjskrip.php";?>
      <br />
      <table class="tg1">
        <thead>
          <tr>
            <th class="tg1-lboi" rowspan="2" style="width:4%; text-align:center;">NO</th>
            <th class="tg1-lboi" rowspan="2" style="width:72%; text-align:center;">ASPEK PENILAIAN</th>
            <th class="tg1-lboi" style="width:8%; text-align:center;">NILAI</th>
            <th class="tg1-lboi" rowspan="2" style="width:16%; text-align:center;">NILAI</th>
          </tr>
          <tr>
            <th class="tg1-lboi" style="text-align:center;">MAKS</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="tg1-lboi" colspan="4"><strong>A. Nilai Tulisan</strong></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">1</td>
            <td class="tg1-lboi">Pemilihan dan Perumusan Masalah serta Relevansi Kerangka Teoritik dan Hipotesis (kalau ada) dengan Permasalahan</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">2</td>
            <td class="tg1-lboi">Ketepatan aspek metodologi</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">3</td>
            <td class="tg1-lboi">Kualitas sumber data (primer/sekunder, faktor-faktor kesulitan memperoleh/mencerna)</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">4</td>
            <td class="tg1-lboi">Kekuatan analisis dan penyajian tulisan</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">5</td>
            <td class="tg1-lboi">Kedalaman pembahasan dan ketepatan serta kecermatan pengambilan kesimpulan dan saran</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">6</td>
            <td class="tg1-lboi">Tata tulis</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-uzvj" colspan="2">Jumlah Nilai A</td>
            <td class="tg1-uzvj">60</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-lboi" colspan="4"><strong>B. Nilai Lisan</strong></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">1</td>
            <td class="tg1-lboi">Kemampuan mengemukakan dan menguraikan pemikiran/pendapat</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">2</td>
            <td class="tg1-lboi">Ketepatan dan relevansi jawaban</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">3</td>
            <td class="tg1-lboi">Penguasaan materi skripsi</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">4</td>
            <td class="tg1-lboi">Penampilan (sikap, emosi, dan kesopanan)</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-uzvj" colspan="2">Jumlah Nilai B</td>
            <td class="tg1-uzvj">40</td>
            <td class="tg1-uzvj"></td>
          </tr>
          <tr>
            <td class="tg1-uzvj" colspan="2">Nilai Total = Nilai A + Nilai B</td>
            <td class="tg1-uzvj">100</td>
            <td class="tg1-9wq8"></td>
          </tr>
        </tbody>
      </table>
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
        <?php echo "$dPengUtama[nama]";?>
      </div>
    </div>
    <br />
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <p style="text-align:center; font-size:16px; text-transform:uppercase;"><b>EVALUASI HASIL SIDANG SKRIPSI</b>
      </p>
      <?php include "infoPesertaUjskrip.php";?>
      <br />
      <span><strong>Catatan Revisi</strong></span>
      <table class="catatan">
        <tbody>
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
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </tbody>
      </table>
      <br />
      <br />
      <table class="keterangan">
        <tr>
          <td style="width:30%;border-left:3px dashed; border-top:3px dashed; border-right:3px dashed; border-bottom:3px dashed;"><strong>Keterangan</strong> <br />
            Sebagaimana diatur dalam Pedoman Pendidikan Fakultas Psikologi dan Pedoman Pendidikan UIN Maulana Malik Ibrahim Malang, maksimal waktu penuntasan revisi diberikan tidak lebih dari 14 hari (dua pekan) Sidang Skripsi dilaksanakan
          </td>
          <td style="width:20%;">&nbsp;</td>
          <td style="width:50%;">
            Malang, <?php echo bulanIndo($djdwl['tgl_ujian']);?> <br />
            Penguji Utama,
            <br />
            <br />
            <br />
            <br />
            <br />
            <?php echo "$dPengUtama[nama]";?>
          </td>
        </tr>
      </table>
    </div>
    <br />
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <p style="text-align:center; font-size:16px; text-transform:uppercase;"><b>PENILAIAN SIDANG UJIAN SKRIPSI</b>
      </p>
      <?php include "infoPesertaUjskrip.php";?>
      <br />
      <table class="tg1">
        <thead>
          <tr>
            <th class="tg1-lboi" rowspan="2" style="width:4%; text-align:center;">NO</th>
            <th class="tg1-lboi" rowspan="2" style="width:72%; text-align:center;">ASPEK PENILAIAN</th>
            <th class="tg1-lboi" style="width:8%; text-align:center;">NILAI</th>
            <th class="tg1-lboi" rowspan="2" style="width:16%; text-align:center;">NILAI</th>
          </tr>
          <tr>
            <th class="tg1-lboi" style="text-align:center;">MAKS</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="tg1-lboi" colspan="4"><strong>A. Nilai Tulisan</strong></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">1</td>
            <td class="tg1-lboi">Pemilihan dan Perumusan Masalah serta Relevansi Kerangka Teoritik dan Hipotesis (kalau ada) dengan Permasalahan</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">2</td>
            <td class="tg1-lboi">Ketepatan aspek metodologi</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">3</td>
            <td class="tg1-lboi">Kualitas sumber data (primer/sekunder, faktor-faktor kesulitan memperoleh/mencerna)</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">4</td>
            <td class="tg1-lboi">Kekuatan analisis dan penyajian tulisan</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">5</td>
            <td class="tg1-lboi">Kedalaman pembahasan dan ketepatan serta kecermatan pengambilan kesimpulan dan saran</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">6</td>
            <td class="tg1-lboi">Tata tulis</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-uzvj" colspan="2">Jumlah Nilai A</td>
            <td class="tg1-uzvj">60</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-lboi" colspan="4"><strong>B. Nilai Lisan</strong></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">1</td>
            <td class="tg1-lboi">Kemampuan mengemukakan dan menguraikan pemikiran/pendapat</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">2</td>
            <td class="tg1-lboi">Ketepatan dan relevansi jawaban</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">3</td>
            <td class="tg1-lboi">Penguasaan materi skripsi</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">4</td>
            <td class="tg1-lboi">Penampilan (sikap, emosi, dan kesopanan)</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-uzvj" colspan="2">Jumlah Nilai B</td>
            <td class="tg1-uzvj">40</td>
            <td class="tg1-uzvj"></td>
          </tr>
          <tr>
            <td class="tg1-uzvj" colspan="2">Nilai Total = Nilai A + Nilai B</td>
            <td class="tg1-uzvj">100</td>
            <td class="tg1-9wq8"></td>
          </tr>
        </tbody>
      </table>
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
        <?php echo "$dPengKetua[nama]";?>
      </div>
    </div>
    <br />
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <p style="text-align:center; font-size:16px; text-transform:uppercase;"><b>EVALUASI HASIL SIDANG SKRIPSI</b>
      </p>
      <?php include "infoPesertaUjskrip.php";?>
      <br />
      <span><strong>Catatan Revisi</strong></span>
      <table class="catatan">
        <tbody>
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
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </tbody>
      </table>
      <br />
      <br />
      <table class="keterangan">
        <tr>
          <td style="width:30%;border-left:3px dashed; border-top:3px dashed; border-right:3px dashed; border-bottom:3px dashed;"><strong>Keterangan</strong> <br />
            Sebagaimana diatur dalam Pedoman Pendidikan Fakultas Psikologi dan Pedoman Pendidikan UIN Maulana Malik Ibrahim Malang, maksimal waktu penuntasan revisi diberikan tidak lebih dari 14 hari (dua pekan) Sidang Skripsi dilaksanakan
          </td>
          <td style="width:20%;">&nbsp;</td>
          <td style="width:50%;">
            Malang, <?php echo bulanIndo($djdwl['tgl_ujian']);?> <br />
            Ketua Penguji,
            <br />
            <br />
            <br />
            <br />
            <br />
            <?php echo "$dPengKetua[nama]";?>
          </td>
        </tr>
      </table>
    </div>
    <br />
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <p style="text-align:center; font-size:16px; text-transform:uppercase;"><b>PENILAIAN SIDANG UJIAN SKRIPSI</b>
      </p>
      <?php include "infoPesertaUjskrip.php";?>
      <br />
      <table class="tg1">
        <thead>
          <tr>
            <th class="tg1-lboi" rowspan="2" style="width:4%; text-align:center;">NO</th>
            <th class="tg1-lboi" rowspan="2" style="width:72%; text-align:center;">ASPEK PENILAIAN</th>
            <th class="tg1-lboi" style="width:8%; text-align:center;">NILAI</th>
            <th class="tg1-lboi" rowspan="2" style="width:16%; text-align:center;">NILAI</th>
          </tr>
          <tr>
            <th class="tg1-lboi" style="text-align:center;">MAKS</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="tg1-lboi" colspan="4"><strong>A. Nilai Tulisan</strong></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">1</td>
            <td class="tg1-lboi">Pemilihan dan Perumusan Masalah serta Relevansi Kerangka Teoritik dan Hipotesis (kalau ada) dengan Permasalahan</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">2</td>
            <td class="tg1-lboi">Ketepatan aspek metodologi</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">3</td>
            <td class="tg1-lboi">Kualitas sumber data (primer/sekunder, faktor-faktor kesulitan memperoleh/mencerna)</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">4</td>
            <td class="tg1-lboi">Kekuatan analisis dan penyajian tulisan</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">5</td>
            <td class="tg1-lboi">Kedalaman pembahasan dan ketepatan serta kecermatan pengambilan kesimpulan dan saran</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">6</td>
            <td class="tg1-lboi">Tata tulis</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-uzvj" colspan="2">Jumlah Nilai A</td>
            <td class="tg1-uzvj">60</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-lboi" colspan="4"><strong>B. Nilai Lisan</strong></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">1</td>
            <td class="tg1-lboi">Kemampuan mengemukakan dan menguraikan pemikiran/pendapat</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">2</td>
            <td class="tg1-lboi">Ketepatan dan relevansi jawaban</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">3</td>
            <td class="tg1-lboi">Penguasaan materi skripsi</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-9wq8">4</td>
            <td class="tg1-lboi">Penampilan (sikap, emosi, dan kesopanan)</td>
            <td class="tg1-9wq8">10</td>
            <td class="tg1-lboi"></td>
          </tr>
          <tr>
            <td class="tg1-uzvj" colspan="2">Jumlah Nilai B</td>
            <td class="tg1-uzvj">40</td>
            <td class="tg1-uzvj"></td>
          </tr>
          <tr>
            <td class="tg1-uzvj" colspan="2">Nilai Total = Nilai A + Nilai B</td>
            <td class="tg1-uzvj">100</td>
            <td class="tg1-9wq8"></td>
          </tr>
        </tbody>
      </table>
      <br />
      <br />
      <div class="right">
        Malang, <?php echo bulanIndo($djdwl['tgl_ujian']);?> <br />
        Sekretaris Penguji,
        <br />
        <br />
        <br />
        <br />
        <br />
        <?php echo "$dPengSekretaris[nama]";?>
      </div>
    </div>
    <br />
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <p style="text-align:center; font-size:16px; text-transform:uppercase;"><b>EVALUASI HASIL SIDANG SKRIPSI</b>
      </p>
      <?php include "infoPesertaUjskrip.php";?>
      <br />
      <span><strong>Catatan Revisi</strong></span>
      <table class="catatan">
        <tbody>
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
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </tbody>
      </table>
      <br />
      <br />
      <table class="keterangan">
        <tr>
          <td style="width:30%;border-left:3px dashed; border-top:3px dashed; border-right:3px dashed; border-bottom:3px dashed;"><strong>Keterangan</strong> <br />
            Sebagaimana diatur dalam Pedoman Pendidikan Fakultas Psikologi dan Pedoman Pendidikan UIN Maulana Malik Ibrahim Malang, maksimal waktu penuntasan revisi diberikan tidak lebih dari 14 hari (dua pekan) Sidang Skripsi dilaksanakan
          </td>
          <td style="width:20%;">&nbsp;</td>
          <td style="width:50%;">
            Malang, <?php echo bulanIndo($djdwl['tgl_ujian']);?> <br />
            Sekretaris Penguji,
            <br />
            <br />
            <br />
            <br />
            <br />
            <?php echo "$dPengSekretaris[nama]";?>
          </td>
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