<?php
  include( "koneksiUser.php" );
  $nim = $_SESSION[ 'nim' ];
  
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  $myquery = "select * from mag_peserta_sempro WHERE id='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dataku = mysqli_fetch_assoc( $res );
  ?>
<div class="panel panel-default">
  <div class="panel-body">
      <div class="form-group">
        <label for="">Catatan Pendaftaran:</label>
        <span><?php echo $dataku['catatan'];?></span>
      </div>
  </div>
  <div class="panel-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>