<?php
include "koneksiUser.php";
$nim=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['nim']);
$photo=mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_POST['photo']);

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
    header("location:dashboardUser.php?message=notifEdit");
    exit;
?>