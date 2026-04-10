<?php include( "contentsConAdm.php" );
  error_reporting(E_ALL & ~E_NOTICE);
  require "excel_reader.php";
  
  $id=mysqli_real_escape_string($con,  $_POST['id']);
  $page=mysqli_real_escape_string($con,  $_POST['page']);

  $target = basename($_FILES['data_pengajuan']['name']) ;
  move_uploaded_file($_FILES['data_pengajuan']['tmp_name'], $target);
  chmod($_FILES['data_pengajuan']['name'],0777);
  $data = new Spreadsheet_Excel_Reader($_FILES['data_pengajuan']['name'],false);
  $baris = $data->rowcount($sheet_index=0); 
    
  for ($i=2; $i<=$baris; $i++)
  {
  $id_periode = $data->val($i, 1);
  $nim = $data->val($i, 2);
  $angkatan = $data->val($i, 3);
  $dospem_skripsi1 = $data->val($i, 4);
  $dospem_skripsi2 = $data->val($i, 5);
  $tgl_pengajuan = $data->val($i, 6);
  $thn_pengajuan = $data->val($i, 7);
  $cek1 = $data->val($i, 8);
  $cek2 = $data->val($i, 9);
  $cekberkas1 = $data->val($i, 10);
  $cekberkas2 = $data->val($i, 11);
  $cekberkas3 = $data->val($i, 12);
  $cekberkas4 = $data->val($i, 13);
  $cekberkas5 = $data->val($i, 14);
  $cekjudul = $data->val($i, 15);
  $tgl_cek1 = $data->val($i, 16);
  $tgl_cek2 = $data->val($i, 17);
  $tgl_cekjudul = $data->val($i, 18);
  $tgl_cekberkas = $data->val($i, 19);
  $tgl_mulai = $data->val($i, 20);
  $thn_mulai = $data->val($i, 21);
  $status = $data->val($i, 22);
  
  $query = "INSERT into pengelompokan_dospem_skripsi (id_periode,nim,angkatan,dospem_skripsi1,dospem_skripsi2,tgl_pengajuan,thn_pengajuan,cek1,cek2,cekberkas1,cekberkas2,cekberkas3,cekberkas4,cekberkas5,cekjudul,tgl_cek1,tgl_cek2,tgl_cekjudul,tgl_mulai,thn_mulai,status)values('$id_periode','$nim','$angkatan','$dospem_skripsi1','$dospem_skripsi2','$tgl_pengajuan','$thn_pengajuan','$cek1','$cek2','$cekberkas1','$cekberkas2','$cekberkas3','$cekberkas4','$cekberkas5','$cekjudul','$tgl_cek1','$tgl_cek2','$tgl_cekjudul','$tgl_mulai','$thn_mulai','$status')";
  $hasil = mysqli_query($con, $query);
  }
 
  if(!$hasil){
  header("location:imporPengajuanDospemAdm.php?id=$id&page=$page&message=notifGagal");
  }else{
  header("location:imporPengajuanDospemAdm.php?id=$id&page=$page&message=notifInput");
  }
  unlink($_FILES['data_pengajuan']['name']);
  ?>