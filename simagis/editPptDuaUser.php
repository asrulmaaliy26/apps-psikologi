<?php
  include( "koneksiUser.php" );
  $nim = $_SESSION[ 'nim' ];
  
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  $myquery = "select * from mag_pengelompokan_dospem_tesis WHERE id='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dataku = mysqli_fetch_assoc( $res );
  $id_periode=$dataku['id_periode'];
  ?>
<div class="panel panel-default">
  <div class="panel-body">
    <form action="updatePptDuaUser.php" method="post">
      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
      <input type="text" name="id_periode" class="sr-only" value="<?php echo $dataku['id_periode'];?>" required readonly>
      <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
      <div class="form-group">
        <label for="dospem_tesis2">Dosen pembimbing tesis II yang dipilih:</label>
        <?php
          echo "<select name='dospem_tesis2' class='form-control' required>";
          echo "<option value=''>-Pilih-</option>";
          $tampil = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mag_dospem_tesis WHERE id_periode='$id_periode'" );
          while ( $w = mysqli_fetch_array( $tampil ) ) {
          $mqry = "SELECT * FROM dt_pegawai WHERE id='$w[nip]'";
              $rq = mysqli_query($GLOBALS["___mysqli_ston"], $mqry)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
              $dq = mysqli_fetch_array($rq);
          
          	if ( $dataku['dospem_tesis2'] == $w[ 'id' ] ) {
          		echo "<option value='$w[id]' selected>$dq[nama]</option>";
          	} else {
          		echo "<option value='$w[id]'>$dq[nama]</option>";
          	}
          }
          echo "</select>";
          ?>
      </div>
      <div class="checkbox">
        <label>
        <input type="checkbox" required>&nbsp;Saya menyatakan bahwa isian form ini sudah benar dan sesuai dengan pilihan saya.
        </label>
      </div>
      <button type="submit" class="btn btn-success" name="update">Update</button>
      <button type="reset" class="btn btn-info">Ulang</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </form>
  </div>
</div>