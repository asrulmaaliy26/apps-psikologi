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
  
  $qper = "SELECT * FROM peserta_sempro WHERE id_sempro='$id'";
  $rper = mysqli_query($con, $qper)or die( mysqli_error($con));
  $dper = mysqli_fetch_assoc($rper);
  
  $qidper = "SELECT * FROM pendaftaran_sempro WHERE id='$id'";
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
  
  $qry_grade = "SELECT * FROM grade_sempro WHERE id_sempro='$id'";
  $res_grade = mysqli_query($con, $qry_grade);
  $dt_grade = mysqli_fetch_assoc($res_grade);
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Data Pendaftar Seminar Proposal <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></title>
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
    <span style="text-transform:uppercase;"><b>Data Pendaftar Seminar Proposal <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></b>
    <br>
    <br>
    <table width="100%" style="font-size:10px;">
      <thead>
        <tr style="text-align:center;">
          <td rowspan="2" width="4%">No.</td>
          <td rowspan="2" width="16%">Nama</td>
          <td rowspan="2" width="16%">Judul Proposal</td>
          <td rowspan="2" width="8%">Tgl. Daftar</td>
          <td rowspan="2" width="4%">Status Administrasi</td>
          <td rowspan="2" width="6%">Catatan</td>
          <td colspan="5">Jadwal</td>
          <td rowspan="2" width="6%">Nilai</td>
        </tr>
        <tr style="text-align:center;">
          <td width="8%">Penguji 1</td>
          <td width="8%">Penguji 2</td>
          <td width="8%">Tanggal</td>
          <td width="8%">Pukul</td>
          <td width="8%">Ruang</td>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $sql = "SELECT * FROM peserta_sempro INNER JOIN dt_mhssw ON peserta_sempro.nim=dt_mhssw.nim WHERE peserta_sempro.id_sempro='$id' ORDER BY dt_mhssw.nama ASC";
          $result = mysqli_query($con, $sql);
          while($data = mysqli_fetch_array($result)) {
                            
          $qry_mhssw = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
          $rmhssw = mysqli_query($con, $qry_mhssw);
          $dmhssw = mysqli_fetch_assoc($rmhssw);

          $qry_frek = "SELECT COUNT(id) AS jumData FROM peserta_sempro WHERE nim='$data[nim]'";
          $hfrek = mysqli_query($con,  $qry_frek )or DIE( mysqli_error($con) );
          $dfrek = mysqli_fetch_assoc( $hfrek );
                            
          $qidper = "SELECT * FROM pendaftaran_sempro WHERE id='$id'";
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
                            
          $qry_jdwl = "SELECT * FROM jadwal_sempro WHERE id_sempro='$id' AND id='$data[id_jdwl]'";
          $res_jdwl = mysqli_query($con, $qry_jdwl);
          $dt_jdwl = mysqli_fetch_assoc($res_jdwl);

          $qry_p1 = "SELECT * FROM dt_pegawai WHERE id='$dt_jdwl[penguji1]'";
          $res_p1 = mysqli_query($con, $qry_p1);
          $dt_p1 = mysqli_fetch_assoc($res_p1);

          $qry_p2 = "SELECT * FROM dt_pegawai WHERE id='$dt_jdwl[penguji2]'";
          $res_p2 = mysqli_query($con, $qry_p2);
          $dt_p2 = mysqli_fetch_assoc($res_p2);

          $qry_ruang = "SELECT * FROM dt_ruang WHERE id='$dt_jdwl[ruang]'";
          $res_ruang = mysqli_query($con, $qry_ruang);
          $dt_ruang = mysqli_fetch_assoc($res_ruang);

          $qry_nilai = "SELECT * FROM nilai_sempro WHERE id_pendaftaran='$data[id]'";
          $res_nilai = mysqli_query($con, $qry_nilai);
          $dt_nilai = mysqli_fetch_assoc($res_nilai);

          $qry_grade = "SELECT * FROM grade_sempro WHERE id_sempro='$id'";
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
          <td style="text-align:left;"> <?php echo $data['judul_prop']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['judul_prop']);?> </td>
          <td style="text-align:center;"> <?php echo $data['tgl_pengajuan'];?> </td>
          <td style="text-align:center;"> <?php echo $dcek['nm'];?> </td>
          <td style="text-align:left;"> <?php echo $data['catatan'];?> </td>
          <td style="text-align:left;"> <?php if(empty($dt_p1['nama'])) { echo "Belum ada";} else { echo $dt_p1['nama'];}?> </td>
          <td style="text-align:left;"> <?php if(empty($dt_p2['nama'])) { echo "Belum ada";} else { echo $dt_p2['nama'];}?> </td>
          <td style="text-align:left;"> <?php if(empty($dt_jdwl['tgl_seminar'])) { echo "Belum ada";} else { echo $dt_jdwl['tgl_seminar'];}?> </td>
          <td style="text-align:left;"> <?php if(empty($dt_jdwl['jam_mulai']) && empty($dt_jdwl['jam_selesai'])) { echo "Belum ada";} else { echo $dt_jdwl['jam_mulai'].' - '.$dt_jdwl['jam_selesai'];}?> </td>
          <td style="text-align:left;"> <?php if(empty($dt_jdwl['ruang'])) { echo "Belum ada";} else { echo $dt_ruang['nm'];}?> </td>
          <td style="text-align:center;"> <?php include ("nilaiPesSemproAdm.php");?> </td>
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