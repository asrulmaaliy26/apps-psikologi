<?php 
  include( "contentsConAdm.php" );
  $idPersonal = mysqli_real_escape_string($con, $_GET[ 'idPersonal' ] );
  $id = mysqli_real_escape_string($con, $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con, $_GET[ 'page' ] );
  $page1 = mysqli_real_escape_string($con, $_GET[ 'page1' ] );

  $qry_periode = "SELECT * FROM mag_periode_pengajuan_ac WHERE id='$id'";
  $result = mysqli_query($con, $qry_periode);
  $data = mysqli_fetch_assoc($result);
  
  $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$data[ta]'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
                            
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  
  $qdw = "SELECT * FROM mag_dosen_wali WHERE id='$idPersonal'";
  $rdw = mysqli_query($con, $qdw)or die( mysqli_error($con));
  $ddw = mysqli_fetch_assoc($rdw);
  
  $qry = "SELECT * FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$ddw[id]'";
  $has = mysqli_query($con,  $qry)or die(mysqli_error($con));
  $data = mysqli_fetch_assoc($has);
  
  $qdp = "SELECT * FROM dt_pegawai WHERE id='$ddw[nip]'";
  $rdp = mysqli_query($con, $qdp)or die( mysqli_error($con));
  $ddp = mysqli_fetch_assoc($rdp);   
  ?>
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
                <ol class="breadcrumb float-right">
                  <li class="breadcrumb-item"><a href="magPersonalAcAdm.php?page=<?php echo $page;?>">Personal Academic Coach</a></li>
                  <li class="breadcrumb-item"><a href="magPersonalAcPerPeriodeAdm.php?id=<?php echo $id;?>&page=<?php echo $page;?>&page1=<?php echo $page1;?>"><?php echo 'Semester '.$dsemester['nama'].' '.$dnta['ta'];?></a></li>
                  <li class="breadcrumb-item active">Detail Choaching</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col connectedSortable">
                <?php                 
                  $qry0 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$ddw[id]' AND cek='1'";
                  $result0 =  mysqli_query($con, $qry0) or die(mysqli_error($con));
                  $dataku0 = mysqli_fetch_assoc($result0) or die(mysqli_error($con));
                  $jumlahData0 = $dataku0['jumData'];
                  ?>
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <div class="d-flex justify-content-between">
                      <h3 class="card-title">Pengaju [<?php echo "$jumlahData0";?>]</h3>
                      <span><span class="text-danger">Academic Coach:</span> <?php echo $ddp['nama_tg'];?></span>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover m-0 text-center table-sm custom">
                        <thead>
                          <tr>
                            <th class="pl-1" width="4%">No.</th>
                            <th width="78%">Nama</th>
                            <th class="pr-1" width="18%">Tanggal Pengajuan</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $qdoswal = "SELECT * FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$id' AND cek='1' ORDER BY tgl_pengajuan";
                            $rdoswal = mysqli_query($con, $qdoswal)or die( mysqli_error($con));
                            while($ddoswal = mysqli_fetch_assoc($rdoswal)) {
                              $no++;
                              $qm = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$ddoswal[nim]'";
                              $rm = mysqli_query($con, $qm)or die( mysqli_error($con));
                              $dm = mysqli_fetch_assoc($rm);
                            ?> 
                          <tr>
                            <td class="pl-1"><?php echo $no;?></td>
                            <td class="text-left"><?php echo $dm['nama'].' ['.$dm['nim'].']';?></td>
                            <td class="pr-1"><?php echo $ddoswal['tgl_pengajuan'];?></td>
                          </tr>
                          <?php
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </section>
            </div>
            <div class="row">
              <section class="col connectedSortable">
                <?php                 
                  $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$ddw[id]' AND cek='2' AND status='1'";
                  $result1 =  mysqli_query($con, $qry1) or die(mysqli_error($con));
                  $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($con));
                  $jumlahData1 = $dataku1['jumData'];
                  ?>
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <div class="d-flex justify-content-between">
                      <h3 class="card-title">Proses [<?php echo "$jumlahData1";?>]</h3>
                      <span><span class="text-danger">Academic Coach:</span> <?php echo $ddp['nama_tg'];?></span>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover m-0 text-center table-sm custom">
                        <thead>
                          <tr>
                            <th class="pl-1" width="4%">No.</th>
                            <th width="60%">Nama</th>
                            <th width="18%">Tanggal Pengajuan</th>
                            <th class="pr-1" width="18%">Tanggal Verifikasi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $qdoswal1 = "SELECT * FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$ddw[id]' AND cek='2' AND status='1' ORDER BY tgl_pengajuan";
                            $rdoswal1 = mysqli_query($con, $qdoswal1)or die( mysqli_error($con));
                            while($ddoswal1 = mysqli_fetch_assoc($rdoswal1)) {
                              $no++;
                              $qm1 = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$ddoswal1[nim]'";
                              $rm1 = mysqli_query($con, $qm1)or die( mysqli_error($con));
                              $dm1 = mysqli_fetch_assoc($rm1);
                            ?> 
                          <tr>
                            <td class="pl-1"><?php echo $no;?></td>
                            <td class="text-left"><?php echo $dm1['nama'].' ['.$dm1['nim'].']';?></td>
                            <td><?php echo $ddoswal1['tgl_pengajuan'];?></td>
                            <td class="pr-1"><?php echo $ddoswal1['tgl_cek'];?></td>
                          </tr>
                          <?php
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </section>
            </div>
            <div class="row">
              <section class="col connectedSortable">
                <?php                 
                  $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$ddw[id]' AND cek='2' AND status='2'";
                  $result2 =  mysqli_query($con, $qry2) or die(mysqli_error($con));
                  $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($con));
                  $jumlahData2 = $dataku2['jumData'];
                  ?>
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <div class="d-flex justify-content-between">
                      <h3 class="card-title">Selesai [<?php echo "$jumlahData2";?>]</h3>
                      <span><span class="text-danger">Academic Coach:</span> <?php echo $ddp['nama_tg'];?></span>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover m-0 text-center table-sm custom">
                        <thead>
                          <tr>
                            <th class="pl-1" width="4%">No.</th>
                            <th width="42%">Nama</th>
                            <th width="18%">Tanggal Pengajuan</th>
                            <th width="18%">Tanggal Verifikasi</th>
                            <th class="pr-1" width="18%">Tanggal Selesai</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $qdoswal2 = "SELECT * FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$ddw[id]' AND cek='2' AND status='2' ORDER BY tgl_selesai";
                            $rdoswal2 = mysqli_query($con, $qdoswal2)or die( mysqli_error($con));
                            while($ddoswal2 = mysqli_fetch_assoc($rdoswal2)) {
                              $no++;
                              $qm2 = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$ddoswal2[nim]'";
                              $rm2 = mysqli_query($con, $qm2)or die( mysqli_error($con));
                              $dm2 = mysqli_fetch_assoc($rm2);
                            ?> 
                          <tr>
                            <td class="pl-1"><?php echo $no;?></td>
                            <td class="text-left"><?php echo $dm2['nama'].' ['.$dm2['nim'].']';?></td>
                            <td><?php echo $ddoswal2['tgl_pengajuan'];?></td>
                            <td><?php echo $ddoswal2['tgl_cek'];?></td>
                            <td class="pr-1"><?php echo $ddoswal2['tgl_selesai'];?></td>
                          </tr>
                          <?php
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </section>
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