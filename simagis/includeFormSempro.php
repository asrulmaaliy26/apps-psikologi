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
<form action="sformPendSempro.php" method="post" enctype="multipart/form-data">
  <div class="panel panel-info">
    <div class="panel-heading">
      <ul class="list">
        <li>Form ini untuk pendaftaran Seminar Proposal Tesis.</li>
        <li>Isilah form di bawah dengan isian yang benar.</li>
        <li>Tekan button <mark>Submit</mark> di bagian bawah form untuk menyimpan isian Anda.</li>
      </ul>
      <button class="btn btn-danger center-block" type="button" data-toggle="collapse" data-target="#collapseSop" aria-expanded="false" aria-controls="collapseSop">
      Lihat SOP Pendaftaran Seminar Proposal Tesis
      </button>
      <div class="collapse" id="collapseSop">
        <?php 
          $qsop= "select * from mag_sop_pspt";
          $rsop = mysqli_query($GLOBALS["___mysqli_ston"], $qsop)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          $dsop = mysqli_fetch_assoc($rsop);
          echo $dsop ['isi'];
          ?>
      </div>
    </div>
    <div class="panel-body">
      <div class="form-group">
        <label for="judul_prop">Judul proposal tesis:</label>
        <textarea name="judul_prop" class="form-control textinput" id="judul_prop" required></textarea>
      </div>
      <div class="form-group">
        <label for="file_prop">Upload file proposal tesis:</label>
        <input type="file" name="file_prop" class="form-control" id="file_prop" required>
        <p class="help-text small"><code>* Dijadikan satu file berbentuk PDF dan harus sudah bertandatangan sah dari dosen pembimbing tesis</code>.</p>
      </div>
      <div class="form-group">
        <label for="file_turnitin">Upload file lampiran turnitin:</label>
        <input type="file" name="file_turnitin" class="form-control" id="file_turnitin" required>
        <p class="help-text small"><code>* File berbentuk PDF dan angka maksimal similiarity: 25%</code>.</p>
      </div>
      <div class="form-group">
        <label for="file_toefl">Upload file sertifikat TOEFL:</label>
        <input type="file" name="file_toefl" class="form-control" id="file_toefl" required>
        <p class="help-text small"><code>* Dijadikan satu file berbentuk PDF, skor minimal TOEFL (dalam versi tercetak): 450</code>.</p>
      </div>
      <div class="form-group">
        <label for="file_transkrip">Upload file transkrip nilai terakhir:</label>
        <input type="file" name="file_transkrip" class="form-control" id="file_transkrip" required>
        <p class="help-text small"><code>* File berbentuk PDF</code>.</p>
      </div>
      <div class="form-group">
        <label for="file_audien">Bukti keikutsertaan sebagai audien seminar proposal tesis:</label>
        <input type="file" name="file_audien" class="form-control" id="file_audien" required>
        <p class="help-text small"><code>* File berbentuk PDF</code>.</p>
      </div>
      <div class="form-group">
        <label for="file_diseminasi">Bukti diseminasi publik yang telah dicapai:</label>
        <input type="file" name="file_diseminasi" class="form-control" id="file_diseminasi" required>
        <p class="help-text small"><code>* File berbentuk PDF</code>.</p>
      </div>
      <div class="form-group">
        <label for="file_publikasi">Bukti publikasi ilmiah (Jurnal/book chapter/publikasi ilmiah lainnya):</label>
        <input type="file" name="file_publikasi" class="form-control" id="file_publikasi" required>
        <p class="help-text small"><code>* File berbentuk PDF</code>.</p>
      </div>
      <div class="form-group">
        <label for="file_kwitansi">Bukti kwitansi pembayaran seminar proposal tesis:</label>
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
      <input type="text" name="id_sempro" class="sr-only" value="<?php echo $id_sempro;?>" required readonly>
      <input type="text" name="ta" class="sr-only" value="<?php echo $dnta['id'];?>" required readonly>
      <input type="text" name="nim" class="sr-only" value="<?php echo $nim;?>" required readonly>
      <input type="text" name="angkatan" class="sr-only" value="<?php echo $dataku['angkatan'];?>" required readonly>
      <input type="text" name="smt_daftar" class="sr-only" value="<?php echo $dataku['smt_daftar'];?>" required readonly>
      <input type="text" name="dospem_tesis1" class="sr-only" value="<?php echo $ddpt1['id'];?>" required readonly>
      <input type="text" name="dospem_tesis2" class="sr-only" value="<?php echo $ddpt2['id'];?>" required readonly>
      <input type="text" name="cek" class="sr-only" value="1" required readonly>
      <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </div>
  </div>
</form>