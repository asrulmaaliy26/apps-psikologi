<?php
  include("koneksiUser.php");
  $nim = $_SESSION['nim'];
  
  $myquery = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
  $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  $qry_moment = "SELECT * FROM mag_periode_pengajuan_dospem WHERE status='1'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_periode=$data['id'];
  $ta=$data['ta'];
  $tahap=$data['tahap'];
   
  $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$ta'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
  $dnta = mysqli_fetch_assoc($hasil);
  
  $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
  $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
  $dsemester = mysqli_fetch_assoc($h);
   
  $qry_nm_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$tahap'";
  $hsl = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_thp);
  $dtahap = mysqli_fetch_assoc($hsl);

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
          <p>Kuota semua Dosen pembimbing tesis yang dipilih atau salah satunya sudah penuh...</p>
          <p><strong>Note:</strong> Silahkan pilih Dosen pembimbing tesis yang belum penuh kuotanya...</p>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          </div>
          </div>
          </div>';}	 
          if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalSama') {
          echo '
          <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog">
          <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Submit gagal</h4>
          </div>
          <div class="modal-body">
          <p>Dosen pembimbing tesis I dan II yang dipilih tidak boleh sama...</p>
          <p><strong>Note:</strong> Silahkan pilih Dosen pembimbing tesis yang berbeda...</p>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          </div>
          </div>
          </div>';}	 
          
          if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalDospem') {
          echo '
          <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog">
          <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Submit gagal</h4>
          </div>
          <div class="modal-body bg-alert">
          <p>Kuota Dosen pembimbing tesis yang dipilih sudah penuh...</p>
          <p><strong>Note:</strong> Silahkan pilih Dosen pembimbing tesis yang belum penuh kuotanya...</p>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          </div>
          </div>
          </div>';}	 
          if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
                 echo '<div class="alert alert-warning custom-alert" role="alert">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Submit berhasil...</div>';}
           
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
                 echo '<div class="alert alert-success custom-alert" role="alert">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Data berhasil diupdate...</div>';} 
                 ?>
        <h3 class="text-center text-info">Dosen Pembimbing Tesis</h3>
        <?php		  
		  if($DATE_NOW < $START_DATE) {echo 
          "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-danger text-center'>Maaf... <br />Pengajuan Dosen Pembimbing Tesis <br />
          Tahap ".$dtahap['tahap'].' Semester '.$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Belum Dibuka!</strong></p>
          </div>";
		  include 'includeRekapPptUser.php';
		  }
          
		  else if($DATE_NOW > $END_DATE) {echo 
          "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-danger text-center'>Maaf... <br />Pengajuan Dosen Pembimbing Tesis <br />
          Tahap ".$dtahap['tahap'].' Semester '.$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Telah Ditutup!</strong></p>
          </div>";
		  include 'includeRekapPptUser.php';
		  }
          
          else if($START_DATE <= $DATE_NOW && $DATE_NOW <= $END_DATE) {
          
          $cekbio = "select * from mag_dt_mhssw_pasca WHERE nim='$dataku[nim]'";
          $rbio = mysqli_query($GLOBALS["___mysqli_ston"], $cekbio) or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          $dbio = mysqli_fetch_array($rbio);
          
          $cekr = "select * from mag_pengelompokan_rumpun WHERE nim='$dataku[nim]' && cek='2'";
          $rr = mysqli_query($GLOBALS["___mysqli_ston"], $cekr) or die( mysqli_error($GLOBALS["___mysqli_ston"]));

          $cekdw = "select * from mag_pengelompokan_dosen_wali WHERE nim='$dataku[nim]' && cek='2'";
          $rdw = mysqli_query($GLOBALS["___mysqli_ston"], $cekdw) or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          
          if($dbio['gelar_belakang']=='' || $dbio['tempat_lahir']=='' || $dbio['tanggal_lahir']=='' || $dbio['jenis_kelamin']=='' || $dbio['alamat_ktp']=='' || $dbio['alamat_malang']=='' || $dbio['kntk']=='' || $dbio['email']=='' || $dbio['pekerjaan']=='' || $dbio['asal_s1']=='' || $dbio['pend_terakhir']=='' || $dbio['nama_ibu']=='' || $dbio['nama_ayah']=='' || $dbio['photo']=='' || (mysqli_num_rows($rr)<1) || (mysqli_num_rows($rdw)<1)) 
           {
		  
		  $myquery1 = "select * FROM mag_dt_mhssw_pasca WHERE nim='$dataku[nim]'";
		  $res1 = mysqli_query($GLOBALS["___mysqli_ston"],  $myquery1 )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
		  $dataku1 = mysqli_fetch_assoc( $res1 );
		  
		  $angkatan=$dataku1['angkatan'];
		  $smt_daftar=$dataku1['smt_daftar'];
		  $yearnow=date("Y");
		  $monthnow=date("m");
		  $jarakyear=($yearnow - $angkatan);
		  $jaraksemestergenap=($monthnow <=6)+2+($jarakyear * 2) - $smt_daftar;
		  $jaraksemestergasal=($monthnow >6)+1+($jarakyear * 2) - $smt_daftar;
		  
		  if($jaraksemestergenap <3) { echo "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-primary'>Pengajuan Dosen Pembimbing Tesis
          Tahap ".$dtahap['tahap'].' Semester '.$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Sedang Dibuka!</strong><br />
          Tetapi belum saatnya bagi Anda untuk mengajukan Dosen Pembimbing Tesis, karena Anda sekarang masih semester ".$jaraksemestergenap.".
          </div>";
		  include 'includeRekapPptUser.php';} 
		  else if($jaraksemestergasal >=3) {
          echo "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-primary'>Pengajuan Dosen Pembimbing Tesis
          Tahap ".$dtahap['tahap'].' Semester '.$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Sedang Dibuka!</strong><br />
          Cek dan lengkapi isian berikut ini dengan benar, agar form pengajuan dapat diakses:<br />
          <a href='dashboardUser.php' class='btn btn-primary'>Biodata</a>
          <a href='formPengajuanPrp.php' class='btn btn-primary'>Pengajuan Peminatan Rumpun Psikologi</a>
		  <a href='formPengajuanAc.php' class='btn btn-primary'>Pengajuan Academic Coach</a></p>
          </div>";
		  include 'includeRekapPptUser.php';
          }
		  } else {
          $q = "SELECT nim FROM mag_pengelompokan_dospem_tesis WHERE nim='$dataku[nim]'";
          $r = mysqli_query($GLOBALS["___mysqli_ston"], $q)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          $d = mysqli_num_rows($r);
          
          if($d==0)  {include 'includeFormPpt.php';}
          elseif($d==1) {include 'includeRekapPptUser.php';}
          }
          }
          ?>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalDetail" aria-labelledby="labelModalDetail" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalDetail">Detail Profil Dosen Pembimbing Tesis</h4>
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
      <div class="modal fade" tabindex="-1" role="dialog" id="modalDetailPtPilihanSatu" aria-labelledby="labelModalDetailPtPilihanSatu" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalDetailPtPilihanSatu">Profil Dosen Pembimbing Tesis I</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalDetailPtPilihanSatu"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalListPengajuanSatu" aria-labelledby="labelModalListPengajuanSatu" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListPengajuanSatu">Daftar yang Mengajukan</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListPengajuanSatu"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalListProsesSatu" aria-labelledby="labelModalListProsesSatu" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListProsesSatu">Daftar yang masih proses</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListProsesSatu"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalDetailPtPilihanDua" aria-labelledby="labelModalDetailPtPilihanDua" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalDetailPtPilihanDua">Profil Dosen Pembimbing Tesis II</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalDetailPtPilihanDua"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalListPengajuanDua" aria-labelledby="labelModalListPengajuanDua" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListPengajuanDua">Daftar yang Mengajukan</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListPengajuanDua"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalListProsesDua" aria-labelledby="labelModalListProsesDua" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListProsesDua">Daftar yang masih proses</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListProsesDua"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalEditPtPilihanSatu" aria-labelledby="labelModalEditPtPilihanSatu" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalEditPtPilihanSatu">Form Edit Dosen Pembimbing Tesis I</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEditPtPilihanSatu"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalEditPtPilihanDua" aria-labelledby="labelModalEditPtPilihanDua" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalEditPtPilihanDua">Form Edit Dosen Pembimbing Tesis II</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEditPtPilihanDua"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalJudOut" aria-labelledby="labelModalJudOut" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalJudOut">Judul dan Outline Tesis</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalJudOut"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalEditJudOut" aria-labelledby="labelModalEditJudOut" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalEditJudOut">Form Edit Judul dan Outline Tesis</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEditJudOut"></div>
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
      $(document).ready(function () {
      $("#myModal").modal({
       backdrop: false
      });
      $("#myModal").modal("show");
      });
      
      tinymce.init({
      selector: ".textinput",
      setup: function (editor) {
      editor.on('change', function () {
       tinymce.triggerSave();
      });
      },
      theme: "modern",
      plugins: [
      "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
      "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
      "save table contextmenu directionality emoticons template paste textcolor", "autoresize"
      ],
      content_css: "css/content.css",
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
      style_formats: [{
       title: 'Bold text',
       inline: 'b'
      },
      {
       title: 'Red text',
       inline: 'span',
       styles: {
      color: '#ff0000'
       }
      },
      {
       title: 'Red header',
       block: 'h1',
       styles: {
      color: '#ff0000'
       }
      },
      {
       title: 'Example 1',
       inline: 'span',
       classes: 'example1'
      },
      {
       title: 'Example 2',
       inline: 'span',
       classes: 'example2'
      },
      {
       title: 'Table styles'
      },
      {
       title: 'Table row 1',
       selector: 'tr',
       classes: 'tablerow1'
      }
      ]
      });
      
      $('#modalDetail').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      
      $.ajax({
      type: "GET",
      url: "detailPtUser.php",
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
      $('#modalListPengajuan').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      
      $.ajax({
      type: "GET",
      url: "viewListPptUser.php",
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
      url: "viewListPrssPtUser.php",
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
      $('#modalDetailPtPilihanSatu').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      
      $.ajax({
      type: "GET",
      url: "detailPptSatuUser.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalDetailPtPilihanSatu').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      $('#modalListPengajuanSatu').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      
      $.ajax({
      type: "GET",
      url: "viewListPptSatuDuaUser.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalListPengajuanSatu').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      $('#modalListProsesSatu').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      
      $.ajax({
      type: "GET",
      url: "viewListPrssSatuDuaUser.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalListProsesSatu').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      $('#modalDetailPtPilihanDua').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      
      $.ajax({
      type: "GET",
      url: "detailPptDuaUser.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalDetailPtPilihanDua').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      $('#modalListPengajuanDua').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      
      $.ajax({
      type: "GET",
      url: "viewListPptSatuDuaUser.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalListPengajuanDua').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      $('#modalListProsesDua').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      
      $.ajax({
      type: "GET",
      url: "viewListPrssSatuDuaUser.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalListProsesDua').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      $('#modalEditPtPilihanSatu').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      
      $.ajax({
      type: "GET",
      url: "editPptSatuUser.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalEditPtPilihanSatu').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      $('#modalEditPtPilihanDua').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      
      $.ajax({
      type: "GET",
      url: "editPptDuaUser.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalEditPtPilihanDua').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      $('#modalJudOut').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      
      $.ajax({
      type: "GET",
      url: "viewJudOutPptUser.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalJudOut').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      $('#modalEditJudOut').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      
      $.ajax({
      type: "GET",
      url: "editJudOutPptUser.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalEditJudOut').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
    </script>
  </body>
</html>