<?php
include "koneksiUser.php";

$nim=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
$nama=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nama']);
$gelar_depan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['gelar_depan']);
$gelar_belakang=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['gelar_belakang']);
$tempat_lahir=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tempat_lahir']);
$tanggal_lahir = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['tanggal_lahir']);
$jenis_kelamin=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['jenis_kelamin']);
$alamat_ktp=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['alamat_ktp']);
$alamat_malang=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['alamat_malang']);
$kntk=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['kntk']);
$email=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['email']);
$pekerjaan=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['pekerjaan']);
$asal_s1=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['asal_s1']);
$pend_terakhir=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['pend_terakhir']);
$nama_ibu=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nama_ibu']);
$pekerjaan_ibu=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['pekerjaan_ibu']);
$alamat_ibu=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['alamat_ibu']);
$telepon_ibu=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['telepon_ibu']);
$nama_ayah=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nama_ayah']);
$pekerjaan_ayah=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['pekerjaan_ayah']);
$alamat_ayah=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['alamat_ayah']);
$telepon_ayah=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['telepon_ayah']);
$photo=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['photo']);

if (empty($nama))
{   
    die("Mohon diisi nama anda!");
}
else
{
    if (!empty($_FILES["photo"]["tmp_name"]))
    {
        $namafolder="photo_mhssw/";
        $jenis_gambar=$_FILES['photo']['type'];
        if($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/png")
        {          
            $photo = $namafolder ."$nim". basename($_FILES['photo']['name']);
            if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photo))
            {
               die("Gambar gagal dikirim");
            }
            
            $res = mysqli_query($GLOBALS["___mysqli_ston"], "select photo from mag_dt_mhssw_pasca where nim='$nim' LIMIT 1");
            $d=mysqli_fetch_assoc($res);
            if (strlen($d['photo'])>3)
            {
                if (file_exists($d['photo'])) unlink($d['photo']);
            }                   
           
            mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE mag_dt_mhssw_pasca SET photo='$photo' WHERE nim='$nim' LIMIT 1");
        }
        else { die("Jenis gambar yang anda kirim salah. Harus .jpg .jpeg .png"); }
    }
    $myqry="UPDATE mag_dt_mhssw_pasca SET nama='$nama',gelar_depan='$gelar_depan',gelar_belakang='$gelar_belakang',tempat_lahir='$tempat_lahir',nama='$nama',tempat_lahir='$tempat_lahir',".
            "tanggal_lahir='$tanggal_lahir',tanggal_lahir='$tanggal_lahir',jenis_kelamin='$jenis_kelamin',alamat_ktp='$alamat_ktp',alamat_malang='$alamat_malang',kntk='$kntk',email='$email',pekerjaan='$pekerjaan',asal_s1='$asal_s1',pend_terakhir='$pend_terakhir',nama_ibu='$nama_ibu',pekerjaan_ibu='$pekerjaan_ibu',alamat_ibu='$alamat_ibu',telepon_ibu='$telepon_ibu',nama_ayah='$nama_ayah',pekerjaan_ayah='$pekerjaan_ayah',alamat_ayah='$alamat_ayah',telepon_ayah='$telepon_ayah' WHERE nim='$nim' LIMIT 1";
    mysqli_query($GLOBALS["___mysqli_ston"], $myqry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
    header("location:dashboardUser.php?message=notifEdit");
    exit;
}
?>