<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  
  // Validasi Kaprodi
  $q_me = mysqli_query($con, "SELECT * FROM dt_pegawai WHERE id='$username'");
  $dMe = mysqli_fetch_assoc($q_me);
  if ($dMe['jabatan_instansi'] != '47') {
    header("location:dashboardAdm.php");
    exit();
  }

  $qta = "SELECT * FROM dt_ta WHERE status='1'";
  $rta = mysqli_query($con, $qta)or die( mysqli_error($con));
  $dta = mysqli_fetch_assoc($rta);   
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
                <h6 class="m-0">Kuota Dosen Pembimbing Skripsi</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Daftar Periode</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        
        <?php
          include 'pagination.php';
          $reload = "rekapKuotaDospemKaprodi.php?pagination=true";
          $sql = "SELECT * FROM pengajuan_dospem ORDER BY start_datetime DESC";
          $result = mysqli_query($con, $sql);
          
          $rpp = 10;
          $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 1;
          $tcount = mysqli_num_rows($result);
          $tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
          $count = 0;
          $i = ($page-1)*$rpp;
          $no_urut = ($page-1)*$rpp;
        ?>
        <section class="content">
          <div class="container-fluid">
            <div class="card card-outline card-info">
              <div class="card-header">
                <h4 class="card-title">Pilih Periode Pengajuan</h4>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-hover m-0 table-bordered text-center table-sm small">
                    <thead>
                      <tr class="bg-secondary">
                        <th width="5%">No.</th>
                        <th>Periode / Semester</th>
                        <th width="20%">Durasi Pengajuan</th>
                        <th width="15%">Status</th>
                        <th width="15%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        while(($count<$rpp) && ($i<$tcount)) {
                          mysqli_data_seek($result, $i);
                          $data = mysqli_fetch_array($result);
                          
                          $id_per = $data['id'];
                          
                          $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$data[tahap]'";
                          $dthp = mysqli_fetch_assoc(mysqli_query($con, $qry_thp));
                          
                          $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$data[ta]'";
                          $dnta = mysqli_fetch_assoc(mysqli_query($con, $qry_nm_ta));
                          
                          $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
                          $dsemester = mysqli_fetch_assoc(mysqli_query($con, $qry_nm_smt));
                      ?>
                      <tr>
                        <td><?php echo ++$no_urut; ?></td>
                        <td class="text-left font-weight-bold">
                          <?php echo 'Tahap '.$dthp['tahap'].' - '.$dsemester['nama'].' '.$dnta['ta']; ?>
                        </td>
                        <td>
                          <span class="badge badge-light border"><?php echo $data['start_datetime']; ?></span><br>
                          <span class="badge badge-light border"><?php echo $data['end_datetime']; ?></span>
                        </td>
                        <td>
                          <?php if($data['status'] == 1): ?>
                            <span class="badge badge-success"><i class="fas fa-check-circle"></i> Aktif</span>
                          <?php else: ?>
                            <span class="badge badge-secondary">Tidak Aktif</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <a href="detailKuotaDospemKaprodi.php?id=<?php echo $id_per; ?>&page=<?php echo $page; ?>" class="btn btn-xs btn-info btn-flat">
                            <i class="fas fa-users-cog"></i> Kelola Kuota
                          </a>
                        </td>
                      </tr>
                      <?php
                          $i++; 
                          $count++;
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="card-footer clearfix">
                <div class="float-right"><?php echo paginate_one($reload, $page, $tpages); ?></div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>
