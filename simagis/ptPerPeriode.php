<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
  		  
   $id = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
   
   $qryperiod = "SELECT * FROM mag_periode_pengajuan_dospem WHERE id='$id'";
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
          if (!empty($_GET['message']) && $_GET['message'] == 'notifSama') {
           echo '
          <div class="modal fade" id="myModal" role="dialog">
           <div class="modal-dialog">
           <div class="modal-content">
           <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal">×</button>
           <h4 class="modal-title">Submit gagal</h4>
           </div>
           <div class="modal-body">
           <p>Submit gagal.</p>
           <p><strong>Note:</strong> Data yang diinput sudah ada, silahkan cek lagi!</p>
           </div>
           <div class="modal-footer">
           <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
           </div>
           </div>
           </div>';} 
          		  
           if (!empty($_GET['message']) && $_GET['message'] == 'notifInput') {
           echo '<div class="alert alert-success custom-alert" role="alert">
           <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diinput</div>';}	
          if (!empty($_GET['message']) && $_GET['message'] == 'notifEdit') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil diupdate</div>';}	
          if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil dihapus</div>';}		 
           ?>
        <h3 class="text-center text-warning">Data Dosen Pembimbing Tesis</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah data Dosen Pembimbing Tesis <?php echo 'Tahap'.' '.$dtahap['tahap'].' Semester'.' '.$dsemester['nama'].' TA. '.$dnta['ta'];?>.</li>
              <li>Silahkan tekan button yang dimaksud untuk melihat atau konfigurasi data.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation"><a href="rekapPptAdm.php">Periode Pengajuan</a></li>
                  <li role="presentation" class="active"><a>Data Dospem Tesis</a></li>
                  <button role="presentation" class="btn btn-primary pull-right" title="Input dospem tesis baru" data-toggle="modal" data-target="#modalInput"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Input Dospem Tesis Baru</button>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-condensed table-bordered table-striped custom" width="100%" style="margin-bottom:0px; font-size:13px;">
                    <thead>
                      <tr>
                        <th rowspan="3" class="text-center" width="3%">No.</th>
                        <th rowspan="3" class="text-center" width="36%">Nama | NIP</th>
                        <th colspan="2" rowspan="2" class="text-center">Kuota Pembimbing</th>
                        <th colspan="8" class="text-center">Total Pembimbing</th>
                        <th rowspan="3" class="text-center" width="11%">Opsi</th>
                      </tr>
					  <tr>
					  <th colspan="4" class="text-center">I</th>
                        <th colspan="4" class="text-center">II</th>
					  </tr>
					  <tr>
                        <th class="text-center" width="7%">I</th>
                        <th class="text-center" width="7%">II</th>
                        <th class="text-center" width="4%" style=" font-size:10px;">Ajuan</th>
                        <th class="text-center" width="4%" style=" font-size:10px;">Proses</th>
                        <th class="text-center" width="4%" style=" font-size:10px;">Selesai</th>
                        <th class="text-center" width="6%" style=" font-size:10px;">Total</th>
                        <th class="text-center" width="4%" style=" font-size:10px;">Ajuan</th>
                        <th class="text-center" width="4%" style=" font-size:10px;">Proses</th>
                        <th class="text-center" width="4%" style=" font-size:10px;">Selesai</th>
                        <th class="text-center" width="6%" style=" font-size:10px;">Total</th>
					  </tr>
                    </thead>
                    <tbody class="text-muted">
            <?php
                        $no=0;
                        $sql =  "SELECT * FROM mag_dospem_tesis WHERE id_periode = '$id' ORDER BY id ASC";
                        $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
                        while($data = mysqli_fetch_array($result)) {
                        $no++;
                        $qnd =  "SELECT * FROM dt_pegawai WHERE id = '$data[nip]'";
                        $r = mysqli_query($GLOBALS["___mysqli_ston"], $qnd);
                        $dnd = mysqli_fetch_assoc($r);
                        
						$qry1 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$data[id]' AND id_periode='$data[id_periode]' AND (cek1='1' OR cek1='2') AND status='1'";
            $result1 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $dataku1 = mysqli_fetch_assoc($result1) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $jumlahData1 = $dataku1['jumData'];
            $sisa1 = $data['kuota1'] - $jumlahData1;
                        
            $qry2 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$data[id]' AND id_periode='$data[id_periode]' AND (cek2='1' OR cek2='2') AND status='1'";
            $result2 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $dataku2 = mysqli_fetch_assoc($result2) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
            $jumlahData2 = $dataku2['jumData'];
            $sisa2 = $data['kuota2'] - $jumlahData2;
						
						$qry3 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$data[id]' AND id_periode='$data[id_periode]' AND cek1='1'";
						$result3 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$dataku3 = mysqli_fetch_assoc($result3) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$jumlahData3 = $dataku3['jumData'];
						
						$qry4 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$data[id]' AND id_periode='$data[id_periode]' AND cek2='1'";
						$result4 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$dataku4 = mysqli_fetch_assoc($result4) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$jumlahData4 = $dataku4['jumData'];
                        
            $qry5 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$data[id]' AND id_periode='$data[id_periode]' AND cek1='2' AND status='1'";
						$result5 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$dataku5 = mysqli_fetch_assoc($result5) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$jumlahData5 = $dataku5['jumData'];
						
						$qry6 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$data[id]' AND id_periode='$data[id_periode]' AND cek2='2' AND status='1'";
						$result6 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$dataku6 = mysqli_fetch_assoc($result6) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$jumlahData6 = $dataku6['jumData'];
						
						$qry7 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$data[id]' AND id_periode='$data[id_periode]' AND cek1='2' AND cekjudul='2' AND status='2'";
						$result7 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$dataku7 = mysqli_fetch_assoc($result7) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$jumlahData7 = $dataku7['jumData'];
						
						$qry8 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$data[id]' AND id_periode='$data[id_periode]' AND cek2='2' AND cekjudul='2' AND status='2'";
						$result8 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$dataku8 = mysqli_fetch_assoc($result8) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$jumlahData8 = $dataku8['jumData'];
												
						$qry9 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$data[id]' AND cek1='2'";
						$result9 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry9) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$dataku9 = mysqli_fetch_assoc($result9) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$jumlahData9 = $dataku9['jumData'];
						
						$qry10 = "SELECT COUNT(*) AS jumData FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$data[id]' AND cek2='2'";
						$result10 =  mysqli_query($GLOBALS["___mysqli_ston"], $qry10) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$dataku10 = mysqli_fetch_assoc($result10) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
						$jumlahData10 = $dataku10['jumData'];
						$jumTotal = ($jumlahData9 + $jumlahData10);
						
						$qpengaju1 = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis1='$data[id]' AND id_periode='$data[id_periode]' AND status='1'";
                        $row1 = mysqli_query($GLOBALS["___mysqli_ston"], $qpengaju1);
                        $dpengaju1 = mysqli_num_rows($row1);
                        
                        $qpengaju2 = "SELECT * FROM mag_pengelompokan_dospem_tesis WHERE dospem_tesis2='$data[id]' AND id_periode='$data[id_periode]' AND status='1'";
                        $row2 = mysqli_query($GLOBALS["___mysqli_ston"], $qpengaju2);
                        $dpengaju2 = mysqli_num_rows($row2);
                        ?>
                      <tr>
                        <td class="text-center"><?php echo $no;?></td>
                        <td><?php echo $dnd['nama'].' | '.$dnd['id'];?></td>
                        <td class="text-center"><?php if($data['kuota1'] - $jumlahData1==0) { echo '<code>Penuh</code>';} else {echo $data['kuota1'].' (tersisa '.$sisa1.')';}?></td>
                        <td class="text-center"><?php if($data['kuota2'] - $jumlahData2==0) { echo '<code>Penuh</code>';} else {echo $data['kuota2'].' (tersisa '.$sisa2.')';}?></td>
                        <td class="text-center"><button class='btn btn-sm btn-block btn-danger' title='Lihat data' data-toggle='modal' data-target='#modalListPengajuanPt1PerPeriode' data-whatever='<?php echo $data['id'];?>'><?php echo "$jumlahData3";?></button></td>
                        <td class="text-center"><button class='btn btn-sm btn-block btn-warning' title='Lihat data' data-toggle='modal' data-target='#modalListProsesPt1PerPeriode' data-whatever='<?php echo $data['id'];?>'><?php echo "$jumlahData5";?></button></td>
                        <td class="text-center"><button class='btn btn-sm btn-block btn-success' title='Lihat data' data-toggle='modal' data-target='#modalListSelesaiPt1PerPeriode' data-whatever='<?php echo $data['id'];?>'><?php echo "$jumlahData7";?></button></td>
                        <td class="text-center"><button class='btn btn-sm btn-block btn-primary' title='Lihat data' data-toggle='modal' data-target='#modalTotalPt1PerPeriode' data-whatever='<?php echo $data['id'];?>'><?php echo "$jumlahData9";?></button></td>
                        <td class="text-center"><button class='btn btn-sm btn-block btn-danger' title='Lihat data' data-toggle='modal' data-target='#modalListPengajuanPt2PerPeriode' data-whatever='<?php echo $data['id'];?>'><?php echo "$jumlahData4";?></button></td>
                        <td class="text-center"><button class='btn btn-sm btn-block btn-warning' title='Lihat data' data-toggle='modal' data-target='#modalListProsesPt2PerPeriode' data-whatever='<?php echo $data['id'];?>'><?php echo "$jumlahData6";?></button></td>
						<td class="text-center"><button class='btn btn-sm btn-block btn-success' title='Lihat data' data-toggle='modal' data-target='#modalListSelesaiPt2PerPeriode' data-whatever='<?php echo $data['id'];?>'><?php echo "$jumlahData8";?></button></td>
						<td class="text-center"><button class='btn btn-sm btn-block btn-primary' title='Lihat data' data-toggle='modal' data-target='#modalTotalPt2PerPeriode' data-whatever='<?php echo $data['id'];?>'><?php echo "$jumlahData10";?></button></td>
                        <td class="text-center">
                          <button class='btn btn-primary' title='Lihat detail profil' data-toggle='modal' data-target='#modalDetailOpsiPt' data-whatever='<?php echo $data['id'];?>'><span class="glyphicon glyphicon-user"></span></button>
						  <button class='btn btn-warning' title='Edit kuota' data-toggle='modal' data-target='#modalEdit' data-whatever='<?php echo $data['id'];?>'><span class="glyphicon glyphicon-edit"></span></button>
                          <?php if($dpengaju1 > 0 || $dpengaju2 > 0) { echo "<a class='btn btn-default' title='Tidak bisa dihapus! Sudah ada pengajuan' disabled><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
                            </a>";} else { echo "<a class='btn btn-default' href='deletePt.php?id=".$data['id']."&id_periode=".$data['id_periode']."' onclick='return confirm(\"Yakin data ini dihapus?\")' title='Hapus'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span>
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
      <div id="modalInput" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="modalInput">Input Dospem Tesis Baru</h4>
            </div>
            <div class="modal-body">
              <div class="panel panel-default">
                <div class="panel-body">
                  <form action="sformInputPtPerPeriode.php" method="post">
                    <input type="text" name="id" class="sr-only" value="<?php echo "$id";?>" required readonly>
                    <div class="form-group">
                      <label for="nip">Dosen Pembimbing Tesis:</label>
                      <select name="nip" class="form-control" id="nip" required>
                        <option value="">-Pilih-</option>
                        <?php
                          $query = "SELECT * FROM dt_pegawai WHERE mengajar_pasca='2' ORDER BY nama_tg";
                                   $r = mysqli_query($GLOBALS["___mysqli_ston"], $query)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
                                   while($dt = mysqli_fetch_array($r)) {            
                            echo "<option value='$dt[id]'>$dt[nama_tg]</option>";
                                 }
                                 ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="kuota1">Kuota untuk Menjadi Dosen Pembimbing Tesis I:</label>
                      <input type="number" min="0" max="20" id="kuota1" name="kuota1" class="form-control" required>
                    </div>
                    <div class="form-group">
                      <label for="kuota2">Kuota untuk Menjadi Dosen Pembimbing Tesis II:</label>
                      <input type="number" min="0" max="20" id="kuota2" name="kuota2" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
	  <div class="modal fade" tabindex="-1" role="dialog" id="modalListPengajuanPt1PerPeriode" aria-labelledby="labelModalListPengajuanPt1PerPeriode" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListPengajuanPt1PerPeriode">Data yang Mengajukan</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListPengajuanPt1PerPeriode"></div>
            </div>
          </div>
        </div>
      </div>
	  <div class="modal fade" tabindex="-1" role="dialog" id="modalListProsesPt1PerPeriode" aria-labelledby="labelModalListProsesPt1PerPeriode" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListProsesPt1PerPeriode">Data yang Sedang Proses</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListProsesPt1PerPeriode"></div>
            </div>
          </div>
        </div>
      </div>
	  <div class="modal fade" tabindex="-1" role="dialog" id="modalListSelesaiPt1PerPeriode" aria-labelledby="labelModalListSelesaiPt1PerPeriode" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListSelesaiPt1PerPeriode">Data yang Telah Selesai</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListSelesaiPt1PerPeriode"></div>
            </div>
          </div>
        </div>
      </div>
	  <div class="modal fade" tabindex="-1" role="dialog" id="modalTotalPt1PerPeriode" aria-labelledby="labelModalTotalPt1PerPeriode" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalTotalPt1PerPeriode">Total Data</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalTotalPt1PerPeriode"></div>
            </div>
          </div>
        </div>
      </div>
	  <div class="modal fade" tabindex="-1" role="dialog" id="modalListPengajuanPt2PerPeriode" aria-labelledby="labelModalListPengajuanPt2PerPeriode" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListPengajuanPt2PerPeriode">Data yang Mengajukan</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListPengajuanPt2PerPeriode"></div>
            </div>
          </div>
        </div>
      </div>
	  <div class="modal fade" tabindex="-1" role="dialog" id="modalListProsesPt2PerPeriode" aria-labelledby="labelModalListProsesPt2PerPeriode" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListProsesPt2PerPeriode">Data yang Sedang Proses</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListProsesPt2PerPeriode"></div>
            </div>
          </div>
        </div>
      </div>
	  <div class="modal fade" tabindex="-1" role="dialog" id="modalListSelesaiPt2PerPeriode" aria-labelledby="labelModalListSelesaiPt2PerPeriode" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalListSelesaiPt2PerPeriode">Data yang Telah Selesai</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalListSelesaiPt2PerPeriode"></div>
            </div>
          </div>
        </div>
      </div>
	  <div class="modal fade" tabindex="-1" role="dialog" id="modalTotalPt2PerPeriode" aria-labelledby="labelModalTotalPt2PerPeriode" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalTotalPt2PerPeriode">Total Data</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalTotalPt2PerPeriode"></div>
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
	  <div class="modal fade" tabindex="-1" role="dialog" id="modalEdit" aria-labelledby="labelModalEdit" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
              <h4 class="modal-title" id="modalEdit">Edit Kuota Dospem Tesis</h4>
            </div>
            <div class="modal-body">
              <div class="isiModalEdit"></div>
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
	  
	  $('#modalListPengajuanPt1PerPeriode').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewListPengajuanPt1PerPeriode.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalListPengajuanPt1PerPeriode').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
	  
	  $('#modalListProsesPt1PerPeriode').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewListProsesPt1PerPeriode.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalListProsesPt1PerPeriode').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
	  
	  $('#modalListSelesaiPt1PerPeriode').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewListSelesaiPt1PerPeriode.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalListSelesaiPt1PerPeriode').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
	  
	  $('#modalTotalPt1PerPeriode').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewTotalPt1PerPeriode.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalTotalPt1PerPeriode').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
	  
	  $('#modalListPengajuanPt2PerPeriode').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewListPengajuanPt2PerPeriode.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalListPengajuanPt2PerPeriode').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
	  
	  $('#modalListProsesPt2PerPeriode').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewListProsesPt2PerPeriode.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalListProsesPt2PerPeriode').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
	  
	  $('#modalListSelesaiPt2PerPeriode').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewListSelesaiPt2PerPeriode.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalListSelesaiPt2PerPeriode').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
	  
	  $('#modalTotalPt2PerPeriode').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "viewTotalPt2PerPeriode.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalTotalPt2PerPeriode').html(data);
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
	   
      $('#modalEdit').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var recipient = button.data('whatever')
      var modal = $(this);
      var dataString = 'id=' + recipient;
      $.ajax({
      type: "GET",
      url: "editKuotaPt.php",
      data: dataString,
      cache: false,
      success: function (data) {
       console.log(data);
       modal.find('.isiModalEdit').html(data);
      },
      error: function (err) {
       console.log(err);
      }
      });
      });
    </script>
  </body>
</html>