<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $myquery = "SELECT * FROM peserta_pkl WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );
  
  $q = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $r = mysqli_query($con, $q)or die( mysqli_error($con));
  $dt = mysqli_fetch_assoc($r);
  $nim = $dt['nim'];
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <form action="updatePendaftaranPklUserSatu.php" method="post" id="formPklS1">
    <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
        <?php 
          include( "navtopAdm.php" );
          include( "navSideBarUserS1.php" );
          ?> 
        <div class="content-wrapper">
          <?php include( "alertUser.php" );?>
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-4">
                  <h1 class="m-0 float-left">Pendaftaran</h1>
                </div>
                <div class="col-sm-8">
                  <ol class="mt-2 breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Praktik Kerja Lapangan (PKL)</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm">
                  <div class="card card-success card-outline">
                    <div class="card-header">
                      <h3 class="card-title">Edit Pendaftaran</h3>
                    </div>
                    <div class="card-body pb-0">
                      <div class="form-row">
                        <div class="form-group col-sm-4">
                          <label for="jenis_pkl">Jenis PKL <span class="text-danger">*</span></label>
                          <select name="jenis_pkl" class="form-control form-control-sm" required>
                            <option value="">-Pilih-</option>
                            <option value="Internasional" <?php echo ($dataku['jenis_pkl'] == 'Internasional') ? 'selected' : ''; ?>>Internasional</option>
                            <option value="Reguler" <?php echo ($dataku['jenis_pkl'] == 'Reguler') ? 'selected' : ''; ?>>Reguler</option>
                          </select>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="peminatan">Peminatan <span class="text-danger">*</span></label>
                          <select name="peminatan" class="form-control form-control-sm" required>
                            <option value="">-Pilih-</option>
                            <option value="Psikologi Klinis" <?php echo ($dataku['peminatan'] == 'Psikologi Klinis') ? 'selected' : ''; ?>>Psikologi Klinis</option>
                            <option value="Psikologi Industri dan Organisasi" <?php echo ($dataku['peminatan'] == 'Psikologi Industri dan Organisasi') ? 'selected' : ''; ?>>Psikologi Industri dan Organisasi</option>
                            <option value="Psikologi Pendidikan" <?php echo ($dataku['peminatan'] == 'Psikologi Pendidikan') ? 'selected' : ''; ?>>Psikologi Pendidikan</option>
                            <option value="Psikologi Sosial" <?php echo ($dataku['peminatan'] == 'Psikologi Sosial') ? 'selected' : ''; ?>>Psikologi Sosial</option>
                          </select>
                        </div>
                        <div class="form-group col-sm-4">
                          <label for="id_dpl">Dosen Pembimbing Lapangan (DPL) <span class="text-danger">*</span></label>
                          <?php
                          echo "<select class='form-control form-control-sm' name='id_dpl' required>";
                          echo "<option value=''>-Pilih-</option>";
                          $tampil = mysqli_query($con, "SELECT * FROM dt_pegawai WHERE jenis_pegawai = '1' ORDER BY nama ASC");
                          while ($w = mysqli_fetch_array($tampil)) {
                             if ($dataku['id_dpl'] == $w['id']) {
                                echo "<option value='$w[id]' selected>$w[nama]</option>";
                             } else {
                                echo "<option value='$w[id]'>$w[nama]</option>";
                             }
                          }
                          echo "</select>";
                          ?>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-4">
                          <label for="nama_instansi">Nama Instansi <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="nama_instansi" value="<?php echo htmlspecialchars($dataku['nama_instansi'] ?? ''); ?>" required>
                        </div>
                        <div class="form-group col-sm-8">
                          <label for="alamat_instansi">Alamat Instansi <span class="text-danger">*</span></label>
                          <input type="text" class="form-control form-control-sm" name="alamat_instansi" value="<?php echo htmlspecialchars($dataku['alamat_instansi'] ?? ''); ?>" required>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-sm-6">
                          <label for="sks_diambil">Total SKS yang telah diambil + sks semester ini <span class="text-danger">*</span></label>
                          <input type="number" class="form-control form-control-sm" name="sks_diambil" value="<?php echo $dataku['sks_diambil'];?>" required>
                        </div>
                      </div>
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="nim" class="sr-only" value="<?php echo $nim;?>" required readonly>
                      <input type="text" name="id_pkl" class="sr-only" value="<?php echo $dataku['id_pkl'];?>" required readonly>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-sm btn-danger btn-submit">Update informasi pendaftaran</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
      <?php include( "footerAdm.php" );?>
      <?php include( "jsAdm.php" );?>
      <script>
        $(document).ready(function() {
          $('#formPklS1').on('submit', function() {
            $('.btn-submit').attr('disabled', 'disabled');
            $('.btn-submit').html('<i class="fas fa-spinner fa-spin mr-1"></i> Memproses...');
          });
        });
      </script>
    </body>
  </form>
</html>