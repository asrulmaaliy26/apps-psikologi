<?php
  include( "koneksiUser.php" );
  $nim = $_SESSION['nim'];
  
  $myquery = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
  $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  $qta = "select * from mag_dt_ta WHERE status='1'";
  $rta = mysqli_query($GLOBALS["___mysqli_ston"], $qta)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dta = mysqli_fetch_assoc($rta);   
   
  $qwd1 = "select * from dt_pegawai WHERE jabatan_instansi = '2'";
  $rwd1 = mysqli_query($GLOBALS["___mysqli_ston"], $qwd1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dwd1 = mysqli_fetch_assoc($rwd1);   
   
  $qkaprodi = "select * from dt_pegawai WHERE jabatan_instansi = '36'";
  $rkaprodi = mysqli_query($GLOBALS["___mysqli_ston"], $qkaprodi)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dkaprodi = mysqli_fetch_assoc($rkaprodi);   
  ?>
<div class="panel panel-info">
  <div class="panel-heading">
    <ul class="list">
      <li>Form ini adalah pilihan peminatan rumpun psikologi.</li>
      <li>Silahkan pilih peminatan rumpun psikologi yang sesuai dengan minat Anda.</li>
      <li>Tekan button <mark>Submit</mark> di bagian bawah form untuk menyimpan pilihan Anda.</li>
    </ul>
    <button class="btn btn-danger center-block" type="button" data-toggle="collapse" data-target="#collapseSop" aria-expanded="false" aria-controls="collapseSop">
    Lihat SOP Pengajuan Peminatan Rumpun Psikologi
    </button>
    <div class="collapse" id="collapseSop">
      <?php 
        $qsop= "select * from mag_sop_pprp";
        $rsop = mysqli_query($GLOBALS["___mysqli_ston"], $qsop)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
        $dsop = mysqli_fetch_assoc($rsop);
        echo $dsop ['isi'];
        ?>
    </div>
  </div>
  <div class="panel-body">
    <form action="sformPprp.php" method="post">
      
      <div class="form-group">
        <label for="rumpun">Peminatan Rumpun Psikologi yang dipilih:</label>
        <select name="rumpun" class="form-control" required>
          <option value="">-Pilih-</option>
          <?php
            $q = mysqli_query($GLOBALS["___mysqli_ston"], "select * from mag_opsi_rumpun ORDER BY nm ASC");
            while ($tampil = mysqli_fetch_array($q)){
              echo "<option value='$tampil[id]'>$tampil[nm]</option>";
            }
            ?>
        </select>
      </div>
      <div class="form-group">
        <label for="tgl_pengajuan">Tanggal pengajuan:</label>
        <input type="text" class="form-control" id="tgl_pengajuan" value="<?php echo date("d-m-Y");?>" disabled>
		<input type="text" name="nim" class="sr-only" value="<?php echo $dataku['nim'];?>" required readonly>
		<input type="text" name="angkatan" class="sr-only" value="<?php echo $dataku['angkatan'];?>" required readonly>
        <input type="text" name="ta" class="sr-only" value="<?php echo $dta['id'];?>" required readonly>
		<input type="text" name="wd1" class="sr-only" value="<?php echo $dwd1['id'];?>" required readonly>
        <input type="text" name="kaprodi" class="sr-only" value="<?php echo $dkaprodi['id'];?>" required readonly>            
		<input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
      </div>
      <div class="checkbox">
        <label>
        <input type="checkbox" id="checked" required>&nbsp;Saya menyatakan bahwa isian form ini sudah benar dan sesuai dengan pilihan saya.
        </label>
      </div>
  </div>
  <div class="panel-footer">
  <input type="text" name="cek" class="sr-only" value="1" required readonly>
  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
  </div>
  </form>
</div>