<?php
  include("koneksiUser.php");
  $nim = $_SESSION['nim'];
  
  $qdpt = "select * from mag_pengelompokan_dospem_tesis WHERE nim='$nim'";
  $rdpt = mysqli_query($GLOBALS["___mysqli_ston"], $qdpt)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $ddpt = mysqli_fetch_assoc($rdpt);
  
  $nm_dospem1 = "";
  if($ddpt && isset($ddpt['dospem_tesis1']) && $ddpt['dospem_tesis1']) {
    $qdpt1 = "select * from mag_dospem_tesis JOIN dt_pegawai ON mag_dospem_tesis.nip=dt_pegawai.id WHERE mag_dospem_tesis.id='$ddpt[dospem_tesis1]'";
    $rdpt1 = mysqli_query($GLOBALS["___mysqli_ston"], $qdpt1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
    $ddpt1 = mysqli_fetch_assoc($rdpt1);
    $nm_dospem1 = $ddpt1['nama'];
  }
  
  $nm_dospem2 = "";
  if($ddpt && isset($ddpt['dospem_tesis2']) && $ddpt['dospem_tesis2']) {
    $qdpt2 = "select * from mag_dospem_tesis JOIN dt_pegawai ON mag_dospem_tesis.nip=dt_pegawai.id WHERE mag_dospem_tesis.id='$ddpt[dospem_tesis2]'";
    $rdpt2 = mysqli_query($GLOBALS["___mysqli_ston"], $qdpt2)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
    $ddpt2 = mysqli_fetch_assoc($rdpt2);
    $nm_dospem2 = $ddpt2['nama'];
  }

  // Fetch all S2 supervisors for datalist based on mengajar_pasca='2'
  $q_list_dosen = "SELECT nama FROM dt_pegawai WHERE mengajar_pasca='2' ORDER BY nama ASC";
  $r_list_dosen = mysqli_query($GLOBALS["___mysqli_ston"], $q_list_dosen);
  $list_dosen = [];
  while($row_dosen = mysqli_fetch_assoc($r_list_dosen)) {
    $list_dosen[] = $row_dosen['nama'];
  }
  ?>
<form action="sformThesisCamp.php" method="post">
  <div class="panel panel-info">
    <div class="panel-heading">
      <h4 class="text-center">Form Pendaftaran Thesis Camp</h4>
      <p class="text-center"><strong>Anda saat ini semester <?php echo $smt_calculated; ?></strong></p>
    </div>
    <div class="panel-body">
      <div class="form-group">
        <label for="topik">Topik atau Judul Penelitian:</label>
        <textarea name="topik" class="form-control" id="topik" rows="3" required></textarea>
      </div>
      
      <div class="form-group">
        <label for="dospem1">Pembimbing 1:</label>
        <input type="text" name="dospem1" class="form-control" id="dospem1" list="listDosen1" value="<?php echo $nm_dospem1; ?>">
        <datalist id="listDosen1">
          <?php foreach($list_dosen as $dosen) { echo "<option value='$dosen'>"; } ?>
        </datalist>
        <p class="help-block small">* Pilih dari list atau ketik manual jika tidak ada</p>
      </div>
      
      <div class="form-group">
        <label for="dospem2">Pembimbing 2:</label>
        <input type="text" name="dospem2" class="form-control" id="dospem2" list="listDosen2" value="<?php echo $nm_dospem2; ?>">
        <datalist id="listDosen2">
          <?php foreach($list_dosen as $dosen) { echo "<option value='$dosen'>"; } ?>
        </datalist>
        <p class="help-block small">* Pilih dari list atau ketik manual jika tidak ada</p>
      </div>
      
      <div class="form-group">
        <label for="tahapan">Tahapan:</label>
        <select name="tahapan" class="form-control" id="tahapan" required>
          <option value="">- Pilih Tahapan -</option>
          <option value="Ujian Proposal">Ujian Proposal</option>
          <option value="Ujian Tesis">Ujian Tesis</option>
        </select>
      </div>
      
      <div class="form-group">
        <label for="harapan">Harapan Mengikuti Thesis Camp:</label>
        <textarea name="harapan" class="form-control" id="harapan" rows="4" required></textarea>
      </div>
      
      <div class="checkbox">
        <label>
          <input type="checkbox" required> Saya menyatakan data yang saya isi adalah benar.
        </label>
      </div>
    </div>
    <div class="panel-footer">
      <input type="hidden" name="id_tc" value="<?php echo $id_tc; ?>">
      <input type="hidden" name="nim" value="<?php echo $nim; ?>">
      <button type="submit" class="btn btn-primary btn-block" name="submit">Daftar Thesis Camp</button>
    </div>
  </div>
</form>
