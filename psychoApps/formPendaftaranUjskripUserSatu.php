<?php include("contentsConAdm.php");
$username = $_SESSION['username'];
$myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
$dmhssw = mysqli_query($con, $myquery) or die(mysqli_error($con));
$dataku = mysqli_fetch_assoc($dmhssw);
$nim = $dataku['nim'];
$oldDate = $dataku['tanggal_lahir'];
$newDate = date("d-m-Y", strtotime($oldDate));

$q = "SELECT * FROM pengelompokan_dospem_skripsi WHERE nim='$dataku[nim]'";
$r = mysqli_query($con, $q) or die(mysqli_error($con));
$dt = mysqli_fetch_assoc($r);

$qry_moment = "SELECT * FROM pendaftaran_skripsi WHERE status='1'";
$hasil = mysqli_query($con, $qry_moment);
$data = mysqli_fetch_assoc($hasil);
$id_ujskrip = $data['id'];
$ta = $data['ta'];
?>
<form action="sformPendaftaranUjskripUserSatu.php" method="post" enctype="multipart/form-data" id="formUjSkripS1">
  <div class="card-body pb-0">
    <div class="form-group">
      <label for="judul_skripsi">Judul skripsi <span class="text-danger">*</span></label>
      <textarea id="textarea-custom-one" name="judul_skripsi" class="form-control form-control-sm" style="height: 300px;" required></textarea>
      <p class="help-block small"><strong>Judul skripsi harus ditulis dengan benar atau pendaftaran ditolak.</strong></p>
    </div>
    <input type="text" name="nim" class="sr-only" value="<?php echo $dataku['nim']; ?>" required readonly>
    <input type="text" name="angkatan" class="sr-only" value="<?php echo $dataku['angkatan']; ?>" required readonly>
    <input type="text" name="pembimbing1" class="sr-only" value="<?php echo $dt['dospem_skripsi1']; ?>" required readonly>
    <input type="text" name="pembimbing2" class="sr-only" value="<?php echo $dt['dospem_skripsi2']; ?>" required readonly>
    <input type="text" name="id_ujskrip" class="sr-only" value="<?php echo $id_ujskrip; ?>" required readonly>
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
    $('#formUjSkripS1').on('submit', function() {
      $('.btn-submit').attr('disabled', 'disabled');
      $('.btn-submit').html('<i class="fas fa-spinner fa-spin mr-1"></i> Memproses...');
    });
  });
</script>