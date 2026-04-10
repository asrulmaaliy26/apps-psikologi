<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $myquery = "SELECT * FROM dpl_pkl WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $res );
  
  $qry_dpl = "SELECT * FROM dt_pegawai WHERE id='$dt[nip]'";
  $res_dpl = mysqli_query($con, $qry_dpl);
  $dt_dpl = mysqli_fetch_assoc($res_dpl);

  $qper = "SELECT * FROM peserta_pkl WHERE id_dpl='$id'";
  $rper = mysqli_query($con, $qper)or die( mysqli_error($con));
  $dper = mysqli_fetch_assoc($rper);
  
  $qidper = "SELECT * FROM pendaftaran_pkl WHERE id='$dt[id_pkl]'";
  $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
  $didper = mysqli_fetch_assoc($ridper);
  
  $qry_ket = "SELECT * FROM dt_pegawai WHERE id='$didper[ketua]'";
  $res_ket = mysqli_query($con, $qry_ket);
  $dt_ket = mysqli_fetch_assoc($res_ket);

  $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
  $hasil = mysqli_query($con, $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
  
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$didper[ta]'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
  
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Peserta PKL Per DPL [<?php echo $dt_dpl['nama']?>] [<?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' '.$dnta['ta']; ?>]</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      table.dpl {
      width: 100%;
      }
      table.dpl td, table.dpl th {}
      table.header {
      border: 1px solid #333333;
      width: 100%;
      text-align: center;
      border-collapse: collapse;
      }
      table.header td, table.header th {
      border: 1px solid #AAAAAA;
      padding: 4px 4px;
      }
      table.header thead {
      border-bottom: 2px solid #333333;
      }
      table.header thead th {
      font-weight: bold;
      text-align: center;
      }
      .right {
      float: right;
      position:relative;
      width: 260px;
      margin-bottom:20px;
      }
      /* DivTable.com */
      .divTable{ display: table; }
      .divTableRow { display: table-row; }
      .divTableHeading { display: table-header-group;}
      .divTableCell, .divTableHead { display: table-cell;}
      .divTableHeading { display: table-header-group;}
      .divTableFoot { display: table-footer-group;}
      .divTableBody { display: table-row-group;}
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
      <p style="text-align:center; font-size:18px; text-transform:uppercase;"><b>Peserta PKL Per DPL <br/><?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' '.$dnta['ta']; ?></b>
      </p>
      <table class="dpl">
        <tbody>
          <tr>
            <td style="width:26%;">Nama DPL</td>
            <td style="width:2%;">:</td>
            <td style="width:72%;"><?php echo $dt_dpl['nama'];?></td>
          </tr>
          <tr>
            <td>Lokasi</td>
            <td>:</td>
            <td><?php echo $dt['lokasi'];?></td>
          </tr>
        </tbody>
      </table>
      <br />
      <table class="header">
        <thead>
          <tr>
            <th width="4%" style="text-align:center;">No.</th>
            <th width="60%">Nama</th>
            <th width="18%" style="text-align:center;">Kontak</th>
            <th width="18%" style="text-align:center;">Nilai</th>
          </tr>
        </thead>
        <tbody>
          <?php              
            $no=0;
            $sql = "SELECT * FROM peserta_pkl INNER JOIN dt_mhssw ON peserta_pkl.nim=dt_mhssw.nim WHERE peserta_pkl.dpl='$dt[nip]' AND peserta_pkl.id_dpl='$id' ORDER BY dt_mhssw.nama ASC";
            $result = mysqli_query($con, $sql);
            WHILE($data = mysqli_fetch_array($result)) { 
            
            $qry_mhssw = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
            $rmhssw = mysqli_query($con, $qry_mhssw);
            $dmhssw = mysqli_fetch_assoc($rmhssw);

            $qry_grade = "SELECT * FROM grade_pkl WHERE id_pkl='$data[id_pkl]'";
            $res_grade = mysqli_query($con, $qry_grade);
            $dt_grade = mysqli_fetch_array($res_grade);
            $no++;
            ?>
          <tr>
            <td style="text-align:center;"><?php echo $no;?></td>
            <td style="text-align:left;"><?php echo $dmhssw['nama'].' / '.$dmhssw['nim'];?></td>
            <td style="text-align:center;"><?php echo $dmhssw['kntk'];?></td>
            <td style="text-align:center;"><?php include "nilaiPesPklAdm.php";?></td>
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