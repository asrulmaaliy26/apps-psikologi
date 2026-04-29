<?php include("contentsConAdm.php");

$id = mysqli_real_escape_string($con, $_GET['id']);

if ($id == 'dummy') {
   // DATA DUMMY UNTUK PREVIEW LAYOUT MAGANG
   $dt = [
      'nim' => '2021010003',
      'no_agenda_surat' => '321',
      'tgl_dikeluarkan' => date('Y-m-d'),
      'lembaga_tujuan_surat' => 'RSJ Dr. Radjiman Wediodiningrat',
      'alamat_lengkap_lts' => 'Jl. Dr. Radjiman No. 251, Lawang, Malang',
      'kota_lts' => '1',
      'sebutan_pimpinan' => '1',
      'nama_obyek' => 'Instansi Rehabilitasi Psikososial',
      'tgl_awal_pelaksanaan' => date('Y-m-d', strtotime('+2 months')),
      'tgl_akhir_pelaksanaan' => date('Y-m-d', strtotime('+3 months')),
      'tembusan' => "1. Dekan Fakultas Psikologi\n2. Pembimbing Lapangan\n3. Arsip"
   ];
   $dataku = [
      'nama' => 'Budi Santoso',
      'nim' => '2021010003'
   ];
   $nm_lembaga = 'Fakultas Psikologi';
   $nm_lembaga_induk = 'Universitas Contoh';
   $nm_kota = 'Malang';
   $dsp = ['nm' => 'Direktur'];
   $ambilbln = date('n');
   $ambilthn = date('Y');

   // Ambil data pejabat dari tabel dekanat (ID 2 = WD1)
   $qset = mysqli_query($con, "SELECT * FROM dekanat WHERE id='2'");
   $dset = mysqli_fetch_assoc($qset);
   $nip_pejabat = ($dset && !empty($dset['nm_jabatan'])) ? $dset['nm_jabatan'] : '196811242000031001';

   $qdekanat1 = "SELECT * FROM dt_pegawai WHERE id='$nip_pejabat'";
   $resdekanat1 = mysqli_query($con, $qdekanat1);
   $ddekanat1 = mysqli_fetch_assoc($resdekanat1);

   if (!$ddekanat1) {
      $ddekanat1 = [
         'nama_tg' => 'Nama Pejabat Belum Diatur',
         'jabatan' => '1',
         'jabatan_instansi' => '2'
      ];
   }

   $qjdekanat1 = "SELECT * FROM opsi_jabatan WHERE id='$ddekanat1[jabatan]'";
   $resjdekanat1 = mysqli_query($con, $qjdekanat1);
   $djdekanat1 = mysqli_fetch_assoc($resjdekanat1) ?: ['nm' => 'Jabatan'];

   $qjidekanat1 = "SELECT * FROM opsi_jabatan_instansi WHERE id='$ddekanat1[jabatan_instansi]'";
   $resjidekanat1 = mysqli_query($con, $qjidekanat1);
   $djidekanat1 = mysqli_fetch_assoc($resjidekanat1) ?: ['nm' => 'Wakil Dekan Bidang Akademik'];
} else {
   // LOGIKA ASLI
   $myquery = "SELECT * FROM magang WHERE id='$id'";
   $res = mysqli_query($con,  $myquery) or die(mysqli_error($con));
   $dt = mysqli_fetch_assoc($res);

   $qry = "SELECT * FROM dt_mhssw WHERE nim='$dt[nim]'";
   $resp = mysqli_query($con,  $qry) or die(mysqli_error($con));
   $dataku = mysqli_fetch_assoc($resp);

   $qnl = "SELECT * FROM nama_lembaga";
   $resnl = mysqli_query($con,  $qnl) or die(mysqli_error($con));
   $dnl = mysqli_fetch_assoc($resnl);
   $nm_lembaga = $dnl['nm'] ?? 'Fakultas Psikologi';

   $qkota = "SELECT * FROM dt_kota WHERE id='$dt[kota_lts]'";
   $reskota = mysqli_query($con,  $qkota) or die(mysqli_error($con));
   $dkota = mysqli_fetch_assoc($reskota);
   $nm_kota = $dkota['nm_kota'] ?? 'Malang';

   $qnli = "SELECT * FROM nama_lembaga_induk";
   $resnli = mysqli_query($con,  $qnli) or die(mysqli_error($con));
   $dnli = mysqli_fetch_assoc($resnli);
   $nm_lembaga_induk = $dnli['nm'] ?? 'UIN Malang';

   $qsp = "SELECT * FROM opsi_sebutan_pimpinan WHERE id='$dt[sebutan_pimpinan]'";
   $ressp = mysqli_query($con,  $qsp) or die(mysqli_error($con));
   $dsp = mysqli_fetch_assoc($ressp) ?: ['nm' => 'Bapak/Ibu Pimpinan'];

   $qbln = "SELECT MONTH(tgl_dikeluarkan) AS bulan FROM magang WHERE id='$id'";
   $resbln = mysqli_query($con,  $qbln) or die(mysqli_error($con));
   $dbln = mysqli_fetch_assoc($resbln);
   $ambilbln = $dbln['bulan'] ?? date('n');

   $qthn = "SELECT YEAR(tgl_dikeluarkan) AS tahun FROM magang WHERE id='$id'";
   $resthn = mysqli_query($con,  $qthn) or die(mysqli_error($con));
   $dthn = mysqli_fetch_assoc($resthn);
   $ambilthn = $dthn['tahun'] ?? date('Y');

   $qdekanat1 = "SELECT * from dt_pegawai WHERE jabatan_instansi='2'";
   $resdekanat1 = mysqli_query($con, $qdekanat1) or die(mysqli_error($con));
   $ddekanat1 = mysqli_fetch_assoc($resdekanat1);

   $qjdekanat1 = "SELECT * from opsi_jabatan WHERE id='$ddekanat1[jabatan]'";
   $resjdekanat1 = mysqli_query($con, $qjdekanat1) or die(mysqli_error($con));
   $djdekanat1 = mysqli_fetch_assoc($resjdekanat1);

   $qjidekanat1 = "SELECT * from opsi_jabatan_instansi WHERE id='$ddekanat1[jabatan_instansi]'";
   $resjidekanat1 = mysqli_query($con, $qjidekanat1) or die(mysqli_error($con));
   $djidekanat1 = mysqli_fetch_assoc($resjidekanat1);
}

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
         width: 260px;
         margin-bottom: 20px;
      }

      .ttd {
         margin-top: 10px;
         margin-bottom: -70px;
         float: right;
         position: relative;
         left: 80px;
         z-index: -1;
      }
   </style>
</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:1.1em;">
   <?php
   include("kopPotret.php");
   ?>
   <table width="100%" style="padding-left:0px;">
      <tr>
         <td width="10%">Nomor</td>
         <td width="2%" align="center">:</td>
         <td width="62%"><?php if ($dt['no_agenda_surat'] == '') {
                              echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                           } else {
                              echo '&nbsp;' . $dt['no_agenda_surat'];
                           } ?>/<?php echo $dkddekanat1['kd_nmr_srt']; ?>/PP.009/<?php echo "$ambilbln"; ?>/<?php echo "$ambilthn"; ?></td>
         <td width="26%" align="right"><?php echo bulanIndo($dt['tgl_dikeluarkan']); ?></td>
      </tr>
      <tr>
         <td>Hal</td>
         <td align="center">:</td>
         <td>Permohonan Magang</td>
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
         <td>Kepada Yth.</td>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td><?php echo $dsp['nm'] . ' ' . $dt['lembaga_tujuan_surat']; ?></td>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td><?php echo $dt['alamat_lengkap_lts']; ?></td>
         <td>&nbsp;</td>
      </tr>
      <tr>
         <td>&nbsp;</td>
         <td>&nbsp;</td>
         <td>di&nbsp;Tempat</td>
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
         <td colspan="2"><i>Assalamu 'alaikum wa Rahmatullah wa Barakatuh.</i></td>
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
         <td colspan="2" style="text-align:justify;">
            Dengan hormat, <br /><br />
            Dalam rangka meningkatkan kompetensi mahasiswa <?php echo "$nm_lembaga" . ' ' . "$nm_lembaga_induk"; ?>, maka dengan ini kami mohon kepada Bapak/Ibu untuk memberikan kesempatan melaksanakan kegiatan magang di lembaga/instansi yang Bapak/Ibu pimpin, kepada:
            <br />
            <br />
            <table width="100%" style="padding-left:0px;">
               <tr>
                  <td width="26%">Nama / NIM</td>
                  <td width="2%" align="center">:</td>
                  <td width="72%"><?php echo strtoupper($dataku['nama']) . '/' . $dataku['nim']; ?></td>
               </tr>
               <tr valign="top">
                  <td>Tempat Magang</td>
                  <td align="center">:</td>
                  <td><?php echo $dt['nama_obyek']; ?></td>
               </tr>
               <tr valign="top">
                  <td>Tanggal Magang</td>
                  <td align="center">:</td>
                  <td><?php echo $dt['tgl_awal_pelaksanaan'] . ' s.d ' . $dt['tgl_akhir_pelaksanaan']; ?></td>
               </tr>
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
         <td colspan="2"><i>Wassalamu 'alaikum wa Rahmatullah wa Barakatuh.</i></td>
      </tr>
   </table>
   <br />
   <br />
   <div class="right">
      a.n. Dekan <br />
      <?php echo $djidekanat1['nm']; ?>,
      <br />
   </div>
   <div class="ttd">
      <?php if (!empty($dkddekanat1['ttd']) && file_exists("images/" . $dkddekanat1['ttd'])) { ?>
         <img width="200" src="images/<?php echo $dkddekanat1['ttd']; ?>">
      <?php } else { ?>
         <br><br><br>
      <?php } ?>
   </div>
   <div class="right">
      <br />
      <br />
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