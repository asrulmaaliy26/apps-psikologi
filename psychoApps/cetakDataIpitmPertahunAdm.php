<?php include( "contentsConAdm.php" );
   
   $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
   $myquery = "SELECT * FROM siprak_mahasiswa WHERE id='$id'";
   $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
   $dt = mysqli_fetch_assoc( $res );
   
   $qry = "SELECT * FROM dt_mhssw WHERE nim='$dt[nim]'";
   $resp = mysqli_query($con,  $qry )or die( mysqli_error($con) );
   $dataku = mysqli_fetch_assoc( $resp );
   
   $qnl = "SELECT * FROM nama_lembaga";
   $resnl = mysqli_query($con,  $qnl )or die( mysqli_error($con) );
   $dnl = mysqli_fetch_assoc( $resnl );
   $nm_lembaga = $dnl['nm'];
   
   $qnli = "SELECT * FROM nama_lembaga_induk";
   $resnli = mysqli_query($con,  $qnli )or die( mysqli_error($con) );
   $dnli = mysqli_fetch_assoc( $resnli );
   $nm_lembaga_induk = $dnli['nm'];
   
   $qbln = "SELECT MONTH(tgl_dikeluarkan) AS bulan FROM siprak_mahasiswa WHERE id='$id'";
   $resbln = mysqli_query($con,  $qbln )or die( mysqli_error($con) );
   $dbln = mysqli_fetch_assoc( $resbln );
   $ambilbln=$dbln['bulan'];
   
   $qthn = "SELECT YEAR(tgl_dikeluarkan) AS tahun FROM siprak_mahasiswa WHERE id='$id'";
   $resthn = mysqli_query($con,  $qthn )or die( mysqli_error($con) );
   $dthn = mysqli_fetch_assoc( $resthn );
   $ambilthn=$dthn['tahun'];
   
   $qmk = "SELECT * FROM matkul_praktikum WHERE id='$dt[matkul]'";
   $resmk = mysqli_query($con,  $qmk )or die( mysqli_error($con) );
   $dmk = mysqli_fetch_assoc( $resmk );
   
   $qtp = "SELECT * FROM opsi_tempat_praktikum";
   $restp = mysqli_query($con,  $qtp )or die( mysqli_error($con) );
   $dtp = mysqli_fetch_assoc( $restp );
   
   $qdekanat1="SELECT * FROM dt_pegawai WHERE jabatan_instansi='2'";
   $resdekanat1=mysqli_query($con, $qdekanat1) or die (mysqli_error($con));
   $ddekanat1=mysqli_fetch_assoc($resdekanat1);
   
   $qjdekanat1="SELECT * FROM opsi_jabatan WHERE id='$ddekanat1[jabatan]'";
   $resjdekanat1=mysqli_query($con, $qjdekanat1) or die (mysqli_error($con));
   $djdekanat1=mysqli_fetch_assoc($resjdekanat1);
   
   $qjidekanat1="SELECT * FROM opsi_jabatan_instansi WHERE id='$ddekanat1[jabatan_instansi]'";
   $resjidekanat1=mysqli_query($con, $qjidekanat1) or die (mysqli_error($con));
   $djidekanat1=mysqli_fetch_assoc($resjidekanat1);
   
   $qkddekanat1="SELECT * FROM dekanat WHERE id='2'";
   $reskddekanat1=mysqli_query($con, $qkddekanat1) or die (mysqli_error($con));
   $dkddekanat1=mysqli_fetch_assoc($reskddekanat1);
   
   function bulanIndo($tanggal)
   {
   $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
   'September','Oktober','Nopember','Desember');
   $split = explode('-', $tanggal);
   return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
   }
   
   function bulanIndo1($tanggal)
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
      <style type="text/css" media="print">
         div.page
         {
         page-break-after: always;
         page-break-inside: avoid;
         }
      </style>
   </head>
   <body style="font-family:Arial, Helvetica, sans-serif; font-size:16px;">
      <div class="page">
         <?php
            include( "kopPotret.php" );
            ?>
         <table width="100%">
            <tr>
               <td width="10%">No.</td>
               <td width="2%" align="center">:</td>
               <td width="62%"><?php if($dt['no_agenda_surat']=='') {echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';} else {echo '&nbsp;'.$dt['no_agenda_surat'];}?>/<?php echo $dkddekanat1['kd_nmr_srt'];?>/PP.009/<?php echo "$ambilbln";?>/<?php echo "$ambilthn";?></td>
               <td width="26%" align="right"><?php echo bulanIndo($dt['tgl_dikeluarkan']);?></td>
            </tr>
            <tr>
               <td>Perihal</td>
               <td align="center">:</td>
               <td><strong>IZIN SEBAGAI TESTEE</strong></td>
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
               <td><strong><?php echo $dt['dosen_testee'].'<br />'.'Dosen Matakuliah '.$dt['matkul_testee'];?></strong></td>
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
               <td style="padding-left:30px;">Tempat</td>
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
                  Sehubungan dengan Praktikum Psikologi mahasiswa <?php echo "$nm_lembaga".' '."$nm_lembaga_induk";?> berikut ini:
                  <br />
                  <br />           
                  <strong>
                     <table width="100%" style="padding-left:30px;">
                        <tr>
                           <td width="26%">Nama / NIM</td>
                           <td width="2%" align="center">:</td>
                           <td width="72%"><?php echo $dataku['nama'].' / '.$dataku['nim'];?></td>
                        </tr>
                     </table>
                  </strong>
                  <br />           
                  Maka dengan ini kami mohon untuk mengizinkan mahasiswa dengan nama <strong><?php echo $dt['nama_testee'].' ('.$dt['nim_testee'].')';?></strong> sebagai testee dalam praktikum matakuliah <?php echo $dmk['nama'];?> pada:
                  <br />
                  <br />           
                  <table width="100%" style="padding-left:30px;">
                     <tr valign="top">
                        <td width="26%">Tanggal</td>
                        <td width="2%" align="center">:</td>
                        <td width="72%"><?php echo bulanIndo1($dt['waktu']);?></td>
                     </tr>
                     <tr valign="top">
                        <td>Waktu</td>
                        <td align="center">:</td>
                        <td><?php echo $dt['jam'];?> - selesai</td>
                     </tr>
                     <tr valign="top">
                        <td>Tempat</td>
                        <td align="center">:</td>
                        <td><?php echo $dtp['nm'].' '."$nm_lembaga".' '."$nm_lembaga_induk";?></td>
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
      </div>
      <div class="page">
         <?php
            include( "kopPotret.php" );
            ?>
         <br>
         <font style="text-align:justify;">Dengan ini saya menyatakan sebagai Dosen Pengampu matakuliah dari mahasiswa (testee) yang bersangkutan untuk memberikan izin mengikuti tes yang diajukan oleh mahasiswa (tester) Fakultas Psikologi UIN Maulana Malik Ibrahim Malang.</font>
         <br>
         <br>
         <div class="right">
            Malang,_____________________,
            <br />
            <br />
            <br />
            <span>*</span>
            <br />
            (____________________________)
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