<?php 
  include( "contentsConAdm.php" );
  $idPersonal = mysqli_real_escape_string($con, $_GET[ 'idPersonal' ] );
  $id = mysqli_real_escape_string($con, $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con, $_GET[ 'page' ] );
  $page1 = mysqli_real_escape_string($con, $_GET[ 'page1' ] );
  
  $qry_periode = "SELECT * FROM mag_periode_pengajuan_dospem WHERE id='$id'";
  $result = mysqli_query($con, $qry_periode);
  $data = mysqli_fetch_assoc($result);
  
  $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$data[ta]'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
                            
  $qry_nm_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$data[tahap]'";
  $hsl = mysqli_query($con, $qry_nm_thp);
  $dtahap = mysqli_fetch_assoc($hsl);

  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
  
  $qdw = "SELECT * FROM mag_dospem_tesis WHERE id='$idPersonal'";
  $rdw = mysqli_query($con, $qdw)or die( mysqli_error($con));
  $ddw = mysqli_fetch_assoc($rdw);
  
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
              <div class="col-sm-5">
                <h4 class="m-0">Pengajuan Dosen Pembimbing Tesis</h4>
              </div>
              <div class="col-sm-7">
                <ol class="breadcrumb float-right">
                  <li class="breadcrumb-item"><a href="magPersonalPtAdm.php?page=<?php echo $page;?>">Personal Dospem Tesis</a></li>
                  <li class="breadcrumb-item"><a href="magPersonalPtPerPeriodeAdm.php?id=<?php echo $id;?>&page=<?php echo $page;?>&page1=<?php echo $page1;?>"><?php echo 'Tahap '.$dtahap['tahap'].' '.'Semester '.$dsemester['nama'].' '.$dnta['ta'];?></a></li>
                  <li class="breadcrumb-item active">Detail Pembimbingan</li>
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
                  $qry1_1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$id' AND dospem_tesis1='$idPersonal' AND cek1='1'";
                  $result1_1 =  mysqli_query($con, $qry1_1) or die(mysqli_error($con));
                  $dataku1_1 = mysqli_fetch_assoc($result1_1) or die(mysqli_error($con));
                  $jumlahData1_1 = $dataku1_1['jumData'];
                  ?>
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <div class="d-flex justify-content-between">
                      <h3 class="card-title">Pengaju Pembimbing I [<?php echo "$jumlahData1_1";?>]</h3>
                      <span><span class="text-danger">Dospem Tesis:</span> <?php echo $ddp['nama_tg'];?></span>
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
                            $qdoswal1_1 = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$id' AND dospem_tesis1='$idPersonal' AND cek1='1' ORDER BY tgl_pengajuan";
                            $rdoswal1_1 = mysqli_query($con, $qdoswal1_1)or die( mysqli_error($con));
                            while($ddoswal1_1 = mysqli_fetch_assoc($rdoswal1_1)) {
                              $no++;
                              $qm1_1 = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$ddoswal1_1[nim]'";
                              $rm1_1 = mysqli_query($con, $qm1_1)or die( mysqli_error($con));
                              $dm1_1 = mysqli_fetch_assoc($rm1_1);
                            ?> 
                          <tr>
                            <td class="pl-1"><?php echo $no;?></td>
                            <td class="text-left"><?php echo $dm1_1['nama'].' ['.$dm1_1['nim'].']';?></td>
                            <td class="pr-1"><?php echo $ddoswal1_1['tgl_pengajuan'];?></td>
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
                  $qry2_1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$idPersonal' AND id_periode='$id' AND cek1='2' AND status='1'";
                  $result2_1 =  mysqli_query($con, $qry2_1) or die(mysqli_error($con));
                  $dataku2_1 = mysqli_fetch_assoc($result2_1) or die(mysqli_error($con));
                  $jumlahData2_1 = $dataku2_1['jumData'];
                  ?>
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <div class="d-flex justify-content-between">
                      <h3 class="card-title">Proses Pembimbing I [<?php echo "$jumlahData2_1";?>]</h3>
                      <span><span class="text-danger">Dospem Tesis:</span> <?php echo $ddp['nama_tg'];?></span>
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
                            <th class="pr-1" width="18%">Tanggal Mulai</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $qdoswal2_1 = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$idPersonal' AND id_periode='$id' AND cek1='2' AND status='1' ORDER BY tgl_pengajuan";
                            $rdoswal2_1 = mysqli_query($con, $qdoswal2_1)or die( mysqli_error($con));
                            while($ddoswal2_1 = mysqli_fetch_assoc($rdoswal2_1)) {
                              $no++;
                              $qm2_1 = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$ddoswal2_1[nim]'";
                              $rm2_1 = mysqli_query($con, $qm2_1)or die( mysqli_error($con));
                              $dm2_1 = mysqli_fetch_assoc($rm2_1);
                            ?> 
                          <tr>
                            <td class="pl-1"><?php echo $no;?></td>
                            <td class="text-left"><?php echo $dm2_1['nama'].' ['.$dm2_1['nim'].']';?></td>
                            <td><?php echo $ddoswal2_1['tgl_pengajuan'];?></td>
                            <td class="pr-1"><?php echo $ddoswal2_1['tgl_mulai'];?></td>
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
                  $qry3_1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$idPersonal' AND id_periode='$id' AND cek1='2' AND cekjudul='2' AND status='2'";
                  $result3_1 =  mysqli_query($con, $qry3_1) or die(mysqli_error($con));
                  $dataku3_1 = mysqli_fetch_assoc($result3_1) or die(mysqli_error($con));
                  $jumlahData3_1 = $dataku3_1['jumData'];
                  ?>
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <div class="d-flex justify-content-between">
                      <h3 class="card-title">Selesai Pembimbing I [<?php echo "$jumlahData3_1";?>]</h3>
                      <span><span class="text-danger">Dospem Tesis:</span> <?php echo $ddp['nama_tg'];?></span>
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
                            <th width="18%">Tanggal Mulai</th>
                            <th class="pr-1" width="18%">Tanggal Selesai</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $qdoswal3_1 = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$idPersonal' AND id_periode='$id' AND cek1='2' AND cekjudul='2' AND status='2' ORDER BY tgl_akhir";
                            $rdoswal3_1 = mysqli_query($con, $qdoswal3_1)or die( mysqli_error($con));
                            while($ddoswal3_1 = mysqli_fetch_assoc($rdoswal3_1)) {
                              $no++;
                              $qm3_1 = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$ddoswal3_1[nim]'";
                              $rm3_1 = mysqli_query($con, $qm3_1)or die( mysqli_error($con));
                              $dm3_1 = mysqli_fetch_assoc($rm3_1);
                            ?> 
                          <tr>
                            <td class="pl-1"><?php echo $no;?></td>
                            <td class="text-left"><?php echo $dm3_1['nama'].' ['.$dm3_1['nim'].']';?></td>
                            <td><?php echo $ddoswal3_1['tgl_pengajuan'];?></td>
                            <td><?php echo $ddoswal3_1['tgl_mulai'];?></td>
                            <td class="pr-1"><?php echo $ddoswal3_1['tgl_akhir'];?></td>
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
                  $qry1_2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$id' AND dospem_tesis2='$idPersonal' AND cek1='1'";
                  $result1_2 =  mysqli_query($con, $qry1_2) or die(mysqli_error($con));
                  $dataku1_2 = mysqli_fetch_assoc($result1_2) or die(mysqli_error($con));
                  $jumlahData1_2 = $dataku1_2['jumData'];
                  ?>
                <div class="card card-outline card-warning">
                  <div class="card-header">
                    <div class="d-flex justify-content-between">
                      <h3 class="card-title">Pengaju Pembimbing II [<?php echo "$jumlahData1_2";?>]</h3>
                      <span><span class="text-danger">Dospem Tesis:</span> <?php echo $ddp['nama_tg'];?></span>
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
                            $qdoswal1_2 = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$id' AND dospem_tesis2='$idPersonal' AND cek1='1' ORDER BY tgl_pengajuan";
                            $rdoswal1_2 = mysqli_query($con, $qdoswal1_2)or die( mysqli_error($con));
                            while($ddoswal1_2 = mysqli_fetch_assoc($rdoswal1_2)) {
                              $no++;
                              $qm1_2 = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$ddoswal1_1[nim]'";
                              $rm1_2 = mysqli_query($con, $qm1_2)or die( mysqli_error($con));
                              $dm1_2 = mysqli_fetch_assoc($rm1_2);
                            ?> 
                          <tr>
                            <td class="pl-1"><?php echo $no;?></td>
                            <td class="text-left"><?php echo $dm1_2['nama'].' ['.$dm1_2['nim'].']';?></td>
                            <td class="pr-1"><?php echo $ddoswal1_2['tgl_pengajuan'];?></td>
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
                  $qry2_2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$idPersonal' AND id_periode='$id' AND cek1='2' AND status='1'";
                  $result2_2 =  mysqli_query($con, $qry2_2) or die(mysqli_error($con));
                  $dataku2_2 = mysqli_fetch_assoc($result2_2) or die(mysqli_error($con));
                  $jumlahData2_2 = $dataku2_2['jumData'];
                  ?>
                <div class="card card-outline card-warning">
                  <div class="card-header">
                    <div class="d-flex justify-content-between">
                      <h3 class="card-title">Proses Pembimbing II [<?php echo "$jumlahData2_2";?>]</h3>
                      <span><span class="text-danger">Dospem Tesis:</span> <?php echo $ddp['nama_tg'];?></span>
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
                            <th class="pr-1" width="18%">Tanggal Mulai</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $qdoswal2_2 = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$idPersonal' AND id_periode='$id' AND cek1='2' AND status='1' ORDER BY tgl_pengajuan";
                            $rdoswal2_2 = mysqli_query($con, $qdoswal2_2)or die( mysqli_error($con));
                            while($ddoswal2_2 = mysqli_fetch_assoc($rdoswal2_2)) {
                              $no++;
                              $qm2_2 = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$ddoswal2_2[nim]'";
                              $rm2_2 = mysqli_query($con, $qm2_2)or die( mysqli_error($con));
                              $dm2_2 = mysqli_fetch_assoc($rm2_2);
                            ?> 
                          <tr>
                            <td class="pl-1"><?php echo $no;?></td>
                            <td class="text-left"><?php echo $dm2_2['nama'].' ['.$dm2_2['nim'].']';?></td>
                            <td><?php echo $ddoswal2_2['tgl_pengajuan'];?></td>
                            <td class="pr-1"><?php echo $ddoswal2_2['tgl_mulai'];?></td>
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
                  $qry3_2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$idPersonal' AND id_periode='$id' AND cek1='2' AND cekjudul='2' AND status='2'";
                  $result3_2 =  mysqli_query($con, $qry3_2) or die(mysqli_error($con));
                  $dataku3_2 = mysqli_fetch_assoc($result3_2) or die(mysqli_error($con));
                  $jumlahData3_2 = $dataku3_2['jumData'];
                  ?>
                <div class="card card-outline card-warning">
                  <div class="card-header">
                    <div class="d-flex justify-content-between">
                      <h3 class="card-title">Selesai Pembimbing II [<?php echo "$jumlahData3_2";?>]</h3>
                      <span><span class="text-danger">Dospem Tesis:</span> <?php echo $ddp['nama_tg'];?></span>
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
                            <th width="18%">Tanggal Mulai</th>
                            <th class="pr-1" width="18%">Tanggal Selesai</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $qdoswal3_2 = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$idPersonal' AND id_periode='$id' AND cek1='2' AND cekjudul='2' AND status='2' ORDER BY tgl_akhir";
                            $rdoswal3_2 = mysqli_query($con, $qdoswal3_2)or die( mysqli_error($con));
                            while($ddoswal3_2 = mysqli_fetch_assoc($rdoswal3_2)) {
                              $no++;
                              $qm3_2 = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$ddoswal3_2[nim]'";
                              $rm3_2 = mysqli_query($con, $qm3_2)or die( mysqli_error($con));
                              $dm3_2 = mysqli_fetch_assoc($rm3_2);
                            ?> 
                          <tr>
                            <td class="pl-1"><?php echo $no;?></td>
                            <td class="text-left"><?php echo $dm3_2['nama'].' ['.$dm3_2['nim'].']';?></td>
                            <td><?php echo $ddoswal3_2['tgl_pengajuan'];?></td>
                            <td><?php echo $ddoswal3_2['tgl_mulai'];?></td>
                            <td class="pr-1"><?php echo $ddoswal3_2['tgl_akhir'];?></td>
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
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>