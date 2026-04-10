<?php
  include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $myquery = "SELECT * FROM peserta_ujskrip WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );
  $id_periode=$dataku['id_periode'];
  
  $qdt_mhssw = "SELECT * FROM dt_mhssw WHERE nim='$dataku[nim]'";
  $hdt_mhssw = mysqli_query($con, $qdt_mhssw);
  $dmhssw = mysqli_fetch_assoc($hdt_mhssw);
  
  $qdt_dospem1 = "SELECT * FROM dt_pegawai WHERE id='$dataku[pembimbing1]'";
  $hdt_dospem1 = mysqli_query($con, $qdt_dospem1);
  $ddospem1 = mysqli_fetch_assoc($hdt_dospem1);
                            
  $qdt_dospem2 = "SELECT * FROM dt_pegawai WHERE id='$dataku[pembimbing2]'";
  $hdt_dospem2 = mysqli_query($con, $qdt_dospem2);
  $ddospem2 = mysqli_fetch_assoc($hdt_dospem2);
  
  $qdt_val_adm = "SELECT * FROM opsi_validasi WHERE id='$dataku[val_adm]'";
  $hdt_val_adm = mysqli_query($con, $qdt_val_adm);
  $dvaladm = mysqli_fetch_assoc($hdt_val_adm);

  $qry_frek = "SELECT COUNT(id) AS jumData FROM peserta_ujskrip WHERE nim='$dataku[nim]'";
  $hfrek = mysqli_query($con,  $qry_frek )or DIE( mysqli_error($con) );
  $dfrek = mysqli_fetch_assoc( $hfrek );
  ?>
<div class="table-responsive">
  <table class="table table-striped m-0 table-bordered text-justify table-sm small custom">
    <tbody>
      <tr>
        <td scope="row" width="26%">Nama</td>
        <td width="4%" class="text-center">:</td>
        <td width="70%"><?php echo $dmhssw['nama'].'/'.$dmhssw['nim'];?></td>
      </tr>
      <tr>
        <td scope="row">Pendaftaran Ke</td>
        <td class="text-center">:</td>
        <td><?php echo $dfrek['jumData'];?></td>
      </tr>
      <tr>
        <td scope="row">Tanggal Pendaftaran</td>
        <td class="text-center">:</td>
        <td><?php echo $dataku['tgl_pengajuan'];?></td>
      </tr>
      <tr>
        <td scope="row">Status Pendaftaran</td>
        <td class="text-center">:</td>
        <td><?php echo $dvaladm['nm'].' pada tanggal '.$dataku['tgl_validasi'];?></td>
      </tr>
      <tr>
        <td scope="row">Judul Skripsi</td>
        <td class="text-center">:</td>
        <td><?php echo $dataku['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $dataku['judul_skripsi']);?></td>
      </tr>
      <tr>
        <td scope="row">Dosen Pembimbing Skripsi I</td>
        <td class="text-center">:</td>
        <td><?php echo $ddospem1['nama'];?></td>
      </tr>
      <tr>
        <td scope="row">Dosen Pembimbing Skripsi II</td>
        <td class="text-center">:</td>
        <td><?php echo $ddospem2['nama'];?></td>
      </tr>
    </tbody>
  </table>
</div>