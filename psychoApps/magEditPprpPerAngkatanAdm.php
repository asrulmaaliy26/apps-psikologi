<?php 
  include( "contentsConAdm.php" );
  $angkatan = mysqli_real_escape_string($con, $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con, $_GET[ 'page' ] );
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
                <h4 class="m-0">Pengajuan Peminatan Rumpun Psikologi</h4>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-right">
                  <li class="breadcrumb-item"><a href="magEditPprpAdm.php?page=<?php echo $page;?>">Edit Pengajuan</a></li>
                  <li class="breadcrumb-item active">Angkatan <?php echo $angkatan;?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination1.php';
           $reload1 = "magEditPprpPerAngkatanAdm.php?id=$angkatan&page=$page";
           $sql1 = "SELECT * FROM mag_pengelompokan_rumpun WHERE angkatan='$angkatan' ORDER BY id DESC";
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
                    <h3 class="card-title">Angkatan <?php echo $angkatan;?></h3>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-bordered table-hover m-0 text-center table-sm custom">
                        <thead>
                          <tr>
                            <th width="4%" class="pl-1">No.</th>
                            <th width="50%">Nama [NIM]</th>
                            <th width="10%">Tgl. Pengajuan</th>
                            <th width="32%">Pilihan Rumpun</th>
                            <th width="4%" class="pr-1">Opsi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            while(($count1<$rpp1) && ($i1<$tcount1)) {
                            mysqli_data_seek($result1, $i1);
                            $data = mysqli_fetch_array($result1);
                            $id=$data['id'];
                            
                            $qnm = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$data[nim]'";
                            $res = mysqli_query($con, $qnm);
                            $dnm =mysqli_fetch_assoc($res);
                            
                            $qrumpun = "SELECT * FROM mag_opsi_rumpun WHERE id='$data[rumpun]'";
                            $res = mysqli_query($con, $qrumpun);
                            $drumpun = mysqli_fetch_assoc($res);
                            ?> 
                          <tr>
                            <td class="pl-1"><?php echo ++$no_urut;?></td>
                            <td class="text-left"><?php echo $dnm['nama'].' ['.$dnm['nim'].']';?></td>
                            <td><?php echo $data['tgl_pengajuan'];?></td>
                            <td><?php echo $drumpun['nm'];?></td>
                            <td class="pr-1">
                              <?php if($data['cek']==2) {echo '<button type="button" class="btn btn-outline-secondary btn-xs btn-block disabled" title="Telah diverifikasi"><i class="far fa-edit"></i></button>';} else if($data['cek']==1) { echo'<a href="magEditPprpPerIdAdm.php?angkatan='.$angkatan.'&id='.$id.'&page='.$page.'&page1='.$page1.'" type="button" class="btn btn-outline-success btn-xs btn-block" title="Edit"><i class="far fa-edit"></i></a>';}?>
                            </td>
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