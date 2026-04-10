<?php
   include("koneksiAdm.php");
   
   $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
   $myquery = "select * from mag_siowi WHERE id='$id'";
   $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
   $dt = mysqli_fetch_assoc( $res );
   
   $qry = "select * from mag_dt_mhssw_pasca WHERE nim='$dt[nim]'";
   $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qry )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
   $dataku = mysqli_fetch_assoc( $resp );
   
   $qdp = "select * from dt_pegawai WHERE id='$dt[dosen_pembimbing]'";
   $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qdp )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
   $ddp = mysqli_fetch_assoc( $resp );
   
   $qkota = "select * from dt_kota WHERE id='$dt[kota_penelitian]'";
   $reskota = mysqli_query($GLOBALS["___mysqli_ston"],  $qkota )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
   $dkota = mysqli_fetch_assoc( $reskota );
   $nm_kota = $dkota['nm_kota'];
   
   $qnl = "select * from nama_lembaga";
   $resnl = mysqli_query($GLOBALS["___mysqli_ston"],  $qnl )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
   $dnl = mysqli_fetch_assoc( $resnl );
   $nm_lembaga = $dnl['nm'];
   
   $qnli = "select * from nama_lembaga_induk";
   $resnli = mysqli_query($GLOBALS["___mysqli_ston"],  $qnli )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
   $dnli = mysqli_fetch_assoc( $resnli );
   $nm_lembaga_induk = $dnli['nm'];
   
   $qsp = "select * from opsi_sebutan_pimpinan WHERE id='$dt[sebutan_pimpinan]'";
   $ressp = mysqli_query($GLOBALS["___mysqli_ston"],  $qsp )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
   $dsp = mysqli_fetch_assoc( $ressp );
   
   $qmatkul = "select * from mag_dt_matkul_all WHERE id='$dt[matkul]'";
   $resmatkul = mysqli_query($GLOBALS["___mysqli_ston"],  $qmatkul )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
   $dmatkul = mysqli_fetch_assoc( $resmatkul );
   
   $qbln = "SELECT MONTH(tgl_dikeluarkan) AS bulan FROM mag_siowi WHERE id='$id'";
   $resbln = mysqli_query($GLOBALS["___mysqli_ston"],  $qbln )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
   $dbln = mysqli_fetch_assoc( $resbln );
   $ambilbln=$dbln['bulan'];
   
   $qthn = "SELECT YEAR(tgl_dikeluarkan) AS tahun FROM mag_siowi WHERE id='$id'";
   $resthn = mysqli_query($GLOBALS["___mysqli_ston"],  $qthn )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
   $dthn = mysqli_fetch_assoc( $resthn );
   $ambilthn=$dthn['tahun'];
   
   $qdekanat1="select * from dt_pegawai WHERE id='$dt[wd1]'";
   $resdekanat1=mysqli_query($GLOBALS["___mysqli_ston"], $qdekanat1) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
   $ddekanat1=mysqli_fetch_assoc($resdekanat1);
   
   $qjdekanat1="select * from opsi_jabatan WHERE id='$ddekanat1[jabatan]'";
   $resjdekanat1=mysqli_query($GLOBALS["___mysqli_ston"], $qjdekanat1) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
   $djdekanat1=mysqli_fetch_assoc($resjdekanat1);
   
   $qjidekanat1="select * from opsi_jabatan_instansi WHERE id='$ddekanat1[jabatan_instansi]'";
   $resjidekanat1=mysqli_query($GLOBALS["___mysqli_ston"], $qjidekanat1) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
   $djidekanat1=mysqli_fetch_assoc($resjidekanat1);
   
   $qkddekanat1="select * from dekanat WHERE id='2'";
   $reskddekanat1=mysqli_query($GLOBALS["___mysqli_ston"], $qkddekanat1) or die (mysqli_error($GLOBALS["___mysqli_ston"]));
   $dkddekanat1=mysqli_fetch_assoc($reskddekanat1);
   
   function bulanIndo($tanggal)
   {
   $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
   'September','Oktober','Nopember','Desember');
   $split = explode('-', $tanggal);
   return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
   }
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Surat Simagis</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <style>
         table,th,td {
         border: 0;
         }
         .right {
         float: right;
         position:relative;
         width: 260px;
         margin-bottom:20px;
         }
      </style>
   </head>
   <body style="font-family:Arial, Helvetica, sans-serif; font-size:16px;">
      <?php
         include( "kopPotret.php" );
         ?>
      <table width="100%">
         <tr>
            <td width="10%">No.</td>
            <td width="2%" align="center">:</td>
            <td width="62%">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/<?php echo $dkddekanat1['kd_nmr_srt'];?>/PP.009/<?php echo "$ambilbln";?>/<?php echo "$ambilthn";?></td>
            <td width="26%" align="right"><?php echo bulanIndo($dt['tgl_dikeluarkan']);?></td>
         </tr>
         <tr>
            <td>Perihal</td>
            <td align="center">:</td>
            <td><strong>IZIN OBSERVASI DAN WAWANCARA</strong></td>
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
            <td><strong><?php echo $dsp['nm'].' '.$dt['lembaga_tujuan_surat'];?></strong></td>
            <td>&nbsp;</td>
         </tr>
         <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>di</td>
            <td>&nbsp;</td>
         </tr>
         <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="padding-left:30px;"><?php echo $nm_kota;?></td>
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
            <td>&nbsp;</td>
            <td>&nbsp;</td>
         </tr>
         <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2" style="text-align:justify;">
               Dengan hormat, <br />
               Dalam rangka pengembangan keilmuan bagi mahasiswa Program Studi Magister Psikologi <?php echo "$nm_lembaga".' '."$nm_lembaga_induk";?>, maka dengan ini kami mohon kepada Bapak/Ibu untuk memberikan kesempatan kepada:
               <br />
               <br />
               <table width="100%" style="padding-left:30px;">
                  <tr>
                     <td width="32%">Nama / NIM</td>
                     <td width="2%" align="center">:</td>
                     <td width="68%"><?php echo $dataku['nama'].' / '.$dataku['nim'];?></td>
                  </tr>
                  <tr valign="top">
                     <td>Tugas Matakuliah</td>
                     <td align="center">:</td>
                     <td><?php echo $dmatkul['nm'];?></td>
                  </tr>
                  <tr>
                     <td>Dosen Pengampu</td>
                     <td align="center">:</td>
                     <td><?php echo $ddp['nama'];?></td>
                  </tr>
                  <tr valign="top">
                     <td>Tempat</td>
                     <td align="center">:</td>
                     <td><?php echo $dt['tempat_ow'];?></td>
                  </tr>
                  <tr valign="top">
                     <td>Keperluan</td>
                     <td align="center">:</td>
                     <td>Observasi dan wawancara  (<?php echo nl2br($dt['tujuan_surat']);?>)</td>
                  </tr>
               </table>
               <br />
               Demikian permohonan ini kami sampaikan, atas perhatian dan kerjasamanya kami sampaikan terimakasih.
            </td>
         </tr>
      </table>
      <br />
      <br />
      <br />
      <div class="right">
            a.n. Dekan, <br />
            <?php echo $djidekanat1['nm'];?>,
            <br />
            <br />
            <br />
            <br />
            <br />
            <?php echo $ddekanat1['nama_tg'];?>
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
      <script src="js/jquery.min.js"></script>
      <script type="text/javascript">
         $(document).ready(function() {
            window.print();
            window.close(); 
         });
      </script>
   </body>
</html>