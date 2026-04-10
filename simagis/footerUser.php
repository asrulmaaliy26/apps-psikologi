<?php include "koneksiUser.php";
  $q = "SELECT * FROM mag_dt_ta WHERE status='1'";
  $r = mysqli_query($GLOBALS["___mysqli_ston"], $q)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $d = mysqli_fetch_assoc($r);
  ?>
<div class="footer">
  <div class="container-footer">
    <div class="col-sm-12">
      <p class="text-center text-primary visible-lg visible-md"><span class="text-danger">Semester <?php if($d['semester']==1) {echo "Gasal";} else {echo "Genap";}?> TA. <?php echo $d['ta'];?></span><br>Sistem Informasi Magister Psikologi Fakultas Psikologi UIN Maliki Malang<br><span class="small text-success">Copyright © Simagis [version 1.0]</span></p>
      <p class="text-center text-primary visible-sm visible-xs"><span class="text-danger">Semester <?php if($d['semester']==1) {echo "Gasal";} else {echo "Genap";}?> TA. <?php echo $d['ta'];?></span><br>Sistem Informasi Magister Psikologi<br>Fakultas Psikologi UIN Maliki Malang<br><span class="small text-success">Copyright © Simagis [version 1.0]</span></p>
    </div>
  </div>
</div>