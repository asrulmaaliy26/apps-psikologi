<?php
  include("koneksiAdm.php");
  $username = $_SESSION['username'];
        
   $id_tc = mysqli_real_escape_string($GLOBALS["___mysqli_ston"],  $_GET[ 'id' ] );
   $qryperiod = "select * from mag_periode_thesis_camp WHERE id='$id_tc'";
   $rperiod = mysqli_query($GLOBALS["___mysqli_ston"], $qryperiod)or die( mysqli_error($GLOBALS["___mysqli_ston"]));
   $dperiod = mysqli_fetch_assoc($rperiod);
   $ta = $dperiod['ta'];
   
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
    <?php include "navPendAdm.php";?>
    <div class="container-fluid">
      <div class="row">
        <?php
          if (!empty($_GET['message']) && $_GET['message'] == 'notifDelete') {
          echo '<div class="alert alert-success custom-alert" role="alert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close"></a><span class="glyphicon glyphicon-thumbs-up"></span> Data berhasil dihapus</div>';}    
                 ?>
        <h3 class="text-center text-warning">Pendaftar Thesis Camp</h3>
        <div class="panel panel-success">
          <div class="panel-heading">
            <ul class="list">
              <li>Berikut adalah data Pendaftar Thesis Camp <?php echo 'Semester'.' '.$dsemester['nama'].' TA. '.$dnta['ta'];?>.</li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12" style="margin-bottom:10px;">
                <ul class="nav nav-tabs">
                  <li role="presentation"><a href="rekapThesisCampAdm.php">Periode Pendaftaran</a></li>
                  <li role="presentation" class="active"><a>Data Pendaftar</a></li>
                </ul>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-condensed table-bordered table-striped custom" width="100%" style="margin-bottom:0px; font-size:13px;">
                    <thead>
                      <tr>
                        <th class="text-center" width="3%">No.</th>
                        <th class="text-center" width="18%">Nama | NIM | Tgl. Daftar</th>
                        <th class="text-center" width="5%">Smt.</th>
                        <th class="text-center" width="18%">Topik / Judul</th>
                        <th class="text-center" width="13%">Pembimbing 1</th>
                        <th class="text-center" width="13%">Pembimbing 2</th>
                        <th class="text-center" width="9%">Tahapan</th>
                        <th class="text-center" width="17%">Harapan</th>
                      </tr>
                    </thead>
                    <tbody class="text-muted">
                      <?php
                        $no=0;
                        $sql =  "SELECT * FROM mag_peserta_thesis_camp WHERE id_periode_thesis_camp = '$id_tc' ORDER BY nim ASC";
                        $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
                            while($data = mysqli_fetch_array($result)) {
                        $no++;
                        $qrymhssw = "select * from mag_dt_mhssw_pasca WHERE nim='$data[nim]' ORDER BY nim ASC";
                        $resp = mysqli_query($GLOBALS["___mysqli_ston"],  $qrymhssw )or die( mysqli_error($GLOBALS["___mysqli_ston"]) );
                        $dmhssw = mysqli_fetch_assoc( $resp );
                        
                        // Hitung semester mahasiswa
                        $current_smt_type = (int)$dnta['semester']; // 1=Ganjil, 2=Genap
                        $current_year = (int)$dnta['ta'];
                        $entry_year = (int)$dmhssw['angkatan'];
                        $entry_smt = (int)$dmhssw['smt_daftar']; // 1=Ganjil, 2=Genap
                        $smt_mhs = ($current_year - $entry_year) * 2 + $current_smt_type - ($entry_smt - 1);
                        ?>
                      <tr>
                        <td class="text-center"><?php echo $no;?></td>
                        <td><?php echo $dmhssw['nama'].' | '.$dmhssw['nim'].' | '.$dmhssw['kntk'].' | '.$data['tgl_daftar'];?></td>
                        <td class="text-center"><?php echo $smt_mhs;?></td>
                        <td><?php echo $data['topik'];?></td>
                        <td><?php echo $data['dospem1'];?></td>
                        <td><?php echo $data['dospem2'];?></td>
                        <td class="text-center"><?php echo $data['tahapan'];?></td>
                        <td><?php echo $data['harapan'];?></td>
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
  </body>
</html>
