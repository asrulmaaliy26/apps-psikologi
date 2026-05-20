<?php
include( "contentsConAdm.php" );

$nim = mysqli_real_escape_string($con,  $_POST[ 'nim' ] );
$unsur = mysqli_real_escape_string($con,  $_POST[ 'unsur' ] );
$sub_unsur = mysqli_real_escape_string($con,  $_POST[ 'sub_unsur' ] );
$jenis_aitem = mysqli_real_escape_string($con,  $_POST[ 'jenis_aitem' ] );
$bukti_fisik = mysqli_real_escape_string($con,  $_POST[ 'bukti_fisik' ] );
$deskrip_unsur = mysqli_real_escape_string($con,  $_POST[ 'deskrip_unsur' ] );
$tmpt = mysqli_real_escape_string($con,  $_POST[ 'tmpt' ] );
$start_keg = mysqli_real_escape_string($con,  $_POST[ 'start_keg' ] );
$end_keg = mysqli_real_escape_string($con,  $_POST[ 'end_keg' ] );
$krdt = mysqli_real_escape_string($con,  $_POST[ 'krdt' ] );
$semester = mysqli_real_escape_string($con,  $_POST[ 'semester' ] );
$tgl_input = mysqli_real_escape_string($con,  $_POST[ 'tgl_input' ] );
$statusform = mysqli_real_escape_string($con,  $_POST[ 'statusform' ] );

$bukti_fisik_file = "";
if (isset($_FILES['bukti_fisik_file']) && $_FILES['bukti_fisik_file']['error'] == 0) {
    $target_dir = "file_skkm/";
    $new_filename = $nim . "_" . time() . "_" . basename($_FILES["bukti_fisik_file"]["name"]);
    $target_file = $target_dir . $new_filename;
    
    if (move_uploaded_file($_FILES["bukti_fisik_file"]["tmp_name"], $target_file)) {
        $bukti_fisik_file = mysqli_real_escape_string($con, $new_filename);
    }
}

$sql = "INSERT INTO skkm (`nim`, `unsur`, `sub_unsur`, `jenis_aitem`, `krdt`, `bukti_fisik`, `deskrip_unsur`, `tmpt`, `start_keg`, `end_keg`, `semester`, `semester_edit`, `tgl_input`, `tgl_edit`, `tgl_validasi`, `statusform`, `bukti_fisik_file`) 
        VALUES ('$nim', '$unsur', '$sub_unsur', '$jenis_aitem', '$krdt', '$bukti_fisik', '$deskrip_unsur', '$tmpt', '$start_keg', '$end_keg', '$semester', '0', '$tgl_input', '0000-00-00', '0000-00-00', '$statusform', '$bukti_fisik_file')";
mysqli_query($con, $sql) or die(mysqli_error($con)); {
	header("location:formSkkmUser.php?id=$unsur&message=notifInput");
}
?>