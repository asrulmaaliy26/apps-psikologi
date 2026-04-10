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
      $nim     = $data->val($i, 1);
      $angkatan   = $data->val($i, 2);
      $nama  = $data->val($i, 3);
      $tanggal_lahir  = $data->val($i, 4);
      $nama_ayah  = $data->val($i, 5);
      $nama_ibu  = $data->val($i, 6);
      $jenis_kelamin  = $data->val($i, 7);
      $kntk  = $data->val($i, 8);
      $imel  = $data->val($i, 9);
      $status  = $data->val($i, 10);

    if($nim != "" && $angkatan != "" && $nama != ""){
      mysqli_query($con,"INSERT INTO dt_mhssw VALUES ('$nim','$angkatan','','','$nama','','$tanggal_lahir','','','$nama_ayah','','','','$nama_ibu','','','','','','$jenis_kelamin','$kntk','$imel','','','','','','','','','','','','$status','','','','','','','','','','','','','','','','')");
      $berhasil++;
      header("location:imporDataMahasiswaS1.php?message=notifInput");
    }
    else {
      header("location:imporDataMahasiswaS1.php?message=notifGagal");
    }
  }
  mysqli_close($con);
  ?>