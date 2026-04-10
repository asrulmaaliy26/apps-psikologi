<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
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
  
  $qidper = "SELECT * FROM pengajuan_dospem WHERE id='$id'";
  $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
  $didper = mysqli_fetch_assoc($ridper);
  
  $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
  $hasil = mysqli_query($con, $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
                            
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
    <title>Data Pengajuan Dosen Pembimbing Skripsi <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      table {
      border-collapse: collapse;
      }
      table, th, td {
      border: 1px solid #264653;
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
  </head>
  <body style="font-family:Arial, Helvetica, sans-serif; font-size:16px;">
    <?php
      include( "kopPotret.php" );
      ?>
    <br>
    <span style="text-transform:uppercase;"><b>Data Pengajuan Dosen Pembimbing Skripsi <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></b></span>
    <br>
    <br>
    <table width="100%" style="font-size:10px;">
      <thead>
        <tr style="text-align:center;">
          <th width="3%">No.</th>
          <th width="12%">Nama</th>
          <th width="4%">IPK</th>
          <th width="6%">SKS Ditempuh</th>
          <th width="17%">Judul</th>
          <th width="6%">Jenis Skripsi</th>
          <th width="6%">Bidang Skripsi</th>
          <th width="6%">Metode Riset</th>
          <th width="8%">Variabel</th>
          <th width="13%">Dospem I</th>
          <th width="13%">Dospem II</th>
          <th width="8%">Tgl. Pengajuan</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $sql = "SELECT * FROM pengelompokan_dospem_skripsi WHERE id_periode='$id' ORDER BY NIM ASC";
          $result = mysqli_query($con, $sql);
          while($data = mysqli_fetch_array($result)) {
          
          $qry_mhssw = "SELECT * FROM dt_mhssw WHERE nim=$data[nim]";
          $rmhssw = mysqli_query($con, $qry_mhssw);
          $dmhssw = mysqli_fetch_assoc($rmhssw);
          
          $qdt_jenis = "SELECT * FROM opsi_jenis_skripsi WHERE id='$data[jenis_skripsi]'";
          $hdt_jenis = mysqli_query($con, $qdt_jenis);
          $djenis = mysqli_fetch_assoc($hdt_jenis);
          
          $qdt_bidang = "SELECT * FROM opsi_bidang_skripsi WHERE id='$data[bidang_skripsi]'";
          $hdt_bidang = mysqli_query($con, $qdt_bidang);
          $dbidang = mysqli_fetch_assoc($hdt_bidang);
          
          $qdt_metode = "SELECT * FROM opsi_jenis_penelitian WHERE id='$data[metode_riset]'";
          $hdt_metode = mysqli_query($con, $qdt_metode);
          $dmetode = mysqli_fetch_assoc($hdt_metode);

          $q_dospem1 = "SELECT * FROM dt_pegawai WHERE id=$data[dospem_skripsi1]";
          $rdospem1 = mysqli_query($con, $q_dospem1);
          $ddospem1 = mysqli_fetch_assoc($rdospem1);
          
          $q_dospem2 = "SELECT * FROM dt_pegawai WHERE id=$data[dospem_skripsi2]";
          $rdospem2 = mysqli_query($con, $q_dospem2);
          $ddospem2 = mysqli_fetch_assoc($rdospem2);                         
          $no++;
          ?> 
        <tr>
          <td style="text-align:center;"> <?php echo $no;?> </td>
          <td style="text-align:left;"> <?php echo $dmhssw['nama'].' / '.$dmhssw['nim'];?> </td>
          <td style="text-align:left;"> <?php echo $data['ipk'];?> </td>
          <td style="text-align:left;"> <?php echo $data['sks_ditempuh'];?> </td>
          <td style="text-align:left;"> <?php echo $data['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['judul_skripsi']);?> </td>
          <td style="text-align:left;"> <?php echo $djenis['nm'];?> </td>
          <td style="text-align:left;"> <?php echo $dbidang['nm'];?> </td>
          <td style="text-align:left;"> <?php echo $dmetode['opsi'];?> </td>
          <td style="text-align:left;"> <?php echo $data['var_1'].', '.$data['var_2'].', '.$data['var_3'].', '.$data['var_4'];?> </td>  
          <td style="text-align:left;"> <?php echo $ddospem1['nama'];?> </td>
          <td style="text-align:left;"> <?php echo $ddospem2['nama'];?> </td>
          <td style="text-align:left;"> <?php echo $data['tgl_pengajuan'];?> </td>
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
         window.print();
         window.close(); 
      });
    </script>
  </body>
</html>