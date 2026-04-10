<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );

  $qpenguji = "SELECT * FROM dt_pegawai WHERE id='$id'";
  $rqpenguji = mysqli_query($con, $qpenguji)or die( mysqli_error($con));
  $dqpenguji = mysqli_fetch_assoc($rqpenguji);
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php
        include( "navtopAdm.php" );
        include( "navSideBarAdmBakS1.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Penguji Ujian Skripsi</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="rekapPengujiUjskripAdm.php?page=<?php echo $page;?>">Penguji Ujian Skripsi</a></li>
                  <li class="breadcrumb-item active small">Sekretaris Penguji</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination0.php';
          $reload0 = "rekapSekretarisUjskripAdm.php?id=$id&page=$page&pagination0=true";
          $sql0 = "SELECT * FROM jadwal_ujskrip INNER JOIN pendaftaran_skripsi ON jadwal_ujskrip.id_ujskrip=pendaftaran_skripsi.id WHERE sekretaris_penguji='$id' GROUP BY jadwal_ujskrip.id_ujskrip ORDER BY pendaftaran_skripsi.status ASC, pendaftaran_skripsi.start_datetime DESC";
          $result0 = mysqli_query($con, $sql0);
                
          $rpp0 = 10;
          $page0 = isset($_GET["page0"]) ? (intval($_GET["page0"])) : 1;
          $tcount0 = mysqli_num_rows($result0);
          $tpages0 = ($tcount0) ? ceil($tcount0/$rpp0) : 1;
          $count0 = 0;
          $i0 = ($page0-1)*$rpp0;
          $no_urut0 = ($page0-1)*$rpp0;
        ?>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Sekretaris Penguji Per Periode</h4>
                      <span class="badge badge-info float-right"> <?php echo $dqpenguji['nama'];?></span>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" rowspan="2" class="pl-1">No.</td>
                            <td width="40%" rowspan="2">Periode Pendaftaran</td>
                            <td class="border-bottom-0" colspan="2">Durasi Pendaftaran</td>
                            <td width="10%" rowspan="2">Menjadi <br>Sekretaris Penguji</td>
                            <td colspan="2" class="pr-1" rowspan="2">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="14%" class="pl-1">Mulai</td>
                            <td width="14%" class="pr-1">Akhir</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count0<$rpp0) && ($i0<$tcount0)) {
                            mysqli_data_seek($result0, $i0);
                            $data0 = mysqli_fetch_array($result0);

                            $qry_id_ujskrip = "SELECT * FROM pendaftaran_skripsi WHERE id='$data0[id_ujskrip]'";
                            $r_id_ujskrip = mysqli_query($con, $qry_id_ujskrip);
                            $d_id_ujskrip = mysqli_fetch_assoc($r_id_ujskrip);

                            $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$d_id_ujskrip[tahap]'";
                            $hasil = mysqli_query($con, $qry_thp);
                            $dthp = mysqli_fetch_assoc($hasil);
                            
                            $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$data0[ta]'";
                            $hasil = mysqli_query($con, $qry_nm_ta);
                            $dnta = mysqli_fetch_assoc($hasil);
                            
                            $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
                            $h = mysqli_query($con, $qry_nm_smt);
                            $dsemester = mysqli_fetch_assoc($h);
                                                        
                            $qry1 = "SELECT COUNT(id) AS jumData FROM jadwal_ujskrip WHERE id_ujskrip='$data0[id_ujskrip]' AND sekretaris_penguji='$data0[sekretaris_penguji]'";
                            $result1 =  mysqli_query($con, $qry1) or die(mysqli_error($con));
                            $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($con));
                            $jumlahData1 = $dataku1['jumData'];
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut0;?> </td>
                            <td class="text-left"> <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?> </td>
                            <td class="text-center"> <?php echo $data0['start_datetime'];?> </td>
                            <td class="text-center"> <?php echo $data0['end_datetime'];?> </td>
                            <td class="text-center"> <a href="detailSekretarisUjskripPerPeriodeAdm.php?id=<?php echo $id;?>&id_ujskrip=<?php echo $data0['id_ujskrip'];?>&page=<?php echo $page;?>&page0=<?php echo $page0;?>" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data" type="button"><?php echo $jumlahData1;?></a> </td>
                            <td width="6%" class="text-center pl-1"> <a href="cetakDetailSekretarisUjskripPerPeriodeAdm.php?id=<?php echo $id;?>&id_ujskrip=<?php echo $data0['id_ujskrip'];?>&page=<?php echo $page;?>&page0=<?php echo $page0;?>" class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Cetak data atau jadwal" type="button"><i class="fas fa-print"></i></a> </td>
                            <td width="6%" class="text-center pr-1"> <a href="eksporDetailSekretarisUjskripPerPeriodeAdm.php?id=<?php echo $id;?>&id_ujskrip=<?php echo $data0['id_ujskrip'];?>&page=<?php echo $page;?>&page0=<?php echo $page0;?>" type="button" class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Ekspor data ke Ms. Excel"><i class="fas fa-download"></i></a> </td>
                          </tr>
                          <?php
                            $i0++; 
                            $count0++;
                            }
                            ?>                     
                        </tbody>
                      </table>
                    </div>
                  </div>
                   <div class="card-footer pb-0 clearfix">
                    <div class="float-right"><?php echo paginate_one0($reload0, $page0, $tpages0); ?></div>
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