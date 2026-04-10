<?php
  include("koneksiUser.php");
  $nim = $_SESSION['nim'];
  
  $myquery = "select * from mag_dt_mhssw_pasca WHERE nim='$nim'";
  $dmhssw = mysqli_query($GLOBALS["___mysqli_ston"], $myquery)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
  $dataku = mysqli_fetch_assoc($dmhssw);
  ?>
<html lang="en">
  <head>
    <?php include 'headUser.php';?>
  </head>
  <body>
    <?php include "navPendUser.php";?>
    <div class="container">
      <div class="row">
        <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifGagal') {
                 echo '
          <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog">
          <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">×</button>
          <h4 class="modal-title">Submit gagal</h4>
          </div>
          <div class="modal-body">
          <p>Salah satu atau semua file yang diupload bukan berbentuk PDF (berekstensi .pdf).</p>
          <p><strong>Note:</strong> Konversikan file ke PDF terlebih dahulu...</p>
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
          </div>
          </div>
          </div>';} 
          if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
                 echo '<div class="alert alert-warning custom-alert" role="alert">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Submit berhasil...</div>';}
           
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
                 echo '<div class="alert alert-success custom-alert" role="alert">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Data berhasil diupdate...</div>';}
          
          if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
                 echo '<div class="alert alert-danger custom-alert" role="alert">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>Data berhasil dihapus...</div>';}         
                 ?>
        <h3 class="text-center text-info">Upload Revisi Seminar Proposal Tesis</h3>
        <div class="panel panel-info">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah data pendaftaran Seminar Proposal Tesis Anda.</li>
              <li>Form diisi paling lambat 30 hari setelah pelaksanaan Seminar Proposal Tesis, dan secara otomatis setelah batas waktu berakhir, maka form tidak dapat diisi lagi.</li>
              <li>Silahkan pilih pendaftaran Seminar Proposal Tesis yang Anda maksud untuk pengisian form.</li>
              <li>Form dapat diedit selama belum terverifikasi oleh admin.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table class="table table-condensed table-bordered custom" style="margin-bottom:0px;">
                <thead>
                  <tr class="success">
                    <th width="2%" class="text-center">No.</th>
                    <th width="42%" class="text-center">Periode seminar proposal tesis</th>
                    <th width="14%" class="text-center">Tgl. seminar</th>
                    <th width="22%" class="text-center">Tgl. akhir revisi</th>
                    <th width="20%" class="text-center">Opsi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $no=0;
                    $qry = "SELECT * FROM mag_peserta_sempro WHERE nim='$dataku[nim]'";
                    $has = mysqli_query($GLOBALS["___mysqli_ston"],  $qry )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
                    while($md = mysqli_fetch_assoc( $has )) {
                    $id=$md['id'];
                    $id_sempro=$md['id_sempro'];
                    $no++;
                    
                    $qry_jadwal = "SELECT * FROM mag_jadwal_sempro WHERE id_sempro='$md[id_sempro]' AND nim='$md[nim]'";
                    $res = mysqli_query($GLOBALS["___mysqli_ston"], $qry_jadwal);
                    $djadwal = mysqli_fetch_assoc($res);
                    $batas_revisi = $djadwal['batas_revisi'];
                    $timestamp = strtotime($batas_revisi);
                    $tgl_bts_rev_konv = date("d-m-Y", $timestamp);

                    $qry_moment = "SELECT * FROM mag_periode_pendaftaran_sempro WHERE id='$md[id_sempro]'";
                    $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_moment);
                    $data = mysqli_fetch_assoc($hasil);
                    $id_sempro=$data['id'];
                    $thp=$data['tahap'];
                    $ta=$data['ta'];
                    
                    $qry_nm_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$thp'";
                    $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_thp);
                    $dthp = mysqli_fetch_assoc($hasil);
                    
                    $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$ta'";
                    $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
                    $dnta = mysqli_fetch_assoc($hasil);
                    
                    $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
                    $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
                    $dsemester = mysqli_fetch_assoc($h);
                    ?>
                  <tr>
                    <td class="text-center"><?php echo $no;?></td>
                    <td class="text-center"><?php echo "Tahap ".$dthp['tahap']." Semester ".$dsemester['nama'].' TA. '.$dnta['ta']."";?></td>
                    <td class="text-center"><?php echo $djadwal['tgl_seminar'];?></td>
                    <td class="text-center"><?php echo $tgl_bts_rev_konv;?></td>
                    <td class="text-center">
                      <?php 
                        $qry_cek_daftar = "SELECT COUNT(id) AS jum FROM mag_revisi_sempro WHERE id_peserta='$id' AND id_sempro='$id_sempro' AND nim='$dataku[nim]'";
                        $res = mysqli_query($GLOBALS["___mysqli_ston"], $qry_cek_daftar);
                        $dcek = mysqli_fetch_assoc($res);
                        $jum=$dcek['jum'];

                        if(date('Y-m-d') > $djadwal['batas_revisi']) {
                        echo '<span class="btn btn-danger btn-sm btn-block disabled" title="Kadaluarsa"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Kadaluarsa</span>';
                        }

                        else if(empty($djadwal['tgl_seminar'])) { echo '<a role="button" class="btn btn-primary btn-sm btn-block" title="Belum terjadwal" disabled><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Belum terjadwal</a>';}
                        else if($jum>0) {
                        $qry_val = "SELECT * FROM mag_revisi_sempro WHERE id_peserta='$id' AND id_sempro='$id_sempro' AND nim='$dataku[nim]'";
                        $resval = mysqli_query($GLOBALS["___mysqli_ston"], $qry_val);
                        $dval = mysqli_fetch_assoc($resval);

                          echo '<a role="button" href="includeEditFormRevisiSempro.php?id='.$dval['id'].'&id_sempro='.$md['id_sempro'].'&id_pendaftaran='.$md['id'].'" class="btn btn-success btn-sm btn-block" title="Edit upload revisi"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Edit upload revisi</a>';}
                        else { echo '<a role="button" href="includeFormRevisiSempro.php?id_sempro='.$md['id_sempro'].'&id_pendaftaran='.$md['id'].'" class="btn btn-primary btn-sm btn-block" title="Upload revisi"><span class="glyphicon glyphicon-upload" aria-hidden="true"></span> Upload revisi</a>';}
                        ?>
                    </td>
                  </tr>
                  <?php }?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "footerUser.php";?>
    <?php include "jsSourceUser.php";?>
  </body>
</html>