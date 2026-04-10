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
    <title>Peserta PKL Per DPL <br/><?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' '.$dnta['ta']; ?></title>
    <meta charset="utf-8">
    <style type="text/css">
      .tg  {border-collapse:collapse;border-spacing:0;}
      .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
      overflow:hidden;padding:10px 5px;word-break:normal;}
      .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
      font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
      .tg .tg-cly1{text-align:left;vertical-align:middle}
      .tg .tg-z4i2{border-color:#ffffff;text-align:left;vertical-align:middle}
      .tg .tg-v0mg{border-color:#ffffff;text-align:center;vertical-align:middle}
      .tg .tg-xwyw{border-color:#000000;text-align:center;vertical-align:middle}
      .tg .tg-nrix{text-align:center;vertical-align:middle}
      .tg-sort-header::-moz-selection{background:0 0}
      .tg-sort-header::selection{background:0 0}.tg-sort-header{cursor:pointer}
      .tg-sort-header:after{content:'';float:right;margin-top:7px;border-width:0 5px 5px;border-style:solid;
      border-color:#404040 transparent;visibility:hidden}
      .tg-sort-header:hover:after{visibility:visible}
      .tg-sort-asc:after,.tg-sort-asc:hover:after,.tg-sort-desc:after{visibility:visible;opacity:.4}
      .tg-sort-desc:after{border-bottom:none;border-width:5px 5px 0}
    </style>
  <body>
    <?php
      header("Content-type: application/vnd-ms-excel");
      header('Content-Disposition: attachment; filename=Peserta PKL Per DPL ['.$dt_dpl['nama'].'] [Tahap '.$dthp['tahap'].' Semester '.$dsemester['nama'].' '.$dnta['ta'].'].xls');
      ?>
    <table style="border:none;">
      <thead>
        <tr style="border:none;">
          <th colspan="5">Peserta PKL Per DPL <br/><?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' '.$dnta['ta']; ?>
          </th>
        </tr>
      </thead>
    </table>
    <table>
      <thead>
        <tr style="visibility:collapse;">
          <td width="4%"></td>
          <td width="8%"></td>
          <td width="2%"></td>
          <td width="48%"></td>
          <td width="38%"></td>
        </tr>
        <tr>
          <td colspan="2">Nama DPL</td>
          <td style="text-align:center;">:</td>
          <td colspan="2"><?php echo $dt_dpl['nama'];?></td>
        </tr>
        <tr>
          <td colspan="2">Lokasi</td>
          <td style="text-align:center;">:</td>
          <td colspan="2"><?php echo $dt['lokasi'];?></td>
        </tr>
        <tr style="border:none;">
          <td style="border:none;"></td>
          <td style="border:none;"></td>
          <td style="border:none;"></td>
          <td style="border:none;"></td>
          <td style="border:none;"></td>
        </tr>
        <tr style="border:solid 1px; border-collapse:collapse;">
          <th width="4%" style="text-align:center;">No.</th>
          <th colspan="3" width="60%">Nama</th>
          <th width="36%" style="text-align:center;">Kontak</th>
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
          $no++;
          ?>  
        <tr style="border:solid 1px; border-collapse:collapse;">
          <td style="text-align:center;"><?php echo $no;?></td>
          <td colspan="3" style="text-align:left;"><?php echo $dmhssw['nama'].' / '.$dmhssw['nim'];?></td>
          <td style="text-align:left;"><?php echo $dmhssw['kntk'];?></td>
        </tr>
        <?php
          }
          ?>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td> Ketua PKL,
            <br />
            <br />
            <br />
            <br />
            <?php echo $dt_ket['nama_tg'];?>
          </td>
        </tr>
      </tbody>
    </table>
    <?php include( "jsAdm.php" );?>
    <script type="text/javascript">
      $(document).ready(function() {
         window.close(); 
      });
    </script>
  </body>
</html>