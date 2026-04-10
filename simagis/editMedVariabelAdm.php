<?php
  include( "koneksiAdm.php" );
  $username = $_SESSION[ 'username' ];
  
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  $myquery = "SELECT * FROM mag_mediatorvariable WHERE id='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dataku = mysqli_fetch_assoc( $res );
  ?>
<div class="panel panel-default">
  <div class="panel-body">
    <form action="updateMedVariabelAdm.php" method="post">
      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
      <div class="form-group">
        <label for="nm">Nama Variabel Mediator:</label>
        <input type="text" name="nm" class="form-control" id="nm" placeholder="Nama mediator variabel" value="<?php echo $dataku['nm'];?>" required>
      </div>
      <div class="checkbox">
        <label>
        <input type="checkbox" required>&nbsp;Saya menyatakan bahwa isian form ini sudah benar.
        </label>
      </div>
      <button type="submit" class="btn btn-success" name="update">Update</button>
      <button type="reset" class="btn btn-info">Ulang</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </form>
  </div>
</div>