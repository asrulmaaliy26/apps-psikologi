<?php include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $myquery = "SELECT * FROM siow_kelompok WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $res );
  
  $qdp = "SELECT * FROM dt_pegawai WHERE id='$dt[dosen_pembimbing]'";
  $resp = mysqli_query($con,  $qdp )or die( mysqli_error($con) );
  $ddp = mysqli_fetch_assoc( $resp );
  
  $qkota = "SELECT * FROM dt_kota WHERE id='$dt[kota_penelitian]'";
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
  
  $qsp = "SELECT * FROM opsi_sebutan_pimpinan WHERE id='$dt[sebutan_pimpinan]'";
  $ressp = mysqli_query($con,  $qsp )or die( mysqli_error($con) );
  $dsp = mysqli_fetch_assoc( $ressp );
  
  $qmatkul = "SELECT * FROM dt_matkul WHERE id='$dt[matkul]'";
  $resmatkul = mysqli_query($con,  $qmatkul )or die( mysqli_error($con) );
  $dmatkul = mysqli_fetch_assoc( $resmatkul );
  
  $qmodelpelaksanaan = "SELECT * FROM opsi_model_ow_penel WHERE id='$dt[model_pelaksanaan]'";
  $resmodelpelaksanaan = mysqli_query($con,  $qmodelpelaksanaan )or die( mysqli_error($con) );
  $dmodelpelaksanaan = mysqli_fetch_assoc( $resmodelpelaksanaan );
  
  $qbln = "SELECT MONTH(tgl_dikeluarkan) AS bulan FROM siow_kelompok WHERE id='$id'";
  $resbln = mysqli_query($con,  $qbln )or die( mysqli_error($con) );
  $dbln = mysqli_fetch_assoc( $resbln );
  $ambilbln=$dbln['bulan'];
  
  $qthn = "SELECT YEAR(tgl_dikeluarkan) AS tahun FROM siow_kelompok WHERE id='$id'";
  $resthn = mysqli_query($con,  $qthn )or die( mysqli_error($con) );
  $dthn = mysqli_fetch_assoc( $resthn );
  $ambilthn=$dthn['tahun'];
  
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
      width: 300px;
      margin-bottom:20px;
      }
      .ttd {
      margin-top:30px;
      margin-bottom:-40px;
      float: right;
      position:relative;
      left: 240px;
      }
      @media print {
      body {margin-top: 10mm; margin-bottom: 20mm;
      margin-left: 30mm; margin-right: 20mm}
      }
    </style>
  </head>
  <body style="font-family:Arial, Helvetica, sans-serif; font-size:1.1em;">
    <?php
      include( "kopPotretUser.php" );
      ?>
    <table width="100%" style="padding-left:0px;">
      <tr>
        <td width="10%">Nomor</td>
        <td width="2%" align="center">:</td>
        <td width="62%"><?php if($dt['no_agenda_surat']=='') {echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';} else {echo $dt['no_agenda_surat'];}?>/<?php echo $dkddekanat1['kd_nmr_srt'];?>/PP.009/<?php echo "$ambilbln";?>/<?php echo "$ambilthn";?></td>
        <td width="26%" align="right"><?php echo bulanIndo($dt['tgl_dikeluarkan']);?></td>
      </tr>
      <tr>
        <td>Hal</td>
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
          Dalam rangka pengembangan keilmuan bagi mahasiswa <?php echo "$nm_lembaga".' '."$nm_lembaga_induk";?>, maka dengan ini kami mohon kepada Bapak/Ibu untuk memberikan kesempatan kepada:
          <br />
          <br />
          <table width="100%" style="padding-left:0px;">
            <tr valign="top">
              <td width="28%">Nama / NIM</td>
              <td width="2%" align="center">:</td>
              <td width="70%" style="padding:0;">
                <table width="100%" style="border-collapse:collapse; padding-left:0;">
                  <?php           
                    $qry = "SELECT * FROM anggota_siowk WHERE id_siowk='$dt[id]' AND nim_anggota<>'' ORDER BY urutan ASC";
                    $resp = mysqli_query($con,  $qry )or die( mysqli_error($con) );
                    while($dataku = mysqli_fetch_assoc( $resp )) {
                    
                    $qmhssw = "SELECT * FROM dt_mhssw WHERE nim='$dataku[nim_anggota]'";
                    $resmhssw = mysqli_query($con,  $qmhssw )or die( mysqli_error($con) );
                    $dtmhssw = mysqli_fetch_assoc( $resmhssw );
                    ?>
                  <tr>
                    <td><?php echo strtoupper($dtmhssw['nama']).'/'.$dtmhssw['nim'];?></td>
                    <?php } ?>     
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td>Keperluan</td>
              <td align="center">:</td>
              <td>Observasi dan Wawancara</td>
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
              <td>Tanggal Kegiatan</td>
              <td align="center">:</td>
              <td><?php echo $dt['tgl_awal_pelaksanaan'].' s.d '.$dt['tgl_akhir_pelaksanaan'];?></td>
            </tr>
            <tr valign="top">
              <td>Model Kegiatan</td>
              <td align="center">:</td>
              <td><?php echo $dmodelpelaksanaan['nm'];?></td>
            </tr>
          </table>
          <br />
          Demikian permohonan ini, atas perhatian dan kerjasamanya kami sampaikan terima kasih.
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
      a.n. Dekan, 
      <br />
      <?php echo $djidekanat1['nm'];?>,
      <br />
    </div>
    <div class="ttd">
      <img width="80%" src="images/ttd_wd1.png">
    </div>
    <div class="right">
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
    <?php include( "jsAdm.php" );?>
    <script type="text/javascript">
      $(document).ready(function() {
         window.print();
         window.close(); 
      });
    </script>
  </body>
</html>