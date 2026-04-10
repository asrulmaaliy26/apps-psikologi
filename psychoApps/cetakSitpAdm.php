<?php include( "contentsConAdm.php" );
   
   $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
   $myquery = "SELECT * FROM sitp WHERE id='$id'";
   $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
   $dt = mysqli_fetch_assoc( $res );
   
   $qkota = "SELECT * FROM dt_kota WHERE id='$dt[kota_lts]'";
   $reskota = mysqli_query($con,  $qkota )or die( mysqli_error($con) );
   $dkota = mysqli_fetch_assoc( $reskota );
   $nm_kota = $dkota['nm_kota'];
   
   $qnl = "SELECT * FROM nama_lembaga";
   $resnl = mysqli_query($con,  $qnl )or die( mysqli_error($con) );
   $dnl = mysqli_fetch_assoc( $resnl );
   $nm_lembaga = $dnl['nm'];
   
   $qnli = "SELECT * FROM nama_lembaga_induk";
   $resnli = mysqli_query($con,  $qnli )or die( mysqli_error($con) );
   $dnli = mysqli_fetch_assoc( $resnli );
   $nm_lembaga_induk = $dnli['nm'];
   
   $qpend = "SELECT * FROM pendaftaran_pkl WHERE status='1'";
   $rpend = mysqli_query($con, $qpend)or die( mysqli_error($con));
   $dpend = mysqli_fetch_assoc($rpend);

   $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$dpend[ta]'";
   $hasil = mysqli_query($con, $qry_nm_ta);
   $dnta = mysqli_fetch_assoc($hasil);
                        
   $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
   $h = mysqli_query($con, $qry_nm_smt);
   $dsemester = mysqli_fetch_assoc($h);

   $qsp = "SELECT * FROM opsi_sebutan_pimpinan WHERE id='$dt[sebutan_pimpinan]'";
   $ressp = mysqli_query($con,  $qsp )or die( mysqli_error($con) );
   $dsp = mysqli_fetch_assoc( $ressp );
   
   $qbln = "SELECT MONTH(tgl_dikeluarkan) AS bulan FROM sitp WHERE id='$id'";
   $resbln = mysqli_query($con,  $qbln )or die( mysqli_error($con) );
   $dbln = mysqli_fetch_assoc( $resbln );
   $ambilbln=$dbln['bulan'];
   
   $qthn = "SELECT YEAR(tgl_dikeluarkan) AS tahun FROM sitp WHERE id='$id'";
   $resthn = mysqli_query($con,  $qthn )or die( mysqli_error($con) );
   $dthn = mysqli_fetch_assoc( $resthn );
   $ambilthn=$dthn['tahun'];
   
   $qdekanat="SELECT * FROM dt_pegawai WHERE jabatan_instansi='1'";
   $resdekanat=mysqli_query($con, $qdekanat) or die (mysqli_error($con));
   $ddekanat=mysqli_fetch_assoc($resdekanat);
   
   $qjdekanat="SELECT * FROM opsi_jabatan WHERE id='$ddekanat[jabatan]'";
   $resjdekanat=mysqli_query($con, $qjdekanat) or die (mysqli_error($con));
   $djdekanat=mysqli_fetch_assoc($resjdekanat);
   
   $qjidekanat="SELECT * FROM opsi_jabatan_instansi WHERE id='$ddekanat[jabatan_instansi]'";
   $resjidekanat=mysqli_query($con, $qjidekanat) or die (mysqli_error($con));
   $djidekanat=mysqli_fetch_assoc($resjidekanat);
   
   $qkddekanat="SELECT * FROM dekanat WHERE id='1'";
   $reskddekanat=mysqli_query($con, $qkddekanat) or die (mysqli_error($con));
   $dkddekanat=mysqli_fetch_assoc($reskddekanat);
   
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
      <table width="100%">
         <tr>
            <td width="10%">Nomor</td>
            <td width="2%" align="center">:</td>
            <td width="62%"><?php if($dt['no_agenda_surat']=='') {echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';} else {echo '&nbsp;'.$dt['no_agenda_surat'];}?>/<?php echo $dkddekanat['kd_nmr_srt'];?>/PP.00.9/<?php echo "$ambilbln";?>/<?php echo "$ambilthn";?></td>
            <td width="26%" align="right"><?php echo bulanIndo($dt['tgl_dikeluarkan']);?></td>
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
            <td>Kepada Yth.</td>
            <td>&nbsp;</td>
         </tr>
         <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $dsp['nm'].' '.$dt['lembaga_tujuan_surat'];?></td>
            <td>&nbsp;</td>
         </tr>
         <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><?php echo $dt['alamat_lengkap_lts'];?></td>
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
               Sehubungan dengan kegiatan Praktik Kerja Lapangan (PKL) <?php if($dt['jenis_pkl']==1) {echo "";} else if($dt['jenis_pkl']==2) {echo "MBKM";}?> <?php echo "$nm_lembaga".' '."$nm_lembaga_induk";?> Semester <?php echo "$dsemester[nama]".' Tahun Akademik '."$dnta[ta]";?>, maka dengan ini kami mohon kepada Bapak/Ibu memberikan izin kepada mahasiswa <?php echo "$nm_lembaga".' '."$nm_lembaga_induk";?> untuk melakukan kegiatan Praktik Kerja Lapangan (PKL) <?php if($dt['jenis_pkl']==1) {echo "";} else if($dt['jenis_pkl']==2) {echo "MBKM";}?> di tempat yang Bapak/Ibu pimpin selama <?php if($dt['jenis_pkl']==1) {echo "45 hari";} else if($dt['jenis_pkl']==2) {echo "3 bulan";}?>.
               <br />
               <br />
               Adapun nama-nama mahasiswa tersebut adalah sebagai berikut:
               <br />
               <table width="100%">
                  <thead>
                     <tr>
                        <th width="70%">Nama</th>
                        <th width="30%">NIM</th>
                     </tr>
                  </thead>
                  <tbody>
                  <?php
                     $qry = "SELECT * FROM draf_anggota_pkl WHERE id_sitp='$dt[id]' AND nim_anggota<>'' ORDER BY urutan ASC";
                     $resp = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                     while($dataku = mysqli_fetch_assoc( $resp )) {
                              
                     $qmhssw = "SELECT * FROM dt_mhssw WHERE nim='$dataku[nim_anggota]'";
                     $resmhssw = mysqli_query($con,  $qmhssw )or die( mysqli_error($con) );
                     $dtmhssw = mysqli_fetch_assoc( $resmhssw );
                     ?>
                  <tr>
                     <td style="padding:0;">
                              <?php echo strtoupper($dtmhssw['nama']);?>
                           </td>
                           <td style="padding:0;">
                              <?php echo $dtmhssw['nim'];?>
                           </td>
                        </tr>
                        <?php } ?>
                        </tbody>
                     </td>
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
         <?php echo $djidekanat['nm'];?>,
         <br />
         <br />
         <br />
         <span>&nbsp;&nbsp;&nbsp;&nbsp;*</span>
         <br />
         <br />
         <?php echo $ddekanat['nama_tg'];?>
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