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
    <p><strong>Data Surat Tugas Tahun <?php echo $tahun;?></strong></p>
    <table width="100%">
      <thead>
        <tr>
          <th width="4%">No</th>
          <th width="66%">Perihal Tugas yang Diberikan</th>
          <th width="10%">Jenis ST</th>
          <th width="10%">Tgl. Berlaku</th>
          <th width="10%">Tgl. Ditetapkan</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $no=0;
          $sql =  "SELECT * FROM st WHERE tahun='$tahun' ORDER BY tgl_ditetapkan ASC";
          $result = mysqli_query($con, $sql);
          while($data = mysqli_fetch_assoc($result)) {
            
            $qryJenisSt = "SELECT * FROM opsi_jenis_st WHERE id='$data[jenis_st]'";
            $rJenisSt = mysqli_query($con, $qryJenisSt);
            $dJenisSt = mysqli_fetch_assoc($rJenisSt);

            $no++;
            $qry = "SELECT COUNT(*) AS jumData FROM st WHERE tahun='$data[tahun]'";
            $r =  mysqli_query($con, $qry) or die(mysqli_error($con));
            $dataku = mysqli_fetch_assoc($r) or die(mysqli_error($con));
            $jumlahData = $dataku['jumData'];
          ?>
        <tr>
          <td style="text-align: center;"><?php echo $no;?></td>
          <td><?php echo $data['perihal'];?></td>
          <td style="text-align: center;"><?php echo $dJenisSt['nm'];?></td>
          <td style="text-align: center;"><?php echo $data['awal_berlaku'].'-'.$data['akhir_berlaku'];?></td>
          <td style="text-align: center;"><?php echo date("d-m-Y", strtotime($data['tgl_ditetapkan']) );?></td>
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