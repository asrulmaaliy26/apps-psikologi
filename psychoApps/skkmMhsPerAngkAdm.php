<?php include( "contentsConAdm.php" ); 
  $angkatan = mysqli_real_escape_string($con, $_GET['angkatan']);
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
                <h6 class="m-0">Rekap SKKM Mahasiswa - Angkatan <?php echo $angkatan; ?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="rekapSkkmMhsBakS1.php">Rekap Angkatan</a></li>
                  <li class="breadcrumb-item active small">Angkatan <?php echo $angkatan; ?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <?php
                include 'pagination.php';
                $reload = "skkmMhsPerAngkAdm.php?angkatan=".$angkatan."&pagination=true";
                $sql = "SELECT dt_mhssw.nim, dt_mhssw.nama, SUM(skkm.krdt) AS totalKredit 
                        FROM skkm 
                        INNER JOIN dt_mhssw ON skkm.nim = dt_mhssw.nim 
                        WHERE dt_mhssw.angkatan='$angkatan' 
                        GROUP BY dt_mhssw.nim 
                        ORDER BY totalKredit DESC";
                $result = mysqli_query($con, $sql);
                
                $rpp = 20;
                $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 1;
                $tcount = mysqli_num_rows($result);
                $tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
                $count = 0;
                $i = ($page-1)*$rpp;
                $no_urut = ($page-1)*$rpp;
                
                $myqry = "SELECT * FROM predikat_total_kredit";
                $hsl = mysqli_query($con, $myqry);
                $opsi  = mysqli_fetch_assoc($hsl);
                $jum1 = $opsi['jumlah_1'];
                $jum2 = $opsi['jumlah_2'];
                $jum3 = $opsi['jumlah_3'];
                ?>
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Daftar Mahasiswa Angkatan <?php echo $angkatan; ?></h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1">No.</td>
                            <td width="15%">NIM</td>
                            <td width="45%" class="text-left">Nama</td>
                            <td width="10%">Total Kredit</td>
                            <td width="15%">Predikat</td>
                            <td width="11%" class="pr-1">Opsi</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            $nim = $data['nim'];
                            $nama = $data['nama'];
                            $totalKredit = $data['totalKredit'];
                            
                            $predikat = "Kurang";
                            $badge = "danger";
                            if ($totalKredit > $jum3){
                                $predikat = "Prestisius";
                                $badge = "success";
                            } else if ($totalKredit >= $jum2){
                                $predikat = "Sangat Aktif";
                                $badge = "primary";
                            } else if ($totalKredit >= $jum1){
                                $predikat = "Aktif";
                                $badge = "info";
                            }
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-center"> <?php echo $nim;?> </td>
                            <td class="text-left"> <?php echo $nama;?> </td>
                            <td class="text-center"> <strong><?php echo $totalKredit;?></strong> </td>
                            <td class="text-center"> <span class="badge badge-<?php echo $badge; ?>"><?php echo $predikat;?></span> </td>
                            <td class="text-center pr-1"> 
                                <a href="detailSkkmMhsAdm.php?nim=<?php echo $nim;?>&angkatan=<?php echo $angkatan; ?>&page=<?php echo $page;?>" type="button" class="btn btn-outline-info btn-flat btn-xs btn-block" title="Lihat Detail SKKM"><i class="fas fa-eye"></i> Detail</a>
                            </td>
                          </tr>
                          <?php
                            $i++; 
                            $count++;
                            }
                            if ($tcount == 0) {
                                echo '<tr><td colspan="6" class="text-center">Tidak ada data mahasiswa yang mengisi SKKM di angkatan ini.</td></tr>';
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
