<?php
  include("contentsConAdm.php");
  
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $qryperiod = "select * from pengajuan_dospem WHERE id='$id'";
  $rperiod = mysqli_query($con, $qryperiod)or die( mysqli_error($con));
  $dperiod = mysqli_fetch_assoc($rperiod);
  $tahap = $dperiod['tahap'];
  $ta = $dperiod['ta'];
  
  $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$tahap'";
  $hasil = mysqli_query($con, $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
  $namatahap = $dthp['tahap'];
  
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$ta'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
  $namata = $dnta['ta'];
  
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  $namasemester = $dsemester['nama'];
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>PsychoApps</title>
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
      header('Content-Disposition: attachment; filename=pengajuan_dospem__tahap_'.$namatahap.'_'.$namasemester.'_'.$namata.'.xls');
      ?> 
    <table style="border:none;">
      <thead>
        <tr style="border:none;">
          <th style="border:none;" colspan="14">Data Pengajuan Dosen Pembimbing Skripsi <?php echo 'Tahap '.$namatahap.' '.$namasemester.' '.$namata.'';?></th>
        </tr>
        <tr style="border:none;">
          <th style="border:none;" colspan="8"></th>
        </tr>
      </thead>
    </table>
    <table>
      <thead>
        <tr>
          <th>No.</th>
          <th>Nama/NIM</th>
          <th>IPK</th>
          <th>SKS yang Telah Ditempuh</th>
          <th>Judul Skripsi</th>
          <th>Jenis Skripsi</th>
          <th>Bidang Skripsi</th>
          <th>Metode Riset</th>
          <th>Variabel 1</th>
          <th>Variabel 2</th>
          <th>Variabel 3</th>
          <th>Variabel 4</th>
          <th>Pengajuan Dospem I</th>
          <th>Pengajuan Dospem II</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $sql =  "SELECT * FROM pengelompokan_dospem_skripsi WHERE id_periode = '$id' ORDER BY nim ASC";
          $result = mysqli_query($con, $sql);
          while($data = mysqli_fetch_array($result)) {
          $no++;
          
          $qrymhssw = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]' ORDER BY nim ASC";
          $resp = mysqli_query($con,  $qrymhssw )or die( mysqli_error($con) );
          $dmhssw = mysqli_fetch_assoc( $resp );
          
          $qdt_jenis = "SELECT * FROM opsi_jenis_skripsi WHERE id='$data[jenis_skripsi]'";
          $hdt_jenis = mysqli_query($con, $qdt_jenis);
          $djenis = mysqli_fetch_assoc($hdt_jenis);
          
          $qdt_bidang = "SELECT * FROM opsi_bidang_skripsi WHERE id='$data[bidang_skripsi]'";
          $hdt_bidang = mysqli_query($con, $qdt_bidang);
          $dbidang = mysqli_fetch_assoc($hdt_bidang);
          
          $qdt_metode = "SELECT * FROM opsi_jenis_penelitian WHERE id='$data[metode_riset]'";
          $hdt_metode = mysqli_query($con, $qdt_metode);
          $dmetode = mysqli_fetch_assoc($hdt_metode);
          
          $qdt_dospem1 = "SELECT * FROM dt_pegawai WHERE id='$data[dospem_skripsi1]'";
          $hdt_dospem1 = mysqli_query($con, $qdt_dospem1);
          $ddospem1 = mysqli_fetch_assoc($hdt_dospem1);
          
          $qdt_dospem2 = "SELECT * FROM dt_pegawai WHERE id='$data[dospem_skripsi2]'";
          $hdt_dospem2 = mysqli_query($con, $qdt_dospem2);
          $ddospem2 = mysqli_fetch_assoc($hdt_dospem2);
          ?>
        <tr>
          <td><?php echo $no;?></td>
          <td><?php echo $dmhssw['nama'].' / '.$dmhssw['nim'];?></td>
          <td><?php echo $data['ipk'];?></td>
          <td><?php echo $data['sks_ditempuh'];?></td>
          <td><?php echo $data['judul_skripsi'];?></td>
          <td><?php echo $djenis['nm'];?></td>
          <td><?php echo $dbidang['nm'];?></td>
          <td><?php echo $dmetode['opsi'];?></td>
          <td><?php echo $data['var_1'];?></td>
          <td><?php echo $data['var_2'];?></td>
          <td><?php echo $data['var_3'];?></td>
          <td><?php echo $data['var_4'];?></td>
          <td><?php echo $ddospem1['nama'];?></td>
          <td><?php echo $ddospem2['nama'];?></td>
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