<?php
include("contentsConAdm.php");
include("initPraPropBimtek.php");
$username = $_SESSION['username'];

// Get all periods where this lecturer is a reviewer
$q_periode = mysqli_query($con, "SELECT DISTINCT r.id_periode, b.id, b.nama_bimtek 
    FROM bimtek_reviewer r 
    JOIN bimtek_pendaftaran b ON r.id_periode = b.id 
    WHERE r.nip='$username' 
    ORDER BY b.id DESC");
?>
<!DOCTYPE html>
<html lang="en">
  <?php include("headAdm.php"); ?>
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php include("navtopAdm.php"); include("navSideBarDosen.php"); ?>
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6"><h6 class="m-0">Bimtek Reviewer</h6></div>
            </div>
          </div>
        </div>

        <section class="content">
          <div class="container-fluid">
            <?php if(mysqli_num_rows($q_periode) == 0): ?>
            <div class="callout callout-info shadow-sm">Anda belum ditugaskan sebagai reviewer pada periode bimtek manapun.</div>
            <?php else: while($d_per = mysqli_fetch_assoc($q_periode)): ?>
            <div class="card card-outline card-info mb-4">
              <div class="card-header">
                <h5 class="card-title"><i class="fas fa-chalkboard-teacher"></i> Periode: <strong><?php echo $d_per['nama_bimtek']; ?></strong></h5>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover table-sm text-center">
                    <thead class="bg-secondary">
                      <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Peminatan</th>
                        <th>Status Pra Proposal</th>
                        <th>Tgl Submit</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $no = 1;
                        $q_mhs = mysqli_query($con, "SELECT bp.nim, bp.peminatan, m.nama, o.nm as nm_pem, pp.id as id_prop, pp.status, pp.tgl_submit, pp.status_sertifikat,
                                b.bypass_sertifikat
                            FROM bimtek_peserta bp
                            JOIN dt_mhssw m ON bp.nim = m.nim
                            JOIN bimtek_pendaftaran b ON bp.id_bimtek = b.id
                            JOIN opsi_bidang_skripsi o ON bp.peminatan = o.id
                            LEFT JOIN bimtek_pra_proposal pp ON pp.nim = bp.nim AND pp.id_bimtek = bp.id_bimtek
                            WHERE bp.id_bimtek='".$d_per['id_periode']."' AND bp.id_reviewer='$username'
                            ORDER BY m.nama ASC");
                        while($d_mhs = mysqli_fetch_assoc($q_mhs)):
                          $status_badge = '-';
                          if($d_mhs['status']){
                            $b = ['proses'=>'badge-warning','revisi'=>'badge-danger','diterima'=>'badge-success'];
                            $l = ['proses'=>'Sedang Diproses','revisi'=>'Perlu Revisi','diterima'=>'Diterima ✓'];
                            $status_badge = "<span class='badge ".$b[$d_mhs['status']]."'>".$l[$d_mhs['status']]."</span>";
                          }
                      ?>
                      <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $d_mhs['nim']; ?></td>
                        <td class="text-left"><?php echo $d_mhs['nama']; ?></td>
                        <td><?php echo $d_mhs['nm_pem']; ?></td>
                        <td><?php echo $status_badge; ?></td>
                        <td><?php echo $d_mhs['tgl_submit'] ? $d_mhs['tgl_submit'] : '-'; ?></td>
                        <td>
                          <?php if($d_mhs['id_prop']): ?>
                            <?php 
                              $s_stat = $d_mhs['status_sertifikat'] ?? 'pending';
                              $is_bypass = ($d_mhs['bypass_sertifikat'] == 1);
                              if($s_stat == 'pending' && !$is_bypass): 
                            ?>
                              <span class="badge badge-warning"><i class="fas fa-clock"></i> Validasi Admin...</span>
                            <?php elseif($s_stat == 'invalid' && !$is_bypass): ?>
                              <span class="badge badge-danger"><i class="fas fa-times"></i> Sertifikat Ditolak</span>
                            <?php else: ?>
                              <?php if($d_mhs['status'] !== 'diterima'): ?>
                                <a href="reviewPraPropBimtekDsn.php?id=<?php echo $d_mhs['id_prop']; ?>" class="btn btn-xs btn-primary">
                                  <i class="fas fa-search"></i> Review
                                </a>
                              <?php else: ?>
                                <a href="reviewPraPropBimtekDsn.php?id=<?php echo $d_mhs['id_prop']; ?>" class="btn btn-xs btn-success">
                                  <i class="fas fa-check"></i> Detail
                                </a>
                              <?php endif; ?>
                            <?php endif; ?>
                          <?php else: ?>
                            <span class="text-muted small">Belum submit</span>
                          <?php endif; ?>
                        </td>
                      </tr>
                      <?php endwhile; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <?php endwhile; endif; ?>
          </div>
        </section>
      </div>
    </div>
    <?php include("footerAdm.php"); include("jsAdm.php"); ?>
  </body>
</html>
