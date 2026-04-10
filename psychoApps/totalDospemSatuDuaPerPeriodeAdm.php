<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $nip = mysqli_real_escape_string($con,  $_GET[ 'nip' ] );
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );

  $qdt_dospem = "SELECT * FROM dt_pegawai WHERE id='$nip'";
  $hdt_dospem = mysqli_query($con, $qdt_dospem);
  $ddospem = mysqli_fetch_assoc($hdt_dospem);

  $qidper = "SELECT * FROM pengajuan_dospem WHERE id='$id'";
  $ridper = mysqli_query($con, $qidper)or die( mysqli_error($con));
  $didper = mysqli_fetch_assoc($ridper);
  
  $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$didper[tahap]'";
  $hasil = mysqli_query($con, $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
                            
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$didper[ta]'";
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
        include( "navSideBarAdmBakS1.php" );
        ?> 
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Rekap Dospem Skripsi <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" class="text-info" href="rekapDospemAdm.php?page=<?php echo $page;?>">Rekap Dospem Skripsi Per Periode</a></li>
                  <li class="breadcrumb-item small"><a class="text-info" class="text-info" href="rekapDospemPerPeriodeAdm.php?id=<?php echo $id;?>&page=<?php echo $page;?>">List Dospem Skripsi</a></li>
                  <li class="breadcrumb-item active small">Total Dospem I & Dospem II</li>                  
                </ol>
              </div>
            </div>
          </div>
        </div>
        <?php
          include 'pagination.php';
          if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
          	$keyword=$_REQUEST['keyword'];
          	$reload = "totalDospemSatuDuaPerPeriodeAdm.php?pagination=true&nip=$nip&keyword=$keyword";
          
          	 $sql = "SELECT *
          	FROM pengelompokan_dospem_skripsi pds
          	INNER JOIN dt_mhssw dm
          	 on pds.nim = dm.nim
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
          
          WHERE (pds.nim LIKE '%$keyword%' OR dm.nama LIKE '%$keyword%' OR pds.ipk LIKE '%$keyword%' OR pds.sks_ditempuh LIKE '%$keyword%' OR pds.judul_skripsi LIKE '%$keyword%' OR pds.var_1 LIKE '%$keyword%' OR pds.var_2 LIKE '%$keyword%' OR pds.var_3 LIKE '%$keyword%' OR pds.var_4 LIKE '%$keyword%' OR pds.tgl_pengajuan LIKE '%$keyword%' OR pds.thn_pengajuan LIKE '%$keyword%' OR pds.tgl_mulai LIKE '%$keyword%' OR pds.thn_mulai LIKE '%$keyword%' OR pds.tgl_akhir LIKE '%$keyword%' OR pds.thn_akhir LIKE '%$keyword%' OR otuu.tahap LIKE '%$keyword%' OR ons.nama LIKE '%$keyword%' OR ojs.nm LIKE '%$keyword%' OR obs.nm LIKE '%$keyword%' OR ojp.opsi LIKE '%$keyword%' OR ovpd1.nm LIKE '%$keyword%' OR ovpd2.nm LIKE '%$keyword%' OR ovpd3.nm LIKE '%$keyword%' OR ospd.nm LIKE '%$keyword%') AND (pds.dospem_skripsi1='$nip' OR pds.dospem_skripsi2='$nip') AND (pds.status='2' OR pds.status='3')";
          
          $result = mysqli_query($con, $sql);
          }else{
          $reload = "totalDospemSatuDuaPerPeriodeAdm.php?pagination=true&nip=$nip";
          $sql = "SELECT * 
            FROM pengelompokan_dospem_skripsi INNER JOIN dt_mhssw on pengelompokan_dospem_skripsi.nim = dt_mhssw.nim WHERE (pengelompokan_dospem_skripsi.dospem_skripsi1='$nip' OR pengelompokan_dospem_skripsi.dospem_skripsi2='$nip') AND (pengelompokan_dospem_skripsi.status='2' OR pengelompokan_dospem_skripsi.status='3') ORDER BY dt_mhssw.nama ASC";
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
                <form method="post" action="totalDospemSatuDuaPerPeriodeAdm.php?nip=<?php echo $nip;?>">
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
                      <a role="button" class="btn btn-outline-secondary pl-3 pr-3" title="Refresh" href="totalDospemSatuDuaPerPeriodeAdm.php?id=<?php echo $id;?>"><i class="fas fa-sync pr-2"></i>Refresh</a>
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
                      <h4 class="card-title float-left">Total Dospem I & Dospem II</h4>
                      <span class="badge badge-info float-right"> <?php echo $ddospem['nama'];?></span>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="text-center bg-secondary">
                            <td width="4%" class="pl-1">No.</td>
                            <td width="44%">Nama</td>
                            <td width="16%">Periode Pengajuan</td>
                            <td width="12%">Tgl. Pengajuan</td>
                            <td width="12%">Tgl. Mulai</td>
                            <td width="12%" class="pr-1">Tgl. Selesai</td>
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
                            <td class="text-left"><div class="clearfix"><div class="float-left"> <?php echo $dmhssw['nama'].' / '.$dmhssw['nim'];?> </div><div class="float-right"><?php if($nip==$data['dospem_skripsi1']) {echo "<span class='badge badge-primary'>Dospem I</span>";} else if($nip==$data['dospem_skripsi2']) {echo "<span class='badge badge-secondary'>Dospem II</span>";}?></div></div></td>
                            <td class="text-left"> <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?> </td>
                            <td class="text-center"> <?php echo $data['tgl_pengajuan'];?> </td>
                            <td class="text-center"> <?php echo $data['tgl_mulai'];?> </td>
                            <td class="text-center pr-1"> <?php echo $data['tgl_akhir'];?> </td>
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