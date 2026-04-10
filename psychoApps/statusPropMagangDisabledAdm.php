<?php include( "contentsConAdm.php" );?>
<select name='validasi_proposal' class='form-control form-control-xs' onchange='this.form.submit();' required disabled title="Permohonan surat sudah diterima.">
<?php
  $tampil = mysqli_query($con,  "SELECT * FROM opsi_validasi ORDER BY id ASC" );
  while ( $w = mysqli_fetch_array( $tampil ) ) {
  if ( $data['validasi_proposal'] == $w[ 'id' ] ) {
  echo "<option value='$w[id]' selected>$w[nm]</option>";
  } else {
  echo "<option value='$w[id]'>$w[nm]</option>";
  }
  }
  ?>
</select>