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

mysqli_query($con,  "INSERT INTO skkm(nim,unsur,sub_unsur,jenis_aitem,krdt,bukti_fisik,deskrip_unsur,tmpt,start_keg,end_keg,semester,tgl_input,statusform)" .
	"VALUES('$nim','$unsur','$sub_unsur','$jenis_aitem','$krdt','$bukti_fisik','$deskrip_unsur','$tmpt','$start_keg','$end_keg','$semester','$tgl_input','$statusform')" )or DIE( mysqli_error($con) ); {
	header("location:formSkkmUser.php?id=$unsur&message=notifInput");
}
?>