<?php include( "contentsConAdm.php" );?>
<select name='statusform' class='form-control form-control-xs' onchange='this.form.submit();' required disabled title="Proposal Belum Diproses atau Ditolak.">
<?php
  $tampil = mysqli_query($con,  "SELECT * FROM opsi_status_pengajuan_surat ORDER BY id ASC" );
  while ( $w = mysqli_fetch_array( $tampil ) ) {
  if ( $data['statusform'] == $w[ 'id' ] ) {
  echo "<option value='$w[id]' selected>$w[nm]</option>";
  } else {
  echo "<option value='$w[id]'>$w[nm]</option>";
  }
  }
  ?>
</select>