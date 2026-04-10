<?php
  include( "koneksiExt.php" );
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET[ 'id' ] );
  
  $qp = "select * from mag_upload_pengumuman WHERE id='$id'";
  $rp = mysqli_query($GLOBALS["___mysqli_ston"], $qp)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dp = mysqli_fetch_assoc($rp);
  ?>
<div class="row">
  <div class="col-lg-12">
    <div class="panel panel-default">
      <div class="panel-body">
        <?php echo $dp['isi'];?>
      </div>
    </div>
  </div>
</div>