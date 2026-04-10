<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
        
   $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
   $id_periode = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id_periode' ] );
   
   $qryperiod = "select * from mag_periode_pengajuan_dospem WHERE id='$id_periode'";
   $rperiod = mysqli_query($GLOBALS["___mysqli_ston"], $qryperiod)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $dperiod = mysqli_fetch_assoc($rperiod);
   $ta = $dperiod['ta'];
   
   $qry = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE id='$id'";
   $has = mysqli_query($GLOBALS["___mysqli_ston"], $qry) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   $data = mysqli_fetch_assoc($has);
   
   $qrym = "SELECT * FROM mag_dt_mhssw_pasca WHERE nim='$data[nim]'";
   $rm = mysqli_query($GLOBALS["___mysqli_ston"], $qrym) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   $dm = mysqli_fetch_assoc($rm);
   
   $qdw1 = "SELECT * FROM mag_dospem_tesis WHERE id='$data[dospem_tesis1]'";
   $rdw1 = mysqli_query($GLOBALS["___mysqli_ston"], $qdw1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   $ddw1 = mysqli_fetch_assoc($rdw1);
   
   $qdp1 = "SELECT * FROM dt_pegawai WHERE id='$ddw1[nip]'";
   $rdp1 = mysqli_query($GLOBALS["___mysqli_ston"], $qdp1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   $ddp1 = mysqli_fetch_assoc($rdp1);
   
   $qr1 = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$ddp1[kepakaran_mayor]'";
   $rr1 = mysqli_query($GLOBALS["___mysqli_ston"], $qr1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   $dr1 = mysqli_fetch_assoc($rr1);
   
   $qdw2 = "SELECT * FROM mag_dospem_tesis WHERE id='$data[dospem_tesis2]'";
   $rdw2 = mysqli_query($GLOBALS["___mysqli_ston"], $qdw2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   $ddw2 = mysqli_fetch_assoc($rdw2);
   
   $qdp2 = "SELECT * FROM dt_pegawai WHERE id='$ddw2[nip]'";
   $rdp2 = mysqli_query($GLOBALS["___mysqli_ston"], $qdp2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   $ddp2 = mysqli_fetch_assoc($rdp2);
   
   $qr2 = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$ddp2[kepakaran_mayor]'";
   $rr2 = mysqli_query($GLOBALS["___mysqli_ston"], $qr2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
   $dr2 = mysqli_fetch_assoc($rr2);
   
   $q = "SELECT nim FROM mag_pengelompokan_dospem_tesis WHERE nim='$data[nim]'";
   $r = mysqli_query($GLOBALS["___mysqli_ston"], $q)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $d = mysqli_num_rows($r);
                 
   $qry_nm_ta = "SELECT * FROM mag_dt_ta WHERE id='$ta'";
   $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_ta);
   $dnta = mysqli_fetch_assoc($hasil);
   
   $qry_nm_smt = "SELECT * FROM opsi_nama_semester WHERE id='$dnta[semester]'";
   $h = mysqli_query($GLOBALS["___mysqli_ston"], $qry_nm_smt);
   $dsemester = mysqli_fetch_assoc($h);   
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
          if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalDisetujui') {
                              echo '
                        <div class="modal fade" id="myModal" role="dialog">
                         <div class="modal-dialog">
                         <div class="modal-content">
                         <div class="modal-header">
                         <button type="button" class="close" data-dismiss="modal">×</button>
                         <h4 class="modal-title">Update gagal</h4>
                         </div>
                         <div class="modal-body">
                         <p>Dosen pembimbing tesis ini tidak dapat disetujui karena kuotanya penuh...</p>
             <p><strong>Note:</strong> Silahkan pilih Dosen pembimbing tesis yang belum penuh kuotanya...</p>
                         </div>
                         <div class="modal-footer">
                         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                         </div>
                         </div>
                         </div>
                         </div>';}
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
                if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalSama') {
                echo '
                <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Submit gagal</h4>
                </div>
                <div class="modal-body">
                <p>Dosen pembimbing tesis I dan II yang dipilih tidak boleh sama...</p>
                <p><strong>Note:</strong> Silahkan pilih Dosen pembimbing tesis yang berbeda...</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </div>
                </div>
                </div>';}  
                
                if (!empty($_GET['message']) && $_GET['message'] == 'notifGagalDospem') {
                echo '
                <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h4 class="modal-title">Submit gagal</h4>
                </div>
                <div class="modal-body bg-alert">
                <p>Kuota Dosen pembimbing tesis yang dipilih sudah penuh...</p>
                <p><strong>Note:</strong> Silahkan pilih Dosen pembimbing tesis yang belum penuh kuotanya...</p>
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
        <h3 class="text-center text-warning">Verifikasi dan Edit Pengajuan Dosen Pembimbing Tesis</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah form verifikasi dan edit Pengajuan Dosen Pembimbing Tesis <?php echo ' Semester'.' '.$dsemester['nama'].' TA. '.$dnta['ta'];?>.</li>
              <li>Silahkan tekan button yang dimaksud untuk melihat atau konfigurasi data.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation"><a href="rekapPptAdm.php">Periode Pengajuan</a></li>
                  <li role="presentation"><a href="pengajuPtPerPeriode.php?id=<?php echo "$id_periode";?>">Data Pengajuan Dospem Tesis</a></li>
                  <li role="presentation" class="active"><a>Verifikasi dan Edit</a></li>
                  <li role="presentation"><a>Atas Nama: <?php echo $dm['nama'].' | '.$dm['nim'];?></a></li>
                </ul>
              </div>
              <div class="col-md-6" style="margin-bottom:10px;">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Judul & Outline</h3>
                  </div>
                  <form action="updateJudOutPptAdm.php" method="post" enctype="multipart/form-data" style="margin:0px;">
                    <div class="panel-body">
                      <div class="form-group">
                        <label for="judul_tesis">Judul tesis:</label>
                        <textarea name="judul_tesis" class="form-control textinput" id="judul_tesis" required><?php echo $data['judul_tesis'];?></textarea>
                      </div>
                      <div class="form-group">
                        <label for="outline_tesis">Outline tesis:</label>
                        <textarea name="outline_tesis" class="form-control textinput" id="outline_tesis" required><?php echo $data['outline_tesis'];?></textarea>
                      </div>
                    </div>
                    <div class="panel-footer">
                      <input type="text" class="sr-only" name="id" value="<?php echo "$id";?>">
                      <input type="text" class="sr-only" name="id_periode" value="<?php echo "$id_periode";?>">
                      <div class="row">
                        <div class="col-md-4">
                          <select name='verifikasi' class='form-control input-sm' onchange='this.form.submit();' required>
                          <?php
                            $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM mag_opsi_verifikasi_pengajuan_dospem ORDER BY nm ASC" );
                            while ( $w = mysqli_fetch_array( $tampil ) ) {
                              if ( $data['cekjudul'] == $w[ 'id' ] ) {
                                echo "<option value='$w[id]' selected>$w[nm]</option>";
                              } else {
                                echo "<option value='$w[id]'>$w[nm]</option>";
                              }
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <button type="submit" class="btn btn-success btn-sm" name="update">Update Judul dan Outline Tesis</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="table-responsive">
                      <table class="table custom">
                        <thead>
                          <tr>
                            <th width="58%">Pilihan Dosen Pembimbing Tesis</th>
                            <th width="26%" class="text-center">Status Pengajuan</th>
                            <th width="16%" class="text-center">Opsi</th>
                          </tr>
                        </thead>
                        <tbody  style="font-size:13px;">
                          <tr>
                            <td><?php echo $ddp1['nama'].' <code>(I)</code>';?></td>
                            <td class="text-center">
                              <label for="" class="sr-only">Verifikasi</label>
                              <form class="" style="margin-bottom:0px;" action="updateVerifikasiPptSatu.php" method="post">
                                <input type="text" class="sr-only" name="id" value="<?php echo "$id";?>" required>
                                <input type="text" class="sr-only" name="id_periode" value="<?php echo "$id_periode";?>" required>
                                <input type="text" class="sr-only" name="dospem_tesis1" value="<?php echo $data['dospem_tesis1'];?>" required>
                                <input type="text" class="sr-only" name="nim" value="<?php echo $data['nim'];?>" required>
                                <select name='verifikasi' class='form-control input-sm' onchange='this.form.submit();' required>
                                <?php
                                  $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM mag_opsi_verifikasi_pengajuan_dospem ORDER BY nm ASC" );
                                  while ( $w = mysqli_fetch_array( $tampil ) ) {
                                    if ( $data['cek1'] == $w[ 'id' ] ) {
                                      echo "<option value='$w[id]' selected>$w[nm]</option>";
                                    } else {
                                      echo "<option value='$w[id]'>$w[nm]</option>";
                                    }
                                  }
                                  ?>
                                </select>
                              </form>
                            </td>
                            <td class="text-center">
                              <button class="btn btn-warning" title="Detail" data-toggle="modal" data-target="#modalDetailPtPilihanSatu" data-whatever="<?php echo $data['id'];?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></button>
                              <?php if($data['cek1']==1) { echo
                                "<button class='btn btn-success' title='Edit' data-toggle='modal' data-target='#modalEditPtPilihanSatu' data-whatever='$data[id]'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
                                </button>";}
                                else if($data['cek1']==2) { echo 
                                "<button class='btn btn-primary disabled' title='Telah disetujui'><span class='glyphicon glyphicon-check' aria-hidden='true'></span>
                                </button>";} 
                                else if($data['cek1']==3) { echo 
                                "<button class='btn btn-danger disabled' title='Tidak disetujui'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                </button>";}
                                ?>
                            </td>
                          </tr>
                          <tr>
                            <td><?php echo $ddp2['nama'].' <code>(II)</code>';?></td>
                            <td class="text-center">
                              <label for="" class="sr-only">Verifikasi</label>
                              <form class="" style="margin-bottom:0px;" action="updateVerifikasiPptDua.php" method="post">
                                <input type="text" class="sr-only" name="id" value="<?php echo "$id";?>" required>
                                <input type="text" class="sr-only" name="id_periode" value="<?php echo "$id_periode";?>" required>
                                <input type="text" class="sr-only" name="dospem_tesis2" value="<?php echo $data['dospem_tesis2'];?>" required>
                                <input type="text" class="sr-only" name="nim" value="<?php echo $data['nim'];?>" required>
                                <select name='verifikasi' class='form-control input-sm' onchange='this.form.submit();' required>
                                <?php
                                  $tampil = mysqli_query($GLOBALS["___mysqli_ston"],  "SELECT * FROM mag_opsi_verifikasi_pengajuan_dospem ORDER BY nm ASC" );
                                  while ( $w = mysqli_fetch_array( $tampil ) ) {
                                    if ( $data['cek2'] == $w[ 'id' ] ) {
                                      echo "<option value='$w[id]' selected>$w[nm]</option>";
                                    } else {
                                      echo "<option value='$w[id]'>$w[nm]</option>";
                                    }
                                  }
                                  ?>
                                </select>
                              </form>
                            </td>
                            <td class="text-center">
                              <button class="btn btn-warning" title="Detail" data-toggle="modal" data-target="#modalDetailPtPilihanDua" data-whatever="<?php echo $data['id'];?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></button>
                              <?php if($data['cek2']==1) { echo
                                "<button class='btn btn-success' title='Edit' data-toggle='modal' data-target='#modalEditPtPilihanDua' data-whatever='$data[id]'><span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
                                </button>";}
                                else if($data['cek2']==2) { echo 
                                "<button class='btn btn-primary disabled' title='Telah disetujui'><span class='glyphicon glyphicon-check' aria-hidden='true'></span>
                                </button>";} 
                                else if($data['cek2']==3) { echo 
                                "<button class='btn btn-danger disabled' title='Tidak disetujui'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span>
                                </button>";}
                                ?>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="panel panel-default">
                      <form action="updateCatatanPptAdm.php" method="post" style="margin:0px;">
                        <div class="panel-body">
                          <input type="text" name="id" class="sr-only" value="<?php echo $id;?>" required readonly>
                          <input type="text" name="id_periode" class="sr-only" value="<?php echo "$id_periode";?>" required readonly>
                          <div class="form-group">
                            <label for="catatan">Catatan yang Diberikan:</label>
                            <textarea name="catatan" class="form-control textedit" id="catatan" required><?php echo $data['catatan'];?></textarea>
                          </div>
                        </div>
                        <div class="panel-footer">
                          <button type="submit" class="btn btn-success btn-sm" name="update">Submit</button>
                          <button type="reset" class="btn btn-info btn-sm">Ulang</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="panel panel-danger" style="margin-bottom:0px;">
                  <div class="panel-heading text-center">
                    <span class="lead">Opsi dan Profil Dosen Pembimbing Tesis</span>
                  </div>
                  <div class="panel-body">
                    <div class="table-responsive">
                      <table class="table table-condensed table-bordered table-hover custom" style="margin-bottom:0px;">
                        <thead>
                          <tr>
                            <th width="4%" class="text-center">No.</th>
                            <th width="36%">Nama</th>
                            <th width="20%">Kepakaran Mayor</th>
                            <th width="15%">Kuota Dospem I</th>
                            <th width="15%">Kuota Dospem II</th>
                            <th width="12%" class="text-center">Opsi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no=0;           
                            $qdpt = "SELECT * FROM mag_dospem_tesis WHERE id_periode='$id_periode'";
                            $rdpt = mysqli_query($GLOBALS["___mysqli_ston"], $qdpt)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                            while($ddpt = mysqli_fetch_assoc($rdpt)) {
                            $no++;
                            
                            $qp = "SELECT * FROM dt_pegawai WHERE id='$ddpt[nip]'";
                            $rp = mysqli_query($GLOBALS["___mysqli_ston"], $qp)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                            $dp = mysqli_fetch_assoc($rp);
                            
                            $qr = "SELECT * FROM opsi_kepakaran_mayor WHERE id='$dp[kepakaran_mayor]'";
                            $rr = mysqli_query($GLOBALS["___mysqli_ston"], $qr)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                            $dr = mysqli_fetch_assoc($rr);         
                            
                            $qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$ddpt[id]' AND id_periode='$data[id_periode]' AND (cek1='1' OR cek1='2') AND status='1'";
                            $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            $jumlahData1 = $dataku1['jumData'];
                            $sisa1 = $ddpt['kuota1'] - $jumlahData1;
                            
                            $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$ddpt[id]' AND id_periode='$data[id_periode]' AND (cek2='1' OR cek2='2') AND status='1'";
                            $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
                            $jumlahData2 = $dataku2['jumData'];
                            $sisa2 = $ddpt['kuota2'] - $jumlahData2;
                            ?>
                          <tr>
                            <td class="text-center"><?php echo $no;?></td>
                            <td><?php echo $dp['nama'];?></td>
                            <td><?php echo $dr['nm'];?></td>
                            <td><?php if($ddpt['kuota1'] - $jumlahData1==0) { echo '<code>Penuh</code>';} else {echo $ddpt['kuota1'].' (tersisa '.$sisa1.')';}?></td>
                            <td><?php if($ddpt['kuota2'] - $jumlahData2==0) { echo '<code>Penuh</code>';} else {echo $ddpt['kuota2'].' (tersisa '.$sisa2.')';}?></td>
                            <td class="text-center">
                              <button class="btn btn-sm btn-block btn-success" title="Lebih detail" data-toggle="modal" data-target="#modalDetailOpsiPt" data-whatever="<?php echo $ddpt['id'];?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Detail
                              </button>
                            </td>
                          </tr>
                          <?php };?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalDetailPtPilihanSatu" aria-labelledby="labelModalDetailPtPilihanSatu" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalDetailPtPilihanSatu">Profil Pilihan Dosen Pembimbing Tesis I</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalDetailPtPilihanSatu"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalListPengajuanPilihanSatu" aria-labelledby="labelModalListPengajuanPilihanSatu" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListPengajuanPilihanSatu">Daftar yang Mengajukan</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListPengajuanPilihanSatu"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalListProsesPilihanSatu" aria-labelledby="labelModalListProsesPilihanSatu" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListProsesPilihanSatu">Daftar yang Masih Proses</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListProsesPilihanSatu"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalEditPtPilihanSatu" aria-labelledby="labelModalEditPtPilihanSatu" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalEditPtPilihanSatu">Form Edit Pilihan Dosen Pembimbing Tesis I</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEditPtPilihanSatu"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalDetailPtPilihanDua" aria-labelledby="labelModalDetailPtPilihanDua" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalDetailPtPilihanDua">Profil Pilihan Dosen Pembimbing Tesis II</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalDetailPtPilihanDua"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalListPengajuanPilihanDua" aria-labelledby="labelModalListPengajuanPilihanDua" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListPengajuanPilihanDua">Daftar yang Mengajukan</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListPengajuanPilihanDua"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalListProsesPilihanDua" aria-labelledby="labelModalListProsesPilihanDua" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListProsesPilihanDua">Daftar yang Masih Proses</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListProsesPilihanDua"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalEditPtPilihanDua" aria-labelledby="labelModalEditPtPilihanDua" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalEditPtPilihanDua">Form Edit Pilihan Dosen Pembimbing Tesis II</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEditPtPilihanDua"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalDetailOpsiPt" aria-labelledby="labelModalDetailOpsiPt" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalDetailOpsiPt">Detail Opsi Dosen Pembimbing Tesis</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalDetailOpsiPt"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalListPengajuanOpsiPt" aria-labelledby="labelModalListPengajuanOpsiPt" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListPengajuanOpsiPt">Daftar yang Mengajukan</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListPengajuanOpsiPt"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" tabindex="-1" role="dialog" id="modalListProsesOpsiPt" aria-labelledby="labelModalListProsesOpsiPt" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListProsesOpsiPt">Daftar yang Masih Proses</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListProsesOpsiPt"></div>
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
      
      tinymce.init({
      selector: ".textinput",
      setup: function (editor) {
      editor.on('change', function () {
       tinymce.triggerSave();
      });
      },
      theme: "modern",
      plugins: [
      "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
      "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
      "save table contextmenu directionality emoticons template paste textcolor", "autoresize"
      ],
      content_css: "css/content.css",
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
      style_formats: [{
       title: 'Bold text',
       inline: 'b'
      },
      {
       title: 'Red text',
       inline: 'span',
       styles: {
      color: '#ff0000'
       }
      },
      {
       title: 'Red header',
       block: 'h1',
       styles: {
      color: '#ff0000'
       }
      },
      {
       title: 'Example 1',
       inline: 'span',
       classes: 'example1'
      },
      {
       title: 'Example 2',
       inline: 'span',
       classes: 'example2'
      },
      {
       title: 'Table styles'
      },
      {
       title: 'Table row 1',
       selector: 'tr',
       classes: 'tablerow1'
      }
      ]
      });
      
      tinymce.init({
      selector: ".textedit",
      setup: function (editor) {
      editor.on('change', function () {
      tinymce.triggerSave();
      });
      },
      theme: "modern",
      plugins: [
      "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
      "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
      "save table contextmenu directionality emoticons template paste textcolor", "autoresize"
      ],
      content_css: "css/content.css",
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
      style_formats: [{
      title: 'Bold text',
      inline: 'b'
      },
      {
      title: 'Red text',
      inline: 'span',
      styles: {
      color: '#ff0000'
      }
      },
      {
      title: 'Red header',
      block: 'h1',
      styles: {
      color: '#ff0000'
      }
      },
      {
      title: 'Example 1',
      inline: 'span',
      classes: 'example1'
      },
      {
      title: 'Example 2',
      inline: 'span',
      classes: 'example2'
      },
      {
      title: 'Table styles'
      },
      {
      title: 'Table row 1',
      selector: 'tr',
      classes: 'tablerow1'
      }
      ]
      });
      
      $('#modalDetailPtPilihanSatu').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "detailPptSatuAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalDetailPtPilihanSatu').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalListPengajuanPilihanSatu').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewListPptPilihanSatuDuaAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalListPengajuanPilihanSatu').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalListProsesPilihanSatu').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewListPrssPilihanSatuDuaAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalListProsesPilihanSatu').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalEditPtPilihanSatu').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "editPptSatuAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalEditPtPilihanSatu').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalDetailPtPilihanDua').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "detailPptDuaAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalDetailPtPilihanDua').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalListPengajuanPilihanDua').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewListPptPilihanSatuDuaAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalListPengajuanPilihanDua').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalListProsesPilihanDua').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewListPrssPilihanSatuDuaAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalListProsesPilihanDua').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalEditPtPilihanDua').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "editPptDuaAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalEditPtPilihanDua').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalDetailOpsiPt').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "detailOpsiPptAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalDetailOpsiPt').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalListPengajuanOpsiPt').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewListPengajuanOpsiPtAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalListPengajuanOpsiPt').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
      
      $('#modalListProsesOpsiPt').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewListProsesOpsiPtAdm.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalListProsesOpsiPt').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });   
    </script>
  </body>
</html>