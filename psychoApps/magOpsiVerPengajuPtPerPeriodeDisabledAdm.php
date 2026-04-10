<?php include( "contentsConAdm.php" );?>
<form>
  <select class="form-control form-control-xs" title="Persetujuan dari Kaprodi belum lengkap atau pembimbingan telah selesai." disabled required>
  <?php
    $tampil = mysqli_query($con,  "SELECT * FROM mag_opsi_verifikasi ORDER BY nm ASC" );
    while ( $w = mysqli_fetch_array( $tampil ) ) {
      if ( $data['verifikasi_admin'] == $w[ 'id' ] ) {
        echo "<option value='$w[id]' selected>$w[nm]</option>";
      } else {
        echo "<option value='$w[id]'>$w[nm]</option>";
      }
    }
    ?>
  </select>
</form>