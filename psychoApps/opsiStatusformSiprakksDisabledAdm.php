<?php include( "contentsConAdm.php" );?>
<form action="updateStatusformSiprakksAdm.php" method="post" enctype="multipart/form-data">
  <input type="text" name="id" class="sr-only" value="<?php echo $data['id'];?>" required readonly>
  <input type="text" name="date" class="sr-only" value="<?php echo $tahun;?>" required readonly>
  <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
  <select name='statusform' class='form-control form-control-xs' onclick='return confirm("Catatan hanya diberikan jika status surat ditolak!")' disabled>
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
</form>