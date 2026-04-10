<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $msql = "SELECT * FROM dt_pengawas_kompre WHERE id='$id'";
  $res = mysqli_query($con, $msql);
  $dataku = mysqli_fetch_array($res);

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
  
  $qidper = "SELECT * FROM pendaftaran_kompre WHERE id='$id'";
  $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
  $didper = mysqli_fetch_assoc($ridper);
  
  $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
  $hasil = mysqli_query($con, $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
                            
  $qry_jenis_periode = "SELECT * FROM opsi_kategori_periode_kompre WHERE id='$didper[jenis_periode]'";
  $hasil = mysqli_query($con, $qry_jenis_periode);
  $djp = mysqli_fetch_assoc($hasil);
  
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$didper[ta]'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
                            
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  
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
    <title>Rekap Pengawas Ujian Komprehensif <?php echo $dataku['nm'];?></title>
    <meta charset="utf-8">
    <style>
      table {
      border-collapse: collapse;
      }
      table, th, td {
      border: 1px solid black;
      }
      th, td {
      padding: 10px;
      }
      .right {
      float: right;
      position:relative;
      width: 260px;
      margin-bottom:20px;
      }
    </style>
  <body>
    <?php
      header("Content-type: application/vnd-ms-excel");
      header('Content-Disposition: attachment; filename=Rekap Pengawas Ujian Komprehensif '.$dataku['nm'].'.xls');
      ?>
    <table style="border:none;">
      <thead>
        <tr style="border:none;">
          <th style="border:none;" colspan="4">Rekap Pengawas Ujian Komprehensif <?php echo $dataku['nm'];?></th>
        </tr>
        <tr style="border:none;">
          <th style="border:none;" colspan="4"></th>
        </tr>
      </thead>
    </table>
    <table>
      <thead>
        <tr style="text-align:center;">
          <td width="4%">No.</td>
          <td width="30%">Periode Pendaftaran</td>
          <td width="50%">Jadwal Ujian</td>
          <td width="16%">Sebagai</td>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $qry_jdwl = "SELECT * FROM jadwal_kompre WHERE pengawas1='$id' OR pengawas2='$id'";
          $rjdwl = mysqli_query($con, $qry_jdwl);
          while($djdwl = mysqli_fetch_assoc($rjdwl)) {

          $sesuaikanTgl = date("d-m-Y", strtotime($djdwl['tgl_kompre']));
          $formatTgl=date("d-m-Y", strtotime($djdwl['tgl_kompre']));
          $day = date('D', strtotime($formatTgl));
          $dayList = array(
          'Sun' => 'Minggu',
          'Mon' => 'Senin',
          'Tue' => 'Selasa',
          'Wed' => 'Rabu',
          'Thu' => 'Kamis',
          'Fri' => "Jum'at",
          'Sat' => 'Sabtu'
          );

          $qidper = "SELECT * FROM pendaftaran_kompre WHERE id='$djdwl[id_kompre]'";
          $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
          $didper = mysqli_fetch_assoc($ridper);
                            
          $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
          $hasil = mysqli_query($con, $qry_thp);
          $dthp = mysqli_fetch_assoc($hasil);
                            
          $qry_jenis_periode = "SELECT * FROM opsi_kategori_periode_kompre WHERE id='$didper[jenis_periode]'";
          $hasil = mysqli_query($con, $qry_jenis_periode);
          $djp = mysqli_fetch_assoc($hasil);
                            
          $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$didper[ta]'";
          $hasil = mysqli_query($con, $qry_nm_ta);
          $dnta = mysqli_fetch_assoc($hasil);
                            
          $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
          $h = mysqli_query($con, $qry_nm_smt);
          $dsemester = mysqli_fetch_assoc($h);
                            
          $qry_ruang = "SELECT * FROM dt_ruang WHERE id='$djdwl[ruang]'";
          $rruang = mysqli_query($con, $qry_ruang);
          $druang = mysqli_fetch_assoc($rruang);
          $no++;
          ?>  
        <tr>
          <td style="text-align:center;"> <?php echo $no;?> </td>
          <td style="text-align:left;"> <?php echo 'Tahap '.$dthp['tahap'].' <span class="small text-secondary">'.$djp['nm'].'</span> '.$dsemester['nama'].' '.$dnta['ta'].'';?> </td>
          <td style="text-align:left;"> <?php echo $dayList[$day].', '.$sesuaikanTgl.', Pukul: '.$djdwl['jam_mulai'].' s.d '.$djdwl['jam_selesai'].', Tempat: '.$druang['nm'];?> </td>
          <td style="text-align:left;"> <?php if($djdwl['pengawas1']==$id) { echo "Pengawas I";} elseif($djdwl['pengawas2']==$id) { echo "Pengawas II";}?> </td>
        </tr>
        <?php
          }
          ?>
      </tbody>
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
    <?php include( "jsAdm.php" );?>
    <script type="text/javascript">
      $(document).ready(function() {
         window.close(); 
      });
    </script>
  </body>
</html>