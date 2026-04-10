<?php
  include("koneksiUser.php");
  $nim = $_SESSION['nim'];
  
  $myquery = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
  $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  $qry_moment = "SELECT * FROM mag_periode_pengajuan_ac WHERE status='1'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_periode=$data['id'];
  $ta=$data['ta'];
   
  $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$ta'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
  
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
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
<html lang="en">
  <head>
    <?php include 'headUser.php';?>
  </head>
  <body>
    <?php include "navPngjnUser.php";?>
    <div class="container">
      <div class="row">
        <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifGagal') {
          echo '
          <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog">
          <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Submit gagal</h4>
          </div>
          <div class="modal-body">
          <p>Kuota Academic coach yang dipilih sudah penuh...</p>
          <p><strong>Note:</strong> Silahkan pilih Academic coach yang belum penuh kuotanya...</p>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          </div>
          </div>
          </div>
          ';}	  
          if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
                 echo '<div class="alert alert-warning custom-alert" role="alert">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Submit berhasil...</div>';}
           
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
                 echo '<div class="alert alert-success custom-alert" role="alert">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Data berhasil diupdate...</div>';}
                 ?>
        <h3 class="text-center text-info">Academic Coach</h3>
        <?php         
          if($DATE_NOW < $START_DATE) {echo 
          "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-danger text-center'>Maaf... <br />Pengajuan Academic Coach <br />
          Semester ".$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Belum Dibuka!</strong></p>
          </div>";
		  include 'includeRekapPacUser.php';
		  }
          
		  else if($DATE_NOW > $END_DATE) {echo 
          "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-danger text-center'>Maaf... <br />Pengajuan Academic Coach <br />
          Semester ".$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Telah Ditutup!</strong></p>
          </div>";
		  include 'includeRekapPacUser.php';
		  }
          
          else if($START_DATE <= $DATE_NOW && $DATE_NOW <= $END_DATE) {
          
          $cekbio = "select * from mag_dt_mhssw_pasca WHERE nim='$dataku[nim]'";
          $rbio = mysqli_query($GLOBALS["___mysqli_ston"], $cekbio) or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          $dbio = mysqli_fetch_array($rbio);
          
          $cekr = "select * from mag_pengelompokan_rumpun WHERE nim='$dataku[nim]' && cek='2'";
          $rr = mysqli_query($GLOBALS["___mysqli_ston"], $cekr) or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          
          if($dbio['gelar_belakang']=='' || $dbio['tempat_lahir']=='' || $dbio['tanggal_lahir']=='' || $dbio['jenis_kelamin']=='' || $dbio['alamat_ktp']=='' || $dbio['alamat_malang']=='' || $dbio['kntk']=='' || $dbio['email']=='' || $dbio['pekerjaan']=='' || $dbio['asal_s1']=='' || $dbio['pend_terakhir']=='' || $dbio['nama_ibu']=='' || $dbio['nama_ayah']=='' || $dbio['photo']=='' || (mysqli_num_rows($rr)<1)) 
           {
          echo "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-primary'>Pengajuan Academic Coach
          Semester ".$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Sedang Dibuka!</strong><br />
          Cek dan lengkapi isian berikut ini dengan benar, agar form pengajuan dapat diakses:<br />
          <a href='dashboardUser.php' class='btn btn-primary'>Biodata</a>
          <a href='formPengajuanPrp.php' class='btn btn-primary'>Pengajuan Peminatan Rumpun Psikologi</a>
          </div>";
		  include 'includeRekapPacUser.php';
          } else {
          $q = "SELECT nim FROM mag_pengelompokan_dosen_wali WHERE nim='$dataku[nim]'";
          $r = mysqli_query($GLOBALS["___mysqli_ston"], $q)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          $d = mysqli_num_rows($r);
          
          if($d==0)  {include 'includeFormPac.php';}
          elseif($d==1) {include 'includeRekapPacUser.php';}
          }
          }
          ?>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalDetailOpsi" aria-labelledby="labelModalDetailOpsi" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalDetailOpsi">Detail profil Academic Coach</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalDetailOpsi"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalListPengajuanOpsi" aria-labelledby="labelModalListPengajuanOpsi" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListPengajuanOpsi">Daftar yang Mengajukan</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListPengajuanOpsi"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit" aria-labelledby="labelModalEdit" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalEdit">Form Edit Academic Coach</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEdit"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalListPengajuan" aria-labelledby="labelModalListPengajuan" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListPengajuan">Daftar yang Mengajukan</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListPengajuan"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalListProses" aria-labelledby="labelModalListProses" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListProses">Daftar yang masih proses</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListProses"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalDetail" aria-labelledby="labelModalDetail" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalDetail">Detail profil Academic Coach</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalDetail"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "footerUser.php";?>
    <?php include "jsSourceUser.php";?>
    <script>
      $(document).ready(function(){
         $("#myModal").modal({backdrop: false});
      $("#myModal").modal("show");
       });
           $('#modalDetailOpsi').on('show.bs.modal', function (event) {
             var button = $(event.relatedTarget)
             var recipient = button.data('whatever')
             var modal = $(this);
             var dataString = 'id=' + recipient;
           
             $.ajax({
           	type: "GET",
           	url: "detailOpsiAcUser.php",
           	data: dataString,
           	cache: false,
           	success: function (data) {
           	  console.log(data);
           	  modal.find('.isiModalDetailOpsi').html(data);
           	},
           	error: function (err) {
           	  console.log(err);
           	}
             });
           }); 
      $('#modalListPengajuanOpsi').on('show.bs.modal', function (event) {
             var button = $(event.relatedTarget)
             var recipient = button.data('whatever')
             var modal = $(this);
             var dataString = 'id=' + recipient;
           
             $.ajax({
           	type: "GET",
           	url: "viewListPacSamaUser.php",
           	data: dataString,
           	cache: false,
           	success: function (data) {
           	  console.log(data);
           	  modal.find('.isiModalListPengajuanOpsi').html(data);
           	},
           	error: function (err) {
           	  console.log(err);
           	}
             });
           }); 
      $('#modalEdit').on('show.bs.modal', function (event) {
             var button = $(event.relatedTarget)
             var recipient = button.data('whatever')
             var modal = $(this);
             var dataString = 'id=' + recipient;
           
             $.ajax({
           	type: "GET",
           	url: "editPacUser.php",
           	data: dataString,
           	cache: false,
           	success: function (data) {
           	  console.log(data);
           	  modal.find('.isiModalEdit').html(data);
           	},
           	error: function (err) {
           	  console.log(err);
           	}
             });
           });
           $('#modalListPengajuan').on('show.bs.modal', function (event) {
             var button = $(event.relatedTarget)
             var recipient = button.data('whatever')
             var modal = $(this);
             var dataString = 'id=' + recipient;
           
             $.ajax({
           	type: "GET",
           	url: "viewListPacSamaUser.php",
           	data: dataString,
           	cache: false,
           	success: function (data) {
           	  console.log(data);
           	  modal.find('.isiModalListPengajuan').html(data);
           	},
           	error: function (err) {
           	  console.log(err);
           	}
             });
           });
        $('#modalListProses').on('show.bs.modal', function (event) {
             var button = $(event.relatedTarget)
             var recipient = button.data('whatever')
             var modal = $(this);
             var dataString = 'id=' + recipient;
           
             $.ajax({
           	type: "GET",
           	url: "viewListPrsAcSamaUser.php",
           	data: dataString,
           	cache: false,
           	success: function (data) {
           	  console.log(data);
           	  modal.find('.isiModalListProses').html(data);
           	},
           	error: function (err) {
           	  console.log(err);
           	}
             });
           });
        $('#modalDetail').on('show.bs.modal', function (event) {
             var button = $(event.relatedTarget)
             var recipient = button.data('whatever')
             var modal = $(this);
             var dataString = 'id=' + recipient;
           
             $.ajax({
           	type: "GET",
           	url: "detailAcUser.php",
           	data: dataString,
           	cache: false,
           	success: function (data) {
           	  console.log(data);
           	  modal.find('.isiModalDetail').html(data);
           	},
           	error: function (err) {
           	  console.log(err);
           	}
             });
           });         
    </script>
  </body>
</html>