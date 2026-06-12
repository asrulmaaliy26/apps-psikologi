<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id_penguji = $_SESSION['username']; // nip dosen yang login
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
              <h6 class="m-0">Peserta PKL (Sebagai Penguji)</h6>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active small">Daftar Mahasiswa PKL</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <section class="col-md-12 connectedSortable">
              <div class="card card-outline card-info">
                <div class="card-header">
                  <div class="clearfix">
                    <h4 class="card-title float-left">Daftar Mahasiswa yang Diuji</h4>
                  </div>
                </div>
                <div class="card-body pt-2 pb-2 pl-0 pr-0">
                  <div class="table-responsive pt-2 pb-2">
                    <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                      <thead>
                        <tr class="text-center bg-secondary">
                          <td width="4%" class="pl-1">No.</td>
                          <td width="25%">Nama Mahasiswa</td>
                          <td width="20%">Instansi PKL</td>
                          <td width="25%">Alamat Instansi</td>
                          <td width="15%">Aksi</td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $no=0;
                          $sql = "SELECT p.*, m.nama as nama_mhs 
                                  FROM peserta_pkl p 
                                  INNER JOIN dt_mhssw m ON p.nim=m.nim 
                                  WHERE p.val_adm='2' AND p.id_penguji='$id_penguji' ORDER BY p.id DESC";
                          $result = mysqli_query($con, $sql);
                          
                          while($data = mysqli_fetch_array($result)) {
                          $no++;
                          ?>
                        <tr>
                          <td class="text-center pl-1"> <?php echo $no;?> </td>
                          <td class="text-left"> <?php echo $data['nama_mhs'].'<br/><small>'.$data['nim'].'</small>';?> </td>
                          <td class="text-left"> <?php echo $data['nama_instansi'];?> </td>
                          <td class="text-left"> <?php echo $data['alamat_instansi'] ?: '<span class="text-muted">-</span>';?> </td>
                          <td class="text-center"> 
                            <a href="formNilaiPengujiPklAdm.php?id_peserta=<?php echo $data['id'];?>" class="btn btn-outline-primary btn-xs"><i class="fas fa-edit"></i> Input Nilai</a>
                          </td>
                        </tr>
                        <?php
                          }
                          ?>                        
                      </tbody>
                    </table>
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
