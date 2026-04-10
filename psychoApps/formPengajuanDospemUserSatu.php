<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  $qry_moment = "SELECT * FROM pengajuan_dospem WHERE status='1'";
  $hasil = mysqli_query($con, $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_periode=$data['id'];
  $ta=$data['ta'];
  ?>
<form action="sformPengajuanDospemUserSatu.php" method="post" enctype="multipart/form-data">
  <div class="card-body pb-0">
    <div class="form-row">
      <div class="form-group col-sm-2">
        <label for="">IPK <span class="text-danger">*</span></label>
        <div class="input-group input-group-sm">
          <input type="number" name="digit_ipk1" class="form-control" min="1" max="3" required>
          <div class="input-group-prepend">
            <span class="input-group-text border-left-0">,</span>
          </div>
          <input type="number" name="digit_ipk2" class="form-control" min="0" max="99" required>
        </div>
      </div>
      <div class="form-group col-sm-3">
        <label for="sks_ditempuh">SKS yang telah ditempuh <span class="text-danger">*</span></label>
        <input type="number" class="form-control form-control-sm" name="sks_ditempuh" min="120" required>
      </div>
      <div class="form-group col-sm-3">
        <label for="jenis_skripsi">Jenis skripsi <span class="text-danger">*</span></label>
        <select name="jenis_skripsi" class="form-control form-control-sm" required>
          <option value="">-Pilih-</option>
          <?php
            $q = mysqli_query($con, "SELECT * FROM opsi_jenis_skripsi ORDER BY id ASC");
            while ($tampil = mysqli_fetch_array($q)){
              echo "<option value='$tampil[id]'>$tampil[nm]</option>";
            }
            ?>
        </select>
      </div>
      <div class="form-group col-sm-4">
        <label for="bidang_skripsi">Peminatan bidang psikologi dalam skripsi <span class="text-danger">*</span></label>
        <select name="bidang_skripsi" class="form-control form-control-sm" required>
          <option value="">-Pilih-</option>
          <?php
            $q = mysqli_query($con, "SELECT * FROM opsi_bidang_skripsi ORDER BY id ASC");
            while ($tampil = mysqli_fetch_array($q)){
              echo "<option value='$tampil[id]'>$tampil[nm]</option>";
            }
            ?>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="judul_skripsi">Judul skripsi yang diajukan <span class="text-danger">*</span></label>
      <textarea id="textarea-custom-one" name="judul_skripsi" class="form-control form-control-sm" style="height: 300px;" required></textarea>
    </div>
    <div class="form-row">
      <div class="form-group col-sm-3">
        <label for="metode_riset">Metode riset <span class="text-danger">*</span></label>
        <select name="metode_riset" class="form-control form-control-sm" required>
          <option value="">-Pilih-</option>
          <?php
            $q = mysqli_query($con, "SELECT * FROM opsi_jenis_penelitian ORDER BY id ASC");
            while ($tampil = mysqli_fetch_array($q)){
              echo "<option value='$tampil[id]'>$tampil[opsi]</option>";
            }
            ?>
        </select>
      </div>
      <div class="form-group col-sm-3">
        <label for="var_1">Variabel 1 <span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm" name="var_1" required>
      </div>
      <div class="form-group col-sm-3">
        <label for="var_2">Variabel 2</label>
        <input type="text" class="form-control form-control-sm" name="var_2">
      </div>
      <div class="form-group col-sm-3">
        <label for="var_3">Variabel 3</label>
        <input type="text" class="form-control form-control-sm" name="var_3">
      </div>
    </div>
    <input type="text" name="nim" class="sr-only" value="<?php echo $dataku['nim'];?>" required readonly>
    <input type="text" name="nama" class="sr-only" value="<?php echo $dataku['nama'];?>" required readonly>
    <input type="text" name="angkatan" class="sr-only" value="<?php echo $dataku['angkatan'];?>" required readonly>
    <input type="text" name="id_periode" class="sr-only" value="<?php echo $id_periode;?>" required readonly>
    <input type="text" name="cek1" class="sr-only" value="1" required readonly>
    <input type="text" name="cek2" class="sr-only" value="1" required readonly>
    <input type="text" name="cekberkas1" class="sr-only" value="1" required readonly>
    <input type="text" name="cekberkas2" class="sr-only" value="1" required readonly>
    <input type="text" name="cekberkas3" class="sr-only" value="1" required readonly>
    <input type="text" name="cekberkas4" class="sr-only" value="1" required readonly>
    <input type="text" name="cekberkas5" class="sr-only" value="1" required readonly>
    <input type="text" name="cekjudul" class="sr-only" value="1" required readonly>
    <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
    <input type="text" name="status" class="sr-only" value="1" required readonly>
  </div>
  <div class="card-footer">
    <button type="submit" class="btn btn-sm btn-danger">Selanjutnya</button>
  </div>
</form>