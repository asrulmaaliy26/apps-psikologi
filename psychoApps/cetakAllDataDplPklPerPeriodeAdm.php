<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $qidper = "SELECT * FROM pendaftaran_pkl WHERE id='$id'";
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
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Rekap DPL PKL <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
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
      table.peserta td, table.peserta th { border: none;
      }
      .right {
      float: right;
      position:relative;
      width: 260px;
      margin-bottom:20px;
      }
      @media print {
      div.page
      {
      page-break-after: always;
      page-break-inside: avoid;
      }
      }
    </style>
  </head>
  <body style="font-family:Arial, Helvetica, sans-serif; font-size:16px;">
    <div class="page">
      <?php
        include( "kopPotret.php" );
        ?>
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><b>Rekap DPL PKL <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></b>
      </p>
      <table class="detail">
        <?php
          $no1=0;
          $sqldpl = "SELECT dpl_pkl.id AS id_dpl, dpl_pkl.id_pkl AS id_pkl, dpl_pkl.nip AS nip, dpl_pkl.lokasi AS lokasi FROM dpl_pkl INNER JOIN dt_pegawai ON dpl_pkl.nip=dt_pegawai.id  WHERE dpl_pkl.id_pkl='$id' ORDER BY dt_pegawai.nama_tg ASC";
          $resdpl = mysqli_query($con, $sqldpl);
          while($datadpl = mysqli_fetch_array($resdpl)) {
          
          $qry_dpl = "SELECT * FROM dt_pegawai WHERE id='$datadpl[nip]'";
          $res_dpl = mysqli_query($con, $qry_dpl);
          $dt_dpl = mysqli_fetch_assoc($res_dpl);
          $no1++;
          ?>
        <tbody>
          <tr>
            <td style="width: 4%; text-align:center;" rowspan="3"><?php echo $no1;?></td>
            <td style="width: 16%;">Nama DPL</td>
            <td style="width: 2%; text-align:center;">:</td>
            <td style="width: 78%;" colspan="2"><?php echo $dt_dpl['nama'];?></td>
          </tr>
          <tr>
            <td>Lokasi</td>
            <td style="text-align:center;">:</td>
            <td colspan="2"><?php echo $datadpl['lokasi'];?></td>
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
      <br />
      <br />
      <br />
      <div class="right">
        Ketua PKL,
        <br />
        <br />
        <br />
        <br />
        <br />
        <?php echo $dt_ket['nama_tg'];?>
      </div>
    </div>
  </body>
  <?php include( "jsAdm.php" );?>
  <script type="text/javascript">
    $(document).ready(function() {
       window.print();
       window.close(); 
    });
  </script>