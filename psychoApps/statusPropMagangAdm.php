<form action="updateStatuspropSimagAdm.php" method="post" enctype="multipart/form-data">
  <input type="text" name="id" class="sr-only" value="<?php echo $data['id'];?>" required readonly>
  <input type="text" name="date" class="sr-only" value="<?php echo $tahun;?>" required readonly>
  <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
  <select name='validasi_proposal' class='form-control form-control-xs' onchange='this.form.submit();' required>
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
</form>