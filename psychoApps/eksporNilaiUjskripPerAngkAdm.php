<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $angkatan = mysqli_real_escape_string($con,  $_GET[ 'angkatan' ] );
  
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
  
  $qper = "SELECT * FROM peserta_ujskrip WHERE id_ujskrip='$id'";
  $rper = mysqli_query($con, $qper)or die( mysqli_error($con));
  $dper = mysqli_fetch_assoc($rper);
  
  $qidper = "SELECT * FROM pendaftaran_skripsi WHERE id='$id'";
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
  
  $qry_grade = "SELECT * FROM grade_ujskrip WHERE id_ujskrip='$id'";
  $res_grade = mysqli_query($con, $qry_grade);
  $dt_grade = mysqli_fetch_assoc($res_grade);
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Data Nilai Ujian Skripsi Angkatan <?php echo "$angkatan";?></title>
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
      header('Content-Disposition: attachment; filename=Data Nilai Ujian Skripsi Angkatan '.$angkatan.'.xls');
      ?>
    <table style="border:none;">
      <thead>
        <tr style="border:none;">
          <th style="border:none;" colspan="16">Data Nilai Ujian Skripsi Angkatan <?php echo "$angkatan";?></th>
        </tr>
        <tr style="border:none;">
          <th style="border:none;" colspan="16"></th>
        </tr>
      </thead>
    </table>
    <table>
      <thead>
        <tr style="text-align:center;">
          <td rowspan="2" width="4%">No.</td>
          <td rowspan="2" width="12%">Nama</td>
          <td rowspan="2" width="14%">Judul Skripsi</td>
          <td colspan="6">Jadwal</td>
          <td colspan="7">Nilai</td>
        </tr>
        <tr style="text-align:center;">
          <td width="8%">Sekretaris Penguji</td>
          <td width="8%">Ketua Penguji</td>
          <td width="8%">Penguji Utama</td>
          <td width="6%">Tanggal</td>
          <td width="6%">Pukul</td>
          <td width="6%">Ruang</td>
          <td width="4%">Sekretaris Penguji</td>
          <td width="4%">Catatan</td>
          <td width="4%">Ketua Penguji</td>
          <td width="4%">Catatan</td>
          <td width="4%">Penguji Utama</td>
          <td width="4%">Catatan</td>
          <td width="4%">Rerata</td>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $sql = "SELECT * FROM peserta_ujskrip INNER JOIN dt_mhssw ON peserta_ujskrip.nim=dt_mhssw.nim INNER JOIN nilai_ujskrip ON peserta_ujskrip.id=nilai_ujskrip.id_pendaftaran INNER JOIN jadwal_ujskrip ON peserta_ujskrip.id=jadwal_ujskrip.id_pendaftaran WHERE peserta_ujskrip.angkatan='$angkatan' ORDER BY dt_mhssw.nama ASC";
          $result = mysqli_query($con, $sql);
          while($data = mysqli_fetch_array($result)) {
                            
          $qry_pra = "SELECT * FROM peserta_ujskrip WHERE id='$data[id_pendaftaran]'";
          $r_pra = mysqli_query($con, $qry_pra);
          $dpra = mysqli_fetch_assoc($r_pra);

          $qry_mhssw = "SELECT * FROM dt_mhssw WHERE nim='$dpra[nim]'";
          $rmhssw = mysqli_query($con, $qry_mhssw);
          $dmhssw = mysqli_fetch_assoc($rmhssw);
                            
          $qry_frek = "SELECT COUNT(id) AS jumData FROM peserta_ujskrip WHERE nim='$dpra[nim]'";
          $hfrek = mysqli_query($con,  $qry_frek )or DIE( mysqli_error($con) );
          $dfrek = mysqli_fetch_assoc( $hfrek );
                            
          $qidper = "SELECT * FROM pendaftaran_skripsi WHERE id='$data[id_ujskrip]'";
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
                            
          $qry_jdwl = "SELECT * FROM jadwal_ujskrip WHERE id_ujskrip='$data[id_ujskrip]' AND id='$data[id_jdwl]'";
          $res_jdwl = mysqli_query($con, $qry_jdwl);
          $dt_jdwl = mysqli_fetch_assoc($res_jdwl);

          $qry_p1 = "SELECT * FROM dt_pegawai WHERE id='$dt_jdwl[sekretaris_penguji]'";
          $res_p1 = mysqli_query($con, $qry_p1);
          $dt_p1 = mysqli_fetch_assoc($res_p1);

          $qry_p2 = "SELECT * FROM dt_pegawai WHERE id='$dt_jdwl[ketua_penguji]'";
          $res_p2 = mysqli_query($con, $qry_p2);
          $dt_p2 = mysqli_fetch_assoc($res_p2);

          $qry_p3 = "SELECT * FROM dt_pegawai WHERE id='$dt_jdwl[penguji_utama]'";
          $res_p3 = mysqli_query($con, $qry_p3);
          $dt_p3 = mysqli_fetch_assoc($res_p3);

          $qry_ruang = "SELECT * FROM dt_ruang WHERE id='$dt_jdwl[ruang]'";
          $res_ruang = mysqli_query($con, $qry_ruang);
          $dt_ruang = mysqli_fetch_assoc($res_ruang);

          $qry_nilai = "SELECT * FROM nilai_ujskrip WHERE id_pendaftaran='$data[id]'";
          $res_nilai = mysqli_query($con, $qry_nilai);
          $dt_nilai = mysqli_fetch_assoc($res_nilai);

          $qry_grade = "SELECT * FROM grade_ujskrip WHERE id_ujskrip='$data[id_ujskrip]'";
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
          <td style="text-align:left;"> <?php echo $data['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['judul_skripsi']);?> </td>
          <td style="text-align:left;"> <?php if(empty($dt_p1['nama'])) { echo "Belum ada";} else { echo $dt_p1['nama'];}?> </td>
          <td style="text-align:left;"> <?php if(empty($dt_p2['nama'])) { echo "Belum ada";} else { echo $dt_p2['nama'];}?> </td>
          <td style="text-align:left;"> <?php if(empty($dt_p3['nama'])) { echo "Belum ada";} else { echo $dt_p3['nama'];}?> </td>
          <td style="text-align:left;"> <?php if(empty($dt_jdwl['tgl_ujian'])) { echo "Belum ada";} else { echo $dt_jdwl['tgl_ujian'];}?> </td>
          <td style="text-align:left;"> <?php if(empty($dt_jdwl['jam_mulai']) && empty($dt_jdwl['jam_selesai'])) { echo "Belum ada";} else { echo $dt_jdwl['jam_mulai'].' - '.$dt_jdwl['jam_selesai'];}?> </td>
          <td style="text-align:left;"> <?php if(empty($dt_jdwl['ruang'])) { echo "Belum ada";} else { echo $dt_ruang['nm'];}?> </td>
          <td style="text-align:center;"> <?php include("nilaiSekretarisPesUjskripAdm.php");?> </td>
          <td style="text-align:center;"> <?php if(empty($data['catatan_sekretaris'])) { echo "Tidak ada";} else { echo nl2br($data['catatan_sekretaris']);}?> </td>
          <td style="text-align:center;"> <?php include("nilaiKetuaPesUjskripAdm.php");?> </td>
          <td style="text-align:center;"> <?php if(empty($data['catatan_ketua'])) { echo "Tidak ada";} else { echo nl2br($data['catatan_ketua']);}?> </td>
          <td style="text-align:center;"> <?php include("nilaiUtamaPesUjskripAdm.php");?> </td>
          <td style="text-align:center;"> <?php if(empty($data['catatan_utama'])) { echo "Tidak ada";} else { echo nl2br($data['catatan_utama']);}?> </td>
          <td style="text-align:center;"> <?php include ("nilaiPesUjskripAdm.php");?> </td>
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