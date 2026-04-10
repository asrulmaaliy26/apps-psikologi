<?php include( "contentsConAdm.php" );
  $username = $_SESSION['username'];
  $myquery = "SELECT * FROM dt_mhssw WHERE nim='$username'";
  $dmhssw = mysqli_query($con, $myquery)or die( mysqli_error($con));
  $dataku = mysqli_fetch_assoc($dmhssw);
  $nim = $dataku['nim'];
  
  $qry_moment = "SELECT * FROM pengajuan_dospem WHERE status='1'";
  $hasil = mysqli_query($con, $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_periode=$data['id'];
  $ta=$data['ta'];
   
  $qry_thp = "SELECT * FROM opsi_tahap_ujprop_ujskrip WHERE id='$data[tahap]'";
  $hasil = mysqli_query($con, $qry_thp);
  $dthp = mysqli_fetch_assoc($hasil);
  
  $qry_nm_ta = "SELECT * FROM dt_ta WHERE id='$ta'";
  $hasil = mysqli_query($con, $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
  
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($con, $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
   
  $DATE_NOW=date("Y-m-d H:m:s");
  $START_DATE=date($data['start_datetime']); 
  $END_DATE=date($data['end_datetime']);
   
  $SPLIT_START_DATE=date_create($data['start_datetime']); 
  $SPLIT_END_DATE=date_create($data['end_datetime']);
      
  $dateStart = date_format($SPLIT_START_DATE,"d-m-Y");
  $dateEnd = date_format($SPLIT_END_DATE,"d-m-Y");
  $timeStart = date_format($SPLIT_START_DATE,"H:i");
  $timeEnd = date_format($SPLIT_END_DATE,"H:i");
  ?>
<!DOCTYPE html>
<html lang="en">
  <?php include( "headAdm.php" );?> 
  <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
      <?php 
        include( "navtopAdm.php" );
        include( "navSideBarUserS1.php" );
        ?> 
      <div class="content-wrapper">
        <?php include( "alertUser.php" );?>
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-4">
                <h1 class="m-0 float-left">Pengajuan Dospem Skripsi</h1>
              </div>
              <div class="col-sm-8">
                <ol class="mt-2 breadcrumb float-sm-right">
                  <li class="breadcrumb-item active">Pengajuan Dospem Skripsi</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm">
                <div class="card card-success card-outline card-outline-tabs">
                  <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" href="prePengajuanDospemUser.php" role="tab" aria-selected="true">Form</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="riwayatPengajuanDospemUser.php" role="tab" aria-selected="true">Riwayat</a>
                      </li>
                    </ul>
                  </div>
                  <?php if($END_DATE < $DATE_NOW) { echo 
                    '<div class="card-body">
                       <h5>Pengajuan Dosen Pembimbing Skripsi Tahap '.$dthp['tahap'].' Semester '.$dsemester['nama'].' '.$dnta['ta'].' telah ditutup.</h5>
                      </div>';}
                    else if($START_DATE > $DATE_NOW) {echo 
                    '<div class="card-body">
                       <h5>Pengajuan Dosen Pembimbing Skripsi Tahap '.$dthp['tahap'].' Semester '.$dsemester['nama'].' '.$dnta['ta'].' belum dibuka. <br>Pengajuan dibuka mulai tanggal '.$dateStart.' pukul '.$timeStart.' sampai dengan tanggal '.$dateEnd.' pukul '.$timeEnd.'.</h5>
                      </div>';}
                      else {
                        $cekbio = "SELECT * FROM dt_mhssw WHERE nim='$dataku[nim]'";
                        $rbio = mysqli_query($con, $cekbio) or die( mysqli_error($con));
                        $dbio = mysqli_fetch_array($rbio);
                    
                        $myquery1 = "SELECT * FROM dt_mhssw WHERE nim='$dataku[nim]'";
                        $res1 = mysqli_query($con,  $myquery1 )or die( mysqli_error($con) );
                        $dataku1 = mysqli_fetch_assoc( $res1 );
                        $angkatan=$dataku1['angkatan'];
                        $yearnow=date("Y");
                        $monthnow=date("m");
                        $jarakyear=($yearnow - $angkatan);
                        $jaraksemestergenap=($monthnow <=6)+1+($jarakyear * 2);
                        $jaraksemestergasal=($monthnow >6)+($jarakyear * 2);
                    
                        $cekdata="SELECT nim FROM pengelompokan_dospem_skripsi WHERE nim='$username'";
                        $ada=mysqli_query($con, $cekdata)  or die(mysqli_error($con));
                    
                        if($dbio['fakultas_pertama_daftar']=='' || $dbio['jurusan_pertama_daftar']=='' || $dbio['jurusan_pertama_daftar']==''|| $dbio['asal_sekolah']=='' || $dbio['pend_terakhir']=='' || $dbio['dosen_wali']=='' || $dbio['tempat_lahir']=='' || $dbio['tanggal_lahir']=='' || $dbio['jenis_kelamin']=='' || $dbio['alamat_ktp']=='' || $dbio['alamat_malang']=='' || $dbio['kntk']=='' || $dbio['imel']=='' || $dbio['nama_ayah']=='' || $dbio['alamat_ayah']=='' || $dbio['telepon_ayah']=='' || $dbio['nama_ibu']=='' || $dbio['pekerjaan_ibu']=='' || $dbio['alamat_ibu']=='' || $dbio['telepon_ibu']=='' || $dbio['photo']=='') { echo 
                          '<div class="card-body">
                             <h5>Tidak bisa melakukan pengajuan! Cek dan lengkapi isian biodata terlebih dahulu di menu Profil.</h5>
                           </div>';}
                        else if($jaraksemestergasal <7)  { echo 
                          '<div class="card-body">
                             <h5>Tidak bisa melakukan pengajuan! Anda sekarang masih semester '.$jaraksemestergasal.'.</h5>
                           </div>';}
                        else if($jaraksemestergenap <7)  { echo 
                          '<div class="card-body">
                             <h5>Anda sekarang masih semester '.$jaraksemestergenap.'.</h5>
                           </div>';}
                        else {
                          $cekIsian="SELECT * FROM pengelompokan_dospem_skripsi WHERE nim='$username'";
                          $r=mysqli_query($con, $cekIsian)  or die(mysqli_error($con));
                          $adaIsian = mysqli_fetch_assoc( $r );
                          
                          if(empty($adaIsian['id_periode']) && empty($adaIsian['nim'])) {
                          include ("formPengajuanDospemUserSatu.php");}

                          else if(empty($adaIsian['file_prop'])) {
                          include ("formPengajuanDospemUserDua.php");}

                          else if(empty($adaIsian['dospem_skripsi1'])) {
                          include ("formPengajuanDospemUserTiga.php");}

                          else if(!empty($adaIsian['id_periode']) && !empty($adaIsian['nim']) && !empty($adaIsian['file_prop']) && !empty($adaIsian['dospem_skripsi1'])) { echo
                          '<div class="card-body">
                             <h5>Anda telah submit. Silahkan lihat di menu riwayat.</h5>
                           </div>';}
                        }
                        }?>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include( "footerAdm.php" );?>
    <?php include( "jsAdm.php" );?>
  </body>
</html>
