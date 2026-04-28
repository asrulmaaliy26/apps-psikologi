<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  $q_aktif = mysqli_query($con, "SELECT * FROM bimtek_pendaftaran WHERE status='1'");
  $d_aktif = mysqli_fetch_assoc($q_aktif);
  
  if(!$d_aktif){
    header("location:prePendaftaranBimtekUser.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php
        include( "navtopAdm.php" );
        include( "navSideBarUserS1.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Form Pendaftaran Bimtek Penulisan TA</h6>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="card card-outline card-primary">
                  <div class="card-header">
                    <h3 class="card-title"><?php echo $d_aktif['nama_bimtek'];?></h3>
                  </div>
                  <form action="sformPendaftaranBimtekUser.php" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                      <input type="hidden" name="id_bimtek" value="<?php echo $d_aktif['id'];?>">
                      <input type="hidden" name="nim" value="<?php echo $username;?>">

                      <div class="form-group">
                        <label for="peminatan">Pilih Peminatan <span class="text-danger">*</span></label>
                        <select name="peminatan" class="form-control form-control-sm" required>
                          <option value="">-Pilih-</option>
                          <?php
                            $q = mysqli_query($con, "SELECT * FROM opsi_bidang_skripsi ORDER BY id ASC");
                            while ($tampil = mysqli_fetch_array($q)){
                              echo "<option value='$tampil[id]'>$tampil[nm]</option>";
                            }
                            ?>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="file_outline">File Outline (PDF/DOCX, Max 5MB) <span class="text-danger">*</span></label>
                        <div class="custom-file">
                          <input type="file" name="file_outline" class="custom-file-input" id="file_outline" required>
                          <label class="custom-file-label" for="file_outline">Choose file</label>
                        </div>
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary btn-sm">Kirim Pendaftaran</button>
                      <a href="prePendaftaranBimtekUser.php" class="btn btn-secondary btn-sm">Batal</a>
                    </div>
                  </form>
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
      $(document).ready(function () {
        bsCustomFileInput.init();
      });
    </script>
  </body>
</html>
