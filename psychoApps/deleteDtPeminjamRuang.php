<?php include( "contentsConAdm.php" );
  $id= mysqli_real_escape_string($con, $_GET['id']);
  $page= mysqli_real_escape_string($con, $_GET['page']);
  
  $qry_inv = "SELECT id_ruang FROM dt_pinjam_ruang WHERE peminjam='$id'";
  $r_inv = mysqli_query($con, $qry_inv);
  while($d_inv = mysqli_fetch_array($r_inv)) {

  $qry1="UPDATE dt_ruang SET status_peminjaman='1' WHERE id='$d_inv[id_ruang]'";
   mysqli_query($con, $qry1) or die(mysqli_error($con));
  }
  
  $myquery =  "DELETE FROM dt_peminjam_ruang WHERE id='$id' LIMIT 1";
  $hapus = mysqli_query($con, $myquery) or die ("gagal menghapus");

  $myquery1 =  "DELETE FROM dt_pinjam_ruang WHERE peminjam='$id'";
  $hapus1 = mysqli_query($con, $myquery1) or die ("gagal menghapus");
  header ("location:dtPinjamRuang.php?page=$page&message=notifDelete");
  ?>