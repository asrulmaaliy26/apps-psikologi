<?php
  include( "koneksiAdm.php" );
  
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  $myquery = "select * from mag_pengelompokan_rumpun WHERE id='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dataku = mysqli_fetch_assoc( $res );
  ?>
<div class="panel panel-default">
  <div class="panel-body">
    <form action="updatePprpAdm.php" method="post">
      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
      <input type="text" name="angkatan" class="sr-only" value="<?php echo $dataku['angkatan'];?>" required readonly>
      <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
      <div class="form-group">
        <label for="rumpun">Peminatan Rumpun Psikologi yang Dipilih:</label>
        <?php
          echo "<select name='rumpun' class='form-control' required>";
          echo "<option value=''>-Pilih-</option>";
          $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM mag_opsi_rumpun ORDER BY nm ASC" );
          while ( $w = mysqli_fetch_array( $tampil ) ) {
          	if ( $dataku['rumpun'] == $w[ 'id' ] ) {
          		echo "<option value='$w[id]' selected>$w[nm]</option>";
          	} else {
          		echo "<option value='$w[id]'>$w[nm]</option>";
          	}
          }
          echo "</select>";
          ?>
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