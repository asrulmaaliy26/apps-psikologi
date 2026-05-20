<?php include("contentsConAdm.php");
$nim = mysqli_real_escape_string($con, $_GET['nim']);
$angkatan = isset($_GET['angkatan']) ? mysqli_real_escape_string($con, $_GET['angkatan']) : '';
$page = isset($_GET['page']) ? mysqli_real_escape_string($con, $_GET['page']) : 1;

$myquery = "SELECT * FROM dt_mhssw WHERE nim='$nim'";
$dmhssw = mysqli_query($con, $myquery) or die(mysqli_error($con));
$dataku = mysqli_fetch_assoc($dmhssw);
?>
<!DOCTYPE html>
<html lang="en">
<?php include("headAdm.php"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <?php
    include("navtopAdm.php");
    include("navSideBarAdmBakS1.php");
    ?>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 float-left">Detail SKKM Mahasiswa</h1>
            </div>
            <div class="col-sm-6">
              <ol class="mt-2 breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="rekapSkkmMhsBakS1.php">Rekap Angkatan</a></li>
                <li class="breadcrumb-item"><a href="skkmMhsPerAngkAdm.php?angkatan=<?php echo $angkatan; ?>&page=<?php echo $page; ?>">Angkatan <?php echo $angkatan; ?></a></li>
                <li class="breadcrumb-item active">Detail</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <?php if (isset($_GET['msg']) && $_GET['msg'] == 'success') { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Berhasil!</strong> Status validasi telah diperbarui.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php } elseif (isset($_GET['msg']) && $_GET['msg'] == 'error') { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Gagal!</strong> Terjadi kesalahan saat memperbarui status.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          <?php } ?>
          <div class="row">
            <div class="col-sm">
              <div class="card card-info card-outline">
                <div class="card-header">
                  <h3 class="card-title">Riwayat SKKM: <strong><?php echo $dataku['nama']; ?> (<?php echo $nim; ?>)</strong></h3>
                </div>
                <div class="card-body pl-0 pr-0 pb-0">
                  <div class="table-responsive">
                    <table class="table table-hover m-0 text-center table-sm custom">
                      <?php
                      $qry = "SELECT * FROM skkm_unsur";
                      $res = mysqli_query($con,  $qry) or die('Error');
                      while ($isi = mysqli_fetch_assoc($res)) {
                        $idUnsur = $isi['id'];
                      ?>
                        <thead>
                          <tr>
                            <th colspan="4" class="pl-2 text-left bg-gradient-info">Unsur <?php echo $isi['unsur']; ?></th>
                          </tr>
                        </thead>
                        <thead>
                          <tr>
                            <th width="5%" class="pl-2">No.</th>
                            <th width="50%" class="text-left">Sub Unsur</th>
                            <th width="35%" class="text-left">Jenis Aitem</th>
                            <th width="10%">Kredit</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $no = 0;
                          $query = "SELECT * FROM skkm WHERE nim='$nim' and unsur='$idUnsur'";
                          $has = mysqli_query($con,  $query) or die('Error');
                          while ($data = mysqli_fetch_assoc($has)) {
                            $no++;
                            $id = $data['id'];
                            $idSubUnsur = $data['sub_unsur'];
                            $idJenisAitem = $data['jenis_aitem'];
                            $bukti_fisik = $data['bukti_fisik'];
                            $statusform = $data['statusform'];
                            $oldDate1 = $data['tgl_input'];
                            $newDate1 = date("d-m-Y", strtotime($oldDate1));
                            $oldDate2 = $data['tgl_validasi'];
                            $newDate2 = date("d-m-Y", strtotime($oldDate2));

                            $qry1 = "SELECT * FROM subunsurskkm WHERE id='$idSubUnsur'";
                            $res1 = mysqli_query($con,  $qry1) or die('Error');
                            $data1 = mysqli_fetch_assoc($res1);

                            $qry2 = "SELECT * FROM jenisaitemskkm WHERE id='$idJenisAitem'";
                            $res2 = mysqli_query($con,  $qry2) or die('Error');
                            $data2 = mysqli_fetch_assoc($res2);

                            $qry3 = "SELECT * FROM buktifisikskkm WHERE id='$bukti_fisik'";
                            $res3 = mysqli_query($con,  $qry3) or die('Error');
                            $data3 = mysqli_fetch_assoc($res3);

                            $qry4 = "SELECT * FROM opsi_validasi WHERE id='$statusform'";
                            $res4 = mysqli_query($con,  $qry4) or die('Error');
                            $data4 = mysqli_fetch_assoc($res4);
                          ?>
                            <tr data-widget="expandable-table" aria-expanded="false">
                              <td class="text-center pl-2"><?php echo $no; ?></td>
                              <td class="text-left"><?php echo ($data1['nmSubUnsur']); ?></td>
                              <td class="text-left"><?php echo ($data2['nmJenisAitem']); ?></td>
                              <td class="text-center pr-1"><strong><?php echo ($data['krdt']); ?></strong></td>
                            </tr>
                            <tr class="expandable-body">
                              <td colspan="4">
                                <section class="content pt-2">
                                  <div class="container-fluid">
                                    <div class="col">
                                      <div class="card">
                                        <div class="card-header">
                                          <h3 class="card-title text-left">Detail Kredit Sub Unsur <?php echo $isi['unsur']; ?></h3>
                                        </div>
                                        <div class="card-body text-left pb-0">
                                          <dl class="row">
                                            <dt class="col-sm-3">Unsur</dt>
                                            <dd class="col-sm-9"><?php echo $isi['unsur']; ?></dd>
                                            <dt class="col-sm-3">Sub unsur</dt>
                                            <dd class="col-sm-9"><?php echo ($data1['nmSubUnsur']); ?></dd>
                                            <dt class="col-sm-3">Jenis aitem</dt>
                                            <dd class="col-sm-9"><?php echo ($data2['nmJenisAitem']); ?></dd>
                                            <dt class="col-sm-3">Jenis Bukti Fisik</dt>
                                            <dd class="col-sm-9"><?php echo $data3['nmBuktiFisik']; ?></dd>
                                            <dt class="col-sm-3">File Bukti Fisik</dt>
                                            <dd class="col-sm-9">
                                              <?php
                                              $fileUrl  = !empty($data['bukti_fisik_file']) ? 'file_skkm/' . $data['bukti_fisik_file'] : '';
                                              $fileName = $data['bukti_fisik_file'];
                                              $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                                              if (!empty($fileUrl)) {
                                                if (in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) { ?>
                                                  <div>
                                                    <a href="#" data-toggle="modal" data-target="#modalBF<?php echo $id; ?>">
                                                      <img src="<?php echo $fileUrl; ?>" alt="Bukti Fisik"
                                                        class="img-thumbnail"
                                                        style="max-height:120px;max-width:220px;cursor:pointer;border:2px solid #17a2b8;">
                                                    </a>
                                                    <br><small class="text-muted"><?php echo $fileName; ?></small>
                                                  </div>
                                                  <!-- Modal Preview Gambar -->
                                                  <div class="modal fade" id="modalBF<?php echo $id; ?>" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <h5 class="modal-title"><i class="fas fa-image"></i> Bukti Fisik: <?php echo $fileName; ?></h5>
                                                          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                          <img src="<?php echo $fileUrl; ?>" alt="Bukti Fisik" class="img-fluid" style="max-width:100%;">
                                                        </div>
                                                        <div class="modal-footer">
                                                          <a href="<?php echo $fileUrl; ?>" target="_blank" class="btn btn-info btn-sm">
                                                            <i class="fas fa-external-link-alt"></i> Buka di Tab Baru
                                                          </a>
                                                          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                <?php } elseif ($fileExt === 'pdf') { ?>
                                                  <div>
                                                    <a href="<?php echo $fileUrl; ?>" target="_blank" class="btn btn-sm btn-outline-danger">
                                                      <i class="fas fa-file-pdf"></i> Lihat PDF
                                                    </a>
                                                    <br><small class="text-muted"><?php echo $fileName; ?></small>
                                                  </div>
                                                <?php } elseif (in_array($fileExt, ['doc', 'docx'])) { ?>
                                                  <div>
                                                    <a href="<?php echo $fileUrl; ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                      <i class="fas fa-file-word"></i> Lihat Dokumen Word
                                                    </a>
                                                    <br><small class="text-muted"><?php echo $fileName; ?></small>
                                                  </div>
                                                <?php } else { ?>
                                                  <div>
                                                    <a href="<?php echo $fileUrl; ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                                      <i class="fas fa-file-download"></i> Download / Lihat File
                                                    </a>
                                                    <br><small class="text-muted"><?php echo $fileName; ?></small>
                                                  </div>
                                                <?php }
                                              } else { ?>
                                                <span class="text-muted"><i class="fas fa-times-circle text-secondary"></i> Tidak ada file yang diupload</span>
                                              <?php } ?>
                                            </dd>
                                            <dt class="col-sm-3">Deskripsi unsur</dt>
                                            <dd class="col-sm-9"><?php echo $data['deskrip_unsur'] = preg_replace('/<p[^>]*>(.*)<\/p[^>]*>/i', '$1', $data['deskrip_unsur']); ?></dd>
                                            <dt class="col-sm-3">Tempat/lembaga</dt>
                                            <dd class="col-sm-9"><?php echo $data['tmpt']; ?></dd>
                                            <dt class="col-sm-3">Waktu kegiatan</dt>
                                            <dd class="col-sm-9"><?php echo $data['start_keg'] . ' s.d ' . $data['end_keg']; ?></dd>
                                            <dt class="col-sm-3">Kredit</dt>
                                            <dd class="col-sm-9"><?php echo $data['krdt']; ?></dd>
                                            <dt class="col-sm-3">Submit data di semester</dt>
                                            <dd class="col-sm-9"><?php echo $data['semester']; ?></dd>
                                            <dt class="col-sm-3">Tanggal input</dt>
                                            <dd class="col-sm-9"><?php echo $newDate1; ?></dd>
                                            <dt class="col-sm-3">Status validasi</dt>
                                            <dd class="col-sm-9">
                                              <form action="updateStatusSkkmAdm.php" method="post" class="form-inline">
                                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                <input type="hidden" name="nim" value="<?php echo $nim; ?>">
                                                <input type="hidden" name="angkatan" value="<?php echo $angkatan; ?>">
                                                <input type="hidden" name="page" value="<?php echo $page; ?>">
                                                <div class="input-group input-group-sm">
                                                  <select name="statusform" class="form-control" required>
                                                    <?php
                                                    $tampil = mysqli_query($con, "SELECT * FROM opsi_validasi ORDER BY id ASC");
                                                    while ($w = mysqli_fetch_array($tampil)) {
                                                      $selected = ($statusform == $w['id']) ? 'selected' : '';
                                                      echo "<option value='$w[id]' $selected>$w[nm]</option>";
                                                    }
                                                    ?>
                                                  </select>
                                                  <div class="input-group-append">
                                                    <button type="submit" class="btn btn-info btn-flat"><i class="fas fa-save"></i> Simpan</button>
                                                  </div>
                                                </div>
                                              </form>
                                              <?php if ($data['statusform'] != 1) { ?>
                                                <small class="text-muted">Terakhir divalidasi pada: <?php echo $newDate2; ?></small>
                                              <?php } ?>
                                            </dd>
                                          </dl>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </section>
                              </td>
                            </tr>
                          <?php
                            $qry2 = "SELECT SUM(krdt) AS jumKredit FROM skkm WHERE nim='$nim' AND unsur = '$idUnsur'";
                            $result = mysqli_query($con,  $qry2);
                            $dt = mysqli_fetch_array($result);
                            $jumKredit = $dt['jumKredit'];

                            $query1 = "SELECT * FROM persentase_skkm WHERE id='$idUnsur'";
                            $hasil1 = mysqli_query($con,  $query1);
                            $data1 = mysqli_fetch_assoc($hasil1);
                            $prsn1 = $data1['jumlah_1'];
                            $prsn2 = $data1['jumlah_2'];

                            $query = "SELECT SUM(krdt) AS totalKredit FROM skkm WHERE nim='$nim'";
                            $hasil = mysqli_query($con,  $query);
                            $data = mysqli_fetch_array($hasil);
                            $totalKredit = $data['totalKredit'];

                            $persenKredit = ($totalKredit != 0) ? ($jumKredit / $totalKredit) * 100 : 0;
                          }
                          ?>
                          <tr>
                            <td colspan="2" class="text-right"><strong>Jumlah kredit:</strong></td>
                            <td colspan="2" class="text-left"><strong><?php if (empty($jumKredit)) {
                                                                        echo "0";
                                                                      } else {
                                                                        echo  $jumKredit;
                                                                      } ?> (<?php printf("%1.0f", $persenKredit);
                                                                                                                                            print("%"); ?>)</strong></td>
                          </tr>
                          <tr>
                            <td colspan="2" class="text-right"><strong>Status:</strong></td>
                            <td colspan="2" class="text-left"><strong><?php
                                                                      if ($persenKredit >= $prsn1 && $persenKredit <= $prsn2) {
                                                                        echo "<span class='text-success'>Sesuai standar</span>";
                                                                      } else if ($persenKredit < $prsn1) {
                                                                        echo "<span class='text-danger'>Kurang dari standar</span>";
                                                                      } else if ($persenKredit > $prsn2) {
                                                                        echo "<span class='text-warning'>Lebih dari standar</span>";
                                                                      }
                                                                      ?></strong></td>
                          </tr>
                        </tbody>
                      <?php
                      }
                      ?>
                    </table>
                  </div>
                </div>
                <div class="card-footer">
                  Total kredit:
                  <?php
                  $myqry = "SELECT * FROM predikat_total_kredit";
                  $hsl = mysqli_query($con, $myqry);
                  $opsi  = mysqli_fetch_assoc($hsl);
                  $jum1 = $opsi['jumlah_1'];
                  $jum2 = $opsi['jumlah_2'];
                  $jum3 = $opsi['jumlah_3'];

                  echo "<strong>" . (empty($totalKredit) ? '0' : $totalKredit) . "</strong>";
                  ?>
                  <br />
                  Predikat:
                  <?php
                  if ($totalKredit > $jum3) {
                    echo "<strong>Prestisius</strong>";
                  } else if ($totalKredit >= $jum2) {
                    echo "<strong>Sangat Aktif</strong>";
                  } else if ($totalKredit >= $jum1) {
                    echo "<strong>Aktif</strong>";
                  } else {
                    echo "<strong>Kurang</strong>";
                  }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
  <?php include("footerAdm.php"); ?>
  <?php include("jsAdm.php"); ?>
</body>

</html>