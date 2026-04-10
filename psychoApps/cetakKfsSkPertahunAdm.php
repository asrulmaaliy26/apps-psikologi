<?php include( "contentsConAdm.php" );
  $thn_upload=mysqli_real_escape_string($con, $_GET['thn_upload']);?>
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
    <p><strong>Data Kirim File Surat Keputusan Tahun <?php echo $thn_upload;?></strong></p>
    <table width="100%">
      <thead>
        <tr>
          <th width="4%">No</th>
          <th width="74%">Keterangan tentang File</th>
          <th width="14%">Tgl. Upload</th>
          <th width="8%">Penerima</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $sql =  "SELECT * FROM sending_surat WHERE thn_upload='$thn_upload' AND jenis_surat='1' ORDER BY tgl_upload ASC";
          $result = mysqli_query($con, $sql);
          while($data = mysqli_fetch_array($result)) {
             $no++;
             $qry = "SELECT COUNT(*) AS jumData FROM sending_surat WHERE thn_upload='$thn_upload' AND jenis_surat='1'";
             $r =  mysqli_query($con, $qry) or die(mysqli_error($con));
             $dataku = mysqli_fetch_assoc($r) or die(mysqli_error($con));
             $jumlahData = $dataku['jumData'];
             
             $qry1 = "SELECT COUNT(id) AS jumData FROM penerima_surat WHERE id_sending_surat='$data[id]'";
             $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
             $data1 = mysqli_fetch_assoc( $has1 );
          ?>
        <tr>
          <td style="text-align: center;"><?php echo $no;?></td>
          <td><?php echo $data['deskripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['deskripsi']);?></td>
          <td style="text-align: center;"><?php echo date("d-m-Y", strtotime($data['tgl_upload']) );?></td>
          <td style="text-align: center;"><?php echo $data1['jumData'];?></td>
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