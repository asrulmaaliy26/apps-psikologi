<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $username = $_SESSION['username'];
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  $queryAdm = "SELECT * FROM dt_all_adm WHERE username='$username'";
  $rAdm = mysqli_query($con, $queryAdm) or die( mysqli_error($con));
  $dAdm = mysqli_fetch_assoc($rAdm);
  $idAdm = $dAdm['username'];
  $tahun = date("Y");
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmTaper.php" );
        ?>
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="mb-0">Kirim File Surat</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small"><a href="rekapKirimSuratTugasAdm.php?page=<?php echo $page;?>">Surat Tugas</a></li>
                  <li class="breadcrumb-item active small">Form Hapus Penerima File</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h4 class="card-title">Form Hapus Penerima File</h4>
                  </div>
                  <div class="card-body pt-2 pb-2 pl-0 pr-0">
                    <form action="sdeletePenerimaFileStAdm.php" method="post" enctype="multipart/form-data">
                      <input type="text" class="sr-only" name="editor" value="<?php echo $idAdm;?>" readonly required>
                      <input type="text" class="sr-only" name="id" value="<?php echo $id;?>" readonly required>
                      <input type="text" class="sr-only" name="page" value="<?php echo $page;?>" readonly required>
                      <div class="form-group">
                        <button name="submit" type="submit" class="btn btn-sm btn-outline-danger float-right mr-3" id="submit1"><i class="fas fa-user-slash"></i> Hapus Nama Terpilih</button>
                        <div class="table-responsive pt-2 pb-2">
                          <table class="table table-hover table-sm custom mb-0">
                            <thead>
                              <tr class="text-left bg-success">
                                <td scope="col" width="4%" class="text-center">No.</td>
                                <td scope="col" width="80%" class="text-center">Nama</td>
                                <td scope="col" width="16%" class="text-center"><input type="checkbox" id="checkAll"> Pilih Semua</td>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $no=0;
                                $sql = "SELECT penerima_surat.id,penerima_surat.id_sending_surat,penerima_surat.penerima,dt_pegawai.id AS id_pegawai,dt_pegawai.nama_tg FROM penerima_surat LEFT JOIN dt_pegawai ON penerima_surat.penerima=dt_pegawai.id WHERE penerima_surat.id_sending_surat='$id' ORDER BY dt_pegawai.nama_tg ASC";
                                $result = mysqli_query($con, $sql);
                                while($data = mysqli_fetch_array($result)) {
                                $no++;
                                ?>
                              <tr>
                                <td class="text-center"><?php echo $no;?></td>
                                <td class="text-left"><?php echo $data['nama_tg'].' ['.$data['id_pegawai'].']';?></td>
                                <td class="text-center">
                                 <input class="chk" type="checkbox" name="item[]" id="myCheckbox" value="<?php echo $data['id'];?>">
                                </td>
                                <?php
                                  }
                                  ?>
                            </tbody>
                          </table>
                        </div>
                        <button name="submit" type="submit" class="btn btn-sm btn-outline-danger float-right mr-3" id="submit2"><i class="fas fa-user-slash"></i> Hapus Nama Terpilih</button>
                      </div>
                    </form>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>