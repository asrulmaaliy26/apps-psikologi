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
    <title>Data Pendaftar Ujian Komprehensif <?php echo 'Tahap '.$dthp['tahap'].' ('.$djp['nm'].') '.$dsemester['nama'].' '.$dnta['ta'].'';?></title>
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
    <span style="text-transform:uppercase;"><b>Data Pendaftar Ujian Komprehensif <?php echo 'Tahap '.$dthp['tahap'].' ('.$djp['nm'].') '.$dsemester['nama'].' '.$dnta['ta'].'';?></b>
    <br>
    Passing Grade: <?php echo $didper['passing_grade'];?></b></span></b></span>
    <br>
    <br>
    <table width="100%" style="font-size:10px;">
      <thead>
        <tr style="text-align:center;">
          <td rowspan="2" width="4%">No.</td>
          <td rowspan="2" width="20%">Nama</td>
          <td rowspan="2" width="8%">Tgl. Daftar</td>
          <td rowspan="2" width="6%">SKS Ditempuh</td>
          <td rowspan="2" width="6%">Status Administrasi</td>
          <td rowspan="2" width="6%">Catatan</td>
          <td colspan="3">Jadwal Ujian</td>
          <td colspan="2">Pengawas</td>
          <td rowspan="2" width="8%">Nilai</td>
        </tr>
        <tr style="text-align:center;">
          <td width="6%">Tanggal</td>
          <td width="6%">Pukul</td>
          <td width="10%">Ruang</td>
          <td width="8%">I</td>
          <td width="8%">II</td>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $sql = "SELECT * FROM peserta_kompre INNER JOIN dt_mhssw ON peserta_kompre.nim=dt_mhssw.nim WHERE peserta_kompre.id_kompre='$id' ORDER BY dt_mhssw.nama ASC";
          $result = mysqli_query($con, $sql);
          while($data = mysqli_fetch_array($result)) {
                            
          $qry_mhssw = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
          $rmhssw = mysqli_query($con, $qry_mhssw);
          $dmhssw = mysqli_fetch_assoc($rmhssw);

          $qry_frek = "SELECT COUNT(id) AS jumData FROM peserta_kompre WHERE nim='$data[nim]'";
          $hfrek = mysqli_query($con,  $qry_frek )or DIE( mysqli_error($con) );
          $dfrek = mysqli_fetch_assoc( $hfrek );
                            
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
                            
          $qry_grade = "SELECT * FROM grade_kompre WHERE id_kompre='$id'";
          $res_grade = mysqli_query($con, $qry_grade);
          $dt_grade = mysqli_fetch_assoc($res_grade);
          
          $qry_jdwl = "SELECT * FROM jadwal_kompre WHERE id='$data[id_jdwl]'";
          $rjdwl = mysqli_query($con, $qry_jdwl);
          $djdwl = mysqli_fetch_assoc($rjdwl);
                            
          $qry_ruang = "SELECT * FROM dt_ruang WHERE id='$djdwl[ruang]'";
          $rruang = mysqli_query($con, $qry_ruang);
          $druang = mysqli_fetch_assoc($rruang);
                            
          $qry_pengawas1 = "SELECT * FROM dt_pengawas_kompre WHERE id='$djdwl[pengawas1]'";
          $rpengawas1 = mysqli_query($con, $qry_pengawas1);
          $dpengawas1 = mysqli_fetch_assoc($rpengawas1);
                            
          $qry_pengawas2 = "SELECT * FROM dt_pengawas_kompre WHERE id='$djdwl[pengawas2]'";
          $rpengawas2 = mysqli_query($con, $qry_pengawas2);
          $dpengawas2 = mysqli_fetch_assoc($rpengawas2);
                            
          $qdt_cek = "SELECT * FROM opsi_validasi WHERE id='$data[val_adm]'";
          $hdt_cek = mysqli_query($con, $qdt_cek);
          $dcek = mysqli_fetch_assoc($hdt_cek);
          $no++;
          ?>  
        <tr>
          <td style="text-align:center;"> <?php echo $no;?> </td>
          <td style="text-align:left;"> <?php echo $dmhssw['nama'].' / '.$dmhssw['nim'];?> </td>
          <td style="text-align:left;"> <?php echo $data['tgl_pengajuan'];?> </td>
          <td style="text-align:left;"> <?php echo $data['sks_ditempuh'];?> </td>
          <td style="text-align:left;"> <?php echo $dcek['nm'];?> </td>
          <td style="text-align:left;"> <?php echo $data['catatan'];?> </td>
          <td style="text-align:left;"> <?php echo $djdwl['tgl_kompre'];?> </td>
          <td style="text-align:left;"> <?php echo $djdwl['jam_mulai'].' - '.$djdwl['jam_selesai'];?> </td>
          <td style="text-align:left;"> <?php echo $druang['nm'];?> </td>  
          <td style="text-align:left;"> <?php echo $dpengawas1['nm'];?> </td>
          <td style="text-align:left;"> <?php echo $dpengawas2['nm'];?> </td>
          <td style="text-align:left;"> <?php if(empty($data['hasil_ujian'])) { echo "Belum ada"." ";} 
        elseif($data['hasil_ujian'] <= $dt_grade['at'] && $data['hasil_ujian'] >= $dt_grade['ab']) { echo $data['hasil_ujian']. ' (A)'.' ';} 
        elseif ($data['hasil_ujian'] <= $dt_grade['bplust'] && $data['hasil_ujian'] >= $dt_grade['bplusb']) { echo $data['hasil_ujian']. ' (B+)'.' ';} 
        elseif ($data['hasil_ujian'] <= $dt_grade['bt']  && $data['hasil_ujian'] >= $dt_grade['bb']) { echo $data['hasil_ujian']. ' (B)'.' ';} 
        elseif ($data['hasil_ujian'] <= $dt_grade['cplust'] && $data['hasil_ujian'] >= $dt_grade['cplusb']) { echo $data['hasil_ujian']. ' (C+)'.' ';} 
        elseif ($data['hasil_ujian'] <= $dt_grade['ct'] && $data['hasil_ujian'] >= $dt_grade['cb']) { echo $data['hasil_ujian']. ' (C)'.' ';} 
        elseif ($data['hasil_ujian'] <= $dt_grade['dt'] && $data['hasil_ujian'] >= $dt_grade['db']) {echo $data['hasil_ujian']. ' (D)'.' ';}?>
        <?php if($data['hasil_ujian'] <= $dt_grade['at'] && $data['hasil_ujian'] >= $didper['passing_grade']) { echo "<span class='bg-primary'>Lulus</span>";} 
        elseif($data['hasil_ujian'] < $didper['passing_grade'] && $data['hasil_ujian'] >= $dt_grade['db']) { echo "<span class='bg-danger'>Gagal</span>";} elseif(empty($data['hasil_ujian'])) { echo "";}?> </td>
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