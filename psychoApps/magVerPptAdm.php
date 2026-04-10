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
                <h4 class="m-0">Pengajuan Dosen Pembimbing Tesis</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Verifikasi Pengajuan</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination.php';
           $reload = "magVerPptAdm.php?pagination=true";
           $sql = "SELECT * FROM mag_periode_pengajuan_dospem ORDER BY start_datetime DESC";
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
                    <h3 class="card-title">Verifikasi Pengajuan</h3>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover m-0 text-center table-sm custom">
                        <thead>
                          <tr>
                            <th rowspan="3" class="pl-1" width="4%">No.</th>
                            <th rowspan="3" width="36%">Periode Pengajuan</th>
                            <th rowspan="3" width="16%">Jumlah Pengajuan</th>
                            <th colspan="6">Persetujuan Kaprodi</th>
                            <th rowspan="2" colspan="2">Verifikasi</th>
                            <th rowspan="3" class="pr-1" width="4%">Opsi</th>
                          </tr>
                          <tr>
                            <th class="pl-1" colspan="2">Dospem I</th>
                            <th colspan="2">Dospem II</th>
                            <th class="pr-1" colspan="2">Judul</th>
                          </tr>
                          <tr>
                            <th class="pl-1" width="5%" style=" font-size:10px;">Belum</th>
                            <th width="5%" style=" font-size:10px;">Selesai</th>
                            <th width="5%" style=" font-size:10px;">Belum</th>
                            <th width="5%" style=" font-size:10px;">Selesai</th>
                            <th width="5%" style=" font-size:10px;">Belum</th>
                            <th class="pr-1" width="5%" style=" font-size:10px;">Selesai</th>
                            <th class="pl-1" width="5%" style=" font-size:10px;">Belum</th>
                            <th class="pr-1" width="5%" style=" font-size:10px;">Selesai</th>
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
                            
                            $qry_nm_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$data[tahap]'";
                            $hsl = mysqli_query($con, $qry_nm_thp);
                            $dtahap = mysqli_fetch_assoc($hsl);
                            
                            $qjumPengaju = "SELECT COUNT(nim) AS jum FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$data[id]'";
                            $rjPengaju = mysqli_query($con, $qjumPengaju);
                            $dJumPengaju = mysqli_fetch_assoc($rjPengaju);
                            
                            $qjumBelumDospem1 = "SELECT COUNT(nim) AS jum FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$data[id]' AND cek1='1'";
                            $rjBelumDospem1 = mysqli_query($con, $qjumBelumDospem1);
                            $djumBelumDospem1 = mysqli_fetch_assoc($rjBelumDospem1);
                            
                            $qjumSelesaiDospem1 = "SELECT COUNT(nim) AS jum FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$data[id]' AND cek1='2'";
                            $rjSelesaiDospem1 = mysqli_query($con, $qjumSelesaiDospem1);
                            $djumSelesaiDospem1 = mysqli_fetch_assoc($rjSelesaiDospem1);
                            
                            $qjumBelumDospem2 = "SELECT COUNT(nim) AS jum FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$data[id]' AND cek2='1'";
                            $rjBelumDospem2 = mysqli_query($con, $qjumBelumDospem2);
                            $djumBelumDospem2 = mysqli_fetch_assoc($rjBelumDospem2);
                            
                            $qjumSelesaiDospem2 = "SELECT COUNT(nim) AS jum FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$data[id]' AND cek2='2'";
                            $rjSelesaiDospem2 = mysqli_query($con, $qjumSelesaiDospem2);
                            $djumSelesaiDospem2 = mysqli_fetch_assoc($rjSelesaiDospem2);
                            
                            $qjumBelumJudul = "SELECT COUNT(nim) AS jum FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$data[id]' AND cekjudul='1'";
                            $rjBelumJudul = mysqli_query($con, $qjumBelumJudul);
                            $djumBelumJudul = mysqli_fetch_assoc($rjBelumJudul);
                            
                            $qjumSelesaiJudul = "SELECT COUNT(nim) AS jum FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$data[id]' AND cekjudul='2'";
                            $rjSelesaiJudul = mysqli_query($con, $qjumSelesaiJudul);
                            $djumSelesaiJudul = mysqli_fetch_assoc($rjSelesaiJudul);
                            
                            $qjumBelumVerAdm = "SELECT COUNT(nim) AS jum FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$data[id]' AND verifikasi_admin='1'";
                            $rjBelumVerAdm = mysqli_query($con, $qjumBelumVerAdm);
                            $djumBelumVerAdm = mysqli_fetch_assoc($rjBelumVerAdm);
                            
                            $qjumSelesaiVerAdm = "SELECT COUNT(nim) AS jum FROM mag_pengelompokan_dospem_tesis WHERE id_periode='$data[id]' AND verifikasi_admin='2'";
                            $rjSelesaiVerAdm = mysqli_query($con, $qjumSelesaiVerAdm);
                            $djumSelesaiVerAdm = mysqli_fetch_assoc($rjSelesaiVerAdm);
                            ?>
                          <tr>
                            <td class="pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-left"><?php if($data['status']==1) { echo 'Tahap '.$dtahap['tahap'].' '.'Semester '.$dsemester['nama'].' '.$dnta['ta'].' <span class="bg-success btn-xs"><i class="fas fa-check"></i> Aktif</span>';} else { echo 'Tahap '.$dtahap['tahap'].' '.'Semester '.$dsemester['nama'].' '.$dnta['ta'];}?></td>
                            <td><?php echo $dJumPengaju['jum'];?></td>
                            <td><?php echo $djumBelumDospem1['jum'];?></td>
                            <td><?php echo $djumSelesaiDospem1['jum'];?></td>
                            <td><?php echo $djumBelumDospem2['jum'];?></td>
                            <td><?php echo $djumSelesaiDospem2['jum'];?></td>
                            <td><?php echo $djumBelumJudul['jum'];?></td>
                            <td><?php echo $djumSelesaiJudul['jum'];?></td>
                            <td><?php echo $djumBelumVerAdm['jum'];?></td>
                            <td><?php echo $djumSelesaiVerAdm['jum'];?></td>
                            <td class="pr-1"><?php if($dJumPengaju['jum'] < 1) { echo '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak ada pengajuan." onclick="return confirm(\'Tidak ada pengajuan.\')"><i class="far fa-edit"></i></a>';} else { echo '<a class="btn btn-outline-success btn-xs btn-block" title="Verifikasi" href="magVerPengajuPtPerPeriodeAdm.php?id='.$id.'&page='.$page.'"><i class="far fa-edit"></i></a>';}?></td>
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