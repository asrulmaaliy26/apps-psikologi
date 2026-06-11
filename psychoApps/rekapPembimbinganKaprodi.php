<?php include("contentsConAdm.php");
$username = $_SESSION['username'];

// Validasi Kaprodi S1 & Sekprodi
$q_me = mysqli_query($con, "SELECT * FROM dt_pegawai WHERE id='$username'");
$dMe = mysqli_fetch_assoc($q_me);
if ($dMe['jabatan_instansi'] != '47' && $dMe['jabatan_instansi'] != '46') {
    header("location:dashboardAdm.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php
        include("navtopAdm.php");
        include("navSideBarDosen.php");
        ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h6 class="m-0">Seluruh Pembimbing Mahasiswa</h6>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active small">Seluruh Pembimbing Mahasiswa</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                        include 'pagination.php';
                        $reload = "rekapPembimbinganKaprodi.php?pagination=true";
                        $sql = "SELECT pengelompokan_dospem_skripsi.angkatan FROM pengelompokan_dospem_skripsi GROUP BY pengelompokan_dospem_skripsi.angkatan ORDER BY pengelompokan_dospem_skripsi.angkatan DESC";
                        $result = mysqli_query($con, $sql);

                        $rpp = 10;
                        $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 1;
                        $tcount = mysqli_num_rows($result);
                        $tpages = ($tcount) ? ceil($tcount / $rpp) : 1;
                        $count = 0;
                        $i = ($page - 1) * $rpp;
                        $no_urut = ($page - 1) * $rpp;
                        ?>
                        <section class="col-md-12 connectedSortable">
                            <div class="card card-outline card-info">
                                <div class="card-header">
                                    <div class="clearfix">
                                        <h4 class="card-title float-left">Daftar Pembimbing Mahasiswa Per Angkatan</h4>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover m-0 table-bordered text-center table-sm small custom">
                                            <thead>
                                                <tr class="text-center bg-secondary">
                                                    <td width="5%" rowspan="2" class="pl-1">No.</td>
                                                    <td width="20%" rowspan="2">Angkatan</td>
                                                    <td class="border-bottom-0" colspan="3">Status Pembimbingan</td>
                                                    <td width="15%" rowspan="2">Total Mahasiswa</td>
                                                </tr>
                                                <tr class="text-center bg-secondary">
                                                    <td width="20%">Pengajuan</td>
                                                    <td width="20%">Proses</td>
                                                    <td width="20%" class="pr-1">Selesai</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while (($count < $rpp) && ($i < $tcount)) {
                                                    mysqli_data_seek($result, $i);
                                                    $data = mysqli_fetch_array($result);
                                                    $angkatan = $data['angkatan'];

                                                    $qry1 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE status = '1' AND angkatan='$angkatan'";
                                                    $data1 = mysqli_fetch_assoc(mysqli_query($con, $qry1));

                                                    $qry2 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE status = '2' AND angkatan='$angkatan'";
                                                    $data2 = mysqli_fetch_assoc(mysqli_query($con, $qry2));

                                                    $qry3 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE status = '3' AND angkatan='$angkatan'";
                                                    $data3 = mysqli_fetch_assoc(mysqli_query($con, $qry3));

                                                    $qry4 = "SELECT COUNT(id) AS jumData FROM pengelompokan_dospem_skripsi WHERE angkatan='$angkatan'";
                                                    $data4 = mysqli_fetch_assoc(mysqli_query($con, $qry4));
                                                    ?>
                                                    <tr>
                                                        <td class="text-center pl-1"> <?php echo ++$no_urut; ?> </td>
                                                        <td class="text-center font-weight-bold"> <?php echo $angkatan; ?> </td>
                                                        <td class="text-center"> <?php echo $data1['jumData']; ?> </td>
                                                        <td class="text-center"> <?php echo $data2['jumData']; ?> </td>
                                                        <td class="text-center"> <?php echo $data3['jumData']; ?> </td>
                                                        <td class="text-center">
                                                            <?php if ($data4['jumData'] == 0) {
                                                                echo '<a type="button" class="btn btn-outline-secondary btn-flat btn-xs btn-block" title="Tidak ada data" onclick="return confirm(\'Tidak ada data\')">' . $data4['jumData'] . '</a>';
                                                            } else {
                                                                echo '<a href="allPembPerAngkKaprodi.php?angkatan=' . $angkatan . '&page=' . $page . '" type="button" class="btn btn-outline-primary btn-flat btn-xs btn-block" title="Lihat dan kelola pembimbing"><i class="fas fa-users-cog"></i> Kelola (' . $data4['jumData'] . ')</a>';
                                                            } ?>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    $i++;
                                                    $count++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer pb-0 clearfix">
                                    <div class="float-right"><?php echo paginate_one($reload, $page, $tpages); ?></div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?php include("footerAdm.php"); ?>
    <?php include("jsAdm.php"); ?>
</body>
</html>
