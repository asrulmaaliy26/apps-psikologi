<?php include( "contentsConAdm.php" );
  $tahun=mysqli_real_escape_string($con, $_GET['tahun']);?>
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
  <body style="font-family:Arial, Helvetica, sans-serif; font-size:16px;">
    <?php
      include( "kopPotret.php" );
      ?>
    <p><strong>Data Agenda Surat Keluar Tahun <?php echo $tahun;?></strong></p>
    <table width="100%">
      <thead>
        <tr>
          <th width="4%">No</th>
          <th width="8%">No. Berkas</th>
          <th width="38%">Alamat Tujuan</th>
          <th width="42%">Perihal</th>
          <th width="8%">Tgl. Surat</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $sql =  "SELECT * FROM surat_keluar WHERE tahun='$tahun' ORDER BY ABS(no_berkas) ASC";
          $result = mysqli_query($con, $sql);
          while($data = mysqli_fetch_array($result)) {
             $no++;
             $qry = "SELECT COUNT(*) AS jumData FROM surat_keluar WHERE tahun='$data[tahun]'";
             $r =  mysqli_query($con, $qry) or die(mysqli_error($con));
             $dataku = mysqli_fetch_assoc($r) or die(mysqli_error($con));
             $jumlahData = $dataku['jumData'];
          ?>
        <tr>
          <td style="text-align: center;"><?php echo $no;?></td>
          <td style="text-align: center;"><?php echo $data['no_berkas'];?></td>
          <td><?php echo $data['tujuan'];?></td>
          <td><?php echo $data['perihal'];?></td>
          <td style="text-align: center;"><?php echo $data['tgl_surat'];?></td>
        </tr>
        <?php
          }
          ?>
      </tbody>
    </table>
    <?php include( "jsAdm.php" );?>
    <script type="text/javascript">
      $(document).ready(function() {
         window.print();
         window.close(); 
      });
    </script>
  </body>
</html>