<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $angkatan = mysqli_real_escape_string($con,  $_GET[ 'angkatan' ] );
  $page0 = mysqli_real_escape_string($con,  $_GET[ 'page0' ] );
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
                <h6 class="m-0">Rekap Pembimbingan Skripsi</h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="rekapPembimbinganAdm.php?page=<?php echo $page0;?>">Rekap Pembimbingan Skripsi</a></li>
                  <li class="breadcrumb-item active small">Pengajuan Angkatan <?php echo $angkatan;?></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Pengajuan Angkatan <?php echo $angkatan;?></h4>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1">No.</td>
                            <td width="20%">Nama</td>
                            <td width="26%">Judul</td>
                            <td width="20%">Dospem I</td>
                            <td width="20%">Dospem II</td>
                            <td width="10%" class="pr-1">Tgl. Pengajuan</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM pengelompokan_dospem_skripsi WHERE angkatan='$angkatan' AND status='1' ORDER BY NIM ASC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {
                            include( "phpverdos.php" );
                            ?> 
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"> <?php echo $no;?> </td>
                            <td class="text-left"> <?php echo $dmhssw['nama'].' / '.$dmhssw['nim'];?> </td>
                            <td class="text-left"> <?php echo $data['judul_skripsi']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['judul_skripsi']);?> </td>
                            <td class="text-left"> <?php echo $ddospem1['nama'];?> </td>
                            <td class="text-left"> <?php echo $ddospem2['nama'];?> </td>
                            <td class="text-center pr-1"> <?php echo $data['tgl_pengajuan'];?> </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="6">
                              <section class="content pt-2">
                                <div class="container-fluid">
                                  <div class="row">
                                    <div class="col-md-5">
                                      <div class="card card-primary card-outline">
                                        <div class="card-body box-profile">
                                          <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle"
                                              src="<?php echo $dmhssw['photo'];?>" onError="this.onerror=null;this.src='<?php if($dmhssw['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="">
                                          </div>
                                          <h3 class="profile-username text-center"><?php echo $dmhssw['nama'];?></h3>
                                          <p class="text-muted text-center"><?php echo $dmhssw['nim'];?></p>
                                          <ul class="list-group list-group-unbordered mb-3 text-left">
                                            <li class="list-group-item">
                                              <b>Kontak</b> <a class="float-right"><?php echo $dmhssw['kntk'];?></a>
                                            </li>
                                            <li class="list-group-item">
                                              <b>Email</b> <a class="float-right"><?php echo $dmhssw['imel'];?></a>
                                            </li>
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-7">
                                      <?php include( "profilPembimbingan.php" );?>
                                    </div>
                                  </div>
                                </div>
                              </section>
                            </td>
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