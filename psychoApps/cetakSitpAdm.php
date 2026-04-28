<?php include("contentsConAdm.php");
$id = mysqli_real_escape_string($con,  $_GET['id']);
$myquery = "SELECT * FROM sitp WHERE id='$id'";
$res = mysqli_query($con,  $myquery) or die(mysqli_error($con));
$dt = mysqli_fetch_assoc($res);

$qkota = "SELECT * FROM dt_kota WHERE id='$dt[kota_lts]'";
$reskota = mysqli_query($con,  $qkota) or die(mysqli_error($con));
$dkota = mysqli_fetch_assoc($reskota);
$nm_kota = $dkota['nm_kota'];

$qnl = "SELECT * FROM nama_lembaga";
$resnl = mysqli_query($con,  $qnl) or die(mysqli_error($con));
$dnl = mysqli_fetch_assoc($resnl);
$nm_lembaga = $dnl['nm'];

$qnli = "SELECT * FROM nama_lembaga_induk";
$resnli = mysqli_query($con,  $qnli) or die(mysqli_error($con));
$dnli = mysqli_fetch_assoc($resnli);
$nm_lembaga_induk = $dnli['nm'];

if (!empty($dt['ta'])) {
   $ta_id = $dt['ta'];
} else {
   $qpend = "SELECT * FROM pendaftaran_pkl WHERE status='1'";
   $rpend = mysqli_query($con, $qpend) or die(mysqli_error($con));
   $dpend = mysqli_fetch_assoc($rpend);
   $ta_id = $dpend['ta'];
}

$qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$ta_id'";
$hasil = mysqli_query($con, $qry_nm_ta);
$dnta = mysqli_fetch_assoc($hasil);

$qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
$h = mysqli_query($con, $qry_nm_smt);
$dsemester = mysqli_fetch_assoc($h);

$qsp = "SELECT * FROM opsi_sebutan_pimpinan WHERE id='$dt[sebutan_pimpinan]'";
$ressp = mysqli_query($con,  $qsp) or die(mysqli_error($con));
$dsp = mysqli_fetch_assoc($ressp);

$qbln = "SELECT MONTH(tgl_dikeluarkan) AS bulan FROM sitp WHERE id='$id'";
$resbln = mysqli_query($con,  $qbln) or die(mysqli_error($con));
$dbln = mysqli_fetch_assoc($resbln);
$ambilbln = $dbln['bulan'];

$qthn = "SELECT YEAR(tgl_dikeluarkan) AS tahun FROM sitp WHERE id='$id'";
$resthn = mysqli_query($con,  $qthn) or die(mysqli_error($con));
$dthn = mysqli_fetch_assoc($resthn);
$ambilthn = $dthn['tahun'];

$qdekanat1 = "SELECT * from dt_pegawai WHERE jabatan_instansi='2'";
$resdekanat1 = mysqli_query($con, $qdekanat1) or die(mysqli_error($con));
$ddekanat1 = mysqli_fetch_assoc($resdekanat1);

$qjdekanat1 = "SELECT * from opsi_jabatan WHERE id='$ddekanat1[jabatan]'";
$resjdekanat1 = mysqli_query($con, $qjdekanat1) or die(mysqli_error($con));
$djdekanat1 = mysqli_fetch_assoc($resjdekanat1);

$qjidekanat1 = "SELECT * from opsi_jabatan_instansi WHERE id='$ddekanat1[jabatan_instansi]'";
$resjidekanat1 = mysqli_query($con, $qjidekanat1) or die(mysqli_error($con));
$djidekanat1 = mysqli_fetch_assoc($resjidekanat1);

$qkddekanat1 = "SELECT * from dekanat WHERE id='2'";
$reskddekanat1 = mysqli_query($con, $qkddekanat1) or die(mysqli_error($con));
$dkddekanat1 = mysqli_fetch_assoc($reskddekanat1);

function bulanIndo($tanggal)
{
   $bulan = array(
      1 => 'Januari',
      'Februari',
      'Maret',
      'April',
      'Mei',
      'Juni',
      'Juli',
      'Agustus',
      'September',
      'Oktober',
      'Nopember',
      'Desember'
   );
   $split = explode('-', $tanggal);
   return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <title>Surat Mahasiswa</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <style>
      table,
      th,
      td {
         border: 0;
      }

      .right {
         float: right;
         position: relative;
         width: 300px;
         margin-bottom: 20px;
      }

      .ttd {
         margin-top: -30px;
         margin-bottom: -40px;
         float: right;
         position: relative;
         left: 340px;
      }

      @media print {
         body {
            margin-top: 10mm;
            margin-bottom: 20mm;
            margin-left: 30mm;
            margin-right: 20mm
         }
      }
   </style>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:1.1em;">
   <?php
   include("kopPotretUser.php");
   ?>
   <table width="100%" style="padding-left:0px;">
      <tr>
         <td width="10%">Nomor</td>
         <td width="2%" align="center">:</td>
         <td width="62%"><?php if ($dt['no_agenda_surat'] == '') {
                              echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                           } else {
                              echo $dt['no_agenda_surat'];
                           } ?>/<?php echo $dkddekanat1['kd_nmr_srt']; ?>/PP.00.9/<?php echo "$ambilbln"; ?>/<?php echo "$ambilthn"; ?></td>
         <td width="26%" align="right"><?php echo bulanIndo($dt['tgl_dikeluarkan']); ?></td>
      </tr>
      <tr>
         <td>Hal</td>
         <td align="center">:</td>
         <td><strong>PERMOHONAN TEMPAT PKL</strong></td>
         <td>&nbsp;</td>
      </tr>

      <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>Kepada Yth.:</td>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td><strong><?php echo $dsp['nm']; ?></strong><br />
            <strong><?php echo $dt['lembaga_tujuan_surat']; ?></strong><br />
            <strong><?php echo $dt['alamat_lengkap_lts']; ?></strong>
         </td>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td colspan="2"><strong><i>Assalamu'alaikum wa Rahmatullah wa Barakatuh</i></strong></td>
      </tr>
      <!-- <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr> -->
      <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td colspan="2" style="text-align:justify;">
            Dengan hormat, <br /><br />
            Sehubungan dengan kegiatan Praktik Kerja Lapangan (PKL) <?php if ($dt['jenis_pkl'] == 1) {
                                                                        echo "";
                                                                     } else if ($dt['jenis_pkl'] == 2) {
                                                                        echo "MBKM";
                                                                     } ?> <?php echo "$nm_lembaga" . ' ' . "$nm_lembaga_induk"; ?> Semester <?php echo "$dsemester[nama]" . ' Tahun Akademik ' . "$dnta[ta]"; ?>, maka dengan ini Kami mohon Bapak/Ibu berkenan memberikan izin kepada mahasiswa kami

            <!-- <?php echo "$nm_lembaga" . ' ' . "$nm_lembaga_induk"; ?>  -->
            untuk melakukan kegiatan Praktik Kerja Lapangan (PKL) <?php if ($dt['jenis_pkl'] == 1) {
                                                                     echo "";
                                                                  } else if ($dt['jenis_pkl'] == 2) {
                                                                     echo "MBKM";
                                                                  } ?> di instansi yang Bapak/Ibu pimpin selama <?php if ($dt['jenis_pkl'] == 1) {
                                                                                                                     echo "40 (empat puluh) hari kerja";
                                                                                                                  } else if ($dt['jenis_pkl'] == 2) {
                                                                                                                     echo "3 bulan";
                                                                                                                  } ?>.
            <br />
            <br />
            Adapun nama-nama mahasiswa tersebut sebagai berikut:
            <br />
            <table width="100%">
               <thead>
                  <tr>
                     <td width="15%" style="text-align: left; vertical-align: top;">Nama</td>
                     <td width="2%" style="text-align: center; vertical-align: top;">:</td>
                     <td width="83%" style="text-align: left;">
                        <table width="100%" style="border-collapse: collapse;">
                           <?php
                           $qry_anggota = "SELECT * FROM draf_anggota_pkl WHERE id_sitp='$dt[id]' AND nim_anggota<>'' ORDER BY urutan ASC";
                           $res_anggota = mysqli_query($con, $qry_anggota) or die(mysqli_error($con));
                           $no_anggota = 1;
                           while ($dataku = mysqli_fetch_assoc($res_anggota)) {
                              $qmhssw = "SELECT * FROM dt_mhssw WHERE nim='$dataku[nim_anggota]'";
                              $resmhssw = mysqli_query($con, $qmhssw) or die(mysqli_error($con));
                              $dtmhssw = mysqli_fetch_assoc($resmhssw);
                           ?>
                              <tr>
                                 <td width="3%" style="vertical-align: top;"><?php echo $no_anggota; ?>.</td>
                                 <td width="55%" style="vertical-align: top;"><?php echo strtoupper($dtmhssw['nama']); ?></td>
                                 <td width="10%" style="vertical-align: top;">NIM</td>
                                 <td width="32%" style="vertical-align: top;"><?php echo $dtmhssw['nim']; ?></td>
                              </tr>
                           <?php
                              $no_anggota++;
                           }
                           ?>
                        </table>
                     </td>
                  </tr>
                  <tr>
                     <td style="text-align: left;">Lokasi</td>
                     <td style="text-align: center;">:</td>
                     <td style="text-align: left;"><?php echo $dt['lembaga_tujuan_surat'] . ' ' . $nm_kota; ?></td>
                  </tr>
                  <tr>
                     <td style="text-align: left;">Waktu</td>
                     <td style="text-align: center;">:</td>
                     <td style="text-align: left;"><?php if ($dt['tgl_mulai_pkl'] == '0000-00-00' or empty($dt['tgl_mulai_pkl'])) {
                                                      echo "-";
                                                   } else {
                                                      echo bulanIndo($dt['tgl_mulai_pkl']) . ' s.d. ' . bulanIndo($dt['tgl_selesai_pkl']);
                                                   } ?></td>
                  </tr>
               </thead>
            </table>
            <br />
            Demikian permohonan ini kami sampaikan, atas perhatian dan kerjasamanya kami sampaikan terimakasih.
         </td>
      </tr>
      <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td colspan="2"><strong><i>Wassalamu'alaikum wa Rahmatullah wa Barakatuh</i></strong></td>
      </tr>
   </table>
   <br />
   <br />
   <div class="right">
      a.n. Dekan
      <br />
      <?php echo $djidekanat1['nm']; ?>,
      <br />
   </div>
   <div class="ttd">
      <img width="40%" src="images/ttd_wd1_1.png">
   </div>
   <div class="right">
      <?php echo $ddekanat1['nama_tg']; ?>
   </div>
   <table width="100%">
      <tr>
         <td>Tembusan:<br />
            <?php
            echo nl2br($dt['tembusan']);
            ?>
         </td>
      </tr>
   </table>
   <?php include("jsAdm.php"); ?>
   <script type="text/javascript">
      $(document).ready(function() {
         window.print();
         window.close();
      });
   </script>
</body>

</html>