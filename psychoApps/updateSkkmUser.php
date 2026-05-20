<?php
include( "contentsConAdm.php" );

$id=mysqli_real_escape_string($con, $_POST['id']);
$sub_unsur=mysqli_real_escape_string($con, $_POST['sub_unsur']);
$jenis_aitem=mysqli_real_escape_string($con, $_POST['jenis_aitem']);
$krdt=mysqli_real_escape_string($con, $_POST['krdt']);
$bukti_fisik=mysqli_real_escape_string($con, $_POST['bukti_fisik']);
$deskrip_unsur=mysqli_real_escape_string($con, $_POST['deskrip_unsur']);
$tmpt=mysqli_real_escape_string($con, $_POST['tmpt']);
$start_keg=mysqli_real_escape_string($con, $_POST['start_keg']);
$end_keg=mysqli_real_escape_string($con, $_POST['end_keg']);
$semester_edit=mysqli_real_escape_string($con, $_POST['semester_edit']);
$tgl_edit=mysqli_real_escape_string($con, $_POST['tgl_edit']);

$username = $_SESSION['username'];
$file_sql = "";
if (isset($_FILES['bukti_fisik_file']) && $_FILES['bukti_fisik_file']['error'] == 0) {
    $q_old = mysqli_query($con, "SELECT bukti_fisik_file FROM skkm WHERE id='$id' LIMIT 1");
    $d_old = mysqli_fetch_assoc($q_old);
    if (!empty($d_old['bukti_fisik_file'])) {
        @unlink("file_skkm/" . $d_old['bukti_fisik_file']);
    }

    $target_dir = "file_skkm/";
    $new_filename = $username . "_" . time() . "_" . basename($_FILES["bukti_fisik_file"]["name"]);
    $target_file = $target_dir . $new_filename;
    
    if (move_uploaded_file($_FILES["bukti_fisik_file"]["tmp_name"], $target_file)) {
        $file_sql = ", bukti_fisik_file='" . mysqli_real_escape_string($con, $new_filename) . "'";
    }
}

$sql="UPDATE skkm SET sub_unsur='$sub_unsur',jenis_aitem='$jenis_aitem',krdt='$krdt',bukti_fisik='$bukti_fisik',deskrip_unsur='$deskrip_unsur',tmpt='$tmpt',start_keg='$start_keg',end_keg='$end_keg',semester_edit='$semester_edit',tgl_edit='$tgl_edit' $file_sql WHERE id='$id' LIMIT 1";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));

header("location:riwayatSkkmUser.php?message=notifEdit");
?>
