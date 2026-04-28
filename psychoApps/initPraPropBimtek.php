<?php
// Auto-create bimtek_pra_proposal table if not exists
// Include this file in any page that uses bimtek_pra_proposal

$_sql_create_pra_prop = "CREATE TABLE IF NOT EXISTS bimtek_pra_proposal (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_bimtek VARCHAR(20) NOT NULL,
  nim VARCHAR(20) NOT NULL,
  id_reviewer VARCHAR(30) NOT NULL,
  judul TEXT,
  abstrak TEXT,
  file_proposal VARCHAR(255),
  file_sertifikat VARCHAR(255),
  status_sertifikat ENUM('pending','valid','invalid','bypassed') DEFAULT 'pending',
  catatan_sertifikat TEXT,
  status ENUM('proses','revisi','diterima') DEFAULT 'proses',
  catatan TEXT,
  pembimbing_saran_1 VARCHAR(30),
  pembimbing_saran_2 VARCHAR(30),
  a1 TINYINT DEFAULT 0,
  a2 TINYINT DEFAULT 0,
  a3 TINYINT DEFAULT 0,
  a4 TINYINT DEFAULT 0,
  a5 TINYINT DEFAULT 0,
  a6 TINYINT DEFAULT 0,
  nilai_akhir FLOAT DEFAULT 0,
  tgl_submit DATETIME,
  tgl_update DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
mysqli_query($con, $_sql_create_pra_prop);

// Add tgl_buka_praprop & tgl_tutup_praprop & bypass_sertifikat columns to bimtek_pendaftaran if not exists
$_cols = mysqli_query($con, "SHOW COLUMNS FROM bimtek_pendaftaran LIKE 'tgl_buka_praprop'");
if(mysqli_num_rows($_cols) == 0){
    mysqli_query($con, "ALTER TABLE bimtek_pendaftaran ADD COLUMN tgl_buka_praprop DATETIME NULL AFTER tgl_tampil_pengumuman");
    mysqli_query($con, "ALTER TABLE bimtek_pendaftaran ADD COLUMN tgl_tutup_praprop DATETIME NULL AFTER tgl_buka_praprop");
}
$_cols2 = mysqli_query($con, "SHOW COLUMNS FROM bimtek_pendaftaran LIKE 'bypass_sertifikat'");
if(mysqli_num_rows($_cols2) == 0){
    mysqli_query($con, "ALTER TABLE bimtek_pendaftaran ADD COLUMN bypass_sertifikat TINYINT(1) DEFAULT 0 AFTER tgl_tutup_praprop");
}

// Add file_sertifikat if not exists
$_c1 = mysqli_query($con, "SHOW COLUMNS FROM bimtek_pra_proposal LIKE 'file_sertifikat'");
if(mysqli_num_rows($_c1) == 0){
    mysqli_query($con, "ALTER TABLE bimtek_pra_proposal ADD COLUMN file_sertifikat VARCHAR(255) NULL AFTER file_proposal");
}
// Add status_sertifikat if not exists
$_c2 = mysqli_query($con, "SHOW COLUMNS FROM bimtek_pra_proposal LIKE 'status_sertifikat'");
if(mysqli_num_rows($_c2) == 0){
    mysqli_query($con, "ALTER TABLE bimtek_pra_proposal ADD COLUMN status_sertifikat ENUM('pending','valid','invalid','bypassed') DEFAULT 'pending' AFTER file_sertifikat");
}
// Add catatan_sertifikat if not exists
$_c3 = mysqli_query($con, "SHOW COLUMNS FROM bimtek_pra_proposal LIKE 'catatan_sertifikat'");
if(mysqli_num_rows($_c3) == 0){
    mysqli_query($con, "ALTER TABLE bimtek_pra_proposal ADD COLUMN catatan_sertifikat TEXT NULL AFTER status_sertifikat");
}

// Add pembimbing_saran_1 and 2 if not exists
$_c4 = mysqli_query($con, "SHOW COLUMNS FROM bimtek_pra_proposal LIKE 'pembimbing_saran_1'");
if(mysqli_num_rows($_c4) == 0){
    mysqli_query($con, "ALTER TABLE bimtek_pra_proposal ADD COLUMN pembimbing_saran_1 VARCHAR(30) NULL AFTER catatan");
    mysqli_query($con, "ALTER TABLE bimtek_pra_proposal ADD COLUMN pembimbing_saran_2 VARCHAR(30) NULL AFTER pembimbing_saran_1");
}

// Add grading columns if not exists
$_c5 = mysqli_query($con, "SHOW COLUMNS FROM bimtek_pra_proposal LIKE 'a1'");
if(mysqli_num_rows($_c5) == 0){
    mysqli_query($con, "ALTER TABLE bimtek_pra_proposal 
        ADD COLUMN a1 TINYINT DEFAULT 0 AFTER pembimbing_saran_2,
        ADD COLUMN a2 TINYINT DEFAULT 0 AFTER a1,
        ADD COLUMN a3 TINYINT DEFAULT 0 AFTER a2,
        ADD COLUMN a4 TINYINT DEFAULT 0 AFTER a3,
        ADD COLUMN a5 TINYINT DEFAULT 0 AFTER a4,
        ADD COLUMN a6 TINYINT DEFAULT 0 AFTER a5,
        ADD COLUMN nilai_akhir FLOAT DEFAULT 0 AFTER a6");
}

// Create upload directory if not exists
$_dir_pra_prop = __DIR__ . '/file_pra_proposal_bimtek';
if(!is_dir($_dir_pra_prop)){
    mkdir($_dir_pra_prop, 0755, true);
}
?>
