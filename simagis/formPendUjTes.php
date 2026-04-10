<?php
  include("koneksiUser.php");
  $nim = $_SESSION['nim'];
  
  $myquery = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$nim'";
  $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dataku = mysqli_fetch_assoc($dmhssw);
  
  $qry_moment = "SELECT * FROM mag_periode_pendaftaran_ujtes WHERE status='1'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_moment);
  $data = mysqli_fetch_assoc($hasil);
  $id_ujtes=$data['id'];
  $thp=$data['tahap'];
  $ta=$data['ta'];
   
  $qry_nm_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$thp'";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_thp);
  $dthp = mysqli_fetch_assoc($hasil);
   
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
    <?php include "navPendUser.php";?>
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
          <p>Salah satu atau semua file yang diupload bukan berbentuk PDF (berekstensi .pdf).</p>
          <p><strong>Note:</strong> Konversikan file ke PDF terlebih dahulu...</p>
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
          
          if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
                 echo '<div class="alert alert-danger custom-alert" role="alert">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Data berhasil dihapus...</div>';}				 
                 ?>
        <h3 class="text-center text-info">Ujian Tesis</h3>
        <?php         
          if($DATE_NOW < $START_DATE) {echo 
          "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-danger text-center'>Maaf... <br />Pendaftaran Ujian Tesis <br />
          Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Belum Dibuka!</strong></p>
          </div>";
          include "includeRekapUjtesUser.php";
          }
          else if($DATE_NOW > $END_DATE) {echo 
          "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-danger text-center'>Maaf... <br />Pendaftaran Ujian Tesis <br />
          Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Telah Ditutup!</strong></p>
          </div>";
          include "includeRekapUjtesUser.php";
          }
          else if($START_DATE <= $DATE_NOW && $DATE_NOW <= $END_DATE) {
          
          $cekbio = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$nim'";
          $rbio = mysqli_query($GLOBALS["___mysqli_ston"], $cekbio) or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          $dbio = mysqli_fetch_array($rbio);
          
          $ceksempro = "SELECT * FROM mag_nilai_sempro AS mns JOIN mag_peserta_sempro AS mps ON mns.id_pendaftaran=mps.id WHERE mps.nim='$nim'";
          $rsempro = mysqli_query($GLOBALS["___mysqli_ston"], $ceksempro) or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          $dsempro = mysqli_fetch_array($rsempro);
          
          $cekrevsempro = "SELECT * FROM mag_revisi_sempro AS mrs JOIN mag_peserta_sempro AS mps ON mrs.id_peserta=mps.id WHERE mps.nim='$nim'";
          $rrevsempro = mysqli_query($GLOBALS["___mysqli_ston"], $cekrevsempro) or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          $drevsempro = mysqli_fetch_array($rrevsempro);

          $qry_grade = "SELECT * FROM mag_grade_sempro WHERE id_sempro='$dsempro[id_sempro]'";
          $res_grade = mysqli_query($GLOBALS["___mysqli_ston"], $qry_grade);
          $dt_grade = mysqli_fetch_array($res_grade);
          
          if($dbio['gelar_belakang']=='' || $dbio['tempat_lahir']=='' || $dbio['tanggal_lahir']=='' || $dbio['jenis_kelamin']=='' || $dbio['alamat_ktp']=='' || $dbio['alamat_malang']=='' || $dbio['kntk']=='' || $dbio['email']=='' || $dbio['pekerjaan']=='' || $dbio['asal_s1']=='' || $dbio['pend_terakhir']=='' || $dbio['nama_ibu']=='' || $dbio['nama_ayah']=='' || $dbio['photo']=='')
           {
          echo "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-primary'>Pendaftaran Ujian Tesis
          Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Sedang Dibuka!</strong>
          <br />
          Cek dan lengkapi isian berikut ini dengan benar, agar form pendaftaran dapat diakses:<br />
          <a href='dashboardUser.php' class='btn btn-primary'>Biodata</a></p>
          </div>";
          include "includeRekapUjtesSideUser.php";
          }
          
          $cekppt = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE nim='$nim' AND cek1='2'AND cek2='2' AND cekjudul='2'";
          $rppt = mysqli_query($GLOBALS["___mysqli_ston"], $cekppt) or die( mysqli_error($GLOBALS["___mysqli_ston"]));
          $row = mysqli_num_rows($rppt);
          $dstatus = mysqli_fetch_array($rppt);

          if($row < 1) {
          echo "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-primary'>Pendaftaran Ujian Tesis
          Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Sedang Dibuka!</strong>
          <br />
          Cek dan lengkapi isian berikut ini dengan benar, agar form pendaftaran dapat diakses:<br />
          <a href='formPengajuanPt.php' class='btn btn-primary'>Pengajuan Pembimbing Tesis</a></p>
          </div>";
          include "includeRekapUjtesSideUser.php";
          }
          else if($dstatus['status']=='2') {
          echo "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-primary'>Pendaftaran Ujian Tesis
          Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Sedang Dibuka!</strong>
          <br />
          <strong>Anda tidak diperkenankan mendaftar, karena Anda telah dinyatakan lulus Magister Psikologi</strong></p>
          </div>";
          include "includeRekapUjtesSideUser.php";
          }
          else if(empty($dsempro['nim']))
          { 
          echo "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-primary'>Pendaftaran Ujian Tesis
          Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Sedang Dibuka!</strong><br />
          Tidak bisa mendaftar karena: <b>Anda belum mengikuti seminar proposal tesis.</b>
          </p>
          </div>";
          }
          else if($dsempro['validasi']=='1')
          { 
          echo "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-primary'>Pendaftaran Ujian Tesis
          Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Sedang Dibuka!</strong><br />
          Tidak bisa mendaftar karena: <b>Hasil seminar proposal tesis belum keluar atau belum divalidasi, segera hubungi admin.</b>
          </p>
          </div>";
          } 
          else if(empty($drevsempro['nim']))
          { 
          echo "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-primary'>Pendaftaran Ujian Tesis
          Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Sedang Dibuka!</strong><br />
          Tidak bisa mendaftar karena: <b>Anda belum mengupload revisi proposal tesis.</b>
          </p>
          </div>";
          }
          else if($drevsempro['cek']=='1')
          { 
          echo "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-primary'>Pendaftaran Ujian Tesis
          Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Sedang Dibuka!</strong><br />
          Tidak bisa mendaftar karena: <b>Data Upload revisi proposal tesis Anda belum divalidasi, segera hubungi admin.</b>
          </p>
          </div>";
          }
          else if($drevsempro['cek']=='3')
          { 
          echo "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-primary'>Pendaftaran Ujian Tesis
          Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Sedang Dibuka!</strong><br />
          Tidak bisa mendaftar karena: <b>Data Upload revisi proposal tesis Anda ditolak, segera lakukan revisi dan upload ulang dan hubungi admin.</b>
          </p>
          </div>";
          }
          else if($dsempro['mean_nilai'] <= $dt_grade['sut'] && $dsempro['mean_nilai'] >= $dt_grade['sub'])
          { 
          echo "<div class='alert alert-danger' style='box-shadow:none;'>
          <p class='text-primary'>Pendaftaran Ujian Tesis
          Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']." <br /><strong>Sedang Dibuka!</strong><br />
          Tidak bisa mendaftar karena: <b>Hasil seminar proposal tesis: <kbd>Seminar Ulang</kbd>. Lihat di detail pendaftaran seminar proposal tesis.</b>
          </p>
          </div>";
          } 
          else {
          $cekdtpndftrn="select nim from mag_peserta_ujtes where nim='$nim' AND id_ujtes='$id_ujtes'";
          $ada=mysqli_query($GLOBALS["___mysqli_ston"], $cekdtpndftrn) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
          
          if(mysqli_num_rows($ada)>0)
          {
          include "includeRekapUjtesUser.php";
          } 
          else 
          {
          include "includeFormUjtes.php";
          include "includeRekapUjtesSideUser.php";
          }
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
              <h4 class="modal-title" id="modalDetail">Detail Pendaftaran Ujian Tesis</h4>
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
      <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit" aria-labelledby="labelModalEdit" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalEdit">Form Edit Pendaftaran Ujian Tesis</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEdit"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalCatatan" aria-labelledby="labelModalCatatan" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalCatatan">Catatan Pendaftaran Ujian Tesis</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalCatatan"></div>
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
      url: "detailPendUjtesUser.php",
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

      $('#modalEdit').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "editPendUjtesUser.php",
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

      $('#modalCatatan').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "catatanPendUjtesUser.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalCatatan').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
    </script>
  </body>
</html>