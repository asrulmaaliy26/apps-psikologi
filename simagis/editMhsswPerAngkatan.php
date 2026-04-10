<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  $angkatan = mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $_GET[ 'angkatan' ] );
  
  ?>
<html lang="en">
  <head>
    <?php include 'headAdm.php';?>
  </head>
  <body>
    <?php include "navMasterDataAdm.php";
      include 'pagination.php';         
      if(isset($_REQUEST['keyword']) && $_REQUEST['keyword']<>""){
      $keyword=$_REQUEST['keyword'];
      $reload = "editMhsswPerAngkatan.php?pagination=true&angkatan=$angkatan&keyword=$keyword";
      
      $sql = "SELECT * FROM mag_dt_mhssw_pasca WHERE angkatan='$angkatan' AND (nim LIKE '%$keyword%' OR nama LIKE '%$keyword%' OR alamat_ktp LIKE '%$keyword%' OR alamat_malang LIKE '%$keyword%' OR kntk LIKE '%$keyword%' OR email LIKE '%$keyword%') ORDER BY nama ASC";
      $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
      }else{
      $reload = "editMhsswPerAngkatan.php?pagination=true&angkatan=$angkatan";
      $sql =  "SELECT * FROM mag_dt_mhssw_pasca WHERE angkatan='$angkatan' ORDER BY nama ASC";
      $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
      }
      
      $rpp = 20;
      $page = isset($_GET["page"]) ? (intval($_GET["page"])) : 1;
      $tcount = mysqli_num_rows($result);
      $tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
      $count = 0;
      $i = ($page-1)*$rpp;
      $no_urut = ($page-1)*$rpp;
      ?>
    <div class="container-fluid">
      <div class="row">
        <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalSempro') {
           echo '
           <div class="modal fade" id="myModal" role="dialog">
           <div class="modal-dialog">
           <div class="modal-content">
           <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">×</button>
           <h4 class="modal-title">Update gagal</h4>
           </div>
           <div class="modal-body">
           <p>Update gagal!</p>
           <p><strong>Note:</strong> Mahasiswa yang bersangkutan belum mengikuti Seminar Proposal Tesis.</p>
           </div>
           <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
           </div>
           </div>
           </div>';}
          if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalUjtes') {
           echo '
           <div class="modal fade" id="myModal" role="dialog">
           <div class="modal-dialog">
           <div class="modal-content">
           <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">×</button>
           <h4 class="modal-title">Update gagal</h4>
           </div>
           <div class="modal-body">
           <p>Update gagal!</p>
           <p><strong>Note:</strong> Mahasiswa yang bersangkutan belum mengikuti Ujian Tesis.</p>
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
            ?>
        <h3 class="text-center text-warning">Master Data Mahasiswa</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah halaman edit dan update master data mahasiswa.</li>
              <li>Silahkan update status mahasiswa pada kolom Status.</li>
              <li>Silahkan tekan button Detail untuk melihat data lebih detail.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation"><a href="rekapMhsswAdm.php">Data Mahasiswa Per Angkatan</a></li>
                  <li role="presentation" class="active"><a>Detail dan Edit Data Mahasiswa</a></li>
                  <li role="presentation"><a>Angkatan: <?php echo "$angkatan";?></a></li>
                </ul>
              </div>
              <div class="col-md-12">
                <form method="post" action="editMhsswPerAngkatan.php?angkatan=<?php echo "$angkatan";?>">
                  <?php error_reporting(E_ALL ^ E_NOTICE)?>
                  <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Kata kunci..."  value="<?php echo $_REQUEST['keyword'];?>" required>
                    <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Search</button>
                    <?php
                      if($_REQUEST['keyword']<>""){
                      ?>
                    <a class="btn btn-success" title="Refresh" href="editMhsswPerAngkatan.php?angkatan=<?php echo "$angkatan";?>"><span class="glyphicon glyphicon-refresh"></span> Refresh</a>
                    <?php
                      }
                      ?>
                    </span>
                  </div>
                </form>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-striped custom">
                    <tbody>
                      <?php
                        while(($count<$rpp) && ($i<$tcount)) {
                        mysqli_data_seek($result, $i);
                        $data = mysqli_fetch_array($result);
                        $nim=$data['nim'];
                        $status=$data['status'];
                        $tempat_lahir=$data['tempat_lahir'];
                        $jenis_kelamin=$data['jenis_kelamin'];
                        $pekerjaan=$data['pekerjaan'];
                        $pekerjaan_ibu=$data['pekerjaan_ibu'];
                        $pekerjaan_ayah=$data['pekerjaan_ayah'];
                        
                        $qstts = "SELECT * FROM mag_opsi_status_mhssw WHERE id='$status'";
                        $rstts = mysqli_query($GLOBALS["___mysqli_ston"], $qstts)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dstts = mysqli_fetch_assoc($rstts);
                        
                        $qrumpun = "SELECT * FROM mag_pengelompokan_rumpun WHERE nim='$nim'";
                        $rrumpun = mysqli_query($GLOBALS["___mysqli_ston"], $qrumpun)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $drumpun = mysqli_fetch_assoc($rrumpun);
                        
                        $qor = "SELECT * FROM mag_opsi_rumpun WHERE id='$drumpun[rumpun]'";
                        $ror = mysqli_query($GLOBALS["___mysqli_ston"], $qor)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dor = mysqli_fetch_assoc($ror);
                        
                        $qdw = "SELECT * FROM mag_pengelompokan_dosen_wali WHERE nim='$nim'";
                        $rdw = mysqli_query($GLOBALS["___mysqli_ston"], $qdw)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $ddw = mysqli_fetch_assoc($rdw);
                        
                        $qodw = "SELECT * FROM mag_dosen_wali WHERE id='$ddw[dosen_wali]'";
                        $rodw = mysqli_query($GLOBALS["___mysqli_ston"], $qodw)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dodw = mysqli_fetch_assoc($rodw);
                        
                        $qndw = "SELECT * FROM dt_pegawai WHERE id='$dodw[nip]'";
                        $rndw = mysqli_query($GLOBALS["___mysqli_ston"], $qndw)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dndw = mysqli_fetch_assoc($rndw);
                        
                        $qdt = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE nim='$nim'";
                        $rdt = mysqli_query($GLOBALS["___mysqli_ston"], $qdt)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $ddt = mysqli_fetch_assoc($rdt);
                        
                        $qodt1 = "SELECT * FROM mag_dospem_tesis WHERE id='$ddt[dospem_tesis1]'";
                        $rodt1 = mysqli_query($GLOBALS["___mysqli_ston"], $qodt1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dodt1 = mysqli_fetch_assoc($rodt1);
                        
                        $qndt1 = "SELECT * FROM dt_pegawai WHERE id='$dodt1[nip]'";
                        $rndt1 = mysqli_query($GLOBALS["___mysqli_ston"], $qndt1)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dndt1 = mysqli_fetch_assoc($rndt1);
                        
                        $qodt2 = "SELECT * FROM mag_dospem_tesis WHERE id='$ddt[dospem_tesis2]'";
                        $rodt2 = mysqli_query($GLOBALS["___mysqli_ston"], $qodt2)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dodt2 = mysqli_fetch_assoc($rodt2);
                        
                        $qndt2 = "SELECT * FROM dt_pegawai WHERE id='$dodt2[nip]'";
                        $rndt2 = mysqli_query($GLOBALS["___mysqli_ston"], $qndt2)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dndt2 = mysqli_fetch_assoc($rndt2);
                        
                        $qsempro = "SELECT * FROM mag_peserta_sempro WHERE nim='$nim'";
                        $rsempro = mysqli_query($GLOBALS["___mysqli_ston"], $qsempro)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dsempro = mysqli_fetch_assoc($rsempro);
                        
                        $qujtes = "SELECT * FROM mag_peserta_ujtes WHERE nim='$nim'";
                        $rujtes = mysqli_query($GLOBALS["___mysqli_ston"], $qujtes)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dujtes = mysqli_fetch_assoc($rujtes);
                        
                        $qtmptl = "SELECT * FROM dt_kota WHERE id='$tempat_lahir'";
                        $rtmptl = mysqli_query($GLOBALS["___mysqli_ston"], $qtmptl)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $dtmptl = mysqli_fetch_assoc($rtmptl);
                        
                        $qjk = "SELECT * FROM opsi_jenis_kelamin WHERE id='$jenis_kelamin'";
                        $rjk = mysqli_query($GLOBALS["___mysqli_ston"], $qjk)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $djk = mysqli_fetch_assoc($rjk);
                        
                        $qjp = "SELECT * FROM jns_pkrjn WHERE id='$pekerjaan'";
                        $rjp = mysqli_query($GLOBALS["___mysqli_ston"], $qjp)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $djp = mysqli_fetch_assoc($rjp);
                        
                        $qjpi = "SELECT * FROM jns_pkrjn WHERE id='$pekerjaan_ibu'";
                        $rjpi = mysqli_query($GLOBALS["___mysqli_ston"], $qjpi)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $djpi = mysqli_fetch_assoc($rjpi);
                        
                        $qjpa = "SELECT * FROM jns_pkrjn WHERE id='$pekerjaan_ayah'";
                        $rjpa = mysqli_query($GLOBALS["___mysqli_ston"], $qjpa)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                        $djpa = mysqli_fetch_assoc($rjpa);
                        ?>        
                      <tr>
                        <td width="12%" class="text-left" style="vertical-align:top;">
                          <img src="<?php echo $data['photo'];?>" onError="this.onerror=null;this.src='<?php if($data['jenis_kelamin']==1){echo "images/cewek.png";} else {echo "images/cowok.png";}?>';" alt="" class="img-responsive img-rounded">
                        </td>
                        <td width="88%" class="text-left" style="vertical-align:top; padding-right:0px">
                          <div class="table-responsive">
                            <table class="table table-condensed custom" style="font-size:13px; background:none;">
                              <tbody>
                                <tr>
                                  <td width="18%" class="text-left" style="border-top:0px;">Nama</td>
                                  <td width="2%" class="text-center" style="border-top:0px;">:</td>
                                  <td width="80%" class="text-left" style="border-top:0px;"><?php echo $data['nama'];?></td>
                                </tr>
                                <tr>
                                  <td class="text-left">NIM</td>
                                  <td class="text-center">:</td>
                                  <td class="text-left"><?php echo $data['nim'];?></td>
                                </tr>
                                <tr>
                                  <td class="text-left">Kontak</td>
                                  <td class="text-center">:</td>
                                  <td class="text-left"><?php echo $data['kntk'];?></td>
                                </tr>
                                <tr>
                                  <td class="text-left">Email</td>
                                  <td class="text-center">:</td>
                                  <td class="text-left"><?php echo $data['email'];?></td>
                                </tr>
                                <tr>
                                  <td class="text-left">Status</td>
                                  <td class="text-center">:</td>
                                  <td class="text-left">
                                    <table>
                                      <tr>
                                        <td>
                                          <form class="form-inline" action="updateStatusMhssw.php" method="post" style="margin:0px;">
                                            <input type="text" class="sr-only" name="nim" value="<?php echo $data['nim'];?>">
                                            <input type="text" class="sr-only" name="angkatan" value="<?php echo "$angkatan";?>">
                                            <input type="text" class="sr-only" name="page" value="<?php echo "$page";?>">
                                            <div class="form-group">
                                              <label class="sr-only" for="">Status</label>
                                              <select name="status" class="form-control input-sm" onchange='this.form.submit();' required>;
                                              <?php 
                                                $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM mag_opsi_status_mhssw ORDER BY nm ASC" );
                                                while ( $w = mysqli_fetch_array( $tampil ) ) {
                                                if ( $data['status'] == $w[ 'id' ] ) {
                                                echo "<option value='$w[id]' selected>$w[nm]</option>";
                                                } else {
                                                echo "<option value='$w[id]'>$w[nm]</option>";
                                                }
                                                }
                                                ?>
                                              </select>
                                            </div>
                                          </form>
                                        </td>
                                        <td>
                                          <?php
                                            if($status==1) {echo '';}
                                            else if($status==2){echo '
                                            <form class="form-inline" action="updateTglLulusMhssw.php" method="post" style="margin:0px;">
                                            <input type="text" class="sr-only" name="nim" value="'.$data['nim'].'">
                                            <input type="text" class="sr-only" name="angkatan" value="'.$angkatan.'">
                                            <input type="text" class="sr-only" name="page" value="'.$page.'">
                                            <div class="form-group">
                                              <label for="" class="sr-only">Keterangan</label>
                                              <span class="form-control-static" style="font-size:13px;">&nbsp;&nbsp;pada tanggal&nbsp;</span>
                                              </div>
                                              <div class="form-group">
                                              <label for="" class="sr-only">Tahun</label>
                                              <div class="input-group date" id="datetimepicker1" style="position:static;">
                                              <input type="text" id="thn_lulus" name="thn_lulus" class="form-control input-sm" value="'.$data['thn_lulus'].'" required>
                                              <span class="input-group-addon">
                                              <span class="glyphicon glyphicon-calendar"></span>
                                              </span>
                                              </div>
                                              </div>
                                              <button type="submit" class="btn btn-primary btn-sm">Update Tanggal Lulus</button> 
                                              </form>';}
                                              else if($status==3){echo '
                                              <form class="form-inline" action="updateTglCutiMhssw.php" method="post" style="margin:0px;">
                                              <input type="text" class="sr-only" name="nim" value="'.$data['nim'].'">
                                            <input type="text" class="sr-only" name="angkatan" value="'.$angkatan.'">
                                            <input type="text" class="sr-only" name="page" value="'.$page.'">
                                            <div class="form-group">
                                              <label for="" class="sr-only">Keterangan</label>
                                              <span class="form-control-static" style="font-size:13px;">&nbsp;&nbsp;mulai tanggal&nbsp;</span>
                                              </div>
                                              <div class="form-group">
                                              <label for="" class="sr-only">Tahun</label>
                                              <div class="input-group date" id="datetimepicker2" style="position:static;">
                                              <input type="text" id="thn_cuti" name="thn_cuti" class="form-control input-sm" value="'.$data['thn_cuti'].'" required>
                                              <span class="input-group-addon">
                                              <span class="glyphicon glyphicon-calendar"></span>
                                              </span>
                                              </div>
                                              </div>
                                              <button type="submit" class="btn btn-primary btn-sm">Update Tanggal Cuti</button> 
                                              </form>';}
                                            else if($status==4){echo '
                                              <form class="form-inline" action="updateTglDoMhssw.php" method="post" style="margin:0px;">
                                              <input type="text" class="sr-only" name="nim" value="'.$data['nim'].'">
                                            <input type="text" class="sr-only" name="angkatan" value="'.$angkatan.'">
                                            <input type="text" class="sr-only" name="page" value="'.$page.'">
                                            <div class="form-group">
                                              <label for="" class="sr-only">Keterangan</label>
                                              <span class="form-control-static" style="font-size:13px;">&nbsp;&nbsp;pada tanggal&nbsp;</span>
                                              </div>
                                              <div class="form-group">
                                              <label for="" class="sr-only">Tahun</label>
                                              <div class="input-group date" id="datetimepicker3" style="position:static;">
                                              <input type="text" id="thn_do" name="thn_do" class="form-control input-sm" value="'.$data['thn_do'].'" required>
                                              <span class="input-group-addon">
                                              <span class="glyphicon glyphicon-calendar"></span>
                                              </span>
                                              </div>
                                              </div>
                                              <button type="submit" class="btn btn-primary btn-sm">Update Tanggal Drop Out</button> 
                                              </form>';}
                                            else if($status==5){echo '
                                              <form class="form-inline" action="updateTglNonAktifMhssw.php" method="post" style="margin:0px;">
                                              <input type="text" class="sr-only" name="nim" value="'.$data['nim'].'">
                                            <input type="text" class="sr-only" name="angkatan" value="'.$angkatan.'">
                                            <input type="text" class="sr-only" name="page" value="'.$page.'">
                                            <div class="form-group">
                                              <label for="" class="sr-only">Keterangan</label>
                                              <span class="form-control-static" style="font-size:13px;">&nbsp;&nbsp;mulai tanggal&nbsp;</span>
                                              </div>
                                              <div class="form-group">
                                              <label for="" class="sr-only">Tahun</label>
                                              <div class="input-group date" id="datetimepicker4" style="position:static;">
                                              <input type="text" id="thn_non_aktif" name="thn_non_aktif" class="form-control input-sm" value="'.$data['thn_non_aktif'].'" required>
                                              <span class="input-group-addon">
                                              <span class="glyphicon glyphicon-calendar"></span>
                                              </span>
                                              </div>
                                              </div>
                                              <button type="submit" class="btn btn-primary btn-sm">Update Tanggal Non Aktif</button> 
                                              </form>';}
                                              ?>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="3" style="padding-left:0px; padding-right:0px;">
                                    <button class="btn btn-sm btn-success" type="button" data-toggle="collapse" data-target="#<?php echo $data['nim'];?>" aria-expanded="false" aria-controls="collapseExample"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Detail</button>
                                    <div class="collapse" id="<?php echo $data['nim'];?>" style="margin-top:10px;">
                                      <div class="table-responsive">
                                        <table class="table table-condensed custom" style="font-size:13px; background:none;">
                                          <tbody>
                                            <tr>
                                              <td class="text-left">Gelar Belakang</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $data['gelar_belakang'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Gelar Depan</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $data['gelar_depan'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Peminatan Rumpun Psikologi</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $dor['nm'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Academic Coach</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $dndw['nama'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Dosen Pembimbing Tesis</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php if($ddt['nim']<1) {echo "";} else {echo '1. '.$dndt1['nama'].' | 2. '.$dndt2['nama'];}?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Seminar Proposal Tesis</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php if($dsempro['nim']>0) {echo "Telah Mengikuti";} else if($dsempro['nim']<1) {echo "Belum Mengikuti";};?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Ujian Tesis</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php if($dujtes['nim']>0) {echo "Telah Mengikuti";} else if($dujtes['nim']<1) {echo "Belum Mengikuti";};?></td>
                                            </tr>
                                            <tr>
                                              <td width="20%" class="text-left">Tempat / Tanggal Lahir</td>
                                              <td width="2%" class="text-center">:</td>
                                              <td width="78%" class="text-left"><?php echo $dtmptl['nm_kota'].'/'.$data['tanggal_lahir'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Jenis Kelamin</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $djk['nm'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Pekerjaan</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $djp['nm'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Asal Strata 1</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $data['asal_s1'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Pendidikan Terakhir</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $data['pend_terakhir'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Nama Ibu</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $data['nama_ibu'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Pekerjaan Ibu</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $djpi['nm'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Alamat Ibu</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $data['alamat_ibu'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Kontak Ibu</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $data['telepon_ibu'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Nama Ayah</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $data['nama_ayah'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Pekerjaan Ayah</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $djpa['nm'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Alamat Ayah</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $data['alamat_ayah'];?></td>
                                            </tr>
                                            <tr>
                                              <td class="text-left">Kontak Ayah</td>
                                              <td class="text-center">:</td>
                                              <td class="text-left"><?php echo $data['telepon_ayah'];?></td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
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
                <div class="text-center"><?php echo paginate_one($reload, $page, $tpages); ?></div>
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
      
      $(document).ready(function() {
      $('#datetimepicker1')
      .datetimepicker({
      format: 'YYYY-MM-DD',
      });
      $('#datetimepicker1 input').click(function(event){
      $('#datetimepicker1 ').data("DateTimePicker").show();
      });
      });
      
      $(document).ready(function() {
      $('#datetimepicker2')
      .datetimepicker({
      format: 'YYYY-MM-DD',
      });
      $('#datetimepicker2 input').click(function(event){
      $('#datetimepicker2 ').data("DateTimePicker").show();
      });
      });
      
      $(document).ready(function() {
      $('#datetimepicker3')
      .datetimepicker({
      format: 'YYYY-MM-DD',
      });
      $('#datetimepicker3 input').click(function(event){
      $('#datetimepicker3 ').data("DateTimePicker").show();
      });
      });
      
      $(document).ready(function() {
      $('#datetimepicker4')
      .datetimepicker({
      format: 'YYYY-MM-DD',
      });
      $('#datetimepicker4 input').click(function(event){
      $('#datetimepicker4 ').data("DateTimePicker").show();
      });
      });
    </script>
  </body>
</html>