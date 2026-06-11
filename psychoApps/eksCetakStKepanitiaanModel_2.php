<?php include("contentsConAdm.php");

$id = mysqli_real_escape_string($con, $_GET['id']);

$sql1 =  "SELECT * FROM nama_lembaga";
$result1 = mysqli_query($con, $sql1);
$data1 = mysqli_fetch_array($result1);

$sql2 =  "SELECT * FROM nama_lembaga_induk";
$result2 = mysqli_query($con, $sql2);
$data2 = mysqli_fetch_array($result2);

$myquery = "select * from st WHERE id='$id'";
$res = mysqli_query($con, $myquery) or die(mysqli_error($con));
$dataku = mysqli_fetch_assoc($res);

$qry = "select COUNT(id_st) AS jumPersonil FROM personil_st WHERE id_st='$id' AND nama <>''";
$r = mysqli_query($con, $qry) or die(mysqli_error($con));
$dt = mysqli_fetch_assoc($r);
$jumPersonil = $dt['jumPersonil'];

$qbln = "SELECT MONTH(tgl_ditetapkan) AS bulan FROM st WHERE id='$id'";
$resbln = mysqli_query($con,  $qbln) or die(mysqli_error($con));
$dbln = mysqli_fetch_assoc($resbln);
$ambilbln = $dbln['bulan'];

$qthn = "SELECT YEAR(tgl_ditetapkan) AS tahun FROM st WHERE id='$id'";
$resthn = mysqli_query($con,  $qthn) or die(mysqli_error($con));
$dthn = mysqli_fetch_assoc($resthn);
$ambilthn = $dthn['tahun'];

$qkodesrt = "select * from dekanat WHERE id='1'";
$reskodesrt = mysqli_query($con, $qkodesrt) or die(mysqli_error($con));
$dkodesrt = mysqli_fetch_assoc($reskodesrt);

$qdekanat = "select * from dt_pegawai WHERE jabatan_instansi='1'";
$resdekanat = mysqli_query($con, $qdekanat) or die(mysqli_error($con));
$ddekanat = mysqli_fetch_assoc($resdekanat);

function bulanIndo($tanggal)
{
   $bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
   $split = explode('-', $tanggal);
   return $split[0] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[2];
}

function tanggalDitetapkan($tanggal)
{
   $bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
   $split = explode('-', $tanggal);
   return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
}

function thnSamaBlnSamaTglTidak($tanggal)
{
   $bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
   $split = explode('-', $tanggal);
   return $split[0];
}

function thnSamaBlnTidak($tanggal)
{
   $bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
   $split = explode('-', $tanggal);
   return $split[0] . ' ' . $bulan[(int)$split[1]];
}

$str1 = $dataku['awal_berlaku'];
$res1 = explode("-", $str1);
$thn1 = $res1[2];
$bln1 = $res1[1];
$tgl1 = $res1[0];

$str2 = $dataku['akhir_berlaku'];
$res2 = explode("-", $str2);
$thn2 = $res2[2];
$bln2 = $res2[1];
$tgl2 = $res2[0];

$sql1 =  "SELECT * FROM nama_lembaga";
$result1 = mysqli_query($con, $sql1);
$data1 = mysqli_fetch_array($result1);

$sql2 =  "SELECT * FROM nama_lembaga_induk";
$result2 = mysqli_query($con, $sql2);
$data2 = mysqli_fetch_array($result2);

function my_ucwords($str, $is_name = false)
{
   if ($is_name) {
      $all_uppercase = '';
      $all_lowercase = 'De La|De Las|Der|Van De|Van Der|Vit De|Von|Or|And';
   } else {
      $all_uppercase = 'Po|Rr|Se|Sw|Ne|Nw|Ii|Iii|Iv|Vi|Vii|Viii|Ix|Xi|Xii|Xiii|Ixx';
      $all_lowercase = 'A|Dan|Sebagai|Dengan|Pada|Dalam|Dari|Atau|Untuk|And|As|By|In|On|At|From|Or|To';
   }
   $prefixes = 'Mc';
   $suffixes = "'S";

   return preg_replace_callback(
      '/\b(\w)/',
      function ($matches) {
          return strtoupper($matches[1]);
      },
      strtolower(trim($str))
   );
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <title>SitaperOnline</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body style="font-family:Arial, Helvetica, sans-serif; font-size:15px;">
   <?php include("kopSurat.php"); ?>
   <div class="page">
      <div class="tengah" style="margin-top:26px;">
         <strong>
            <u>
               <font style="font-size:1.2em;">SURAT TUGAS</font>
            </u>
         </strong>
         <br />
         Nomor :<?php if ($dataku['no_agenda_surat'] == '') {
                      echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                   } else {
                      echo '&nbsp;' . $dataku['no_agenda_surat'];
                   } ?>/<?php echo $dkodesrt['kd_nmr_srt']; ?>/KP.01.1/<?php echo "$ambilbln"; ?>/<?php echo "$ambilthn"; ?>
      </div>
      <br />
      <br />
      <table width="100%">
         <tr valign="top" align="justify">
            <td width="3%">1.</td>
            <td width="36%">Instansi Pemerintah RI yang memberi tugas</td>
            <td width="2%">:</td>
            <td width="59%"><?php echo "$data1[nm]" . ' ' . "$data2[nm]" ?></td>
         </tr>
         <tr valign="top" align="justify">
            <td>2.</td>
            <td>Nama yang diberi tugas</td>
            <td>:</td>
            <td>
               Terlampir.
            </td>
         </tr>
         <tr valign="top" align="justify">
            <td>3.</td>
            <td>Jabatan</td>
            <td>:</td>
            <td>
               Terlampir.
            </td>
         </tr>
         <tr valign="top" align="justify">
            <td>4.</td>
            <td>Yang bersangkutan diberi tugas sebagai</td>
            <td>:</td>
            <td><?php echo $dataku['perihal'] = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dataku['perihal']); ?></td>
         </tr>
         <?php if (empty($dataku['dasar'])) {
            include "nonDasarStKepanitiaan.php";
         } else {
            include "dasarStKepanitiaan.php";
         } ?>
      </table>
      <br />
      <br />
      <div class="kanan_bawah">
         <span>Ditetapkan di</span><span style="text-indent: -30px; margin-left: 30px;">:</span><span style="text-indent: -8px; margin-left: 8px;">Malang</span>
         <br />
         <span>Pada Tanggal</span><span style="text-indent: -26px; margin-left: 26px;">:</span><span style="text-indent: -8px; margin-left: 8px;"><?php echo tanggalDitetapkan($dataku['tgl_ditetapkan']); ?></span>
         <br />
         <br />
         Dekan,
         <br />
         <br />
         <span>&nbsp;&nbsp;&nbsp;&nbsp;*</span>
         <br />
         <br />
         <?php echo $ddekanat['nama_tg'];?>
      </div>
      <br />
      <table width="100%">
         <tr>
            <td>Tembusan:<br />
               <?php
               $qtemb = "select * from tembusan_st";
               $restemb = mysqli_query($con, $qtemb) or die(mysqli_error($con));
               $dtemb = mysqli_fetch_assoc($restemb);
               echo nl2br($dtemb['isi']);
               ?>
            </td>
         </tr>
      </table>
   </div>
   <div class="page">
      <div class="kanan_atas_lampiran">
         <table width="100%" style="font-size:14px;">
            <tr valign="top" align="justify">
               <td colspan="3" style="padding-top:1px; padding-bottom:1px;">Lampiran Surat Tugas:</td>
            </tr>
            <tr valign="top" align="justify">
               <td style="padding-top:1px; padding-bottom:1px;">Nomor</td>
               <td style="padding-top:1px; padding-bottom:1px;">:</td>
               <td style="padding-top:1px; padding-bottom:1px;"><?php if ($dataku['no_agenda_surat'] == '') {
                                                                     echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                                                  } else {
                                                                     echo '&nbsp;' . $dataku['no_agenda_surat'];
                                                                  } ?>/<?php echo $dkodesrt['kd_nmr_srt']; ?>/KP.01.1/<?php echo "$ambilbln"; ?>/<?php echo "$ambilthn"; ?>
               </td>
            </tr>
            <tr valign="top" align="justify">
               <td style="padding-top:1px; padding-bottom:1px;">Tanggal</td>
               <td style="padding-top:1px; padding-bottom:1px;">:</td>
               <td style="padding-top:1px; padding-bottom:1px;"><?php echo tanggalDitetapkan($dataku['tgl_ditetapkan']); ?>
               </td>
            </tr>
         </table>
      </div>
      <br />
      <?php
      $mqry = "select * from st WHERE id='$id'";
      $res = mysqli_query($con, $mqry) or die(mysqli_error($con));
      $data = mysqli_fetch_assoc($res);
      ?>
      <div class="tengah" style="clear:right; text-transform:uppercase; margin-bottom:8px;">
         <strong>DAFTAR NAMA-NAMA YANG DIBERI TUGAS UNTUK <?php echo $data['perihal'] = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['perihal']); ?></strong>
      </div>
      <table class="table-lampiran" align="center">
         <thead>
            <tr>
               <th width="6%">No.</th>
               <th width="50%">Nama</th>
               <th width="44%">Jabatan dalam Kepanitiaan</th>
            </tr>
         </thead>
         <tbody>
            <?php
            $no = 0;
            $qambilpersonil = "select * from personil_st WHERE id_st='$dataku[id]' AND nama<>'' ORDER BY urutan_jabatan";
            $resambilpersonil = mysqli_query($con, $qambilpersonil) or die(mysqli_error($con));
            while ($dambilpersonil = mysqli_fetch_assoc($resambilpersonil)) {

               $safe_nama = mysqli_real_escape_string($con, $dambilpersonil['nama']);
               $qpersonil = "select * from dt_pegawai WHERE id='$safe_nama'";
               $respersonil = mysqli_query($con, $qpersonil) or die(mysqli_error($con));
               $dtpersonil = mysqli_fetch_assoc($respersonil);

               $qjabatanst = "select * from opsi_jabatan_st_kepanitiaan WHERE id='$dambilpersonil[jabatan_st]'";
               $resjabatanst = mysqli_query($con, $qjabatanst) or die(mysqli_error($con));
               $dtjabatanst = mysqli_fetch_assoc($resjabatanst);
               $no++;
            ?>
               <tr>
                  <td><?php echo $no; ?>.</td>
                  <td><?php if ($dambilpersonil['nama'] == $dtpersonil['id']) {
                           echo $dtpersonil['nama'];
                        } else {
                           echo $dambilpersonil['nama'];
                        } ?></td>
                  <td><?php if ($dambilpersonil['jabatan_st'] == $dtjabatanst['id']) {
                           echo $dtjabatanst['nama'];
                        } else {
                           echo $dambilpersonil['jabatan_st'];
                        } ?></td>
               </tr>
            <?php } ?>
         </tbody>
      </table>
      <br />
      <br />
      <div class="kanan_bawah">
         Dekan,
         <br />
         <br />
         <span>&nbsp;&nbsp;&nbsp;&nbsp;^</span>
         <br />
         <br />
         <?php echo $ddekanat['nama_tg'];?>
      </div>
   </div>
</body>

</html>
