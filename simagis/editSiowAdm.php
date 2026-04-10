<?php
  include( "koneksiAdm.php" );
    
  $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
  $myquery = "select * from mag_siowi WHERE id='$id'";
  $res = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dataku = mysqli_fetch_assoc( $res );
  
  $qry = "select * from mag_dt_mhssw_pasca WHERE nim='$dataku[nim]'";
  $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qry )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $dt = mysqli_fetch_assoc( $resp );
  
  $query = "select * from mag_tembusan_surat_ak LIMIT 1";
  $r = mysqli_query($GLOBALS["___mysqli_ston"],  $query )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
  $d = mysqli_fetch_assoc( $r );

  $qwd1 = "select * from dt_pegawai WHERE jabatan_instansi = '2'";
  $rwd1 = mysqli_query($GLOBALS["___mysqli_ston"], $qwd1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dwd1 = mysqli_fetch_assoc($rwd1);
  
  $qkp2 = "select * from dt_pegawai WHERE jabatan_instansi = '36'";
  $rkp2 = mysqli_query($GLOBALS["___mysqli_ston"], $qkp2)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dkp2 = mysqli_fetch_assoc($rkp2);
   ?>
<div class="panel panel-default">
  <div class="panel-body">
    <form action="updateSiowAdm.php" method="post">
      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
      <?php 
        if($dataku['tgl_dikeluarkan']=='0000-00-00') {
        echo '<input type="text" name="tgl_dikeluarkan" id="tgl_dikeluarkan" class="sr-only" value="'.date("Y-m-d").'" required>';}
        else {
        echo '<input type="text" name="tgl_dikeluarkan" id="tgl_dikeluarkan" class="sr-only" value="'.$dataku['tgl_dikeluarkan'].'" required>';}
        ?>
      <input type="text" name="wd1" class="sr-only" value="<?php echo $dwd1['id'];?>" required readonly>
      <input type="text" name="kp2" class="sr-only" value="<?php echo $dkp2['id'];?>" required readonly>
      <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
      <div class="form-group">
        <label for="lembaga_tujuan_surat">Instansi/Lembaga Tujuan Surat</label>
        <input type="text" name="lembaga_tujuan_surat" class="form-control" id="lembaga_tujuan_surat" placeholder="Contoh: Bagian Akademik Universitas Islam Negeri Maulana Malik Ibrahim Malang, dll." value="<?php echo $dataku['lembaga_tujuan_surat'];?>" required>
      </div>
      <div class="form-group">
        <label for="sebutan_pimpinan">Sebutan Pimpinan untuk Instansi/Lembaga Tujuan Surat</label>
        <?php
          echo "<select name='sebutan_pimpinan' class='form-control' required>";
          echo "<option value=''>-Pilih-</option>";
          $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM opsi_sebutan_pimpinan ORDER BY nm ASC" );
          while ( $w = mysqli_fetch_array( $tampil ) ) {
            if ( $dataku['sebutan_pimpinan'] == $w[ 'id' ] ) {
              echo "<option value='$w[id]' selected>$w[nm]</option>";
            } else {
              echo "<option value='$w[id]'>$w[nm]</option>";
            }
          }
          echo "</select>";
          ?>
      </div>
      <div class="form-group">
        <label for="kota_penelitian">Kota Instansi/Lembaga Tujuan Surat</label>
        <?php
          echo "<select name='kota_penelitian' class='form-control' required>";
          echo "<option value=''>-Pilih-</option>";
          $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM dt_kota ORDER BY nm_kota ASC" );
          while ( $w = mysqli_fetch_array( $tampil ) ) {
            if ( $dataku[ 'kota_penelitian' ] == $w[ 'id' ] ) {
              echo "<option value='$w[id]' selected>$w[nm_kota]</option>";
            } else {
              echo "<option value='$w[id]'>$w[nm_kota]</option>";
            }
          }
          echo "</select>";
          ?>
      </div>
      <div class="form-group">
        <label for="tempat_ow">Tempat Observasi dan Wawancara <br />
        <input type="checkbox" name="bilasama" onclick="IsiSama(this.form)" <?php if($dataku['tempat_ow']==$dataku['lembaga_tujuan_surat']) { echo "checked";}?>> Tempat observasi dan wawancara sama dengan instansi/lembaga tujuan surat
        </label>
        <input type="text" name="tempat_ow" class="form-control" id="tempat_ow" placeholder="Contoh: Fakultas Psikologi Universitas Islam Negeri Maulana Malik Ibrahim Malang, dll." value="<?php echo $dataku['tempat_ow'];?>" required>
      </div>
      <div class="form-group">
        <label for="tujuan_surat">Maksud Permohonan Surat:</label>
        <input type="text" name="tujuan_surat" class="form-control" id="tujuan_surat" value="<?php echo $dataku['tujuan_surat'];?>" placeholder="Contoh: Untuk melakukan observasi dan wawancara pada bla bla bla, dll." required>
      </div>
      <div class="form-group">
        <label for="matkul">Tugas Matakuliah</label>
        <?php
          echo "<select name='matkul' class='form-control' required>";
          echo "<option value=''>-Pilih-</option>";
          $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM mag_dt_matkul_all ORDER BY nm ASC" );
          while ( $w = mysqli_fetch_array( $tampil ) ) {
            if ( $dataku[ 'matkul' ] == $w[ 'id' ] ) {
              echo "<option value='$w[id]' selected>[$w[kd]] $w[nm]</option>";
            } else {
              echo "<option value='$w[id]'>[$w[kd]] $w[nm]</option>";
            }
          }
          echo "</select>";
          ?>
      </div>
      <div class="form-group">
        <label for="dosen_pembimbing">Dosen Pengampu Matakuliah</label>
        <?php
          echo "<select name='dosen_pembimbing' class='form-control' required>";
          echo "<option value=''>-Pilih-</option>";
          $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "select * FROM dt_pegawai WHERE jenis_pegawai = '1' AND mengajar_pasca='2' ORDER BY nama_tg ASC" );
          while ( $w = mysqli_fetch_array( $tampil ) ) {
            if ( $dataku[ 'dosen_pembimbing' ] == $w[ 'id' ] ) {
              echo "<option value='$w[id]' selected>$w[nama_tg]</option>";
            } else {
              echo "<option value='$w[id]'>$w[nama_tg]</option>";
            }
          }
          echo "</select>";
          ?>
      </div>
      <div class="form-group">
        <label for="tembusan">Tembusan surat</label>
        <textarea class="form-control input-sm" rows="5" name="tembusan" id="tembusan" required><?php if (empty($dataku['tembusan'])) { echo $d['isi'];} else { echo $dataku['tembusan'];}?></textarea>
        <p class="help-block"><code>Silahkan disesuaikan tembusan suratnya</code>.</p>
      </div>
      <button type="submit" class="btn btn-primary" name="update">Update</button>
      <button type="reset" class="btn btn-warning">Ulang</button>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </form>
  </div>
</div>
<script>
  function IsiSama(f) {
  if(f.bilasama.checked == true) {
   f.tempat_ow.value = f.lembaga_tujuan_surat.value;
  }
  if(f.bilasama.checked == false) {
   f.tempat_ow.value = ""; 
  }
  }
</script>