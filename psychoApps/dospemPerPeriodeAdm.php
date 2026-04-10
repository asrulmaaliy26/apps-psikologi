<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  $id = mysqli_real_escape_string($con,  $_GET[ 'id' ] );
  $page = mysqli_real_escape_string($con,  $_GET[ 'page' ] );
  
  $qper = "SELECT * FROM pengelompokan_dospem_skripsi WHERE id_periode='$id'";
  $rper = mysqli_query($con, $qper)or die( mysqli_error($con));
  $dper = mysqli_fetch_assoc($rper);
  
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
            <?php 
              if (!empty($_GET['message']) && $_GET['message'] == 'notifSama') {
              echo '
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <span>Submit gagal! Data yang diinput sudah ada, silahkan cek lagi!</span>
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
              <div class="alert alert-success alert-dismissible fade show" role="alert">
              <span>Delete berhasil!</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              </div>
              ';}
              ?>
            <div class="row">
              <div class="col-sm-6">
                <h6 class="m-0">Pengajuan Dospem Skripsi <?php echo 'Tahap '.$dthp['tahap'].' '.$dsemester['nama'].' '.$dnta['ta'].'';?></h6>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item small"><a class="text-info" href="pngjnDospemAdm.php?page=<?php echo $page;?>">Periode Pengajuan</a></li>
                  <li class="breadcrumb-item active small">Data Dospem Skripsi</li>
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
                      <h4 class="card-title float-left">Data Dospem Skripsi</h4>
                      <button type="button" class="btn btn-outline-danger btn-flat btn-xs float-right" data-toggle="modal" data-target="#inputModal"><i class="fas fa-user-graduate"></i> Input Dospem Skripsi</button>
                    </div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                        <thead>
                          <tr class="bg-secondary">
                            <td width="4%" class="pl-1">No.</td>
                            <td width="48%">Nama</td>
                            <td width="20%">Kuota Dospem Skripsi I</td>
                            <td width="20%">Kuota Dospem Skripsi II</td>
                            <td class="pr-1" colspan="2">Opsi</td>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;
                            $sql = "SELECT * FROM dospem_skripsi INNER JOIN dt_pegawai ON dospem_skripsi.nip=dt_pegawai.id WHERE dospem_skripsi.id_periode='$id' ORDER BY dt_pegawai.nama_tg ASC";
                            $result = mysqli_query($con, $sql);
                            while($data = mysqli_fetch_array($result)) {
                            
                            $qdt_dospem = "SELECT * FROM dt_pegawai WHERE id='$data[nip]'";
                            $hdt_dospem = mysqli_query($con, $qdt_dospem);
                            $ddospem = mysqli_fetch_assoc($hdt_dospem);
                            
                            $qr = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$ddospem[kepakaran_mayor]'";
                            $rr = mysqli_query($con, $qr)or die( mysqli_error($con));
                            $dr = mysqli_fetch_assoc($rr);
                            
                            $qcek1 = "SELECT * FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$data[nip]' AND id_periode='$id'";
                            $rcek1 = mysqli_query($con, $qcek1)or die( mysqli_error($con));
                            $dcekselesai1 = mysqli_fetch_assoc($rcek1);
                            $selesai1 = $dcekselesai1['status'];
                            $dcekpengaju1 = mysqli_num_rows($rcek1);
                            
                            $qcek2 = "SELECT * FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$data[nip]' AND id_periode='$id'";
                            $rcek2 = mysqli_query($con, $qcek2)or die( mysqli_error($con));
                            $dcekselesai2 = mysqli_fetch_assoc($rcek2);
                            $selesai2 = $dcekselesai2['status'];
                            $dcekpengaju2 = mysqli_num_rows($rcek2);
                            
                            $qry1 = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$data[nip]' AND id_periode='$id' AND (cek1='1' OR cek1='2') AND status='1'";
                            $result1 =  mysqli_query($con, $qry1) or die(mysqli_error($con));
                            $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($con));
                            $jumlahData1 = $dataku1['jumData'];
                            $sisa1 = $data['kuota1'] - $jumlahData1;
                                        
                            $qry2 = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$data[nip]' AND id_periode='$id' AND (cek2='1' OR cek2='2') AND status='1'";
                            $result2 =  mysqli_query($con, $qry2) or die(mysqli_error($con));
                            $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($con));
                            $jumlahData2 = $dataku2['jumData'];
                            $sisa2 = $data['kuota2'] - $jumlahData2;
                            
                            $qpengaju1 = "SELECT * FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$data[nip]' AND id_periode='$id' AND status='1'";
                            $row1 = mysqli_query($con, $qpengaju1);
                            $dpengaju1 = mysqli_num_rows($row1);
                            
                            $qpengaju2 = "SELECT * FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$data[nip]' AND id_periode='$id' AND status='1'";
                            $row2 = mysqli_query($con, $qpengaju2);
                            $dpengaju2 = mysqli_num_rows($row2);
                            
                            $qry1 = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$data[nip]' AND id_periode='$id' AND cek1='1'";
                            $result1 =  mysqli_query($con, $qry1) or die(mysqli_error($con));
                            $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($con));
                            $jumlahData1 = $dataku1['jumData'];
                            
                            $qry11 = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$data[nip]' AND cek1='1'";
                            $result11 =  mysqli_query($con, $qry11) or die(mysqli_error($con));
                            $dataku11 = mysqli_fetch_assoc($result11) or die(mysqli_error($con));
                            $jumlahData11 = $dataku11['jumData'];
                            
                            $qry2 = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$data[nip]' AND id_periode='$id' AND cek2='1'";
                            $result2 =  mysqli_query($con, $qry2) or die(mysqli_error($con));
                            $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($con));
                            $jumlahData2 = $dataku2['jumData'];
                            
                            $qry21 = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$data[nip]' AND cek2='1'";
                            $result21 =  mysqli_query($con, $qry21) or die(mysqli_error($con));
                            $dataku21 = mysqli_fetch_assoc($result21) or die(mysqli_error($con));
                            $jumlahData21 = $dataku21['jumData'];
                            
                            $jumPengajuan = ($jumlahData1 + $jumlahData2);
                            $allJumPengajuan = ($jumlahData11 + $jumlahData21);
                            
                            $qry3 = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$data[nip]' AND id_periode='$id' AND (cek1='2' OR cek1='3') AND status='2'";
                            $result3 =  mysqli_query($con, $qry3) or die(mysqli_error($con));
                            $dataku3 = mysqli_fetch_assoc($result3) or die(mysqli_error($con));
                            $jumlahData3 = $dataku3['jumData'];
                            
                            $qry31 = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$data[nip]' AND (cek1='2' OR cek1='3') AND status='2'";
                            $result31 =  mysqli_query($con, $qry31) or die(mysqli_error($con));
                            $dataku31 = mysqli_fetch_assoc($result31) or die(mysqli_error($con));
                            $jumlahData31 = $dataku31['jumData'];
                            
                            $qry4 = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$data[nip]' AND id_periode='$id' AND (cek2='2' OR cek2='3') AND status='2'";
                            $result4 =  mysqli_query($con, $qry4) or die(mysqli_error($con));
                            $dataku4 = mysqli_fetch_assoc($result4) or die(mysqli_error($con));
                            $jumlahData4 = $dataku4['jumData'];
                            
                            $qry41 = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$data[nip]' AND (cek2='2' OR cek2='3') AND status='2'";
                            $result41 =  mysqli_query($con, $qry41) or die(mysqli_error($con));
                            $dataku41 = mysqli_fetch_assoc($result41) or die(mysqli_error($con));
                            $jumlahData41 = $dataku41['jumData'];
                            
                            $jumProses = ($jumlahData3 + $jumlahData4);
                            $allJumProses = ($jumlahData31 + $jumlahData41);
                            
                            $qry5 = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$data[nip]' AND id_periode='$id' AND (cek1='2' OR cek1='3') AND (cekjudul='2' OR cekjudul='3') AND status='3'";
                            $result5 =  mysqli_query($con, $qry5) or die(mysqli_error($con));
                            $dataku5 = mysqli_fetch_assoc($result5) or die(mysqli_error($con));
                            $jumlahData5 = $dataku5['jumData'];
                            
                            $qry51 = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$data[nip]' AND (cek1='2' OR cek1='3') AND (cekjudul='2' OR cekjudul='3') AND status='3'";
                            $result51 =  mysqli_query($con, $qry51) or die(mysqli_error($con));
                            $dataku51 = mysqli_fetch_assoc($result51) or die(mysqli_error($con));
                            $jumlahData51 = $dataku51['jumData'];
                            
                            $qry6 = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$data[nip]' AND id_periode='$id' AND (cek2='2' OR cek2='3') AND (cekjudul='2' OR cekjudul='3') AND status='3'";
                            $result6 =  mysqli_query($con, $qry6) or die(mysqli_error($con));
                            $dataku6 = mysqli_fetch_assoc($result6) or die(mysqli_error($con));
                            $jumlahData6 = $dataku6['jumData'];
                            
                            $qry61 = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$data[nip]' AND (cek2='2' OR cek2='3') AND (cekjudul='2' OR cekjudul='3') AND status='3'";
                            $result61 =  mysqli_query($con, $qry61) or die(mysqli_error($con));
                            $dataku61 = mysqli_fetch_assoc($result61) or die(mysqli_error($con));
                            $jumlahData61 = $dataku61['jumData'];
                            
                            $jumSelesai = ($jumlahData5 + $jumlahData6);
                            $allJumSelesai = ($jumlahData51 + $jumlahData61);
                            
                            $qry7 = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$data[nip]' AND id_periode='$id'";
                            $result7 =  mysqli_query($con, $qry7) or die(mysqli_error($con));
                            $dataku7 = mysqli_fetch_assoc($result7) or die(mysqli_error($con));
                            $jumlahData7 = $dataku7['jumData'];
                            
                            $qry71 = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi1='$data[nip]'";
                            $result71 =  mysqli_query($con, $qry71) or die(mysqli_error($con));
                            $dataku71 = mysqli_fetch_assoc($result71) or die(mysqli_error($con));
                            $jumlahData71 = $dataku71['jumData'];
                            
                            $qry8 = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$data[nip]' AND id_periode='$id'";
                            $result8 =  mysqli_query($con, $qry8) or die(mysqli_error($con));
                            $dataku8 = mysqli_fetch_assoc($result8) or die(mysqli_error($con));
                            $jumlahData8 = $dataku8['jumData'];
                            
                            $qry81 = "SELECT COUNT(*) AS jumData FROM pengelompokan_dospem_skripsi WHERE dospem_skripsi2='$data[nip]'";
                            $result81 =  mysqli_query($con, $qry81) or die(mysqli_error($con));
                            $dataku81 = mysqli_fetch_assoc($result81) or die(mysqli_error($con));
                            $jumlahData81 = $dataku81['jumData'];
                            
                            $jumTotal = ($jumlahData7 + $jumlahData8);
                            $allJumTotal = ($jumlahData71 + $jumlahData81);
                            $no++;
                            ?>
                          <tr data-widget="expandable-table" aria-expanded="false">
                            <td class="pl-1"> <?php echo $no;?> </td>
                            <td class="text-left"> <?php echo $ddospem['nama_tg'];?> </td>
                            <td class="text-left"> <?php if($data['kuota1']==0) { echo '<span class="text-secondary">Tidak ada kuota</span>';} else if($data['kuota1'] - $jumlahData1==0) { echo '<span class="text-success">Penuh</span>';} else {echo $data['kuota1'].' (tersisa '.$sisa1.')';}?> </td>
                            <td class="text-left"> <?php if($data['kuota2']==0) { echo '<span class="text-secondary">Tidak ada kuota</span>';} else if($data['kuota2'] - $jumlahData2==0) { echo '<span class="text-success">Penuh</span>';} else {echo $data['kuota2'].' (tersisa '.$sisa2.')';}?> </td>
                            <td width="4%"> <?php if($selesai1==3 || $selesai2==3) { echo "<a class='btn btn-outline-secondary btn-flat btn-xs btn-block' onclick='return confirm(\"Tidak bisa diedit! Pembimbingan sudah selesai\")' title='Tidak bisa diedit! Pembimbingan sudah selesai'><i class='far fa-edit'></i></a>";} else { echo '<a href="editKuotaDospemAdm.php?id='.$data['id'].'&id_periode='.$id.'&page='.$page.'" class="btn btn-outline-warning btn-flat btn-xs btn-block" title="Edit kuota"><i class="far fa-edit"></i></a>';}?> </td>
                            <td width="4%" class="pr-1"> <?php if($dcekpengaju1 > 0 || $dcekpengaju2 > 0) { echo "<a class='btn btn-outline-secondary btn-flat btn-xs btn-block' onclick='return confirm(\"Tidak bisa dihapus! Sudah ada pengajuan\")' title='Tidak bisa dihapus! Sudah ada pengajuan'><i class='far fa-trash-alt'></i></a>";} else { echo "<a class='btn btn-outline-danger btn-flat btn-xs btn-block' href='deleteDospemAdm.php?id=".$data['id']."&id_periode=".$id."&page=".$page."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><i class='far fa-trash-alt'></i></a>";}?> </td>
                          </tr>
                          <tr class="expandable-body">
                            <td colspan="6">
                              <section class="content pt-2">
                                <div class="container-fluid">
                                  <div class="row">
                                    <div class="col-md-4">
                                      <div class="card card-primary card-outline">
                                        <div class="card-body box-profile">
                                          <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle"
                                              src="<?php echo '/sikep/'.$ddospem['photo'];?>" onError="this.onerror=null;this.src='<?php if($ddospem['jenis_kelamin']==1){echo "/sikep/images/cewek.png";} else {echo "/sikep/images/cowok.png";}?>';" alt="">
                                          </div>
                                          <h3 class="profile-username text-center"><?php echo $ddospem['nama_tg'];?></h3>
                                          <p class="text-muted text-center"><?php echo $ddospem['id'];?></p>
                                          <ul class="list-group list-group-unbordered mb-3 text-left">
                                            <li class="list-group-item">
                                              <b>Dipilih sebagai Dospem I</b> <a class="float-right"><?php echo "$jumlahData7";?></a>
                                            </li>
                                            <li class="list-group-item">
                                              <b>Dipilih sebagai Dospem II</b> <a class="float-right"><?php echo "$jumlahData8";?></a>
                                            </li>
                                            <li class="list-group-item">
                                              <b>Belum Diverifikasi</b> <a class="float-right"><?php echo "$jumPengajuan";?></a>
                                            </li>
                                            <li class="list-group-item">
                                              <b>Sedang Proses Pembimbingan</b> <a class="float-right"><?php echo "$jumProses";?></a>
                                            </li>
                                            <li class="list-group-item">
                                              <b>Telah Selesai Pembimbingan</b> <a class="float-right"><?php echo "$jumSelesai";?></a>
                                            </li>
                                            <li class="list-group-item">
                                              <b>Total</b> <a class="float-right"><?php echo "$jumTotal";?></a>
                                            </li>
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-8">
                                      <div class="card">
                                        <div class="card-header p-2">
                                          <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#profil<?php echo $data['id'];?>" data-toggle="tab">Profil</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#rekap<?php echo $data['id'];?>" data-toggle="tab">Rekap</a></li>
                                          </ul>
                                        </div>
                                        <div class="card-body">
                                          <div class="tab-content">
                                            <div class="active tab-pane" id="profil<?php echo $data['id'];?>">
                                              <div class="card card-outline card-success">
                                                <div class="card-header">
                                                  <h3 class="card-title">Profil</h3>
                                                </div>
                                                <div class="card-body">
                                                  <div class="post text-left">
                                                    <div class="user-block">
                                                      <img class="img-circle img-bordered-sm" src="<?php echo '/sikep/'.$ddospem['photo'];?>" onError="this.onerror=null;this.src='<?php if($ddospem['jenis_kelamin']==1){echo "/sikep/images/cewek.png";} else {echo "/sikep/images/cowok.png";}?>';" alt="user image">
                                                      <span class="username">
                                                      <span><?php echo $ddospem['nama'];?></span>
                                                      </span>
                                                      <span class="description"><?php echo $ddospem['id'];?></span>
                                                      <span class="description"><b>Kontak:</b> <?php echo $ddospem['kntk1'];?></span>
                                                      <span class="description"><b>Email:</b> <?php echo $ddospem['email1'];?></span>
                                                    </div>
                                                    <dl>
                                                      <dt><i class="fas fa-user-graduate mr-1"></i> Kepakaran Mayor</dt>
                                                      <dd><?php echo $dr['nm'];?></dd>
                                                      <dt><i class="fas fa-user-graduate mr-1"></i> Kepakaran Minor</dt>
                                                      <dd><?php echo $ddospem['kepakaran_minor'];?></dd>
                                                      <dt><i class="fas fa-user-graduate mr-1"></i> Tren Riset</dt>
                                                      <dd><?php echo $ddospem['trend_riset']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $ddospem['trend_riset']);?></dd>
                                                      <dt><i class="fas fa-user-graduate mr-1"></i> Riset Terkini</dt>
                                                      <dd><?php echo $ddospem['profil_riset_terkini']=preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $ddospem['profil_riset_terkini']);?></dd>
                                                    </dl>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="tab-pane" id="rekap<?php echo $data['id'];?>">
                                              <div class="card card-primary">
                                                <div class="card-header">
                                                  <h3 class="card-title">Rekap Periode Ini</h3>
                                                </div>
                                                <div class="card-body text-left p-0">
                                                  <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                      <span class="nav-link text-primary">
                                                      Kuota Dospem I <span class="float-right badge bg-primary"><?php echo $data['kuota1'];?></span>
                                                      </span>
                                                    </li>
                                                    <li class="nav-item">
                                                      <span class="nav-link text-primary">
                                                      Kuota Dospem II <span class="float-right badge bg-primary"><?php echo $data['kuota2'];?></span>
                                                      </span>
                                                    </li>
                                                    <li class="nav-item">
                                                      <span class="nav-link text-primary">
                                                      Dipilih sebagai Dospem I <span class="float-right badge bg-primary"><?php echo "$jumlahData1";?></span>
                                                      </span>
                                                    </li>
                                                    <li class="nav-item">
                                                      <span class="nav-link text-primary">
                                                      Dipilih sebagai Dospem II <span class="float-right badge bg-primary"><?php echo "$jumlahData2";?></span>
                                                      </span>
                                                    </li>
                                                    <li class="nav-item">
                                                      <span class="nav-link text-primary">
                                                      Belum Diverifikasi <span class="float-right badge bg-primary"><?php echo "$jumPengajuan";?></span>
                                                      </span>
                                                    </li>
                                                    <li class="nav-item">
                                                      <span class="nav-link text-primary">
                                                      Sedang Proses Pembimbingan <span class="float-right badge bg-primary"><?php echo "$jumProses";?></span>
                                                      </span>
                                                    </li>
                                                    <li class="nav-item">
                                                      <span class="nav-link text-primary">
                                                      Telah Selesai Pembimbingan <span class="float-right badge bg-primary"><?php echo "$jumSelesai";?></span>
                                                      </span>
                                                    </li>
                                                    <li class="nav-item">
                                                      <span class="nav-link text-primary">
                                                      Total <span class="float-right badge bg-primary"><?php echo "$jumTotal";?></span>
                                                      </span>
                                                    </li>
                                                  </ul>
                                                </div>
                                              </div>
                                              <div class="card card-danger">
                                                <div class="card-header">
                                                  <h3 class="card-title">Rekap Semua Periode</h3>
                                                </div>
                                                <div class="card-body text-left p-0">
                                                  <ul class="nav flex-column">
                                                    <li class="nav-item">
                                                      <span class="nav-link text-danger">
                                                      Dipilih sebagai Dospem I <span class="float-right badge bg-danger"><?php echo "$jumlahData11";?></span>
                                                      </span>
                                                    </li>
                                                    <li class="nav-item">
                                                      <span class="nav-link text-danger">
                                                      Dipilih sebagai Dospem II <span class="float-right badge bg-danger"><?php echo "$jumlahData21";?></span>
                                                      </span>
                                                    </li>
                                                    <li class="nav-item">
                                                      <span class="nav-link text-danger">
                                                      Belum Diverifikasi <span class="float-right badge bg-danger"><?php echo "$allJumPengajuan";?></span>
                                                      </span>
                                                    </li>
                                                    <li class="nav-item">
                                                      <span class="nav-link text-danger">
                                                      Sedang Proses Pembimbingan <span class="float-right badge bg-danger"><?php echo "$allJumProses";?></span>
                                                      </span>
                                                    </li>
                                                    <li class="nav-item">
                                                      <span class="nav-link text-danger">
                                                      Telah Selesai Pembimbingan <span class="float-right badge bg-danger"><?php echo "$allJumSelesai";?></span>
                                                      </span>
                                                    </li>
                                                    <li class="nav-item">
                                                      <span class="nav-link text-danger">
                                                      Total <span class="float-right badge bg-danger"><?php echo "$allJumTotal";?></span>
                                                      </span>
                                                    </li>
                                                  </ul>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
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
      <form action="sformInputDospemPerPeriodeAdm.php" method="post">
        <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-secondary">
              <div class="modal-header">
                <h6 class="modal-title" id="inputModalLabel">Input Dospem Skripsi</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <input type="text" name="id" class="sr-only" value="<?php echo "$id";?>" required readonly>
                <input type="text" name="page" class="sr-only" value="<?php echo "$page";?>" required readonly>
                <div class="form-group">
                  <label for="nip">Nama Dospem Skripsi</label>
                  <select name="nip" class="form-control form-control-sm bg-secondary text-white" id="nip" required>
                    <option value="">-Pilih-</option>
                    <?php
                      $q = mysqli_query($con, "SELECT * FROM dt_pegawai WHERE jenis_pegawai='1' AND status='1' ORDER BY nama_tg ASC");
                      while ($tampil = mysqli_fetch_array($q)){
                        echo "<option value='$tampil[id]'>$tampil[nama_tg]</option>";
                      }
                      ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="kuota1">Kuota Dospem Skripsi I</label>
                  <input type="number" min="0" max="20" name="kuota1" class="form-control form-control-sm bg-transparent text-white" required/>
                </div>
                <div class="form-group">
                  <label for="kuota2">Kuota Dospem Skripsi II</label>
                  <input type="number" min="0" max="20" name="kuota2" class="form-control form-control-sm bg-transparent text-white" required/>
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