<?php
  include( "koneksiAdm.php" );
  
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  $myquery = "select * from mag_dospem_tesis WHERE id='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dataku = mysqli_fetch_assoc( $res );
  ?>
<div class="panel panel-default">
  <div class="panel-body">
    <form action="updateKuotaPt.php" method="post">
      <input type="text" name="id" class="sr-only" value="<?php echo $dataku['id'];?>" required readonly>
      <input type="text" name="id_periode" class="sr-only" value="<?php echo $dataku['id_periode'];?>" required readonly>
      <div class="form-group">
        <label for="nip">Dosen Pembimbing Tesis:</label>
        <?php
          echo "<select name='nip' class='form-control' required disabled>";
          echo "<option value=''>-Pilih-</option>";
          $tampil = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mag_dospem_tesis" );
          while ( $w = mysqli_fetch_array( $tampil ) ) {
          $mqry = "SELECT * FROM dt_pegawai WHERE id='$w[nip]'";
              $rq = mysqli_query($GLOBALS["___mysqli_ston"], $mqry)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
              $dq = mysqli_fetch_array($rq);
          
          	if ( $dataku['nip'] == $w[ 'nip' ] ) {
          		echo "<option value='$w[id]' selected>$dq[nama]</option>";
          	} else {
          		echo "<option value='$w[id]'>$dq[nama]</option>";
          	}
          }
          echo "</select>";
          ?>
      </div>
      <div class="form-group">
        <label for="kuota1">Kuota untuk Menjadi Dosen Pembimbing Tesis I:</label>
        <input type="number" min="0" max="20" id="kuota1" name="kuota1" class="form-control" value="<?php echo $dataku['kuota1'];?>" required>
      </div>
      <div class="form-group">
        <label for="kuota2">Kuota untuk Menjadi Dosen Pembimbing Tesis II:</label>
        <input type="number" min="0" max="20" id="kuota2" name="kuota2" class="form-control" value="<?php echo $dataku['kuota2'];?>" required>
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