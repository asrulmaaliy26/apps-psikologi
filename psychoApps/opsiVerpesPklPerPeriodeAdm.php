<?php include( "contentsConAdm.php" );?>
<form action='updateVerpesPklPerPeriodeAdm.php' method='post' enctype='multipart/form-data'>
  <input type='text' name='id' class='sr-only' value='<?php echo $id;?>' required readonly>
  <input type='text' name='id_pendaftar' class='sr-only' value='<?php echo $data['id'];?>' required readonly>
  <input type='text' name='page' class='sr-only' value='<?php echo $page;?>' required readonly>
  <select name='val_adm' class='form-control form-control-xs' onchange='this.form.submit();' required>
  <?php
    $tampil = mysqli_query($con,  "SELECT * FROM opsi_validasi ORDER BY nm ASC" );
    while ( $w = mysqli_fetch_array( $tampil ) ) {
      if ( $data['val_adm'] == $w[ 'id' ] ) {
        echo "<option value='$w[id]' selected>$w[nm]</option>";
      } else {
        echo "<option value='$w[id]'>$w[nm]</option>";
      }
    };
    ?>
  </select>
</form>