<?php
  include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $myquery = "SELECT * FROM pengelompokan_dospem_skripsi WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );
  $id_periode=$dataku['id_periode'];
  
  $qdt_mhssw = "SELECT * FROM dt_mhssw WHERE nim='$dataku[nim]'";
  $hdt_mhssw = mysqli_query($con, $qdt_mhssw);
  $dmhssw = mysqli_fetch_assoc($hdt_mhssw);
  
  $qdt_jenskripsi = "SELECT * FROM opsi_jenis_skripsi WHERE id='$dataku[jenis_skripsi]'";
  $hdt_jenskripsi = mysqli_query($con, $qdt_jenskripsi);
  $djenskripsi = mysqli_fetch_assoc($hdt_jenskripsi);
  
  $qdt_bidskripsi = "SELECT * FROM opsi_bidang_skripsi WHERE id='$dataku[bidang_skripsi]'";
  $hdt_bidskripsi = mysqli_query($con, $qdt_bidskripsi);
  $dbidskripsi = mysqli_fetch_assoc($hdt_bidskripsi);
  
  $qdt_metriset = "SELECT * FROM opsi_jenis_penelitian WHERE id='$dataku[metode_riset]'";
  $hdt_metriset = mysqli_query($con, $qdt_metriset);
  $dmetriset = mysqli_fetch_assoc($hdt_metriset);
  
  $qdt_dospem1 = "SELECT * FROM dt_pegawai WHERE id='$dataku[dospem_skripsi1]'";
  $hdt_dospem1 = mysqli_query($con, $qdt_dospem1);
  $ddospem1 = mysqli_fetch_assoc($hdt_dospem1);
                            
  $qdt_dospem2 = "SELECT * FROM dt_pegawai WHERE id='$dataku[dospem_skripsi2]'";
  $hdt_dospem2 = mysqli_query($con, $qdt_dospem2);
  $ddospem2 = mysqli_fetch_assoc($hdt_dospem2);
  ?>
<div class="table-responsive">
  <table class="table table-striped m-0 table-bordered text-justify table-sm small custom">
    <tbody>
      <tr>
        <td scope="row" width="50%">Nama</td>
        <td width="4%" class="text-center">:</td>
        <td width="46%"><?php echo $dmhssw['nama'].'/'.$dmhssw['nim'];?></td>
      </tr>
      <tr>
        <td scope="row">Indeks Prestasi Kumulatif (IPK)</td>
        <td class="text-center">:</td>
        <td><?php echo $dataku['ipk'];?></td>
      </tr>
      <tr>
        <td scope="row">SKS yang telah ditempuh</td>
        <td class="text-center">:</td>
        <td><?php echo $dataku['sks_ditempuh'];?> SKS</td>
      </tr>
      <tr>
        <td scope="row">Judul skripsi yang diajukan</td>
        <td class="text-center">:</td>
        <td><?php echo $dataku['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dataku['judul_skripsi']);?></td>
      </tr>
      <tr>
        <td scope="row">Jenis skripsi</td>
        <td class="text-center">:</td>
        <td><?php echo $djenskripsi['nm'];?></td>
      </tr>
      <tr>
        <td scope="row">Peminatan bidang psikologi dalam skripsi</td>
        <td class="text-center">:</td>
        <td><?php echo $dbidskripsi['nm'];?></td>
      </tr>
      <tr>
        <td scope="row">Metode riset</td>
        <td class="text-center">:</td>
        <td><?php echo $dmetriset['opsi'];?></td>
      </tr>
      <tr>
        <td scope="row">Variabel 1</td>
        <td class="text-center">:</td>
        <td><?php echo $dataku['var_1'];?></td>
      </tr>
      <tr>
        <td scope="row">Variabel 2</td>
        <td class="text-center">:</td>
        <td><?php echo $dataku['var_2'];?></td>
      </tr>
      <tr>
        <td scope="row">Variabel 3</td>
        <td class="text-center">:</td>
        <td><?php echo $dataku['var_3'];?></td>
      </tr>
      <tr>
        <td scope="row">Variabel 4</td>
        <td class="text-center">:</td>
        <td><?php echo $dataku['var_4'];?></td>
      </tr>
      <tr>
        <td scope="row">Pilihan dosen pembimbing skripsi I</td>
        <td class="text-center">:</td>
        <td><?php echo $ddospem1['nama'];?></td>
      </tr>
      <tr>
        <td scope="row">Pilihan dosen pembimbing skripsi II</td>
        <td class="text-center">:</td>
        <td><?php echo $ddospem2['nama'];?></td>
      </tr>
      <tr>
        <td scope="row">Tanggal pengajuan</td>
        <td class="text-center">:</td>
        <td><?php echo $dataku['tgl_pengajuan'];?></td>
      </tr>
    </tbody>
  </table>
</div>