<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];

  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  $qry = "SELECT * FROM peserta_sempro WHERE nim='$dataku[nim]' ORDER BY id DESC LIMIT 1";
  $r = mysqli_query($con,  $qry )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $r );
  
  $qry_moment = "SELECT * FROM pendaftaran_sempro WHERE id='$dt[id_sempro]'";
  $hasil = mysqli_query($con, $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_sempro=$data['id'];
  $ta=$data['ta'];
  ?>
<form action="sformPendaftaranSemproUserDua.php" method="post" enctype="multipart/form-data">
  <div class="card-body pb-0">
      <div class="form-group">
        <label for="file_prop">Upload file proposal skripsi (PDF) <span class="text-danger">*</span></label>
        <input type="file" class="form-control form-control-sm" name="file_prop" value="<?php echo $dt['file_prop'];?>" required>
      </div>
    <input type="text" name="id" class="sr-only" value="<?php echo $dt['id'];?>" required readonly>
    <input type="text" name="id_sempro" class="sr-only" value="<?php echo $dt['id_sempro'];?>" required readonly>
  </div>
  <div class="card-footer">
    <button type="submit" class="btn btn-sm btn-danger">Selanjutnya</button>
  </div>
</form>