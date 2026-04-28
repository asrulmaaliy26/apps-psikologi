<?php include( "contentsConAdm.php" );?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php
        include( "navtopAdm.php" );
        include( "navSideBarAdmBakS1.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Rekap Pendaftar Bimtek Penulisan TA</h6>
              </div>
              <div class="col-sm-6 text-right">
                <a href="pndftrnBimtekAdm.php" class="btn btn-secondary btn-sm">
                  <i class="fas fa-arrow-left"></i> Kembali ke Periode
                </a>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12">
                <div class="card card-outline card-info">
                  <?php
                    $id_bimtek = isset($_GET['id_bimtek']) ? mysqli_real_escape_string($con, $_GET['id_bimtek']) : "";
                    if($id_bimtek){
                      $q_bim = mysqli_query($con, "SELECT nama_bimtek FROM bimtek_pendaftaran WHERE id='$id_bimtek'");
                      $d_bim = mysqli_fetch_assoc($q_bim);
                      echo "<div class='card-header'><h3 class='card-title'>Pendaftar: <strong>".$d_bim['nama_bimtek']."</strong></h3></div>";
                    }
                  ?>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small">
                        <thead>
                          <tr class="bg-secondary">
                            <th width="4%">No.</th>
                            <th width="12%">NIM</th>
                            <th width="18%">Nama</th>
                            <th width="15%">Bimtek / Periode</th>
                            <th width="15%">Peminatan</th>
                            <th width="10%">Outline</th>
                            <th width="10%">Tgl Daftar</th>
                            <th width="16%">Bukti Absensi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $filter_sql = $id_bimtek ? " WHERE pb.id_bimtek = '$id_bimtek' " : "";
                            $query = "SELECT pb.*, m.nama, b.nama_bimtek, ops.nm as nm_peminatan 
                                      FROM bimtek_peserta pb 
                                      JOIN dt_mhssw m ON pb.nim = m.nim 
                                      JOIN bimtek_pendaftaran b ON pb.id_bimtek = b.id
                                      JOIN opsi_bidang_skripsi ops ON pb.peminatan = ops.id
                                      $filter_sql
                                      ORDER BY pb.tgl_daftar DESC";
                            $result = mysqli_query($con, $query);
                            $no = 1;
                            while($row = mysqli_fetch_array($result)){
                          ?>
                          <tr>
                            <td><?php echo $no++;?></td>
                            <td><?php echo $row['nim'];?></td>
                            <td class="text-left"><?php echo $row['nama'];?></td>
                            <td class="text-left"><?php echo $row['nama_bimtek'];?></td>
                            <td><?php echo $row['nm_peminatan'];?></td>
                            <td>
                              <a href="file_outline_bimtek/<?php echo $row['file_outline'];?>" class="btn btn-xs btn-primary" target="_blank">
                                <i class="fas fa-file-download"></i> View
                              </a>
                            </td>
                            <td><?php echo $row['tgl_daftar'];?></td>
                            <td>
                              <div class="text-left small">
                                <?php for($s=1; $s<=3; $s++): 
                                  $col_file = 'file_absensi_'.$s;
                                  $col_tgl = 'tgl_absensi_'.$s;
                                ?>
                                  <div class="mb-1 border-bottom pb-1">
                                    <strong>Slot <?php echo $s;?>:</strong>
                                    <?php if($row[$col_file]): ?>
                                      <a href="file_absensi_bimtek/<?php echo $row[$col_file];?>" class="btn btn-xs btn-success py-0" target="_blank">
                                        <i class="fas fa-image"></i> Lihat
                                      </a>
                                      <span class="d-block text-muted" style="font-size: 0.7rem;"><?php echo $row[$col_tgl];?></span>
                                    <?php else: ?>
                                      <span class="text-danger">Belum</span>
                                    <?php endif; ?>
                                  </div>
                                <?php endfor; ?>
                              </div>
                            </td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
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
