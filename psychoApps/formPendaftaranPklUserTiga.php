<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  $qry = "SELECT * FROM peserta_pkl WHERE nim='$dataku[nim]' ORDER BY id DESC LIMIT 1";
  $r = mysqli_query($con,  $qry )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $r );
  
  $qry_moment = "SELECT * FROM pendaftaran_pkl WHERE id='$dt[id_pkl]'";
  $hasil = mysqli_query($con, $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_pkl=$data['id'];
  $ta=$data['ta'];
  ?>
<form action="sformPendaftaranPklUserTiga.php" method="post" enctype="multipart/form-data">
  <div class="card-body pb-0">
    <div class="form-group">
      <label for="id_dpl"><?php if(empty($dt['id_dpl'])) {echo 'Lokasi PKL yang dipilih';} else {echo 'Ganti lokasi PKL';}?></label>
      <select class='form-control form-control-sm' name='id_dpl' <?php if(empty($dt['id_dpl'])) {echo 'required';} else {echo '';}?>>
      <?php
        echo "<option value=''>-Pilih-</option>";
        $tampil = mysqli_query($con,  "SELECT * FROM dpl_pkl WHERE id_pkl='$dt[id_pkl]' AND (kuota > terisi) ORDER BY lokasi ASC" );
        while ( $w = mysqli_fetch_array( $tampil ) ) {
           if ( $dt['id_dpl'] == $w[ 'id' ] ) {
              echo "<option value='$w[id]' selected>$w[lokasi]</option>";
           } else {
              echo "<option value='$w[id]'>$w[lokasi]</option>";
           }
        }
        echo "</select>";
        ?>
    </div>
    <input type="text" name="id" class="sr-only" value="<?php echo $dt['id'];?>" required readonly>
    <input type="text" name="id_pkl" class="sr-only" value="<?php echo $id_pkl;?>" required readonly>
  </div>
  <div class="card-footer">
    <button type="submit" class="btn btn-sm btn-danger">Selanjutnya</button>
  </div>
</form>