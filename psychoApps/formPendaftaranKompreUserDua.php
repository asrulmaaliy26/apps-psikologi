<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];

  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  $qry = "SELECT * FROM peserta_kompre WHERE nim='$dataku[nim]' ORDER BY id DESC LIMIT 1";
  $r = mysqli_query($con,  $qry )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $r );
  
  $qry_moment = "SELECT * FROM pendaftaran_kompre WHERE id='$dt[id_kompre]'";
  $hasil = mysqli_query($con, $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_kompre=$data['id'];
  $ta=$data['ta'];
  ?>
<form action="sformPendaftaranKompreUserDua.php" method="post" enctype="multipart/form-data">
  <div class="card-body pb-0">
      <div class="form-group">
        <label for="file_transkrip_nilai">Upload file transkrip nilai (PDF) <span class="text-danger">*</span></label>
        <input type="file" class="form-control form-control-sm" name="file_transkrip_nilai" value="<?php echo $dt['file_transkrip_nilai'];?>" required>
      </div>
    <input type="text" name="id" class="sr-only" value="<?php echo $dt['id'];?>" required readonly>
    <input type="text" name="id_kompre" class="sr-only" value="<?php echo $dt['id_kompre'];?>" required readonly>
  </div>
  <div class="card-footer">
    <button type="submit" class="btn btn-sm btn-danger">Selanjutnya</button>
  </div>
</form>