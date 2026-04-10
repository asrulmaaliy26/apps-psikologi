<?php
  include("contentsConAdm.php");
  
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
    </style>
  <body>
    <?php
      header("Content-type: application/vnd-ms-excel");
      header('Content-Disposition: attachment; filename=Data Pengajuan Dosen Pembimbing Skripsi Tahap '.$dthp['tahap'].'_'.$dsemester['nama'].'_'.$dnta['ta'].'.xls');
      ?> 
    <table style="border:none;">
      <thead>
        <tr style="border:none;">
          <th style="border:none;" colspan="8">Data Pengajuan Dosen Pembimbing Skripsi <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></th>
        </tr>
        <tr style="border:none;">
          <th style="border:none;" colspan="8"></th>
        </tr>
      </thead>
    </table>
    <table>
      <thead>
          <th width="4%">No.</th>
          <th width="16%">Nama</th>
          <th width="22%">Judul</th>
          <th width="14%">Dospem I</th>
          <th width="14%">Dospem II</th>
          <th width="10%">Tgl. Pengajuan</th>
          <th width="10%">Tgl. Mulai</th>
          <th width="10%">Tgl. Selesai</th>
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
          <td style="text-align:left;"> <?php echo $data['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['judul_skripsi']);?> </td>
          <td style="text-align:left;"> <?php echo $ddospem1['nama'];?> </td>
          <td style="text-align:left;"> <?php echo $ddospem2['nama'];?> </td>
          <td style="text-align:left;"> <?php echo $data['tgl_pengajuan'];?> </td>
          <td style="text-align:left;"> <?php echo $data['tgl_mulai'];?> </td>
          <td style="text-align:left;"> <?php echo $data['tgl_akhir'];?> </td>
        </tr>
        <?php
          }
          ?>
      </tbody>
    </table>
    <script type="text/javascript">
      $(document).ready(function() {
         window.close(); 
      });
    </script>
  </body>
</html>