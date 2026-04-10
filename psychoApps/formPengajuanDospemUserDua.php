<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  $qry = "SELECT * FROM pengelompokan_dospem_skripsi WHERE nim='$dataku[nim]'";
  $r = mysqli_query($con,  $qry )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $r );
  
  $qry_moment = "SELECT * FROM pengajuan_dospem WHERE status='1'";
  $hasil = mysqli_query($con, $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_periode=$data['id'];
  $ta=$data['ta'];
  ?>
<form action="sformPengajuanDospemUserDua.php" method="post" enctype="multipart/form-data">
  <div class="card-body pb-0">
    <div class="form-row">
      <div class="form-group col-sm-4">
        <label for="file_prop">Upload file proposal skripsi (PDF) <span class="text-danger">*</span></label>
        <input type="file" class="form-control form-control-sm" name="file_prop" value="<?php echo $dt['file_prop'];?>" required>
      </div>
      <div class="form-group col-sm-4">
        <label for="file_transkrip">Upload file transkrip nilai sementara (PDF) <span class="text-danger">*</span></label>
        <input type="file" class="form-control form-control-sm" name="file_transkrip" value="<?php echo $dt['file_transkrip'];?>" required>
      </div>
      <div class="form-group col-sm-4">
        <label for="file_toefl_toafl">Upload file TOEFL/TOAFL (PDF) <span class="text-danger">*</span></label>
        <input type="file" class="form-control form-control-sm" name="file_toefl_toafl" value="<?php echo $dt['file_toefl_toafl'];?>" required>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-sm-6">
        <label for="file_tashih">Upload file tashih al-Quran (PDF) <span class="text-danger">*</span></label>
        <input type="file" class="form-control form-control-sm" name="file_tashih" value="<?php echo $dt['file_tashih'];?>" required>
      </div>
      <div class="form-group col-sm-6">
        <label for="file_ukt">Upload file bukti pembayaran UKT semester ini (PDF) <span class="text-danger">*</span></label>
        <input type="file" class="form-control form-control-sm" name="file_ukt" value="<?php echo $dt['file_ukt'];?>" required>
      </div>
    </div>
    <input type="text" name="id" class="sr-only" value="<?php echo $dt['id'];?>" required readonly>
  </div>
  <div class="card-footer">
    <button type="submit" class="btn btn-sm btn-danger">Selanjutnya</button>
  </div>
</form>