<?php
  include( "koneksiUser.php" );
  $nim = $_SESSION[ 'nim' ];
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET[ 'id' ] );
    
  $qry = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE nim='$nim'";
  $has = mysqli_query($GLOBALS["___mysqli_ston"],  $qry)or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  $data = mysqli_fetch_assoc($has);
  ?>
<div class="row">
  <div class="col-md-12">
    <h4 class="page-header" style="margin-top:2px;">Judul Tesis:</h4>
    <?php echo $data['judul_tesis'];?>
    <h4 class="page-header">Outline Tesis:</h4>
    <?php echo $data['outline_tesis'];?>
  </div>
</div>