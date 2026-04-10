<?php
  include("koneksiUser.php");
  $nim = $_SESSION['nim'];
  
  $myquery = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
  $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  $qdpt = "select * from mag_pengelompokan_dospem_tesis WHERE nim='$nim'";
  $ddpt = mysqli_query($GLOBALS["___mysqli_ston"], $qdpt)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $ddpt = mysqli_fetch_assoc($ddpt);
  
  $qdpt1 = "select * from mag_dospem_tesis JOIN dt_pegawai ON mag_dospem_tesis.nip=dt_pegawai.id WHERE mag_dospem_tesis.id='$ddpt[dospem_tesis1]'";
  $ddpt1 = mysqli_query($GLOBALS["___mysqli_ston"], $qdpt1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $ddpt1 = mysqli_fetch_assoc($ddpt1);
  
  $qdpt2 = "select * from mag_dospem_tesis JOIN dt_pegawai ON mag_dospem_tesis.nip=dt_pegawai.id WHERE mag_dospem_tesis.id='$ddpt[dospem_tesis2]'";
  $ddpt2 = mysqli_query($GLOBALS["___mysqli_ston"], $qdpt2)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $ddpt2 = mysqli_fetch_assoc($ddpt2);  
  ?>
<div class="panel panel-info">
  <div class="panel-heading">
    <ul class="list">
      <li>Form ini untuk pendaftaran Ujian Tesis.</li>
      <li>Isilah form di bawah dengan isian yang benar.</li>
      <li>Tekan button <mark>Submit</mark> di bagian bawah form untuk menyimpan isian Anda.</li>
    </ul>
    <button class="btn btn-danger center-block" type="button" data-toggle="collapse" data-target="#collapseSop" aria-expanded="false" aria-controls="collapseSop">
    Lihat SOP Pendaftaran Ujian Tesis
    </button>
    <div class="collapse" id="collapseSop">
      <?php 
        $qsop= "select * from mag_sop_put";
        $rsop = mysqli_query($GLOBALS["___mysqli_ston"], $qsop)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
        $dsop = mysqli_fetch_assoc($rsop);
        echo $dsop ['isi'];
        ?>
    </div>
  </div>
  <div class="panel-body">
    <form action="sformPendUjtes.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="judul_tesis">Judul ujian tesis:</label>
        <textarea name="judul_tesis" class="form-control textinput" id="judul_tesis" required></textarea>
      </div>
      <div class="form-group">
        <label for="file_tesis">Upload file tesis:</label>
        <input type="file" name="file_tesis" class="form-control" id="file_tesis" required>
        <p class="help-text small"><code>* Dijadikan satu file berbentuk PDF dan harus sudah bertandatangan sah dari dosen pembimbing tesis</code>.</p>
      </div>
      <div class="form-group">
        <label for="file_turnitin">Upload file lampiran turnitin:</label>
        <input type="file" name="file_turnitin" class="form-control" id="file_turnitin" required>
        <p class="help-text small"><code>* File berbentuk PDF dan angka maksimal similiarity: 25%</code>.</p>
      </div>
      <div class="form-group">
        <label for="file_transkrip">Upload file transkrip nilai terakhir:</label>
        <input type="file" name="file_transkrip" class="form-control" id="file_transkrip" required>
        <p class="help-text small"><code>* File berbentuk PDF</code>.</p>
      </div>      
      <div class="form-group">
        <label for="file_jurnal">Upload file jurnal (jurnal dari tesis yang disetujui pembimbing):</label>
        <input type="file" name="file_jurnal" class="form-control" id="file_jurnal" required>
        <p class="help-text small"><code>* File berbentuk PDF</code>.</p>
      </div>
      <div class="form-group">
        <label for="file_contoh_jurnal">Upload file contoh tulisan jurnal yang dituju:</label>
        <input type="file" name="file_contoh_jurnal" class="form-control" id="file_contoh_jurnal" required>
        <p class="help-text small"><code>* File berbentuk PDF</code>.</p>
      </div>
      <div class="form-group">
        <label for="file_kwitansi">Bukti kwitansi pembayaran ujian tesis:</label>
        <input type="file" name="file_kwitansi" class="form-control" id="file_kwitansi" required>
        <p class="help-text small"><code>* File berbentuk PDF</code>.</p>
      </div>
      <div class="form-group">
        <label for="dospem_tesis1">Dosen pembimbing tesis I:</label>
        <input type="text" class="form-control" id="dospem_tesis1" value="<?php echo $ddpt1['nama'];?>" required disabled>
      </div>
      <div class="form-group">
        <label for="dospem_tesis2">Dosen pembimbing tesis II:</label>
        <input type="text" class="form-control" id="dospem_tesis2" value="<?php echo $ddpt2['nama'];?>" required disabled>
      </div>
      <div class="form-group">
        <label for="tgl_pendaftaran">Tanggal pendaftaran:</label>
        <input type="text" class="form-control" id="tgl_pendaftaran" value="<?php echo date("d-m-Y");?>" disabled>
        <input type="text" name="tgl_pendaftaran" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
      </div>
      <div class="checkbox">
        <label>
        <input type="checkbox" id="checked" required>&nbsp;Saya menyatakan bahwa isian form ini sudah benar.
        </label>
      </div>
  </div>
  <div class="panel-footer">
  <input type="text" name="id_ujtes" class="sr-only" value="<?php echo $id_ujtes;?>" required readonly>
  <input type="text" name="ta" class="sr-only" value="<?php echo $dnta['id'];?>" required readonly>
  <input type="text" name="nim" class="sr-only" value="<?php echo $nim;?>" required readonly>
  <input type="text" name="angkatan" class="sr-only" value="<?php echo $dataku['angkatan'];?>" required readonly>
  <input type="text" name="smt_daftar" class="sr-only" value="<?php echo $dataku['smt_daftar'];?>" required readonly>
  <input type="text" name="dospem_tesis1" class="sr-only" value="<?php echo $ddpt1['id'];?>" required readonly>
  <input type="text" name="dospem_tesis2" class="sr-only" value="<?php echo $ddpt2['id'];?>" required readonly>
  <input type="text" name="cek" class="sr-only" value="1" required readonly>
  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
  </div>
  </form>
</div>
<script type="text/javascript" src="tinymce/tinymce.min.js"></script>