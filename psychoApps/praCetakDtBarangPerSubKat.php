<?php include( "contentsConAdm.php" );
  $qry_jum = "SELECT COUNT(id) AS jumData FROM dt_inventaris_barang";
  $r_jum = mysqli_query($con,  $qry_jum )or DIE( mysqli_error($con) );
  $d_jum = mysqli_fetch_assoc( $r_jum );
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarAdmBmn.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h4 class="mb-0">Cetak</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Data Barang</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php include 'pagination.php';
          $reload = "praCetakDtBarangPerSubKat.php?pagination=true";
          $sql = "SELECT * FROM dt_inventaris_barang GROUP BY sub_kategori ORDER BY sub_kategori ASC";
          $result = mysqli_query($con, $sql);
          
          $rpp = 20;
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
              <section class="col-md-12 connectedSortable">
                <div class="card card-danger card-outline card-outline-tabs">
                  <div class="card-header p-0 pb-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link" href="praCetakDtBarangPerMerk.php" role="tab" aria-selected="false">Merk</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="praCetakDtBarangPerTahun.php" role="tab" aria-selected="false">Tahun Perolehan</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="praCetakDtBarangPerSumDa.php" role="tab" aria-selected="false">Sumber Dana</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="praCetakDtBarangPerKat.php" role="tab" aria-selected="false">Kategori</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" href="praCetakDtBarangPerSubKat.php" role="tab" aria-selected="true">Sub Kategori</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="praCetakDtBarangPerLetak.php" role="tab" aria-selected="false">Letak</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="praCetakDtBarangPerKondisi.php" role="tab" aria-selected="false">Kondisi</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="praCetakDtBarangPerStatus.php" role="tab" aria-selected="false">Status</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="cetakDtBarangAll.php" role="tab" aria-selected="false" target="_blank">Semua Barang</a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-sm custom">
                        <thead class="thead-light">
                          <th width="4%" class="pl-1 text-center">No.</th>
                          <th width="52%">Sub Kategori</th>
                          <th width="36%">Jumlah</th>
                          <th class="pr-1 text-center" colspan="2">Opsi</th>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $qry_sub_kat = "SELECT * FROM opsi_sub_kat_barang WHERE id='$data[sub_kategori]'";
                            $r_sub_kat = mysqli_query($con, $qry_sub_kat);
                            $d_sub_kat = mysqli_fetch_assoc($r_sub_kat);
                            
                            $qry_jum = "SELECT COUNT(id) AS jumData FROM dt_inventaris_barang WHERE sub_kategori='$data[sub_kategori]'";
                            $r_jum = mysqli_query($con,  $qry_jum )or DIE( mysqli_error($con) );
                            $d_jum = mysqli_fetch_assoc( $r_jum );
                            ?>
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-left"> <?php echo $d_sub_kat['nm'];?> </td>
                            <td class="text-left"> <?php echo $d_jum['jumData'];?> </td>
                            <td class="text-center" width="4%"> <a href="cetakDtBarangPerSubKat.php?id=<?php echo $data['sub_kategori'];?>&page=<?php echo $page;?>" target="_blank" class="btn btn-outline-primary btn-xs btn-block" title="Cetak data"><i class="fas fa-print"></i></a> </td>
                            <td class="text-center pr-1" width="4%"> <a href="eksporDtBarangPerSubKat.php?id=<?php echo $data['sub_kategori'];?>&page=<?php echo $page;?>" class="btn btn-outline-success btn-xs btn-block" title="Ekspor data"><i class="fas fa-file-excel"></i></a> </td>
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
                    <div class="float-right"><?php echo paginate_one($reload, $page, $tpages);?></div>
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