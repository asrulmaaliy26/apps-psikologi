<?php include( "contentsConAdm.php" );
  $qta = "SELECT * FROM dt_ta WHERE status='1'";
  $rta = mysqli_query($con, $qta)or die( mysqli_error($con));
  $dta = mysqli_fetch_assoc($rta);   
   
  $qwd1 = "SELECT * FROM dt_pegawai WHERE jabatan_instansi = '2'";
  $rwd1 = mysqli_query($con, $qwd1)or die( mysqli_error($con));
  $dwd1 = mysqli_fetch_assoc($rwd1);   
   
  $qkaprodi = "SELECT * FROM dt_pegawai WHERE jabatan_instansi = '47'";
  $rkaprodi = mysqli_query($con, $qkaprodi)or die( mysqli_error($con));
  $dkaprodi = mysqli_fetch_assoc($rkaprodi);
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
            <?php
              if (!empty($_GET['message']) && $_GET['message'] == 'notifSama') {
              echo '
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <span>Ada nama yang mirip, silahkan dicek!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
              echo '
              <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span>Submit berhasil!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
              echo '
              <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span>Edit berhasil!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
              echo '
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <span>Delete berhasil!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              ?>
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Rekap Pengawas Kompre</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active small">Rekap Pengawas Kompre</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination.php';
           $reload = "rekapPengawasKompreAdm.php?pagination=true";
           $sql = "SELECT * FROM dt_pengawas_kompre ORDER BY nm ASC";
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
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Rekap Pengawas Kompre</h4>
                      <button type="button" class="btn btn-outline-danger btn-flat btn-xs float-right" data-toggle="modal" data-target="#inputModal"><i class="fas fa-calendar-plus"></i> Input Pengawas Baru</button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1" rowspan="2">No.</td>
                            <td width="50%" rowspan="2">Nama Pengawas</td>
                            <td class="border-bottom-0" colspan="2">Total Menjadi</td>
                            <td width="10%" rowspan="2">Total</td>
                            <td class="pr-1" rowspan="2" colspan="4">Opsi</td>
                          </tr>
                          <tr class="text-center bg-secondary">
                            <td width="10%" class="pl-1">Pengawas I</td>
                            <td width="10%" class="pr-1">Pengawas II</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            
                            $id = $data['id'];
                            
                            $qry1 = "SELECT COUNT(id) AS jumData FROM jadwal_kompre WHERE pengawas1 = '$id'";
                            $has1 = mysqli_query($con,  $qry1 )or DIE( mysqli_error($con) );
                            $data1 = mysqli_fetch_assoc( $has1 );
                              
                            $qry2 = "SELECT COUNT(id) AS jumData FROM jadwal_kompre WHERE pengawas2 = '$id'";
                            $has2 = mysqli_query($con,  $qry2 )or DIE( mysqli_error($con) );
                            $data2 = mysqli_fetch_assoc( $has2 );
                              
                            $totalPengawas=$data1['jumData'] + $data2['jumData'];
                            ?> 
                          <tr>
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
                            <td class="text-left"> <?php echo $data['nm'];?> </td>
                            <td class="text-center"> <?php if($data1['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data">'.$data1['jumData'].'</a>';} else { echo '<a href="totalPengawas1KompreAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data1['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($data2['jumData']==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data">'.$data2['jumData'].'</a>';} else { echo '<a href="totalPengawas2KompreAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$data2['jumData'].'</a>';} ?> </td>
                            <td class="text-center"> <?php if($totalPengawas==0) { echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" onclick="return confirm(\'Tidak ada data\')" title="Tidak ada data">'.$totalPengawas.'</a>';} else { echo '<a href="totalPengawasKompreAdm.php?id='.$id.'&page='.$page.'" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat data">'.$totalPengawas.'</a>';} ?> </td>
                            <td width="4%" class="text-center pl-1"> <a href="cetakRekapPengawasKompreAdm.php?id=<?php echo "$id";?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Cetak data" target="_blank"><i class="fas fa-print"></i></a> </td>
                            <td width="4%" class="text-center pr-1"> <a href="eksporRekapPengawasKompreAdm.php?id=<?php echo "$id";?>" type="button" class="btn btn-outline-success btn-flat btn-xs btn-block" title="Ekspor data ke Ms. Excel"><i class="fas fa-download"></i></a> </td>
                            <td class="text-center" width="4%"> <a href="editPengawasKompreAdm.php?id=<?php echo $id;?>&page=<?php echo $page;?>" class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Edit pengawas"><i class="far fa-edit"></i></a> </td>
                            <td width="4%" class="pr-1"> <?php if($totalPengawas>0) { echo "<a class='btn btn-outline-secondary btn-flat btn-xs btn-block' onclick='return confirm(\"Tidak bisa dihapus! Pengawas sudah pernah terjadwal\")' title='Tidak bisa dihapus! Pengawas sudah pernah terjadwal' disabled><i class='far fa-trash-alt'></i>
                              </a>";} else { echo "<a class='btn btn-outline-danger btn-flat btn-xs btn-block' href='deletePengawasKompreAdm.php?id=".$id."&page=".$page."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><i class='far fa-trash-alt'></i></a>";}?> </td>
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
      <form action="sformInputPengawasKompreAdm.php" method="post">
        <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-secondary">
              <div class="modal-header">
                <h6 class="modal-title" id="inputModalLabel">Input Pengawas Baru</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="text" name="page" class="sr-only" value="<?php echo $page;?>" required readonly>
                <div class="form-group">
                  <label for="nm">Nama</label>
                  <input type="text" name="nm" class="form-control form-control-sm bg-transparent text-white" required>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-warning btn-flat btn-sm" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline-primary btn-flat btn-sm">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>