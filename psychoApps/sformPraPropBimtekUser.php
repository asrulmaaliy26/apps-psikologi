<?php
include("contentsConAdm.php");
include("initPraPropBimtek.php");
$username = $_SESSION['username'];

$id_bimtek = mysqli_real_escape_string($con, $_POST['id_bimtek']);
$id_reviewer = mysqli_real_escape_string($con, $_POST['id_reviewer']);
$judul = mysqli_real_escape_string($con, $_POST['judul']);
$abstrak = mysqli_real_escape_string($con, $_POST['abstrak']);
$tgl = date('Y-m-d H:i:s');

// Validate reviewer still matches and get bypass_sertifikat setting
$q_check = mysqli_query($con, "SELECT bp.id, b.bypass_sertifikat FROM bimtek_peserta bp 
    JOIN bimtek_pendaftaran b ON bp.id_bimtek = b.id
    WHERE bp.nim='$username' AND bp.id_bimtek='$id_bimtek' AND bp.id_reviewer='$id_reviewer'");
$d_check = mysqli_fetch_assoc($q_check);
if(!$d_check){
    header("location:formPraPropBimtekUser.php?id_bimtek=$id_bimtek&error=invalid");
    exit();
}
$bypass_sertifikat = $d_check['bypass_sertifikat'];

// Check existing record
$q_exist = mysqli_query($con, "SELECT id, status, file_proposal, file_sertifikat FROM bimtek_pra_proposal WHERE nim='$username' AND id_bimtek='$id_bimtek'");
$d_exist = mysqli_fetch_assoc($q_exist);

// Handle file upload
$file_name = $d_exist ? $d_exist['file_proposal'] : ''; // keep old file if no new upload
if(isset($_FILES['file_proposal']) && $_FILES['file_proposal']['size'] > 0){
    $file = $_FILES['file_proposal'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if($ext !== 'pdf'){
        header("location:formPraPropBimtekUser.php?id_bimtek=$id_bimtek&error=filetype");
        exit();
    }
    if($file['size'] > 5*1024*1024){
        header("location:formPraPropBimtekUser.php?id_bimtek=$id_bimtek&error=filesize");
        exit();
    }
    $file_name = $username . '_' . $id_bimtek . '_prop_' . time() . '.pdf';
    move_uploaded_file($file['tmp_name'], __DIR__ . '/file_pra_proposal_bimtek/' . $file_name);
}

// Handle sertifikat upload
$sertifikat_name = $d_exist ? $d_exist['file_sertifikat'] : '';
if(isset($_FILES['file_sertifikat']) && $_FILES['file_sertifikat']['size'] > 0){
    $file_sert = $_FILES['file_sertifikat'];
    $ext_sert = strtolower(pathinfo($file_sert['name'], PATHINFO_EXTENSION));
    if($ext_sert !== 'pdf'){
        header("location:formPraPropBimtekUser.php?id_bimtek=$id_bimtek&error=filetypesert");
        exit();
    }
    if($file_sert['size'] > 5*1024*1024){
        header("location:formPraPropBimtekUser.php?id_bimtek=$id_bimtek&error=filesizesert");
        exit();
    }
    $sertifikat_name = $username . '_' . $id_bimtek . '_sert_' . time() . '.pdf';
    move_uploaded_file($file_sert['tmp_name'], __DIR__ . '/file_pra_proposal_bimtek/' . $sertifikat_name);
}

if(!$file_name || !$sertifikat_name){
    header("location:formPraPropBimtekUser.php?id_bimtek=$id_bimtek&error=nofile");
    exit();
}

// Determine status_sertifikat
$status_sertifikat = ($bypass_sertifikat == 1) ? 'bypassed' : 'pending';

if($d_exist){
    // Only allow resubmit if status = revisi
    if($d_exist['status'] !== 'revisi'){
        header("location:formPraPropBimtekUser.php?id_bimtek=$id_bimtek&error=notrevisi");
        exit();
    }
    // Update existing record, reset status to proses, and status_sertifikat
    mysqli_query($con, "UPDATE bimtek_pra_proposal SET 
        judul='$judul', abstrak='$abstrak', file_proposal='$file_name', file_sertifikat='$sertifikat_name',
        status_sertifikat='$status_sertifikat', catatan_sertifikat='',
        status='proses', catatan='', tgl_update='$tgl'
        WHERE id='".$d_exist['id']."'");
} else {
    // Insert new record
    mysqli_query($con, "INSERT INTO bimtek_pra_proposal (id_bimtek, nim, id_reviewer, judul, abstrak, file_proposal, file_sertifikat, status_sertifikat, status, tgl_submit, tgl_update)
        VALUES ('$id_bimtek', '$username', '$id_reviewer', '$judul', '$abstrak', '$file_name', '$sertifikat_name', '$status_sertifikat', 'proses', '$tgl', '$tgl')");
}

header("location:formPraPropBimtekUser.php?id_bimtek=$id_bimtek&message=success");
?>
