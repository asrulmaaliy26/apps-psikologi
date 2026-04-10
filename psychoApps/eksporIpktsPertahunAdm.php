<?php include( "contentsConAdm.php" );
  $thn_pengajuan=mysqli_real_escape_string($con, $_GET['tahun']);?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Cetak Data</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      table,th,td {
      border: solid 1px;
      border-collapse: collapse;
      padding: 3px;
      }
    </style>
  </head>
  <body>
    <?php
      include( "kopPotret.php" );
      ?>
      <?php
      header("Content-type: application/vnd-ms-excel");
      header('Content-Disposition: attachment; filename=>Data Surat Izin Praktikum Kelompok Testee Siswa Tahun '.$thn_pengajuan.'.xls');
      ?>
    <p><strong>Data Surat Izin Praktikum Kelompok Testee Siswa Tahun <?php echo $thn_pengajuan;?></strong></p>
    <table width="100%">
      <thead>
        <tr>
          <th width="4%">No</th>
          <th width="8%">Tgl. Pengajuan</th>
          <th width="28%">Pemohon</th>
          <th width="52%">Instansi/Lembaga Tujuan Surat</th>
          <th width="8%">Status</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $sql =  "SELECT * FROM siprak_siswa WHERE jenis_praktikum = '2' AND thn_pengajuan='$thn_pengajuan' ORDER BY id ASC";
          $result = mysqli_query($con, $sql);
          while($data = mysqli_fetch_array($result)) {
             $no++;
             $qryMhssw = "SELECT * FROM dt_mhssw WHERE nim='$data[nim]'";
             $rMhssw = mysqli_query($con, $qryMhssw);
             $dMhssw = mysqli_fetch_assoc($rMhssw);

             $qryOsps = "SELECT * FROM opsi_status_pengajuan_surat WHERE id='$data[statusform]'";
             $rOsps = mysqli_query($con, $qryOsps);
             $dOsps = mysqli_fetch_assoc($rOsps);
             
             $qry = "SELECT COUNT(*) AS jumData FROM siprak_siswa WHERE jenis_praktikum = '2' AND thn_pengajuan='$data[thn_pengajuan]'";
             $r =  mysqli_query($con, $qry) or die(mysqli_error($con));
             $dataku = mysqli_fetch_assoc($r) or die(mysqli_error($con));
             $jumlahData = $dataku['jumData'];
          ?>
        <tr>
          <td style="text-align: center;"><?php echo $no;?></td>
          <td style="text-align: center;"><?php echo $data['tgl_pengajuan'];?></td>
          <td><?php echo $dMhssw['nama'];?></td>
          <td><?php echo $data['tujuan_prak'];?></td>
          <td style="text-align: center;"><?php echo $dOsps['nm'];?></td>
        </tr>
        <?php
          }
          ?>
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