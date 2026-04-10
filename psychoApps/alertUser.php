<?php
include( "contentsConAdm.php" );
$username = $_SESSION['username'];

if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
echo '<div class="alert alert-success custom-alert col-12 rounded-0" role="alert" style="position:fixed;">
<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Submit berhasil...</div>';}

if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
echo '<div class="alert alert-success custom-alert col-12 rounded-0" role="alert" style="position:fixed;">
<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Data berhasil diupdate...</div>';}

if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
echo '<div class="alert alert-success custom-alert col-12 rounded-0" role="alert" style="position:fixed;">
<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Data berhasil dihapus...</div>';}

if (!empty($_GET['message']) && $_GET['message'] == 'notifGagal') {
echo '<div class="alert alert-success custom-alert col-12 rounded-0" role="alert" style="position:fixed;">
<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Data gagal diupdate...</div>';}

if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalUpload') {
echo '<div class="alert alert-success custom-alert col-12 rounded-0" role="alert" style="position:fixed;">
<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Gagal! File yang diupload harus berbentuk pdf. Ukuran file maksimal 2MB</div>';}

if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalSempro') {
echo '<div class="alert alert-success custom-alert col-12 rounded-0" role="alert" style="position:fixed;">
<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Gagal! yang bersangkutan telah mengikuti Seminar Proposal Tesis</div>';}

if (!empty($_GET['message']) && $_GET['message'] == 'notifCatatan') {
echo '<div class="alert alert-success custom-alert col-12 rounded-0" role="alert" style="position:fixed;">
<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Catatan berhasil diupdate...</div>';}

if (!empty($_GET['message']) && $_GET['message'] == 'notifSama') {
echo '<div class="alert alert-success custom-alert col-12 rounded-0" role="alert" style="position:fixed;">
<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Submit Gagal! Periode sudah ada...</div>';}

if (!empty($_GET['message']) && $_GET['message'] == 'notifTa') {
echo '<div class="alert alert-success custom-alert col-12 rounded-0" role="alert" style="position:fixed;">
<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Tidak ada Tahun Akademik yang aktif, silahkan cek Tahun Akademik...</div>';}

if (!empty($_GET['message']) && $_GET['message'] == 'notifSamaAc') {
echo '<div class="alert alert-success custom-alert col-12 rounded-0" role="alert" style="position:fixed;">
<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Submit Gagal! Academic Coach sudah ada...</div>';}

if (!empty($_GET['message']) && $_GET['message'] == 'notifSamaPt') {
echo '<div class="alert alert-success custom-alert col-12 rounded-0" role="alert" style="position:fixed;">
<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Submit Gagal! Dospem Tesis sudah ada...</div>';}

if (!empty($_GET['message']) && $_GET['message'] == 'notifSetengah') {
echo '<div class="alert alert-success custom-alert col-12 rounded-0" role="alert" style="position:fixed;">
<a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Hanya syarat SKS dan waktu pendaftaran yang terupdate! Sedangkan tahap tidak terupdate karena telah ada...</div>';}

if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalDospem1') {
echo '
<div class="modal fade" id="modalAlert">
  <div class="modal-dialog">
    <div class="modal-content bg-success">
      <div class="modal-header">
        <h4 class="modal-title">Peringatan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p>Kuota Dosen pembimbing skripsi 1 yang dipilih sudah penuh. Silahkan pilih Dosen pembimbing skripsi 1 yang belum penuh kuotanya.</p>
      </div>
    </div>
  </div>
</div>';
}

if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalDospem2') {
echo '
<div class="modal fade" id="modalAlert">
  <div class="modal-dialog">
    <div class="modal-content bg-success">
      <div class="modal-header">
        <h4 class="modal-title">Peringatan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p>Kuota Dosen pembimbing skripsi 2 yang dipilih sudah penuh. Silahkan pilih Dosen pembimbing skripsi 2 yang belum penuh kuotanya.</p>
      </div>
    </div>
  </div>
</div>';
}

if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalDospem12') {
echo '
<div class="modal fade" id="modalAlert">
  <div class="modal-dialog">
    <div class="modal-content bg-success">
      <div class="modal-header">
        <h4 class="modal-title">Peringatan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p>Kuota Dosen pembimbing skripsi 1 dan 2 yang dipilih sudah penuh. Silahkan pilih Dosen pembimbing skripsi yang belum penuh kuotanya.</p>
      </div>
    </div>
  </div>
</div>';
}

if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalSama') {
echo '
<div class="modal fade" id="modalAlert">
  <div class="modal-dialog">
    <div class="modal-content bg-success">
      <div class="modal-header">
        <h4 class="modal-title">Peringatan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <h4>Note!</h4>
        <p>Pilihan Dosen pembimbing skripsi tidak boleh sama. Silahkan pilih Dosen pembimbing skripsi yang berbeda.</p>
      </div>
    </div>
  </div>
</div>';
}
?>