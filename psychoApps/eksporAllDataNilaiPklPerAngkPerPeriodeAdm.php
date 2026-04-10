<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $angkatan = mysqli_real_escape_string($con,  $_GET[ 'angkatan' ] );
  $id_pkl = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
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
  
  $qper = "SELECT * FROM peserta_pkl WHERE id_pkl='$id_pkl'";
  $rper = mysqli_query($con, $qper)or die( mysqli_error($con));
  $dper = mysqli_fetch_assoc($rper);
  
  $qidper = "SELECT * FROM pendaftaran_pkl WHERE id='$id_pkl'";
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
  
  $qry_grade = "SELECT * FROM grade_pkl WHERE id_pkl='$id_pkl'";
  $res_grade = mysqli_query($con, $qry_grade);
  $dt_grade = mysqli_fetch_assoc($res_grade);
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Data Nilai PKL Angkatan <?php echo ''.$angkatan.' Pada '. 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></title>
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
      header('Content-Disposition: attachment; filename=>Data Nilai PKL Angkatan '.$angkatan.' Pada Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'.xls');
      ?>
    <table style="border:none;">
      <thead>
        <tr style="border:none;">
          <th style="border:none;" colspan="9">Data Nilai PKL Angkatan <?php echo ''.$angkatan.' Pada '. 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?>
          </th>
        </tr>
        <tr style="border:none;">
          <th style="border:none;" colspan="9"></th>
        </tr>
      </thead>
    </table>
    <table>
      <thead>
        <tr style="text-align:center;">
          <td width="4%">No.</td>
          <td width="20%">Nama</td>
          <td width="8%">Tgl. Daftar</td>
          <td width="6%">SKS Ditempuh</td>
          <td width="6%">Status Administrasi</td>
          <td width="6%">Catatan</td>
          <td width="18%">DPL</td>
          <td width="28%">Lokasi</td>
          <td width="8%">Nilai</td>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $sql = "SELECT * FROM peserta_pkl INNER JOIN dt_mhssw ON peserta_pkl.nim=dt_mhssw.nim WHERE peserta_pkl.id_pkl='$id_pkl' AND peserta_pkl.angkatan='$angkatan' AND peserta_pkl.nilai!='' ORDER BY dt_mhssw.nama ASC";
          $result = mysqli_query($con, $sql);
          while($data = mysqli_fetch_array($result)) {
                            
          $qry_mhssw = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
          $rmhssw = mysqli_query($con, $qry_mhssw);
          $dmhssw = mysqli_fetch_assoc($rmhssw);

          $qry_frek = "SELECT COUNT(id) AS jumData FROM peserta_pkl WHERE nim='$data[nim]'";
          $hfrek = mysqli_query($con,  $qry_frek )or DIE( mysqli_error($con) );
          $dfrek = mysqli_fetch_assoc( $hfrek );
                            
          $qidper = "SELECT * FROM pendaftaran_pkl WHERE id='$id_pkl'";
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
                            
          $qry_opsi_dpl = "SELECT * FROM dpl_pkl WHERE id_pkl='$id_pkl' AND id='$data[id_dpl]'";
          $res_opsi_dpl = mysqli_query($con, $qry_opsi_dpl);
          $dt_opsi_dpl = mysqli_fetch_assoc($res_opsi_dpl);

          $qry_dpl = "SELECT * FROM dt_pegawai WHERE id='$dt_opsi_dpl[nip]'";
          $res_dpl = mysqli_query($con, $qry_dpl);
          $dt_dpl = mysqli_fetch_assoc($res_dpl);

          $qry_grade = "SELECT * FROM grade_pkl WHERE id_pkl='$id_pkl'";
          $res_grade = mysqli_query($con, $qry_grade);
          $dt_grade = mysqli_fetch_assoc($res_grade);
                            
          $qdt_cek = "SELECT * FROM opsi_validasi WHERE id='$data[val_adm]'";
          $hdt_cek = mysqli_query($con, $qdt_cek);
          $dcek = mysqli_fetch_assoc($hdt_cek);
          $no++;
          ?>  
        <tr>
          <td style="text-align:center;"> <?php echo $no;?> </td>
          <td style="text-align:left;"> <?php echo $dmhssw['nama'].' / '.$dmhssw['nim'];?> </td>
          <td style="text-align:center;"> <?php echo $data['tgl_pengajuan'];?> </td>
          <td style="text-align:center;"> <?php echo $data['sks_diambil'];?> </td>
          <td style="text-align:center;"> <?php echo $dcek['nm'];?> </td>
          <td style="text-align:left;"> <?php echo $data['catatan'];?> </td>
          <td style="text-align:left;"> <?php if(empty($data['dpl'])) { echo "Belum ada";} else { echo $dt_dpl['nama'];}?> </td>
          <td style="text-align:left;"> <?php if(empty($dt_opsi_dpl['lokasi'])) { echo "Belum ada";} else { echo $dt_opsi_dpl['lokasi'];}?> </td>
          <td style="text-align:center;"> <?php include ("nilaiPesPklAdm.php");?> </td>
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