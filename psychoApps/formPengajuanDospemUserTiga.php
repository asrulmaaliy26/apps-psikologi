<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  $qry = "SELECT * FROM pengelompokan_dospem_skripsi WHERE nim='$dataku[nim]'";
  $r = mysqli_query($con,  $qry )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $r );
  
  $qry_moment = "SELECT * FROM pengajuan_dospem WHERE status='1'";
  $hasil = mysqli_query($con, $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_periode=$data['id'];
  $ta=$data['ta'];
  ?>
<form action="sformPengajuanDospemUserTiga.php" method="post" enctype="multipart/form-data">
  <div class="card-body pb-0">
    <div class="form-row">
      <div class="form-group col-sm-6">
        <label for="dospem_skripsi1">Pilihan dosen pembimbing skripsi 1 <span class="text-danger">*</span></label>
        <?php
          echo "<select name='dospem_skripsi1' class='form-control form-control-sm' required>";
          echo "<option value=''>-Pilih-</option>";
          $tampil = mysqli_query($con, "SELECT * FROM dospem_skripsi WHERE id_periode='$dt[id_periode]'" );
          while ( $w = mysqli_fetch_array( $tampil ) ) {
          $mqry = "SELECT * FROM dt_pegawai WHERE id='$w[nip]'";
          $rq = mysqli_query($con, $mqry)or die( mysqli_error($con));
          $dq = mysqli_fetch_array($rq);
          
          if ( $dt['dospem_skripsi1'] == $w[ 'nip' ] ) {
          echo "<option value='$w[nip]' selected>$dq[nama]</option>";
          } else {
          echo "<option value='$w[nip]'>$dq[nama]</option>";
          }
          }
          echo "</select>";
          ?>
      </div>
      <div class="form-group col-sm-6">
        <label for="dospem_skripsi2">Pilihan dosen pembimbing skripsi 2</label>
        <?php
          echo "<select name='dospem_skripsi2' class='form-control form-control-sm'>";
          echo "<option value=''>-Pilih-</option>";
          $tampil = mysqli_query($con, "SELECT * FROM dospem_skripsi WHERE id_periode='$dt[id_periode]'" );
          while ( $w = mysqli_fetch_array( $tampil ) ) {
          $mqry = "SELECT * FROM dt_pegawai WHERE id='$w[nip]'";
          $rq = mysqli_query($con, $mqry)or die( mysqli_error($con));
          $dq = mysqli_fetch_array($rq);
          
          if ( $dt['dospem_skripsi2'] == $w[ 'nip' ] ) {
          echo "<option value='$w[nip]' selected>$dq[nama]</option>";
          } else {
          echo "<option value='$w[nip]'>$dq[nama]</option>";
          }
          }
          echo "</select>";
          ?>
      </div>
    </div>
    <input type="text" name="id" class="sr-only" value="<?php echo $dt['id'];?>" required readonly>
    <input type="text" name="id_periode" class="sr-only" value="<?php echo $id_periode;?>" required readonly>
  </div>
  <div class="card-footer">
    <button type="submit" class="btn btn-sm btn-danger">Selanjutnya</button>
  </div>
</form>