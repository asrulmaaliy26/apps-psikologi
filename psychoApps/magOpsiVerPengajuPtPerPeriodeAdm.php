<?php include( "contentsConAdm.php" );?>
<form action="magUpdateVerPengajuPtPerPeriodeAdm.php" method="post" enctype="multipart/form-data">
  <input type="text" name="idPersonal" class="sr-only" value="<?php echo $idPersonal;?>" required readonly>
  <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
  <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
  <input type="text" name="page1" class="sr-only" value="<?php echo $page1;?>" required readonly>
  <select name='verifikasi_admin' class='form-control form-control-xs' onchange='this.form.submit();' required>
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