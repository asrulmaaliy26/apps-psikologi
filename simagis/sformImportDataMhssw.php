<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  require "excel_reader2.php";
  
  $target = basename($_FILES['data_mahasiswa']['name']) ;
  move_uploaded_file($_FILES['data_mahasiswa']['tmp_name'], $target);
  chmod($_FILES['data_mahasiswa']['name'],0777);
  $data = new Spreadsheet_Excel_Reader($_FILES['data_mahasiswa']['name'],false);
  $baris = $data->rowcount($sheet_index=0); 
    
  for ($i=2; $i<=$baris; $i++)
  {
  $nim = $data->val($i, 1);
  $angkatan = $data->val($i, 2);
  $smt_daftar = $data->val($i, 3);
  $nama = $data->val($i, 4);
  $status = $data->val($i, 5);
  $password = $data->val($i, 6);
  $jenis_kelamin = $data->val($i, 7);
  
  $query = "INSERT into mag_dt_mhssw_pasca (nim,angkatan,smt_daftar,nama,status,password,jenis_kelamin)values('$nim','$angkatan','$smt_daftar','$nama','$status',MD5('$password'),'$jenis_kelamin')";
  $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $query);
  }
 
  if(!$hasil){
  header("location:rekapMhsswAdm.php?message=notifGagal");
  }else{
  header("location:rekapMhsswAdm.php?message=notifInput");
  }
  unlink($_FILES['data_mahasiswa']['name']);
  ?>