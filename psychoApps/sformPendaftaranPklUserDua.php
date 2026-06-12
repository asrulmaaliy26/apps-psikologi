<?php include( "contentsConAdm.php" );
$id = mysqli_real_escape_string($con, $_POST['id']);
$id_pkl = mysqli_real_escape_string($con, $_POST['id_pkl']);
$j_ftpd = $_FILES['file_pembekalan']['type'] ?? '';

$myquery = "SELECT * FROM peserta_pkl WHERE id='$id'";
$r = mysqli_query($con,  $myquery )or die( mysqli_error($con) );
$dt = mysqli_fetch_assoc( $r );
$q = "SELECT * FROM dt_mhssw WHERE nim='$dt[nim]'";
$has = mysqli_query($con,  $q )or die( mysqli_error($con) );
$dataku = mysqli_fetch_assoc( $has );
$nim =  $dataku['nim'];
$nama = $dataku['nama'];
$date = strtotime('now');

if ($j_ftpd == "application/pdf") {
    $namaftpd = "file_pembekalan_pkl/";
    if (!file_exists($namaftpd)) {
        mkdir($namaftpd, 0777, true);
    }
    
    $temp_pembekalan = explode(".", $_FILES["file_pembekalan"]["name"]);
    $nama_file_pembekalan = $nama . '-'. $nim . '-' . $id_pkl . '_pembekalan-pkl_'. $date . '.' . end($temp_pembekalan);
    $file_pembekalan = $namaftpd . $nama_file_pembekalan;
    move_uploaded_file($_FILES['file_pembekalan']['tmp_name'], $namaftpd . $nama_file_pembekalan);
      
    $res2 = mysqli_query($con, "SELECT file_pembekalan FROM peserta_pkl WHERE id='$id' LIMIT 1");
    $d2 = mysqli_fetch_assoc($res2);
    if (strlen($d2['file_pembekalan']) > 3) {
        if (file_exists($d2['file_pembekalan'])) unlink($d2['file_pembekalan']);
    }
    mysqli_query($con, "UPDATE peserta_pkl SET file_pembekalan='$file_pembekalan', statusform='1' WHERE id='$id' LIMIT 1");
    // Karena Langkah 3 dihilangkan, kita arahkan langsung ke halaman selesai pendaftaran
    header("location:prePendaftaranPklUser.php?id=$id&message=notifInput");
} else {
    header("location:prePendaftaranPklUser.php?id=$id&message=notifGagalUpload");
}
?>