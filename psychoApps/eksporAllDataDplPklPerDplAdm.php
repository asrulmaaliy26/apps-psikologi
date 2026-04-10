<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $qry_dpl = "SELECT * FROM dt_pegawai WHERE id='$id'";
  $res_dpl = mysqli_query($con, $qry_dpl);
  $dt_dpl = mysqli_fetch_assoc($res_dpl);
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Rekap DPL PKL <?php echo $dt_dpl['nama'];?></title>
    <meta charset="utf-8">
    <style type="text/css">
      table.detail {
      border: 1px solid #000000;
      width: 100%;
      text-align: left;
      border-collapse: collapse;
      }
      table.detail td, table.detail th {
      border: 1px solid #000000;
      vertical-align: top;
      }
      table.peserta {
      width: 100%;
      border-collapse: collapse;
      }
    </style>
  <body>
    <?php
      header("Content-type: application/vnd-ms-excel");
      header('Content-Disposition: attachment; filename=Rekap DPL PKL '.$dt_dpl['nama'].'.xls');
      ?>
    <table style="border:none;">
      <thead>
        <tr style="border:none;">
          <th colspan="7">Rekap DPL PKL <br/><?php echo $dt_dpl['nama'];?>
          </th>
        </tr>
      </thead>
    </table>
    <table class="detail">
      <?php
        $no1=0;
        $sqldpl = "SELECT dpl_pkl.id AS id_dpl, dpl_pkl.id_pkl AS id_pkl, dpl_pkl.nip AS nip, dpl_pkl.lokasi AS lokasi FROM dpl_pkl INNER JOIN dt_pegawai ON dpl_pkl.nip=dt_pegawai.id INNER JOIN pendaftaran_pkl ON dpl_pkl.id_pkl=pendaftaran_pkl.id INNER JOIN peserta_pkl ON dpl_pkl.id=peserta_pkl.id_dpl WHERE dpl_pkl.nip='$id' ORDER BY dpl_pkl.id_pkl DESC";
        $resdpl = mysqli_query($con, $sqldpl);
        while($datadpl = mysqli_fetch_array($resdpl)) {
        
        $qidper = "SELECT * FROM pendaftaran_pkl WHERE id='$datadpl[id_pkl]'";
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

        $qry_ket = "SELECT * FROM dt_pegawai WHERE id='$didper[ketua]'";
        $res_ket = mysqli_query($con, $qry_ket);
        $dt_ket = mysqli_fetch_assoc($res_ket);
        $no1++;
        ?>
      <tbody>
        <tr>
          <td style="width: 4%; text-align:center;" rowspan="3"><?php echo $no1;?></td>
            <td style="width: 16%;">Periode PKL</td>
            <td style="width: 2%; text-align:center;">:</td>
            <td style="width: 78%;" colspan="2"><?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></td>
        </tr>
        <tr>
          <td>Lokasi</td>
          <td style="text-align:center;">:</td>
          <td><?php echo $datadpl['lokasi'];?></td>
        </tr>
        <tr>
          <td>Peserta</td>
          <td style="text-align:center;">:</td>
          <td style="background-color: #dfe0e8;">
            <table class="peserta">
              <tbody>
                <tr>
                  <td width="4%" style="text-align:center;">No.</td>
                  <td width="60%" style="text-align:left;">Nama</td>
                  <td width="18%" style="text-align:center;">Kontak</td>
                  <td width="18%" style="text-align:center;">Nilai</td>
                </tr>
                <?php 
                  $no2=0;
                  $sqlpes = "SELECT * FROM peserta_pkl INNER JOIN dt_mhssw ON peserta_pkl.nim=dt_mhssw.nim WHERE peserta_pkl.dpl='$datadpl[nip]' AND peserta_pkl.id_dpl='$datadpl[id_dpl]' ORDER BY dt_mhssw.nama ASC";
                  $respes = mysqli_query($con, $sqlpes);
                  WHILE($data = mysqli_fetch_array($respes)) { 
                  
                  $qry_mhssw = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
                  $rmhssw = mysqli_query($con, $qry_mhssw);
                  $dmhssw = mysqli_fetch_assoc($rmhssw);
                  
                  $qry_grade = "SELECT * FROM grade_pkl WHERE id_pkl='$data[id_pkl]'";
                  $res_grade = mysqli_query($con, $qry_grade);
                  $dt_grade = mysqli_fetch_array($res_grade);
                  $no2++;
                  ?>
                <tr>
                  <td style="text-align:center;"><?php echo $no2;?></td>
                  <td style="text-align:left;"><?php echo $dmhssw['nama'].' / '.$dmhssw['nim'];?></td>
                  <td style="text-align:center;"><?php echo $dmhssw['kntk'];?></td>
                  <td style="text-align:center;"><?php include "nilaiPesPklAdm.php";?></td>
                </tr>
              </tbody>
              <?php
                } 
                ?>
            </table>
          </td>
        </tr>
      </tbody>
      <?php
        }
        ?>
    </table>
    Ketua PKL,
    <br />
    <br />
    <br />
    <br />
    <?php echo $dt_ket['nama_tg'];?>
    <?php include( "jsAdm.php" );?>
    <script type="text/javascript">
      $(document).ready(function() {
         window.close(); 
      });
    </script>
  </body>
</html>