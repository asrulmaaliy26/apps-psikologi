<?php
include("../psychoApps/contentsConAdm.php");

// 1. Add column ruangan_id if not exists (redundant if SQL script was run, but safe)
$check_col = mysqli_query($con, "SHOW COLUMNS FROM lab_booking_periode LIKE 'ruangan_id'");
if (mysqli_num_rows($check_col) == 0) {
    mysqli_query($con, "ALTER TABLE lab_booking_periode ADD ruangan_id INT NULL AFTER jam_selesai");
    echo "Added ruangan_id column.<br>";
}

// 2. Add room 'R1 - 12' if not exists
$check_room = mysqli_query($con, "SELECT id FROM dt_ruang WHERE nm = 'R1 - 12'");
if (mysqli_num_rows($check_room) == 0) {
    // We need a category and model ID. Let's find some existing ones or use defaults.
    $q_kat = mysqli_query($con, "SELECT id FROM opsi_kat_ruang LIMIT 1");
    $d_kat = mysqli_fetch_assoc($q_kat);
    $kat_id = $d_kat['id'] ?? 1;

    $q_mod = mysqli_query($con, "SELECT id FROM opsi_model_ruang LIMIT 1");
    $d_mod = mysqli_fetch_assoc($q_mod);
    $mod_id = $d_mod['id'] ?? 1;

    mysqli_query($con, "INSERT INTO dt_ruang (id_ruang, nm, kategori, model, status_peminjaman) VALUES (0, 'R1 - 12', '$kat_id', '$mod_id', 1)");
    echo "Added room 'R1 - 12'.<br>";
} else {
    echo "Room 'R1 - 12' already exists.<br>";
}

echo "Migration finished.";
?>
