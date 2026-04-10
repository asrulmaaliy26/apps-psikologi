<?php include( "contentsConAdm.php" );
   
   $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
   $myquery = "SELECT * FROM skkb WHERE id='$id'";
   $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
   $dt = mysqli_fetch_assoc( $res );
   
   $qry = "SELECT * FROM dt_mhssw WHERE nim='$dt[nim]'";
   $resp = mysqli_query($con,  $qry )or die( mysqli_error($con) );
   $dataku = mysqli_fetch_assoc( $resp );
   
   $qtl = "SELECT * FROM dt_kota WHERE id='$dataku[tempat_lahir]'";
   $restl = mysqli_query($con,  $qtl )or die( mysqli_error($con) );
   $dtl = mysqli_fetch_assoc( $restl );
   
   $qnl = "SELECT * FROM nama_lembaga";
   $resnl = mysqli_query($con,  $qnl )or die( mysqli_error($con) );
   $dnl = mysqli_fetch_assoc( $resnl );
   $nm_lembaga = $dnl['nm'];
   
   $qnli = "SELECT * FROM nama_lembaga_induk";
   $resnli = mysqli_query($con,  $qnli )or die( mysqli_error($con) );
   $dnli = mysqli_fetch_assoc( $resnli );
   $nm_lembaga_induk = $dnli['nm'];
   
   $qbln = "SELECT MONTH(tgl_dikeluarkan) AS bulan FROM skkb WHERE id='$id'";
   $resbln = mysqli_query($con,  $qbln )or die( mysqli_error($con) );
   $dbln = mysqli_fetch_assoc( $resbln );
   $ambilbln=$dbln['bulan'];
   
   $qthn = "SELECT YEAR(tgl_dikeluarkan) AS tahun FROM skkb WHERE id='$id'";
   $resthn = mysqli_query($con,  $qthn )or die( mysqli_error($con) );
   $dthn = mysqli_fetch_assoc( $resthn );
   $ambilthn=$dthn['tahun'];
   
   $qdekanat3="SELECT * FROM dt_pegawai WHERE jabatan_instansi='4'";
   $resdekanat3=mysqli_query($con, $qdekanat3) or die (mysqli_error($con));
   $ddekanat3=mysqli_fetch_assoc($resdekanat3);
   
   $qjdekanat3="SELECT * FROM opsi_jabatan WHERE id='$ddekanat3[jabatan]'";
   $resjdekanat3=mysqli_query($con, $qjdekanat3) or die (mysqli_error($con));
   $djdekanat3=mysqli_fetch_assoc($resjdekanat3);
   
   $qjidekanat3="SELECT * FROM opsi_jabatan_instansi WHERE id='$ddekanat3[jabatan_instansi]'";
   $resjidekanat3=mysqli_query($con, $qjidekanat3) or die (mysqli_error($con));
   $djidekanat3=mysqli_fetch_assoc($resjidekanat3);
   
   $qkddekanat3="SELECT * FROM dekanat WHERE id='4'";
   $reskddekanat3=mysqli_query($con, $qkddekanat3) or die (mysqli_error($con));
   $dkddekanat3=mysqli_fetch_assoc($reskddekanat3);
   
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
      <title>Surat Mahasiswa</title>
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
      <br />
      <p style="text-align:center;"><strong><font style="font-size:18px; text-decoration:underline;">SURAT KETERANGAN KELAKUAN BAIK</font></strong><br />
         <font style="font-size:16px;">Nomor:<?php if($dt['no_agenda_surat']=='') {echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';} else {echo '&nbsp;'.$dt['no_agenda_surat'];}?>/<?php echo $dkddekanat3['kd_nmr_srt'];?>/PP.009/<?php echo "$ambilbln";?>/<?php echo "$ambilthn";?></font>
      </p>
      <p>Yang bertandatangan di bawah ini:</p>
      <table width="100%" style="margin-left:0px; text-align:justify;">
         <tr valign="top">
            <td width="24%">Nama
            <td>
            <td width="2%" align="center">:</td>
            <td width="74%"><?php echo $ddekanat3['nama'];?></td>
         </tr>
         <tr valign="top">
            <td>NIP
            <td>
            <td align="center">:</td>
            <td><?php echo $ddekanat3['id'];?></td>
         </tr>
         <tr valign="top">
            <td>Jabatan
            <td>
            <td align="center">:</td>
            <td><?php echo $djidekanat3['nm'];?></td>
         </tr>
      </table>
      <p>Dengan ini menerangkan bahwa:</p>
      <table width="100%" style="margin-left:0px;">
         <tr valign="top">
            <td width="24%">Nama
            <td>
            <td width="2%" align="center">:</td>
            <td width="74%"><?php echo $dataku['nama'];?></td>
         </tr>
         <tr valign="top">
            <td>NIM
            <td>

            <td align="center">:</td>
            <td><?php echo $dataku['nim'];?></td>
         </tr>
         <tr valign="top">
            <td>Tempat/tanggal lahir
            <td>
            <td align="center">:</td>
            <td><?php echo $dtl['nm_kota'].'/'.date('d-m-Y',strtotime($dataku['tanggal_lahir']));?></td>
         </tr>
         <tr valign="top">
            <td>Alamat
            <td>
            <td align="center">:</td>
            <td><?php echo $dataku['alamat_ktp'];?></td>
         </tr>
      </table>
      <p style="text-align:justify;">Yang bersangkutan selama mengikuti perkuliahan di <?php echo "$nm_lembaga".' '."$nm_lembaga_induk";?> berkelakuan baik dan tidak terkena sanksi tertulis atas pelanggaran berat sesuai dengan tata tertib di <?php echo "$nm_lembaga_induk";?>.</p>
      <p style="text-align:justify;">Surat keterangan ini berlaku mulai tanggal <?php echo $dt['tgl_awal_berlaku'].' sampai dengan '.$dt['tgl_akhir_berlaku'];?>.</p>
      <p style="text-align:justify;">Demikian surat keterangan ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya.</p>
      <br />
      <br />
      <div class="right">
         Malang, <?php echo bulanIndo($dt['tgl_dikeluarkan']);?> <br />
         a.n. Dekan <br />
         <?php echo $djidekanat3['nm'];?>,
         <br />
         <br />
         <br />
         <span>&nbsp;&nbsp;&nbsp;&nbsp;*</span>
         <br />
         <br />
         <?php echo $ddekanat3['nama_tg'];?>
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
      <?php include( "jsAdm.php" );?>
      <script type="text/javascript">
         $(document).ready(function() {
            window.print();
            window.close(); 
         });
      </script>
   </body>
</html>