<?php 
  include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con, $_GET[ 'page' ] );
  
  $qry_periode = "SELECT * FROM mag_periode_pengajuan_ac WHERE id='$id'";
  $result = mysqli_query($con, $qry_periode);
  $data = mysqli_fetch_assoc($result);
  
  $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$data[ta]'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
                            
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
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
        <?php include( "alertUser.php" );?>
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h4 class="m-0">Pengajuan Academic Coach</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                  <li class="breadcrumb-item"><a href="magPersonalAcAdm.php?page=<?php echo $page;?>">Personal Academic Coach</a></li>
                  <li class="breadcrumb-item active"><?php echo 'Semester '.$dsemester['nama'].' '.$dnta['ta'];?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination1.php';
           $reload1 = "magPersonalAcPerPeriodeAdm.php?id=$id&page=$page";
           $sql1 = "SELECT
           mag_dosen_wali.id AS idPersonal,
           mag_dosen_wali.id_periode,
           mag_dosen_wali.nip,
           mag_dosen_wali.kuota,
           dt_pegawai.id,
           dt_pegawai.nama_tg

           FROM mag_dosen_wali 
           LEFT JOIN dt_pegawai 
           ON mag_dosen_wali.nip=dt_pegawai.id 
           WHERE mag_dosen_wali.id_periode = '$id' ORDER BY dt_pegawai.nama_tg ASC";
           $result1 = mysqli_query($con, $sql1);
           
           $rpp1 = 10;
           $page1 = isset($_GET["page1"]) ? (intval($_GET["page1"])) : 1;
           $tcount1 = mysqli_num_rows($result1);
           $tpages1 = ($tcount1) ? ceil($tcount1/$rpp1) : 1;
           $count1 = 0;
           $i1 = ($page1-1)*$rpp1;
           $no_urut = ($page1-1)*$rpp1;
           ?>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col connectedSortable">
                <div class="card card-outline card-success">
                  <div class="card-header">
                    <h3 class="card-title"><?php echo 'Semester '.$dsemester['nama'].' '.$dnta['ta'];?></h3>
                    <a class="btn btn-outline-success btn-xs float-right" title="Input Academic Coach Baru" href="magInputPersonalAcPerPeriodeAdm.php?id=<?php echo $id;?>&page=<?php echo $page;?>&page1=<?php echo $page1;?>"><i class="far fa-calendar-plus"></i> Input Academic Coach Baru</a>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover m-0 text-center table-sm custom">
                        <thead>
                          <tr>
                            <th rowspan="2" class="pl-1" width="4%">No.</th>
                            <th rowspan="2" width="40%">Nama</th>
                            <th rowspan="2" width="12%">Kuota</th>
                            <th colspan="4">Progres Academic Coach</th>
                            <th rowspan="2" colspan="3" class="pr-1" width="12%">Opsi</th>
                          </tr>
                          <tr>
                            <th class="pl-1" width="8%">Pengaju</th>
                            <th width="8%">Proses</th>
                            <th width="8%">Selesai</th>
                            <th class="pr-1" width="8%">Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count1<$rpp1) && ($i1<$tcount1)) {
                            mysqli_data_seek($result1, $i1);
                            $data = mysqli_fetch_array($result1);
                            
                            $qnd =  "SELECT * FROM dt_pegawai WHERE id='$data[nip]'";
                            $r = mysqli_query($con, $qnd);
                            $dnd = mysqli_fetch_assoc($r);
                            
                            $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$data[idPersonal]' AND id_periode='$data[id_periode]' AND (cek='1' OR cek='2') AND status='1'";
                            $res1 =  mysqli_query($con, $qry1) or die(mysqli_error($con));
                            $dataku1 = mysqli_fetch_assoc($res1) or die(mysqli_error($con));
                            $jumlahData1 = $dataku1['jumData'];
                            $sisa1 = $data['kuota'] - $jumlahData1;
                            
                            $qpengaju1 = "SELECT * FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$data[idPersonal]' AND id_periode='$data[id_periode]'";
                            $row1 = mysqli_query($con, $qpengaju1);
                            $dpengaju1 = mysqli_num_rows($row1);
                            
                            $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$data[idPersonal]' AND id_periode='$data[id_periode]' AND cek='1'";
                            $result2 =  mysqli_query($con, $qry2) or die(mysqli_error($con));
                            $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($con));
                            $jumlahData2 = $dataku2['jumData'];
                            
                            $qry3 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$data[idPersonal]' AND id_periode='$data[id_periode]' AND cek='2' AND status='1'";
                            $result3 =  mysqli_query($con, $qry3) or die(mysqli_error($con));
                            $dataku3 = mysqli_fetch_assoc($result3) or die(mysqli_error($con));
                            $jumlahData3 = $dataku3['jumData'];
                            
                            $qry4 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$data[idPersonal]' AND id_periode='$data[id_periode]' AND cek='2' AND status='2'";
                            $result4 =  mysqli_query($con, $qry4) or die(mysqli_error($con));
                            $dataku4 = mysqli_fetch_assoc($result4) or die(mysqli_error($con));
                            $jumlahData4 = $dataku4['jumData'];
                            
                            $qry5 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dosen_wali WHERE dosen_wali='$data[idPersonal]' AND id_periode='$data[id_periode]' AND cek='2'";
                            $result5 =  mysqli_query($con, $qry5) or die(mysqli_error($con));
                            $dataku5 = mysqli_fetch_assoc($result5) or die(mysqli_error($con));
                            $jumlahData5 = $dataku5['jumData'];
                            ?> 
                          <tr>
                            <td class="pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-left"><?php echo $dnd['nama_tg'];?></td>
                            <td><?php if($data['kuota'] - $jumlahData1==0) { echo '<span class="bg-success btn-xs btn-block">Penuh '.'('.$data['kuota'].')</span>';} else {echo $data['kuota'].' (tersisa '.$sisa1.')';}?></td>
                            <td><?php echo $jumlahData2?></td>
                            <td><?php echo $jumlahData3?></td>
                            <td><?php echo $jumlahData4?></td>
                            <td><?php echo $jumlahData5?></td>
                            <td class="pr-1" width="4%"><a class="btn btn-outline-success btn-xs btn-block" title="Detail Choaching" href="magDetailPersonalAcPerPeriodeAdm.php?idPersonal=<?php echo $data['idPersonal'];?>&id=<?php echo $id;?>&page=<?php echo $page;?>&page1=<?php echo $page1;?>"><i class="fas fa-expand"></i></a></td>
                            <td class="pr-1" width="4%"><a class="btn btn-outline-success btn-xs btn-block" title="Edit Personal" href="magEditPersonalAcPerPeriodeAdm.php?idPersonal=<?php echo $data['idPersonal'];?>&id=<?php echo $id;?>&page=<?php echo $page;?>&page1=<?php echo $page1;?>"><i class="far fa-edit"></a></td>
                            <td class="pr-1" width="4%"><?php if($dpengaju1 > 0) { echo '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa dihapus! Telah ada pengajuan." onclick="return confirm(\'Tidak bisa dihapus! Telah ada pengajuan.\')"><i class="fas fa-trash"></i></a>';} else { echo '<a class="btn btn-outline-success btn-xs btn-block" href="magDeletePersonalAcPerPeriodeAdm.php?idPersonal='.$data['idPersonal'].'&id='.$id.'&page='.$page.'&page1='.$page1.'" onclick="return confirm(\'Yakin data ini dihapus?\')" title="Hapus"><i class="fas fa-trash"></i></a>';}?></td>
                          </tr>
                          <?php
                            $i1++; 
                            $count1++;
                            }
                            ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer pb-0 clearfix">
                    <div class="float-right"><?php echo paginate_one1($reload1, $page1, $tpages1); ?></div>
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