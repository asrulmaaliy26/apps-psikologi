<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
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
                  <li class="breadcrumb-item small"><a class="text-info" href="rekapPembimbinganAdm.php">Rekap Pembimbingan Skripsi</a></li>
                  <li class="breadcrumb-item active small">Total Pengajuan Pembimbingan Skripsi</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination.php';
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
            $keyword=$_REQUEST['keyword'];
            $reload = "allPengPembAdm.php?pagination=true&keyword=$keyword";
          
            $sql = "SELECT *
            FROM pengelompokan_dospem_skripsi pds
            INNER JOIN dt_mhssw dm
             on pds.nim = dm.nim
            INNER JOIN dt_pegawai dp1
             on pds.dospem_skripsi1 = dp1.id
            INNER JOIN dt_pegawai dp2
             on pds.dospem_skripsi2 = dp2.id
            INNER JOIN pengajuan_dospem pd
             on pds.id_periode = pd.id
            INNER JOIN opsi_tahap_ujprop_ujskrip otuu
             on pd.tahap = otuu.id
            INNER JOIN dt_ta dt
             on pd.ta = dt.id
            INNER JOIN opsi_nama_semester ons
             on dt.semester = ons.id 
            INNER JOIN opsi_jenis_skripsi ojs
             on pds.jenis_skripsi = ojs.id
            INNER JOIN opsi_bidang_skripsi obs
             on pds.bidang_skripsi = obs.id
            INNER JOIN opsi_jenis_penelitian ojp
             on pds.metode_riset = ojp.id
            INNER JOIN opsi_validasi_pengajuan_dospem ovpd1
             on pds.cek1 = ovpd1.id  
            INNER JOIN opsi_validasi_pengajuan_dospem ovpd2
             on pds.cek2 = ovpd2.id
            INNER JOIN opsi_validasi_pengajuan_dospem ovpd3
             on pds.cekjudul = ovpd3.id 
            INNER JOIN opsi_status_pengajuan_dospem ospd
             on pds.status = ospd.id

            WHERE (pds.nim LIKE '%$keyword%' OR dm.nama LIKE '%$keyword%' OR dp1.nama LIKE '%$keyword%' OR dp2.nama LIKE '%$keyword%' OR pds.ipk LIKE '%$keyword%' OR pds.sks_ditempuh LIKE '%$keyword%' OR pds.judul_skripsi LIKE '%$keyword%' OR pds.var_1 LIKE '%$keyword%' OR pds.var_2 LIKE '%$keyword%' OR pds.var_3 LIKE '%$keyword%' OR pds.var_4 LIKE '%$keyword%' OR pds.tgl_pengajuan LIKE '%$keyword%' OR pds.thn_pengajuan LIKE '%$keyword%' OR otuu.tahap LIKE '%$keyword%' OR ons.nama LIKE '%$keyword%' OR ojs.nm LIKE '%$keyword%' OR obs.nm LIKE '%$keyword%' OR ojp.opsi LIKE '%$keyword%' OR ovpd1.nm LIKE '%$keyword%' OR ovpd2.nm LIKE '%$keyword%' OR ovpd3.nm LIKE '%$keyword%' OR ospd.nm LIKE '%$keyword%') AND (pds.status='1') ORDER BY dm.nama ASC";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "allPengPembAdm.php?pagination=true";
          $sql = "SELECT *
            FROM pengelompokan_dospem_skripsi INNER JOIN dt_mhssw on pengelompokan_dospem_skripsi.nim = dt_mhssw.nim WHERE pengelompokan_dospem_skripsi.status='1' ORDER BY dt_mhssw.nama ASC";
          $result = mysqli_query($con, $sql);
           }
           
           $rpp = 50;
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
              <div class="col mb-2">
                <form method="post" action="allPengPembAdm.php?page=<?php echo $page;?>">
                  <?php error_reporting(E_ALL & ~E_NOTICE);?>
                  <div class="input-group input-group-sm">
                    <input type="search" name="keyword" class="form-control form-control bg-light border-secondary" placeholder="Kata kunci..." value="<?php echo $_REQUEST['keyword'];?>" required>
                    <div class="input-group-append">
                      <button role="button" type="submit" class="btn btn-outline-secondary pl-3 pr-3">
                      <i class="fa fa-search"></i>
                      </button>
                      <?php
                        if($_REQUEST['keyword']<>""){
                        ?>
                      <a role="button" class="btn btn-outline-secondary pl-3 pr-3" title="Refresh" href="allPengPembAdm.php?page=<?php echo $page;?>"><i class="fas fa-sync pr-2"></i>Refresh</a>
                      <?php
                        }
                        ?>
                    </div>
                  </div>
                </form>
              </div>
              <section class="col-md-12 connectedSortable">
                <div class="card card-outline card-info">
                  <div class="card-header">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Total Pengajuan Pembimbingan Skripsi</h4>
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
                            while(($count<$rpp) && ($i<$tcount)) {
                            mysqli_data_seek($result, $i);
                            $data = mysqli_fetch_array($result);
                            include( "phpverdos.php" );
                            ?> 
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="text-center pl-1"> <?php echo ++$no_urut;?> </td>
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