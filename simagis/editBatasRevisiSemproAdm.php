<?php
include("koneksiAdm.php");
$id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET['id']);

$q = "SELECT a.nim, b.nama, c.batas_revisi 
      FROM mag_peserta_sempro a
      LEFT JOIN mag_dt_mhssw_pasca b ON a.nim = b.nim
      LEFT JOIN mag_jadwal_sempro c ON a.id = c.id_pendaftaran
      WHERE a.id='$id'";
$r = mysqli_query($GLOBALS["___mysqli_ston"], $q) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
$d = mysqli_fetch_assoc($r);
?>
<div class="panel panel-default">
  <div class="panel-body">
    <form action="updateBatasRevisiSemproAdm.php" method="post">
      <input type="hidden" name="id_pendaftaran" value="<?php echo $id; ?>">
      <div class="form-group">
        <label>Nama Mahasiswa | NIM</label>
        <input type="text" class="form-control" value="<?php echo $d['nama'].' | '.$d['nim']; ?>" readonly>
      </div>
      <div class="form-group">
        <label>Batas Akhir Revisi</label>
        <input type="date" class="form-control" name="batas_revisi" value="<?php echo (!empty($d['batas_revisi']) && $d['batas_revisi'] != '0000-00-00') ? $d['batas_revisi'] : ''; ?>" required>
      </div>
      <button type="submit" class="btn btn-primary" onclick="return confirm('Yakin ingin merubah batas revisi mahasiswa ini?')">Simpan Perubahan</button>
    </form>
  </div>
</div>
