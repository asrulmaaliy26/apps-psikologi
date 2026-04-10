<?php include( "contentsConAdm.php" );
  $id=mysqli_real_escape_string($con, $_POST['id']);
  $page=mysqli_real_escape_string($con, $_POST['page']);
  $id_sempro=mysqli_real_escape_string($con, $_POST['id_sempro']);
  $nim=mysqli_real_escape_string($con, $_POST['nim']);
  $nama=mysqli_real_escape_string($con, $_POST['nama']);
  $judul_prop=mysqli_real_escape_string($con, $_POST['judul_prop']);
  $pembimbing1=mysqli_real_escape_string($con, $_POST['pembimbing1']);
  $pembimbing2=mysqli_real_escape_string($con, $_POST['pembimbing2']);
  $file_prop = mysqli_real_escape_string($con, $_POST['file_prop']);
  
  $jenis_berkas = $_FILES['file_prop']['type'];
  if ($jenis_berkas == "application/pdf") {
  $myquery = "SELECT * FROM peserta_sempro WHERE id='$id'";
  $r = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
  $dt = mysqli_fetch_assoc( $r );
  $date=strtotime('now');
     $namafolder = "file_proposal/";
     $temp = explode(".", $_FILES["file_prop"]["name"]);
     $nama_baru = $nama . '-' . $nim . '-' . $id_sempro . '_proposal_'.$date. '.' . end($temp);
     $file_prop = $namafolder . $nama_baru;
     move_uploaded_file($_FILES['file_prop']['tmp_name'], $namafolder . '/' . $nama_baru);
  
        $res = mysqli_query($con, "SELECT file_prop FROM peserta_sempro WHERE id='$id' LIMIT 1");
        $d=mysqli_fetch_assoc($res);
        if (strlen($d['file_prop'])>3)
        {
        if (file_exists($d['file_prop'])) unlink($d['file_prop']);
        }
        mysqli_query($con, "UPDATE peserta_sempro SET file_prop='$file_prop' WHERE id='$id' LIMIT 1");
        } else {
        header("location:verPndftrSemproPerPeriodeAdm.php?message=notifGagal");
        }
  
  $myqry="UPDATE peserta_sempro SET judul_prop='$judul_prop',pembimbing1='$pembimbing1',pembimbing2='$pembimbing2' WHERE id='$id' LIMIT 1";
  mysqli_query($con, $myqry) or die(mysqli_error($con));
  
  $qry="UPDATE jadwal_sempro SET penguji1='$pembimbing1' WHERE id_pendaftaran='$id' LIMIT 1";
  mysqli_query($con, $qry) or die(mysqli_error($con));
  
  header("location:verPndftrSemproPerPeriodeAdm.php?id=$id_sempro&page=$page&message=notifEdit");
  ?>