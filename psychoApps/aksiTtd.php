<?php
include("contentsConAdm.php");

if (isset($_POST['submit'])) {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $nm_jabatan = mysqli_real_escape_string($con, $_POST['nm_jabatan']);
    $kd_nmr_srt = mysqli_real_escape_string($con, $_POST['kd_nmr_srt']);

    // Handle File Upload
    if (!empty($_FILES['ttd_file']['name'])) {
        $file_name = $_FILES['ttd_file']['name'];
        $file_size = $_FILES['ttd_file']['size'];
        $file_tmp = $_FILES['ttd_file']['tmp_name'];
        $file_type = $_FILES['ttd_file']['type'];
        
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed = ['jpg', 'jpeg', 'png'];

        if (in_array(strtolower($ext), $allowed)) {
            $new_name = "ttd_dynamic_" . $id . "." . $ext;
            $path = "images/" . $new_name;
            
            if (move_uploaded_file($file_tmp, $path)) {
                $query = "UPDATE dekanat SET nm_jabatan='$nm_jabatan', kd_nmr_srt='$kd_nmr_srt', ttd='$new_name' WHERE id='$id'";
            } else {
                header("Location: pengaturanTtdAdm.php?message=notifError");
                exit();
            }
        } else {
            header("Location: pengaturanTtdAdm.php?message=notifType");
            exit();
        }
    } else {
        $query = "UPDATE dekanat SET nm_jabatan='$nm_jabatan', kd_nmr_srt='$kd_nmr_srt' WHERE id='$id'";
    }

    if (mysqli_query($con, $query)) {
        header("Location: pengaturanTtdAdm.php?message=notifUpdate");
    } else {
        header("Location: pengaturanTtdAdm.php?message=notifError");
    }
} else {
    header("Location: pengaturanTtdAdm.php");
}
?>
