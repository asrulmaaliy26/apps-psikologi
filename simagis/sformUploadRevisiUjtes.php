<?php
  include("koneksiUser.php");
  $id_pendaftaran = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_pendaftaran']);
  $id_ujtes = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['id_ujtes']);
  $nim = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
  $judul_tesis = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['judul_tesis']);
  $variable_x1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['variable_x1']);
  $variable_x2 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['variable_x2']);
  $variable_x3 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['variable_x3']);
  $variable_y1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['variable_y1']);
  $variable_y2 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['variable_y2']);
  $variable_y3 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['variable_y3']);
  $co_variable_1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['co_variable_1']);
  $co_variable_2 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['co_variable_2']);
  $co_variable_3 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['co_variable_3']);
  $mediator = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['mediator']);
  $moderator = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['moderator']);
  $jns_penel = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['jns_penel']);
  $jns_alat_ukur = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['jns_alat_ukur']);
  $keyword_1 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['keyword_1']);
  $keyword_2 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['keyword_2']);
  $keyword_3 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['keyword_3']);
  $keyword_4 = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['keyword_4']);
  $link_pub = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['link_pub']);
  $file_tesis = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_tesis']);
  $file_form_revisi = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['file_form_revisi']);
  $tgl_upload = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tgl_upload']);
  $thn_upload = date('Y');
  $cek = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['cek']);

  $namafolder = "file_revisi_tesis/";
  $jenis_berkas = $_FILES['file_tesis']['type'];
  $nmfold = "file_form_revisi_tesis/";
  $j_berkas = $_FILES['file_form_revisi']['type'];
  
  if ($jenis_berkas == "application/pdf" && $j_berkas == "application/pdf") {
  	
  	$temp = explode(".", $_FILES["file_tesis"]["name"]);
  	$nama_baru = $nim . '-' . $id_ujtes . '_revisi-tesis' . '.' . end($temp);
  	$berkas = $namafolder . $nama_baru;
  	move_uploaded_file($_FILES['file_tesis']['tmp_name'], $namafolder . '/' . $nama_baru);
  
  	$temp_form_revisi = explode(".", $_FILES["file_form_revisi"]["name"]);
  	$nname = $nim . '-' . $id_ujtes . '_form-revisi-tesis' . '.' . end($temp_form_revisi);
  	$form_revisi = $nmfold . $nname;
  	move_uploaded_file($_FILES['file_form_revisi']['tmp_name'], $nmfold . '/' . $nname);

      mysqli_query(
  		$GLOBALS["___mysqli_ston"],
  		"insert into mag_revisi_tesis(id_peserta,id_ujtes,nim,judul_tesis,variable_x1,variable_x2,variable_x3,variable_y1,variable_y2,variable_y3,co_variable_1,co_variable_2,co_variable_3,mediator,moderator,jns_penel,jns_alat_ukur,keyword_1,keyword_2,keyword_3,keyword_4,link_pub,file_tesis,file_form_revisi,tgl_upload,thn_upload,cek)"
  			. "values('$id_pendaftaran','$id_ujtes','$nim','$judul_tesis','$variable_x1','$variable_x2','$variable_x3','$variable_y1','$variable_y2','$variable_y3','$co_variable_1','$co_variable_2','$co_variable_3','$mediator','$moderator','$jns_penel','$jns_alat_ukur','$keyword_1','$keyword_2','$keyword_3','$keyword_4','$link_pub','$berkas','$form_revisi','$tgl_upload','$thn_upload','$cek')"
  	) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
  
  	header("location:formRevisiTesis.php?message=notifInput");
  } else {
  	header("location:formRevisiTesis.php?message=notifGagal");
  }
  ?>