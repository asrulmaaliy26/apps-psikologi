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
        <?php include( "alertUser.php" );?>
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="m-0">Pengajuan Academic Coach</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Periode Pengajuan</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination.php';
           $reload = "magPeriodePacAdm.php?pagination=true";
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
                    <h3 class="card-title">Periode Pengajuan</h3>
                    <a class="btn btn-outline-success btn-xs float-right" title="Input Periode Baru" href="magInputPeriodePacBaruAdm.php?page=<?php echo $page;?>"><i class="far fa-calendar-plus"></i> Input Periode Baru</a>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover m-0 text-center table-sm custom">
                        <thead>
                          <tr>
                            <th class="pl-1" width="4%">No.</th>
                            <th width="46%">Periode Pengajuan</th>
                            <th width="16%">Batas Waktu Awal</th>
                            <th width="16%">Batas Waktu Akhir</th>
                            <th width="10%">Status</th>
                            <th class="pr-1" colspan="2">Opsi</th>
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

                            $qry0 = "SELECT COUNT(id) AS jumData FROM mag_pengelompokan_dosen_wali WHERE id_periode='$data[id]'";
                            $result0 =  mysqli_query($con, $qry0) or die(mysqli_error($con));
                            $dataku0 = mysqli_fetch_assoc($result0) or die(mysqli_error($con));
                            $jumlahData0 = $dataku0['jumData'];

                            $qry1 = "SELECT COUNT(id) AS jumData FROM mag_dosen_wali WHERE id_periode='$data[id]'";
                            $result1 =  mysqli_query($con, $qry1) or die(mysqli_error($con));
                            $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($con));
                            $jumlahData1 = $dataku1['jumData'];
                            ?> 
                          <tr>
                            <td class="pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-left"><?php echo 'Semester '.$dsemester['nama'].' '.$dnta['ta'];?></td>
                            <td><?php echo $data['start_datetime'];?></td>
                            <td><?php echo $data['end_datetime'];?></td>
                            <td><?php if($data['status']==1) { echo "<span class='bg-success btn-xs btn-block'><i class='fas fa-check'></i> Aktif</span>";} else { echo "<a role='button' class='btn btn-outline-secondary btn-xs btn-block' title='Aktifkan!' href='magUpdateStatusPeriodePacAdm.php?id=".$id."&page=".$page."' onclick='return confirm(\"Yakin Periode ini diaktifkan?\")'><i class='fas fa-ban'></i> Non Aktif</a>";}?></td>
                            <td width="4%"><a class="btn btn-outline-success btn-xs btn-block" title="Edit periode" href="magEditPeriodePacPerIdAdm.php?id=<?php echo $id;?>&page=<?php echo $page;?>"><i class="far fa-edit"></i></a></td>
                            <td class="pr-1" width="4%"><?php if($jumlahData0 > 0 OR $jumlahData1 > 0) { echo "<a class='btn btn-outline-secondary btn-xs btn-block' title='Tidak bisa dihapus! Telah ada pengajuan.' onclick='return confirm(\"Tidak bisa dihapus! Telah ada pengajuan.\")'><i class='fas fa-trash'></i></a>";} else { echo "<a class='btn btn-outline-success btn-xs btn-block' href='magDeletePeriodePacPerIdAdm.php?id=".$id."&page=".$page."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><i class='fas fa-trash'></i></a>";}?></td>
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