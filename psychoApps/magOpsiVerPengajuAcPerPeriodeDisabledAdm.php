<?php include( "contentsConAdm.php" );?>
<form>
  <select class="form-control form-control-xs" title="Coaching telah selesai." disabled required>
  <?php
    $tampil = mysqli_query($con,  "SELECT * FROM mag_opsi_verifikasi ORDER BY nm ASC" );
    while ( $w = mysqli_fetch_array( $tampil ) ) {
      if ( $data['cek'] == $w[ 'id' ] ) {
        echo "<option value='$w[id]' selected>$w[nm]</option>";
      } else {
        echo "<option value='$w[id]'>$w[nm]</option>";
      }
    }
    ?>
  </select>
</form>