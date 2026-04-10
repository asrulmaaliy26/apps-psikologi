<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  
  $myquery = "SELECT * FROM pengelompokan_dospem_skripsi WHERE id='$id'";
  $res = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dataku = mysqli_fetch_assoc( $res );
  $nim = $dataku['nim'];
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <form action="updatePengajuanDospemUserTigaDua.php" method="post" enctype="multipart/form-data">
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
                  <h1 class="m-0 float-left">Pengajuan Dospem Skripsi</h1>
                </div>
                <div class="col-sm-8">
                  <ol class="mt-2 breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Pengajuan Dospem Skripsi</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm">
                  <div class="card card-success card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                      <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                          <a class="nav-link" href="prePengajuanDospemUser.php" role="tab" aria-selected="true">Form</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="riwayatPengajuanDospemUser.php" role="tab" aria-selected="true">Riwayat</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link active" href="editPengajuanDospemUserTigaDua.php?id=<?php echo $id;?>" role="tab" aria-selected="true">Edit Dosen Pembimbing Skripsi 2</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body">
                      <label for="dospem_skripsi2">Pilihan dosen pembimbing skripsi 2 <span class="text-danger">*</span></label>
                      <?php
                        echo "<select name='dospem_skripsi2' class='form-control form-control-sm' required>";
                        echo "<option value=''>-Pilih-</option>";
                        $tampil = mysqli_query($con, "SELECT * FROM dospem_skripsi WHERE id_periode='$dataku[id_periode]'" );
                        while ( $w = mysqli_fetch_array( $tampil ) ) {
                        $mqry = "SELECT * FROM dt_pegawai WHERE id='$w[nip]'";
                        $rq = mysqli_query($con, $mqry)or die( mysqli_error($con));
                        $dq = mysqli_fetch_array($rq);
                        
                        if ( $dataku['dospem_skripsi2'] == $w[ 'nip' ] ) {
                        echo "<option value='$w[nip]' selected>$dq[nama]</option>";
                        } else {
                        echo "<option value='$w[nip]'>$dq[nama]</option>";
                        }
                        }
                        echo "</select>";
                        ?>
                      <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                      <input type="text" name="nim" class="sr-only" value="<?php echo $nim;?>" required readonly>
                      <input type="text" name="id_periode" class="sr-only" value="<?php echo $dataku['id_periode'];?>" required readonly>
                      <input type="text" name="cek2" class="sr-only" value="<?php echo $dataku['cek2'];?>" required readonly>
                      <input type="text" name="tgl_pengajuan" class="sr-only" value="<?php echo date("d-m-Y");?>" required readonly>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-sm btn-danger">Update dosen pembimbing skripsi 2</button>
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
    </body>
  </form>
</html>