<?php
function calculateTotalPkl($con, $id_peserta) {
    $q = mysqli_query($con, "SELECT * FROM penilaian_pkl_detail WHERE id_peserta_pkl='$id_peserta'");
    if(mysqli_num_rows($q) == 0) return [
        'panitia_avg' => 0, 'super_avg' => 0, 'dpl_pel_avg' => 0,
        'dpl_lap_avg' => 0, 'peng_lap_avg' => 0, 'dpl_pres_avg' => 0,
        'peng_pres_avg' => 0, 'total' => 0
    ];
    
    $d = mysqli_fetch_assoc($q);
    
    // 1. Pembekalan Panitia (10%) - 3 ind
    $panitia_sum = 0;
    $panitia_count = 0;
    for($i=1; $i<=3; $i++) {
        $f = 'panitia_pembekalan_'.$i;
        if($d[$f] !== null) { $panitia_sum += $d[$f]; $panitia_count++; }
    }
    $panitia_avg = ($panitia_count > 0) ? ($panitia_sum / 3) : 0; // if not all filled, still divide by 3 or count? usually divide by total indicators
    // wait, if some are not filled, it means 0. So divide by total indicators
    $panitia_avg = $panitia_sum / 3;

    // 2. Pelaksanaan Supervisor (40%) - 12 ind
    $super_sum = 0;
    for($i=1; $i<=12; $i++) {
        $f = 'super_pelaksanaan_'.$i;
        if($d[$f] !== null) { $super_sum += $d[$f]; }
    }
    $super_avg = $super_sum / 12;

    // 3. Pelaksanaan DPL (10%) - 8 ind
    $dpl_pel_sum = 0;
    for($i=1; $i<=8; $i++) {
        $f = 'dpl_pelaksanaan_'.$i;
        if($d[$f] !== null) { $dpl_pel_sum += $d[$f]; }
    }
    $dpl_pel_avg = $dpl_pel_sum / 8;

    // 4. Laporan DPL (10%) - 6 ind
    $dpl_lap_sum = 0;
    for($i=1; $i<=6; $i++) {
        $f = 'dpl_laporan_'.$i;
        if($d[$f] !== null) { $dpl_lap_sum += $d[$f]; }
    }
    $dpl_lap_avg = $dpl_lap_sum / 6;

    // 5. Laporan Penguji (10%) - 6 ind
    $peng_lap_sum = 0;
    for($i=1; $i<=6; $i++) {
        $f = 'penguji_laporan_'.$i;
        if($d[$f] !== null) { $peng_lap_sum += $d[$f]; }
    }
    $peng_lap_avg = $peng_lap_sum / 6;

    // 6. Presentasi DPL (10%) - 6 ind
    $dpl_pres_sum = 0;
    for($i=1; $i<=6; $i++) {
        $f = 'dpl_presentasi_'.$i;
        if($d[$f] !== null) { $dpl_pres_sum += $d[$f]; }
    }
    $dpl_pres_avg = $dpl_pres_sum / 6;

    // 7. Presentasi Penguji (10%) - 6 ind
    $peng_pres_sum = 0;
    for($i=1; $i<=6; $i++) {
        $f = 'penguji_presentasi_'.$i;
        if($d[$f] !== null) { $peng_pres_sum += $d[$f]; }
    }
    $peng_pres_avg = $peng_pres_sum / 6;

    // Calculate Total
    $total = ($panitia_avg * 0.10) + 
             ($super_avg * 0.40) + 
             ($dpl_pel_avg * 0.10) + 
             ($dpl_lap_avg * 0.10) + 
             ($peng_lap_avg * 0.10) + 
             ($dpl_pres_avg * 0.10) + 
             ($peng_pres_avg * 0.10);

    // Update to db
    mysqli_query($con, "UPDATE peserta_pkl SET nilai='$total' WHERE id='$id_peserta'");

    return [
        'panitia_avg' => $panitia_avg,
        'super_avg' => $super_avg,
        'dpl_pel_avg' => $dpl_pel_avg,
        'dpl_lap_avg' => $dpl_lap_avg,
        'peng_lap_avg' => $peng_lap_avg,
        'dpl_pres_avg' => $dpl_pres_avg,
        'peng_pres_avg' => $peng_pres_avg,
        'total' => $total
    ];
}
?>
