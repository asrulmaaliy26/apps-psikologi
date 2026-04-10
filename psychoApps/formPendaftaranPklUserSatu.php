<?php include("contentsConAdm.php");
$username = $_SESSION['username'];
$myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
$dmhssw = mysqli_query($con, $myquery) or die(mysqli_error($con));
$dataku = mysqli_fetch_assoc($dmhssw);
$oldDate = $dataku['tanggal_lahir'];
$newDate = date("d-m-Y", strtotime($oldDate));

$qry_moment = "SELECT * FROM pendaftaran_pkl WHERE status='1'";
$hasil = mysqli_query($con, $qry_moment);
$data = mysqli_fetch_assoc($hasil);
$id_pkl = $data['id'];
$ta = $data['ta'];
?>
<form action="sformPendaftaranPklUserSatu.php" method="post" enctype="multipart/form-data" id="formPklS1">
  <div class="card-body pb-0">
    <div class="form-row">
      <div class="form-group col-sm-2">
        <label for="jenis_pkl">Pilihan jenis PKL <span class="text-danger">*</span></label>
        <select name="jenis_pkl" class="form-control form-control-sm" required>
          <option value="">-Pilih-</option>
          <?php
          $q = mysqli_query($con, "SELECT * FROM opsi_jenis_pkl ORDER BY id ASC");
          while ($tampil = mysqli_fetch_array($q)) {
            echo "<option value='$tampil[id]'>$tampil[nm]</option>";
          }
          ?>
        </select>
      </div>
      <div class="form-group col-sm-4">
        <label for="dosen_wali">Dosen wali <span class="text-danger">*</span></label>
        <?php
        echo "<select class='form-control form-control-sm' name='dosen_wali' required>";
        echo "<option value=''>-Pilih-</option>";
        $tampil = mysqli_query($con,  "SELECT * FROM dt_pegawai WHERE jenis_pegawai = '1' ORDER BY nama ASC");
        while ($w = mysqli_fetch_array($tampil)) {
          if ($dataku['dosen_wali'] == $w['id']) {
            echo "<option value='$w[id]' selected>$w[nama]</option>";
          } else {
            echo "<option value='$w[id]'>$w[nama]</option>";
          }
        }
        echo "</select>";
        ?>
      </div>
      <div class="form-group col-sm-2">
        <label for="tempat_lahir">Tempat lahir <span class="text-danger">*</span></label>
        <?php
        echo "<select class='form-control form-control-sm' name='tempat_lahir' required>";
        echo "<option value=''>-Pilih-</option>";
        $tampil = mysqli_query($con,  "SELECT * FROM dt_kota ORDER BY nm_kota ASC");
        while ($w = mysqli_fetch_array($tampil)) {
          if ($dataku['tempat_lahir'] == $w['id']) {
            echo "<option value='$w[id]' selected>$w[nm_kota]</option>";
          } else {
            echo "<option value='$w[id]'>$w[nm_kota]</option>";
          }
        }
        echo "</select>";
        ?>
      </div>
      <div class="form-group col-sm-2">
        <label for="tanggal_lahir">Tanggal lahir <span class="text-danger">*</span></label>
        <div class="input-group date" id="tgl_dmy_one" data-target-input="nearest">
          <input type="text" name="tanggal_lahir" class="form-control form-control-sm datetimepicker-input" data-target="#tgl_dmy_one" value="<?php echo $newDate; ?>" required />
          <div class="input-group-append" data-target="#tgl_dmy_one" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fas fa-calendar-alt"></i></div>
          </div>
        </div>
      </div>
      <div class="form-group col-sm-2">
        <label for="jenis_kelamin">Jenis kelamin <span class="text-danger">*</span></label>
        <?php
        echo "<select class='form-control form-control-sm' name='jenis_kelamin' required>";
        echo "<option value=''>-Pilih-</option>";
        $tampil = mysqli_query($con,  "SELECT * FROM jns_kelamin ORDER BY id ASC");
        while ($w = mysqli_fetch_array($tampil)) {
          if ($dataku['jenis_kelamin'] == $w['id']) {
            echo "<option value='$w[id]' selected>$w[nm]</option>";
          } else {
            echo "<option value='$w[id]'>$w[nm]</option>";
          }
        }
        echo "</select>";
        ?>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-sm-5">
        <label for="alamat_ktp">Alamat asal <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm" name="alamat_ktp" value="<?php echo $dataku['alamat_ktp']; ?>" required>
      </div>
      <div class="form-group col-sm-5">
        <label for="alamat_malang">Alamat di Malang <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm" name="alamat_malang" value="<?php echo $dataku['alamat_malang']; ?>" required>
      </div>
      <div class="form-group col-sm-2">
        <label for="kntk">Kontak HP <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm" name="kntk" value="<?php echo $dataku['kntk']; ?>" required>
      </div>
    </div>
    <div class="form-row">
      <div class="form-group col-sm-3">
        <label for="kontak_lain">Kontak HP orang terdekat <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm" name="kontak_lain" required>
      </div>
      <div class="form-group col-sm-3">
        <label for="sks_lalu">Total SKS telah diambil <span class="text-danger">*</span></label>
        <input type="number" class="form-control form-control-sm" name="sks_lalu" required>
      </div>
      <div class="form-group col-sm-3">
        <label for="sks_smt_berjalan">SKS diambil semester ini <span class="text-danger">*</span></label>
        <input type="number" class="form-control form-control-sm" name="sks_smt_berjalan" required>
      </div>
      <div class="form-group col-sm-3">
        <label for="riwayat_penyakit">Riwayat penyakit</label>
        <input type="text" class="form-control form-control-sm" name="riwayat_penyakit">
      </div>
    </div>
    <input type="text" name="nim" class="sr-only" value="<?php echo $dataku['nim']; ?>" required readonly>
    <input type="text" name="angkatan" class="sr-only" value="<?php echo $dataku['angkatan']; ?>" required readonly>
    <input type="text" name="id_pkl" class="sr-only" value="<?php echo $id_pkl; ?>" required readonly>
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
    $('#formPklS1').on('submit', function() {
      $('.btn-submit').attr('disabled', 'disabled');
      $('.btn-submit').html('<i class="fas fa-spinner fa-spin mr-1"></i> Memproses...');
    });
  });
</script>