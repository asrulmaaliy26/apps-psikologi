<?php include( "contentsConAdm.php" );
  include "excel_reader2.php";
  error_reporting(E_ALL & ~E_NOTICE);

  $target = basename($_FILES['filedata']['name']) ;
  move_uploaded_file($_FILES['filedata']['tmp_name'], $target);
  chmod($_FILES['filedata']['name'],0777);
  $data = new Spreadsheet_Excel_Reader($_FILES['filedata']['name'],false);
  $jumlah_baris = $data->rowcount($sheet_index=0);
  $berhasil = 0;
    for ($i=2; $i<=$jumlah_baris; $i++){
      $nim = $data->val($i, 1);
      $angkatan = $data->val($i, 2);
      $smt_daftar = $data->val($i, 3);
      $nama = $data->val($i, 4);
      $status = $data->val($i, 5);
      $jenis_kelamin = $data->val($i, 6);

    if($nim != "" && $angkatan != "" && $nama != ""){
      mysqli_query($con,"INSERT INTO mag_dt_mhssw_pasca VALUES ('$nim','$angkatan','$smt_daftar','$nama','','','$status','','','','$jenis_kelamin','','','','','','','','','','','','','','','','','','','','')");
      $berhasil++;
      header("location:imporDataMahasiswaS2.php?message=notifInput");
    }
    else {
      header("location:imporDataMahasiswaS2.php?message=notifGagal");
    }
  }
  mysqli_close($con);
  ?>