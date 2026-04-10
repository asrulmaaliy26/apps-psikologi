<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  		  
   $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
   
   $qryperiod = "select * from mag_periode_pengajuan_dospem WHERE id='$id'";
   $rperiod = mysqli_query($GLOBALS["___mysqli_ston"], $qryperiod)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $dperiod = mysqli_fetch_assoc($rperiod);
   $ta = $dperiod['ta'];
   $tahap=$dperiod['tahap'];
   
   $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$ta'";
   $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
   $dnta = mysqli_fetch_assoc($hasil);
   
   $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
   $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
   $dsemester = mysqli_fetch_assoc($h);

   $qry_nm_thp = "SELECT * FROM mag_opsi_tahap_ujprop_ujtes WHERE id='$tahap'";
   $hsl = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_thp);
   $dtahap = mysqli_fetch_assoc($hsl);
  ?>
<html lang="en">
  <head>
    <?php include 'headAdm.php';?>
  </head>
  <body>
    <?php include "navPngjnAdm.php";?>
    <div class="container-fluid">
      <div class="row">
        <?php
		if (!empty($_GET['message']) && $_GET['message'] == 'notifGagal') {
                echo '
          <div class="modal fade" id="myModal" role="dialog">
           <div class="modal-dialog">
           <div class="modal-content">
           <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">×</button>
           <h4 class="modal-title">Update gagal</h4>
           </div>
           <div class="modal-body">
           <p>Update gagal. Mahasiswa ini telah mengikuti seminar proposal tesis</p>
           </div>
           <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
           </div>
           </div>
           </div>';} 
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diupdate</div>';}	
          if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil dihapus</div>';}		 
           ?>
        <h3 class="text-center text-warning">Data Pengajuan Dosen Pembimbing Tesis</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah data Pengajuan Dosen Pembimbing Tesis <?php echo 'Tahap'.' '.$dtahap['tahap'].' Semester'.' '.$dsemester['nama'].' TA. '.$dnta['ta'];?>.</li>
              <li>Silahkan tekan button yang dimaksud untuk melihat atau konfigurasi data.</li>
              <li>Silahkan pilih Verifikasi & Edit untuk memverifikasi dan mengedit pengajuan.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation"><a href="rekapPptAdm.php">Periode Pengajuan</a></li>
                  <li role="presentation" class="active"><a>Data Pengajuan Dospem Tesis</a></li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-striped custom" width="100%" style="margin-bottom:0px;">
                    <thead>
                      <tr>
                        <th class="text-center" width="3%">No.</th>
                        <th width="23%">Nama | NIM</th>
                        <th class="text-center" width="24%">Dospem Tesis I</th>
                        <th class="text-center" width="24%">Dospem Tesis II</th>
						<th class="text-center" width="11%">Tgl. Pengajuan</th>
						<th class="text-center" width="11%">Verifikasi & Edit</th>
                        <th class="text-center" width="4%">Opsi</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted" style="font-size:13px;">
                      <?php
                        $no=0;
                        $sql =  "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE id_periode = '$id' ORDER BY id ASC";
                        $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
                        while($data = mysqli_fetch_array($result)) {
                        $no++;
                        
						$qnm =  "SELECT * FROM mag_dt_mhssw_pasca WHERE nim = '$data[nim]'";
                        $r = mysqli_query($GLOBALS["___mysqli_ston"], $qnm);
                        $dnm = mysqli_fetch_assoc($r);
						
                        $qnd1 =  "SELECT * FROM mag_dospem_tesis AS mdt JOIN dt_pegawai AS dp ON mdt.nip=dp.id WHERE mdt.id = '$data[dospem_tesis1]'";
                        $r = mysqli_query($GLOBALS["___mysqli_ston"], $qnd1);
                        $dnd1 = mysqli_fetch_assoc($r);

						$qnd2 =  "SELECT * FROM mag_dospem_tesis AS mdt JOIN dt_pegawai AS dp ON mdt.nip=dp.id WHERE mdt.id = '$data[dospem_tesis2]'";
                        $r = mysqli_query($GLOBALS["___mysqli_ston"], $qnd2);
                        $dnd2 = mysqli_fetch_assoc($r);
						
						$qcek = "SELECT * FROM mag_peserta_sempro WHERE nim='$data[nim]' AND cek='2'";
                        $row = mysqli_query($GLOBALS["___mysqli_ston"], $qcek);
                        $dcek = mysqli_num_rows($row);
                        ?>
                      <tr>
                        <td class="text-center"><?php echo $no;?></td>
                        <td><?php echo $dnm['nama'].' | '.$dnm['nim'];?></td>
                        <td><?php echo $dnd1['nama'];?></td>
                        <td><?php echo $dnd2['nama'];?></td>
                        <td class="text-center"><?php echo $data['tgl_pengajuan'];?></td>
                        <td class="text-center">
                          <a class="btn btn-warning btn-sm" href="verifikasiEditPpt.php?id=<?php echo $data['id'];?>&id_periode=<?php echo $data['id_periode'];?>" title="Verifikasi & Edit"><span class="glyphicon glyphicon-edit"></span> Verifikasi & Edit</a>
						</td>
                        <td class="text-center">
                          <?php if($dcek > 0) { echo "<a class='btn btn-default' title='Tidak bisa dihapus! Mahasiswa ini telah mengikuti seminar proposal tesis' disabled><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                            </a>";} else { echo "<a class='btn btn-default' href='deletePpt.php?id=".$data['id']."&id_periode=".$data['id_periode']."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                            </a>";}?>                   
                        </td>
                      </tr>
                      <?php
                        }
                        ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include "footerAdm.php";?>
    <?php include "jsSourceAdm.php";?>
    <script>
      $(document).ready(function () {
      $("#myModal").modal({
       backdrop: false
      });
      $("#myModal").modal("show");
      });
    </script>
  </body>
</html>