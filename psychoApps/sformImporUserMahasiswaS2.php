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
      $username     = $data->val($i, 1);
      $password   = $data->val($i, 2);
      $level  = $data->val($i, 3);
      $nm_person  = $data->val($i, 4);
      $login_terakhir  = $data->val($i, 5);
      $status  = $data->val($i, 6);
    if($username != "" && $password != "" && $level != "" && $nm_person !="" && $status !=""){
      mysqli_query($con,"INSERT INTO dt_all_adm VALUES ('$username',md5('$password'),'$level','$nm_person','$login_terakhir','$status')");
      $berhasil++;
      header("location:imporUserMahasiswaS2.php?message=notifInput");
    }
    else {
      header("location:imporUserMahasiswaS2.php?message=notifGagal");
    }
  }
  mysqli_close($con);
  ?>