<?php include( "contentsConAdm.php" );
   
if ($id == 'dummy') {
    // DATA DUMMY UNTUK PREVIEW LAYOUT PRAKTIKUM SISWA KELOMPOK
    $dt = [
        'id' => 'dummy',
        'no_agenda_surat' => '108',
        'tgl_dikeluarkan' => date('Y-m-d'),
        'tujuan_prak' => 'SMA Negeri 1 Malang',
        'sebutan_pimpinan' => '1',
        'waktu' => date('Y-m-d', strtotime('+7 days')),
        'jam' => '08.00',
        'tembusan' => "1. Dekan Fakultas Psikologi\n2. Arsip",
        'matkul' => '1',
        'jenjang_testee' => '1'
    ];
    $dataku = [
        'nama' => 'Maya Sari',
        'nim' => '2021010030'
    ];
    $nm_lembaga = 'Fakultas Psikologi';
    $nm_lembaga_induk = 'Universitas Contoh';
    $nm_kota = 'Malang';
    $dmk = ['nama' => 'Psikologi Pendidikan'];
    $djt = ['nama' => 'Siswa/Siswi'];
    $dtp = ['nm' => 'Aula Sekolah'];
    $dsp = ['nm' => 'Kepala Sekolah'];
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
    $myquery = "SELECT * FROM siprak_siswa WHERE id='$id'";
    $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
    $dt = mysqli_fetch_assoc( $res );
    
    $qry = "SELECT * FROM dt_mhssw WHERE nim='$dt[nim]'";
    $resp = mysqli_query($con,  $qry )or die( mysqli_error($con) );
    $dataku = mysqli_fetch_assoc( $resp );
    
    $qkota = "SELECT * FROM dt_kota WHERE id='$dt[kota_prak]'";
    $reskota = mysqli_query($con,  $qkota )or die( mysqli_error($con) );
    $dkota = mysqli_fetch_assoc( $reskota );
    $nm_kota = $dkota['nm_kota'] ?? 'Malang';
    
    $qnl = "SELECT * FROM nama_lembaga";
    $resnl = mysqli_query($con,  $qnl )or die( mysqli_error($con) );
    $dnl = mysqli_fetch_assoc( $resnl );
    $nm_lembaga = $dnl['nm'] ?? 'Fakultas Psikologi';
    
    $qnli = "SELECT * FROM nama_lembaga_induk";
    $resnli = mysqli_query($con,  $qnli )or die( mysqli_error($con) );
    $dnli = mysqli_fetch_assoc( $resnli );
    $nm_lembaga_induk = $dnli['nm'] ?? 'UIN Malang';
    
    $qsp = "SELECT * FROM opsi_sebutan_pimpinan WHERE id='$dt[sebutan_pimpinan]'";
    $ressp = mysqli_query($con,  $qsp )or die( mysqli_error($con) );
    $dsp = mysqli_fetch_assoc( $ressp ) ?: ['nm' => 'Bapak/Ibu Pimpinan'];
    
    if ($id != 'dummy') {
        $qbln = "SELECT MONTH(tgl_dikeluarkan) AS bulan FROM siprak_siswa WHERE id='$id'";
        $resbln = mysqli_query($con,  $qbln )or die( mysqli_error($con) );
        $dbln = mysqli_fetch_assoc( $resbln );
        $ambilbln = $dbln['bulan'] ?? date('n');
        
        $qthn = "SELECT YEAR(tgl_dikeluarkan) AS tahun FROM siprak_siswa WHERE id='$id'";
        $resthn = mysqli_query($con,  $qthn )or die( mysqli_error($con) );
        $dthn = mysqli_fetch_assoc( $resthn );
        $ambilthn = $dthn['tahun'] ?? date('Y');
    }
    
    $qmk = "SELECT * FROM matkul_praktikum WHERE id='$dt[matkul]'";
    $resmk = mysqli_query($con,  $qmk )or die( mysqli_error($con) );
    $dmk = mysqli_fetch_assoc( $resmk );
    
    $qjt = "SELECT * FROM jenjang_testee WHERE id='$dt[jenjang_testee]'";
    $resjt = mysqli_query($con,  $qjt )or die( mysqli_error($con) );
    $djt = mysqli_fetch_assoc( $resjt );
    
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
}
    
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
         .right-top {
         float: right;
         position:relative;
         width: 450px;
         margin-bottom:40px;
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
               <td width="62%"><?php if($dt['no_agenda_surat']=='') {echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';} else {echo '&nbsp;'.$dt['no_agenda_surat'];}?>/<?php echo $dkddekanat1['kd_nmr_srt'];?>/<?php echo $dkddekanat1['kd_nmr_srt'];?>/PP.009/<?php echo "$ambilbln";?>/<?php echo "$ambilthn";?></td>
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
               <td>Kepada Yth.</td>
               <td>&nbsp;</td>
            </tr>
            <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td><strong><?php echo $dsp['nm'].' '.$dt['tujuan_prak'];?></strong></td>
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
               <td colspan="2"><strong><i>Assalaamu 'alaykum warahmatullaahi wabarakaatuh.</i></strong></td>
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
                  Maka dengan ini kami mohon untuk mengizinkan nama-nama <?php echo $djt['nama'];?> sebagaimana terlampir sebagai testee dalam praktikum matakuliah <?php echo $dmk['nama'];?> pada:
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
            <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
               <td colspan="2"><strong><i>Wassalaamu 'alaykum warahmatullaahi wabarakaatuh.</i></strong></td>
            </tr>
         </table>
         <br />
         <br />
         <div class="right">
            a.n. Dekan <br />
            <?php echo $djidekanat1['nm'];?>,
            <div class="ttd">
               <img src="images/<?php echo $dkddekanat1['ttd'];?>" width="200" />
            </div>
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
         <div class="right-top">
            <table width="100%">
               <tr valign="top">
                  <td width="10%">Lampiran</td>
                  <td width="2%" align="center">:</td>
                  <td width="88%">
                     Surat Izin sebagai Testee <br />
                     <table width="100%" style="border-collapse:collapse; padding-left:0;">
                        <tr valign="top">
                           <td width="18%">Nomor</td>
                           <td width="2%" align="center">:</td>
                           <td width="80%"><?php if($dt['no_agenda_surat']=='') {echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';} else {echo '&nbsp;'.$dt['no_agenda_surat'];}?>/<?php echo $dkddekanat1['kd_nmr_srt'];?>/<?php echo $dkddekanat1['kd_nmr_srt'];?>/PP.009/<?php echo "$ambilbln";?>/<?php echo "$ambilthn";?></td>
                        </tr>
                        <tr valign="top">
                           <td>Tanggal</td>
                           <td align="center">:</td>
                           <td><?php echo bulanIndo($dt['tgl_dikeluarkan']);?></td>
                        </tr>
                     </table>
                  </td>
               </tr>
            </table>
         </div>
         <br>
         <table width="100%">
            <tr>
               <td style="text-align:center; text-transform:uppercase;"><strong>daftar nama <?php echo $djt['nama'];?></strong></td>
            </tr>
         </table>
         <br />
         <table width="70%" style="border-collapse:collapse; margin: 0px auto;">
            <thead style="border:1px solid #dddddd; text-align:left;">
               <tr style="border:1px solid #dddddd;">
                  <th width="7%" style="border:1px solid #dddddd; padding: 6px;">No.</th>
                  <th width="93%" style="border:1px solid #dddddd; padding: 6px;">Nama</th>
               </tr>
            </thead>
            <tbody style="border:1px solid #dddddd; padding: 6px;">
               <tr style="border:1px solid #dddddd; padding: 6px;">
                  <?php 
                     $no = 0;
                     $q = "SELECT * FROM testee_siprak WHERE id_siprak='$id' AND nama_testee<>'' ORDER BY nama_testee ASC";
                     $hsl = mysqli_query($con, $q)or die( mysqli_error($con));
                     while($mydata = mysqli_fetch_assoc($hsl)){
                     $no++;                              
                     ?>
                  <td style="border:1px solid #dddddd; padding: 6px;"><?php echo $no;?></td>
                  <td style="border:1px solid #dddddd; padding: 6px;"><?php echo $mydata['nama_testee'];?></td>
               </tr>
               <?php };?>
            </tbody>
         </table>
         <br />
         <br />
         <br />
         <div class="right">
            a.n. Dekan, <br />
            <?php echo $djidekanat1['nm'];?>,
            <div class="ttd">
               <img src="images/<?php echo $dkddekanat1['ttd'];?>" width="200" />
            </div>
            <?php echo $ddekanat1['nama_tg'];?>
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