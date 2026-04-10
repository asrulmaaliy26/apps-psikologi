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
                  <li class="breadcrumb-item"><a href="magVerPacAdm.php?page=<?php echo $page;?>">Verifikasi Pengajuan</a></li>
                  <li class="breadcrumb-item active"><?php echo 'Semester '.$dsemester['nama'].' '.$dnta['ta'];?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination1.php';
           $reload1 = "magVerPengajuAcPerPeriodeAdm.php?id=$id&page=$page";
           $sql1 = "SELECT
           mag_pengelompokan_dosen_wali.id AS idPersonal,
           mag_pengelompokan_dosen_wali.id_periode,
           mag_pengelompokan_dosen_wali.nim,
           mag_pengelompokan_dosen_wali.dosen_wali,
           mag_pengelompokan_dosen_wali.tgl_pengajuan,
           mag_pengelompokan_dosen_wali.thn_pengajuan,
           mag_pengelompokan_dosen_wali.cek,
           mag_pengelompokan_dosen_wali.tgl_cek,
           mag_pengelompokan_dosen_wali.thn_cek,
           mag_pengelompokan_dosen_wali.catatan,
           mag_pengelompokan_dosen_wali.tgl_selesai,
           mag_pengelompokan_dosen_wali.thn_selesai,
           mag_pengelompokan_dosen_wali.status,
           mag_dt_mhssw_pasca.nim,
           mag_dt_mhssw_pasca.nama
          
           FROM mag_pengelompokan_dosen_wali 
           LEFT JOIN mag_dt_mhssw_pasca
           ON mag_pengelompokan_dosen_wali.nim=mag_dt_mhssw_pasca.nim
           WHERE mag_pengelompokan_dosen_wali.id_periode = '$id' ORDER BY mag_dt_mhssw_pasca.nama ASC";
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
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover m-0 text-center table-sm custom">
                        <thead>
                          <tr>
                            <th class="pl-1" width="4%">No.</th>
                            <th width="34%">Nama</th>
                            <th width="12%">Tgl. Pengajuan</th>
                            <th width="26%">Pilihan Academic Coach</th>
                            <th colspan="2" class="pr-1">Opsi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count1<$rpp1) && ($i1<$tcount1)) {
                            mysqli_data_seek($result1, $i1);
                            $data = mysqli_fetch_array($result1);
                            $idPersonal=$data['idPersonal'];
                            
                            $qnm = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$data[nim]'";
                            $res = mysqli_query($con, $qnm);
                            $dnm =mysqli_fetch_assoc($res);
                            
                            $qdw = "SELECT * FROM mag_dosen_wali WHERE id='$data[dosen_wali]'";
                            $res = mysqli_query($con, $qdw);
                            $ddw = mysqli_fetch_assoc($res);
                            
                            $qndw = "SELECT * FROM dt_pegawai WHERE id='$ddw[nip]'";
                            $res = mysqli_query($con, $qndw);
                            $dndw = mysqli_fetch_assoc($res);
                            ?> 
                          <tr>
                            <td class="pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-left"><?php echo $dnm['nama'].' ['.$dnm['nim'].']';?></td>
                            <td><?php echo $data['tgl_pengajuan'];?></td>
                            <td class="text-left"><?php echo $dndw['nama_tg'];?></td>
                            <td width="14%"> <?php if($data['status']==1) { include 'magOpsiVerPengajuAcPerPeriodeAdm.php';} if($data['status']==2) { include 'magOpsiVerPengajuAcPerPeriodeDisabledAdm.php';}?></td>
                            <td width="10%" class="pr-1"><?php if($data['cek']==2) {echo '<a class="btn btn-outline-secondary btn-xs btn-block" title="Telah diverifikasi." onclick="return confirm(\'Telah diverifikasi.\')"><i class="far fa-edit"></i> Catatan</a>';} else if($data['status']==2) {echo '<a class="btn btn-outline-secondary btn-xs btn-block" title="Telah selesai." onclick="return confirm(\'Telah selesai.\')"><i class="far fa-edit"></i> Catatan</a>';} else { echo '<a class="btn btn-outline-success btn-xs btn-block" title="Edit Pengajuan" href="magEditPengajuAcPerPeriodePerIdAdm.php?idPersonal='.$data['idPersonal'].'&id='.$id.'&page='.$page.'"><i class="far fa-edit"></i> Catatan</a>';}?></td>
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