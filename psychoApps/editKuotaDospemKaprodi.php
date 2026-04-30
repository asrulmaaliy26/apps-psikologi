<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  // Validasi Kaprodi
  $q_me = mysqli_query($con, "SELECT * FROM dt_pegawai WHERE id='$username'");
  $dMe = mysqli_fetch_assoc($q_me);
  if ($dMe['jabatan_instansi'] != '47') {
    header("location:dashboardAdm.php");
    exit();
  }

  $id = mysqli_real_escape_string($con, $_GET['id']);
  $id_per = mysqli_real_escape_string($con, $_GET['id_per']);
  $page = mysqli_real_escape_string($con, $_GET['page']);

  $sql = "SELECT ds.*, p.nama FROM dospem_skripsi ds 
          INNER JOIN dt_pegawai p ON ds.nip = p.id 
          WHERE ds.id = '$id'";
  $data = mysqli_fetch_assoc(mysqli_query($con, $sql));
?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php
        include( "navtopAdm.php" );
        include( "navSideBarDosen.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Edit Kuota Dospem</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="detailKuotaDospemKaprodi.php?id=<?php echo $id_per;?>&page=<?php echo $page;?>">Detail Kuota</a></li>
                  <li class="breadcrumb-item active small">Edit</li>
                </ol>
              </div>
            </div>
          </div>
        </div>

        <section class="content">
          <div class="container-fluid">
            <div class="card card-outline card-warning">
              <div class="card-header">
                <h4 class="card-title">Edit Kuota - <?php echo $data['nama']; ?></h4>
              </div>
              <form action="sEditKuotaDospemKaprodi.php" method="post">
                <div class="card-body">
                  <input type="hidden" name="id" value="<?php echo $id; ?>">
                  <input type="hidden" name="id_per" value="<?php echo $id_per; ?>">
                  <input type="hidden" name="page" value="<?php echo $page; ?>">
                  
                  <div class="form-group">
                    <label class="small font-weight-bold">Dosen</label>
                    <input type="text" class="form-control form-control-sm" value="<?php echo $data['nama']; ?>" readonly>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label class="small font-weight-bold">Kuota I</label>
                        <input type="number" name="kuota1" class="form-control form-control-sm" value="<?php echo $data['kuota1']; ?>" required>
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label class="small font-weight-bold">Kuota II</label>
                        <input type="number" name="kuota2" class="form-control form-control-sm" value="<?php echo $data['kuota2']; ?>" required>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-sm btn-primary">Update Kuota</button>
                  <a href="detailKuotaDospemKaprodi.php?id=<?php echo $id_per; ?>&page=<?php echo $page; ?>" class="btn btn-sm btn-secondary">Batal</a>
                </div>
              </form>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>
