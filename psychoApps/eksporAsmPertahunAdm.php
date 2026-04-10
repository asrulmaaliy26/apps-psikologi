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
  <body>
    <?php
      include( "kopPotret.php" );
      ?>
      <?php
      header("Content-type: application/vnd-ms-excel");
      header('Content-Disposition: attachment; filename=Data Agenda Surat Masuk Tahun '.$tahun.'.xls');
      ?>
    <p><strong>Data Agenda Surat Masuk Tahun <?php echo $tahun;?></strong></p>
    <table width="100%">
      <thead>
        <tr>
          <th width="4%">No</th>
          <th width="8%">No. Berkas</th>
          <th width="28%">Pengirim</th>
          <th width="10%">No. Surat</th>
          <th width="34%">Perihal</th>
          <th width="8%">Tgl. Terima</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $sql =  "SELECT * FROM surat_masuk WHERE tahun='$tahun' ORDER BY ABS(no_berkas) ASC";
          $result = mysqli_query($con, $sql);
          while($data = mysqli_fetch_assoc($result)) {
             $no++;
             $qry = "SELECT COUNT(*) AS jumData FROM surat_masuk WHERE tahun='$data[tahun]'";
             $r =  mysqli_query($con, $qry) or die(mysqli_error($con));
             $dataku = mysqli_fetch_assoc($r) or die(mysqli_error($con));
             $jumlahData = $dataku['jumData'];
          ?>
        <tr>
          <td style="text-align: center;"><?php echo $no;?></td>
          <td style="text-align: center;"><?php echo $data['no_berkas'];?></td>
          <td><?php echo $data['pengirim'];?></td>
          <td><?php echo $data['no_surat'];?></td>
          <td><?php echo $data['perihal'];?></td>
          <td style="text-align: center;"><?php echo $data['tgl_terima'];?></td>
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