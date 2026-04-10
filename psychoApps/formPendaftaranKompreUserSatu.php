<?php include("contentsConAdm.php");
$username = $_SESSION['username'];
$myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
$dmhssw = mysqli_query($con, $myquery) or die(mysqli_error($con));
$dataku = mysqli_fetch_assoc($dmhssw);
$oldDate = $dataku['tanggal_lahir'];
$newDate = date("d-m-Y", strtotime($oldDate));

$qry_moment = "SELECT * FROM pendaftaran_kompre WHERE status='1'";
$hasil = mysqli_query($con, $qry_moment);
$data = mysqli_fetch_assoc($hasil);
$id_kompre = $data['id'];
$ta = $data['ta'];
?>
<form action="sformPendaftaranKompreUserSatu.php" method="post" enctype="multipart/form-data" id="formKompreS1">
  <div class="card-body pb-0">
    <div class="form-group">
      <label for="sks_ditempuh">SKS yang telah ditempuh <span class="text-danger">*</span></label>
      <input type="text" class="form-control form-control-sm" name="sks_ditempuh" id="sks_ditempuh" required>
    </div>
    <input type="text" name="nim" class="sr-only" value="<?php echo $dataku['nim']; ?>" required readonly>
    <input type="text" name="angkatan" class="sr-only" value="<?php echo $dataku['angkatan']; ?>" required readonly>
    <input type="text" name="id_kompre" class="sr-only" value="<?php echo $id_kompre; ?>" required readonly>
    <input type="text" name="val_adm" class="sr-only" value="1" required readonly>
    <input type="text" name="statusform" class="sr-only" value="1" required readonly>
    <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y"); ?>" required readonly>
  </div>
  <div class="card-footer">
    <button type="submit" class="btn btn-sm btn-danger btn-submit">Selanjutnya</button>
  </div>
</form>

<script>
  $(document).ready(function() {
    $('#formKompreS1').on('submit', function() {
      $('.btn-submit').attr('disabled', 'disabled');
      $('.btn-submit').html('<i class="fas fa-spinner fa-spin mr-1"></i> Memproses...');
    });
  });
</script>