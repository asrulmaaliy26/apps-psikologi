<?php 
  include( "contentsConAdm.php" );
  $id = mysqli_real_escape_string($con, $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con, $_GET[ 'page' ] );
  
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
                <h4 class="m-0">Pengajuan Dosen Pembimbing Tesis</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                  <li class="breadcrumb-item"><a href="magPersonalPtAdm.php?page=<?php echo $page;?>">Personal Dospem Tesis</a></li>
                  <li class="breadcrumb-item active"><?php echo 'Tahap '.$dtahap['tahap'].' '.'Semester '.$dsemester['nama'].' '.$dnta['ta'];?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination1.php';
           $reload1 = "magPersonalPtPerPeriodeAdm.php?id=$id&page=$page";
           $sql1 = "SELECT
           mag_dospem_tesis.id AS idPersonal,
           mag_dospem_tesis.id_periode,
           mag_dospem_tesis.nip,
           mag_dospem_tesis.kuota1,
           mag_dospem_tesis.kuota2,
           dt_pegawai.id,
           dt_pegawai.nama_tg

           FROM mag_dospem_tesis 
           LEFT JOIN dt_pegawai 
           ON mag_dospem_tesis.nip=dt_pegawai.id 
           WHERE mag_dospem_tesis.id_periode = '$id' ORDER BY dt_pegawai.nama_tg ASC";
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
                    <h3 class="card-title"><?php echo 'Tahap '.$dtahap['tahap'].' '.'Semester '.$dsemester['nama'].' '.$dnta['ta'];?></h3>
                    <a class="btn btn-outline-success btn-xs float-right" title="Input Dospem Tesis Baru" href="magInputPersonalPtPerPeriodeAdm.php?id=<?php echo $id;?>&page=<?php echo $page;?>&page1=<?php echo $page1;?>"><i class="far fa-calendar-plus"></i> Input Dospem Tesis Baru</a>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover m-0 text-center table-sm custom">
                        <thead>
                          <tr>
                        <th rowspan="3" class="pl-1" width="4%">No.</th>
                        <th rowspan="3" width="24%">Nama</th>
                        <th colspan="2" rowspan="2">Kuota Pembimbing</th>
                        <th colspan="8">Total Pembimbing</th>
                        <th colspan="3" rowspan="3" class="pr-1">Opsi</th>
                      </tr>
                      <tr>
                        <th class="pl-1" colspan="4" width="7%">I</th>
                        <th class="pr-1" colspan="4" width="7%">II</th>
                      </tr>
                      <tr>
                        <th class="pl-1" width="7%">I</th>
                        <th class="pr-1" width="7%">II</th>
                        <th width="4%" style=" font-size:10px;">Pengaju</th>
                        <th width="4%" style=" font-size:10px;">Proses</th>
                        <th width="4%" style=" font-size:10px;">Selesai</th>
                        <th width="4%" style=" font-size:10px;">Total</th>
                        <th width="4%" style=" font-size:10px;">Pengaju</th>
                        <th width="4%" style=" font-size:10px;">Proses</th>
                        <th width="4%" style=" font-size:10px;">Selesai</th>
                        <th class="pr-1" width="4%" style=" font-size:10px;">Total</th>
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
                            
                            $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$data[idPersonal]' AND id_periode='$data[id_periode]' AND (cek1='1' OR cek1='2') AND status='1'";
                            $res1 =  mysqli_query($con, $qry1) or die(mysqli_error($con));
                            $dataku1 = mysqli_fetch_assoc($res1) or die(mysqli_error($con));
                            $jumlahData1 = $dataku1['jumData'];
                            $sisa1 = $data['kuota1'] - $jumlahData1;

                            $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$data[idPersonal]' AND id_periode='$data[id_periode]' AND (cek2='1' OR cek2='2') AND status='1'";
                            $res2 =  mysqli_query($con, $qry2) or die(mysqli_error($con));
                            $dataku2 = mysqli_fetch_assoc($res2) or die(mysqli_error($con));
                            $jumlahData2 = $dataku2['jumData'];
                            $sisa2 = $data['kuota2'] - $jumlahData2;
            
                            $qry3 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$data[idPersonal]' AND id_periode='$data[id_periode]' AND cek1='1'";
                            $res3 =  mysqli_query($con, $qry3) or die(mysqli_error($con));
                            $dataku3 = mysqli_fetch_assoc($res3) or die(mysqli_error($con));
                            $jumlahData3 = $dataku3['jumData'];

                            $qry4 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$data[idPersonal]' AND id_periode='$data[id_periode]' AND cek2='1'";
                            $res4 =  mysqli_query($con, $qry4) or die(mysqli_error($con));
                            $dataku4 = mysqli_fetch_assoc($res4) or die(mysqli_error($con));
                            $jumlahData4 = $dataku4['jumData'];

                            $qry5 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$data[idPersonal]' AND id_periode='$data[id_periode]' AND cek1='2' AND status='1'";
                            $res5 =  mysqli_query($con, $qry5) or die(mysqli_error($con));
                            $dataku5 = mysqli_fetch_assoc($res5) or die(mysqli_error($con));
                            $jumlahData5 = $dataku5['jumData'];

                            $qry6 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$data[id]' AND id_periode='$data[id_periode]' AND cek2='2' AND status='1'";
                            $res6 =  mysqli_query($con, $qry6) or die(mysqli_error($con));
                            $dataku6 = mysqli_fetch_assoc($res6) or die(mysqli_error($con));
                            $jumlahData6 = $dataku6['jumData'];
                            
                            $qry7 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$data[idPersonal]' AND id_periode='$data[id_periode]' AND cek1='2' AND cekjudul='2' AND status='2'";
                            $res7 =  mysqli_query($con, $qry7) or die(mysqli_error($con));
                            $dataku7 = mysqli_fetch_assoc($res7) or die(mysqli_error($con));
                            $jumlahData7 = $dataku7['jumData'];
                            
                            $qry8 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$data[idPersonal]' AND id_periode='$data[id_periode]' AND cek2='2' AND cekjudul='2' AND status='2'";
                            $res8 =  mysqli_query($con, $qry8) or die(mysqli_error($con));
                            $dataku8 = mysqli_fetch_assoc($res8) or die(mysqli_error($con));
                            $jumlahData8 = $dataku8['jumData'];
                                        
                            $qry9 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$data[idPersonal]' AND cek1='2'";
                            $res9 =  mysqli_query($con, $qry9) or die(mysqli_error($con));
                            $dataku9 = mysqli_fetch_assoc($res9) or die(mysqli_error($con));
                            $jumlahData9 = $dataku9['jumData'];
                            
                            $qry10 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$data[idPersonal]' AND cek2='2'";
                            $res10 =  mysqli_query($con, $qry10) or die(mysqli_error($con));
                            $dataku10 = mysqli_fetch_assoc($res10) or die(mysqli_error($con));
                            $jumlahData10 = $dataku10['jumData'];
                            $jumTotal = ($jumlahData9 + $jumlahData10);

                            $qpengaju1 = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$data[idPersonal]' AND id_periode='$data[id_periode]' AND status='1'";
                            $row1 = mysqli_query($con, $qpengaju1);
                            $dpengaju1 = mysqli_num_rows($row1);

                            $qpengaju2 = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$data[idPersonal]' AND id_periode='$data[id_periode]' AND status='1'";
                            $row2 = mysqli_query($con, $qpengaju2);
                            $dpengaju2 = mysqli_num_rows($row2);
                            ?> 
                          <tr>
                            <td class="pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-left"><?php echo $dnd['nama_tg'];?></td>
                            <td><?php if($data['kuota1'] - $jumlahData1==0) { echo '<span class="bg-success btn-xs btn-block">Penuh '.'('.$data['kuota1'].')</span>';} else {echo $data['kuota1'].' (tersisa '.$sisa1.')';}?></td>
                            <td><?php if($data['kuota2'] - $jumlahData1==0) { echo '<span class="bg-success btn-xs btn-block">Penuh '.'('.$data['kuota2'].')</span>';} else {echo $data['kuota2'].' (tersisa '.$sisa2.')';}?></td>
                            <td><?php echo $jumlahData3;?></td>
                            <td><?php echo $jumlahData5;?></td>
                            <td><?php echo $jumlahData7;?></td>
                            <td><?php echo $jumlahData9;?></td>
                            <td><?php echo $jumlahData4;?></td>
                            <td><?php echo $jumlahData6;?></td>
                            <td><?php echo $jumlahData8;?></td>
                            <td><?php echo $jumlahData10;?></td>
                            <td width="4%"><a class="btn btn-outline-success btn-xs btn-block" title="Detail Pembimbingan" href="magDetailPersonalPtPerPeriodeAdm.php?idPersonal=<?php echo $data['idPersonal'];?>&id=<?php echo $id;?>&page=<?php echo $page;?>&page1=<?php echo $page1;?>"><i class="fas fa-expand"></i></a></td>
                            <td width="4%"><a class="btn btn-outline-success btn-xs btn-block" title="Edit Personal" href="magEditPersonalPtPerPeriodeAdm.php?idPersonal=<?php echo $data['idPersonal'];?>&id=<?php echo $id;?>&page=<?php echo $page;?>&page1=<?php echo $page1;?>"><i class="far fa-edit"></a></td>
                            <td class="pr-1" width="4%"><?php if($dpengaju1 > 0 || $dpengaju2 > 0) { echo '<a class="btn btn-outline-secondary btn-xs btn-block" title="Tidak bisa dihapus! Telah ada pengajuan." onclick="return confirm(\'Tidak bisa dihapus! Telah ada pengajuan.\')"><i class="fas fa-trash"></i></a>';} else { echo '<a class="btn btn-outline-success btn-xs btn-block" href="magDeletePersonalPtPerPeriodeAdm.php?idPersonal='.$data['idPersonal'].'&id='.$id.'&page='.$page.'&page1='.$page1.'" onclick="return confirm(\'Yakin data ini dihapus?\')" title="Hapus"><i class="fas fa-trash"></i></a>';}?></td>
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