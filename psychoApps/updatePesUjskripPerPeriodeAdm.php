<?php include( "contentsConAdm.php" );
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $page=mysqli_real_escape_string($con, $_POST['page']);
  $id_ujskrip=mysqli_real_escape_string($con, $_POST['id_ujskrip']);
  $nim=mysqli_real_escape_string($con, $_POST['nim']);
  $nama=mysqli_real_escape_string($con, $_POST['nama']);
  $judul_skripsi=mysqli_real_escape_string($con, $_POST['judul_skripsi']);
  $pembimbing1=mysqli_real_escape_string($con, $_POST['pembimbing1']);
  $pembimbing2=mysqli_real_escape_string($con, $_POST['pembimbing2']);
  $file_skripsi = mysqli_real_escape_string($con, $_POST['file_skripsi']);
  
  $jenis_berkas = $_FILES['file_skripsi']['type'];
  if ($jenis_berkas == "application/pdf") {
  $myquery = "SELECT * FROM peserta_ujskrip WHERE id='$id'";
  $r = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $r );
  $date=strtotime('now');
     $namafolder = "file_skripsi_ujian/";
     $temp = explode(".", $_FILES["file_skripsi"]["name"]);
     $nama_baru = $nama . '-' . $nim . '-' . $id_ujskrip . '_skripsi_'.$date. '.' . end($temp);
     $file_skripsi = $namafolder . $nama_baru;
     move_uploaded_file($_FILES['file_skripsi']['tmp_name'], $namafolder . '/' . $nama_baru);
  
        $res = mysqli_query($con, "SELECT file_skripsi FROM peserta_ujskrip WHERE id='$id' LIMIT 1");
        $d=mysqli_fetch_assoc($res);
        if (strlen($d['file_skripsi'])>3)
        {
        if (file_exists($d['file_skripsi'])) unlink($d['file_skripsi']);
        }
        mysqli_query($con, "UPDATE peserta_ujskrip SET file_skripsi='$file_skripsi' WHERE id='$id' LIMIT 1");
        } else {
        header("location:verPndftrUjskripPerPeriodeAdm.php?message=notifGagal");
        }
  
  $myqry="UPDATE peserta_ujskrip SET judul_skripsi='$judul_skripsi',pembimbing1='$pembimbing1',pembimbing2='$pembimbing2' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry) or die(mysqli_error($con));
  
  $qry="UPDATE jadwal_sempro SET penguji1='$pembimbing1' WHERE id_pendaftaran='$id' LIMIT 1";
  mysqli_query($con, $qry) or die(mysqli_error($con));
  
  header("location:verPndftrUjskripPerPeriodeAdm.php?id=$id_ujskrip&page=$page&message=notifEdit");
  ?>