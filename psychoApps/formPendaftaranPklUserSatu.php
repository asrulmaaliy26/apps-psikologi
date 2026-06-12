<?php include("contentsConAdm.php");
$username = $_SESSION['username'];
$myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
$dmhssw = mysqli_query($con, $myquery) or die(mysqli_error($con));
$dataku = mysqli_fetch_assoc($dmhssw);

$qry_moment = "SELECT * FROM pendaftaran_pkl WHERE status='1'";
$hasil = mysqli_query($con, $qry_moment);
$data = mysqli_fetch_assoc($hasil);
$id_pkl = $data['id'];
$ta = $data['ta'];
?>
<form action="sformPendaftaranPklUserSatu.php" method="post" enctype="multipart/form-data" id="formPklS1">
  <div class="card-body pb-0">
    <div class="form-row">
      <div class="form-group col-sm-4">
        <label for="jenis_pkl">Jenis PKL <span class="text-danger">*</span></label>
        <select name="jenis_pkl" class="form-control form-control-sm" required>
          <option value="">-Pilih-</option>
          <option value="Internasional">Internasional</option>
          <option value="Reguler">Reguler</option>
        </select>
      </div>
      <div class="form-group col-sm-4">
        <label for="peminatan">Peminatan <span class="text-danger">*</span></label>
        <select name="peminatan" class="form-control form-control-sm" required>
          <option value="">-Pilih-</option>
          <option value="Psikologi Klinis">Psikologi Klinis</option>
          <option value="Psikologi Industri dan Organisasi">Psikologi Industri dan Organisasi</option>
          <option value="Psikologi Pendidikan">Psikologi Pendidikan</option>
          <option value="Psikologi Sosial">Psikologi Sosial</option>
        </select>
      </div>
      <div class="form-group col-sm-4">
        <label for="dpl">Dosen Pembimbing Lapangan (DPL) <span class="text-danger">*</span></label>
        <?php
        echo "<select class='form-control form-control-sm' name='id_dpl' required>";
        echo "<option value=''>-Pilih DPL-</option>";
        $tampil = mysqli_query($con, "SELECT * FROM dt_pegawai WHERE jenis_pegawai = '1' ORDER BY nama ASC");
        while ($w = mysqli_fetch_array($tampil)) {
          echo "<option value='$w[id]'>$w[nama]</option>";
        }
        echo "</select>";
        ?>
      </div>
    </div>
    
    <div class="form-row">
      <div class="form-group col-sm-4">
        <label for="nama_instansi">Nama Instansi <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm" name="nama_instansi" required>
      </div>
      <div class="form-group col-sm-8">
        <label for="alamat_instansi">Alamat Instansi <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm" name="alamat_instansi" required>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group col-sm-6">
        <label for="sks_lalu">Total SKS telah diambil <span class="text-danger">*</span></label>
        <input type="number" class="form-control form-control-sm" name="sks_lalu" required>
      </div>
      <div class="form-group col-sm-6">
        <label for="sks_smt_berjalan">SKS diambil semester ini <span class="text-danger">*</span></label>
        <input type="number" class="form-control form-control-sm" name="sks_smt_berjalan" required>
      </div>
    </div>
    
    <div class="form-row">
      <div class="form-group col-sm-12">
        <label for="file_pembekalan">Upload Tugas Pembekalan PKL (PDF) <span class="text-danger">*</span></label>
        <input type="file" accept="application/pdf" class="form-control form-control-sm" name="file_pembekalan" required>
      </div>
    </div>

    <input type="text" name="nim" class="sr-only" value="<?php echo $dataku['nim']; ?>" required readonly>
    <input type="text" name="angkatan" class="sr-only" value="<?php echo $dataku['angkatan']; ?>" required readonly>
    <input type="text" name="id_pkl" class="sr-only" value="<?php echo $id_pkl; ?>" required readonly>
    <input type="text" name="val_adm" class="sr-only" value="2" required readonly>
    <input type="text" name="statusform" class="sr-only" value="1" required readonly>
    <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y"); ?>" required readonly>
  </div>
  <div class="card-footer">
    <button type="submit" class="btn btn-sm btn-danger btn-submit">Simpan Pendaftaran</button>
  </div>
</form>

<script>
  $(document).ready(function() {
    $('#formPklS1').on('submit', function() {
      $('.btn-submit').attr('disabled', 'disabled');
      $('.btn-submit').html('<i class="fas fa-spinner fa-spin mr-1"></i> Memproses...');
    });
  });
</script>