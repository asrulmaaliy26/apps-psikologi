<?php include( "contentsConAdm.php" );?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmBakS2.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="m-0">Pengajuan Academic Coach</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Edit Pengajuan</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination.php';
           $reload = "magEditPacAdm.php?pagination=true";
           $sql = "SELECT * FROM mag_periode_pengajuan_ac GROUP BY ta ORDER BY start_datetime DESC";
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
            <div class="row">
              <section class="col connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h3 class="card-title">Edit Pengajuan</h3>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover m-0 text-center table-sm custom">
                        <thead>
                          <tr>
                            <th class="pl-1" width="4%">No.</th>
                            <th width="74%">Periode Pengajuan</th>
                            <th width="18%">Jumlah Pengajuan</th>
                            <th class="pr-1" width="4%">Opsi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $id = $data['id'];
                            $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$data[ta]'";
                            $hasil = mysqli_query($con, $qry_nm_ta);
                            $dnta = mysqli_fetch_assoc($hasil);
                            
                            $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
                            $h = mysqli_query($con, $qry_nm_smt);
                            $dsemester = mysqli_fetch_assoc($h);
                            
                            $qjumPengaju = "SELECT COUNT(nim) AS jum FROM mag_pengelompokan_dosen_wali WHERE id_periode='$data[id]'";
                            $rjPengaju = mysqli_query($con, $qjumPengaju);
                            $dJumPengaju = mysqli_fetch_assoc($rjPengaju);
                            ?>
                          <tr>
                            <td class="pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-left"><?php if($data['status']==1) { echo 'Semester '.$dsemester['nama'].' '.$dnta['ta'].' <span class="bg-success btn-xs"><i class="fas fa-check"></i> Aktif</span>';} else { echo 'Semester '.$dsemester['nama'].' '.$dnta['ta'];}?></td>
                            <td><?php echo $dJumPengaju['jum'];?></td>
                            <td class="pr-1"><?php if($dJumPengaju['jum'] < 1) { echo '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada pengajuan." onclick="return confirm(\'Tidak ada pengajuan.\')"><i class="far fa-edit"></i></a>';} else { echo '<a class="btn btn-outline-success btn-xs btn-block" title="Edit" href="magEditPengajuAcPerPeriodeAdm.php?id='.$id.'&page='.$page.'"><i class="far fa-edit"></i></a>';}?></td>
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
                  <div class="card-footer pb-0 clearfix">
                    <div class="float-right"><?php echo paginate_one($reload, $page, $tpages); ?></div>
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