<?php include( "contentsConAdm.php" );
  $sql1 =  "SELECT * FROM nama_lembaga";
  $result1 = mysqli_query($con, $sql1);
  $data1 = mysqli_fetch_array($result1);
  
  $sql2 =  "SELECT * FROM nama_lembaga_induk";
  $result2 = mysqli_query($con, $sql2);
  $data2 = mysqli_fetch_array($result2);
  
  $sql3 =  "SELECT * FROM nama_lembaga_naungan";
  $result3 = mysqli_query($con, $sql3);
  $data3 = mysqli_fetch_array($result3);
  
  $sql4 =  "SELECT * FROM alamat_lembaga";
  $result4 = mysqli_query($con, $sql4);
  $data4 = mysqli_fetch_array($result4);
  ?>
<div class="img-kiri">
  <img src="images/logo_uin.png" width="77" height="73" style="visibility:visible !important;">
</div>
<div style="text-align:center;">
  <strong><font class="baris-satu-dua-tiga" style="text-transform:uppercase;"><?php echo "$data3[nm]";?><br />
  <?php echo "$data2[nm]";?><br />
  <?php echo "$data1[nm]";?></font></strong><br />
  <font class="baris-empat"><?php echo "$data4[nm]";?></font>
</div>
<div>
  <hr>
</div>